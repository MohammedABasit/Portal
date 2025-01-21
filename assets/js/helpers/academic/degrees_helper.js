$(document).ready(function () {
    // Handle section change to load corresponding degrees
    $(document).on('change', 'select[name="sections[]"]', function () {
        const selectedSectionId = $(this).val();
        const $degreeSelect = $(this).closest('.academic-entry').find('select[name="degree[]"]');
        
        // Clear and disable degree select if no section is selected
        if (!selectedSectionId) {
            $degreeSelect.empty();
            $degreeSelect.append('<option value="">اختر النوع</option>');
            $degreeSelect.prop('disabled', true);
            return;
        }

        // Show loader before making the AJAX request
        $('.page-content').addClass('dimmed');
        $('.loader-container').show();

        $.ajax({
            url: 'API/academic/load_degrees.php',
            method: 'GET',
            data: { section_id: selectedSectionId },
            success: function (response) {
                if (response.status === 'success') {
                    $degreeSelect.empty();
                    $degreeSelect.append('<option value="">اختر النوع</option>');

                    response.data.forEach(degree => {
                        $degreeSelect.append(`<option value="${degree.id}">${degree.degree_name}</option>`);
                    });

                    $degreeSelect.prop('disabled', false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: response.message || 'حدث خطأ في تحميل الدرجات العلمية'
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: 'حدث خطأ في الاتصال بالخادم'
                });
            },
            complete: function () {
                // Hide loader after request completes
                $('.page-content').removeClass('dimmed');
                $('.loader-container').hide();
            }
        });
    });
});