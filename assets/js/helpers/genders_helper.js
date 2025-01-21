$(document).ready(function () {

    // Show loader before making the AJAX request
    $('.page-content').addClass('dimmed');
    $('.loader-container').show();

    $.ajax({
        url: 'API/load_genders.php',
        method: 'GET',
        success: function (response) {
            if (response.status === 'success') {
                const $genderSelect = $('select[name="gender"]');
                $genderSelect.empty();
                $genderSelect.append('<option value="">اختر النوع</option>');

                response.data.forEach(gender => {
                    $genderSelect.append(`<option value="${gender.id}">${gender.gender}</option>`);
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: response
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
        complete: function() {
            // Hide loader after request completes (success or error)
            $('.page-content').removeClass('dimmed');
            $('.loader-container').hide();
        }
    });
});