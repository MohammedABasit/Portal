$(document).ready(function() {
    const table = $('#trainersTable').DataTable({
        ajax: {
            url: 'API/Trainers/get_trainers.php',
            dataSrc: 'data'
        },
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function(row) {
                        return 'تفاصيل المدرب: ' + row.data().full_name;
                    }
                }),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                    tableClass: 'table'
                })
            }
        },
        columns: [
            { 
                data: 'profile_photo',
                render: function(data, type, row) {
                    return `<img src="${data ? 'uploads/' + data : 'assets/img/Default.jpg'}" 
                            alt="${row.full_name}" 
                            class="rounded-circle"
                            width="40" 
                            height="40">`;
                },
                responsivePriority: 1
            },
            { 
                data: 'full_name',
                responsivePriority: 2
            },
            { data: 'national_id' },
            { data: 'gender' },
            { data: 'birthdate' },
            { data: 'address' },
            {
                data: 'id',
                render: function(data) {
                    return `
                        <div class="btn-group">
                            <a href="trainer-details.php?id=${data}" 
                               class="btn btn-sm btn-primary">عرض</a>
                            <button class="btn btn-sm btn-danger delete-trainer" 
                                    data-id="${data}">حذف</button>
                        </div>`;
                },
                responsivePriority: 3
            }
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json'
        }
    });

    // Keep the delete trainer handler exactly the same
    $('#trainersTable').on('click', '.delete-trainer', function() {
        const trainerId = $(this).data('id');
        
        Swal.fire({
            title: 'هل أنت متأكد من حذف بيانات المدرب؟',
            text: "لا يمكن التراجع عن هذا الإجراء!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'تأكيد',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                $('.loader-container').show();
                
                fetch('API/Trainers/delete_trainer.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: trainerId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            'تم حذف البيانات!',
                            data.message,
                            'success'
                        );
                        table.ajax.reload();
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    Swal.fire(
                        'خطأ!',
                        error.message,
                        'error'
                    );
                })
                .finally(() => {
                    $('.loader-container').hide();
                });
            }
        });
    });
});