$(document).ready(function () {
    var marital_status_husband_array = [];
    var marital_status_siblings_array = [];

    // Show loader before making the AJAX request
    $('.page-content').addClass('dimmed');
    $('.loader-container').show();

    $.ajax({
        url: 'API/load_marital_status.php',
        method: 'GET',
        success: function (response) {
            if (response.status === 'success') {
                const $marital_statusSelect = $('select[name="marital_status"]');
                $marital_statusSelect.empty();
                $marital_statusSelect.append('<option value="">اختر النوع</option>');

                response.data.forEach(marital_status => {
                    $marital_statusSelect.append(`<option value="${marital_status.id}">${marital_status.marital_status}</option>`);
                    marital_status_siblings_array[marital_status.id] = marital_status.hasSiblings;
                    marital_status_husband_array[marital_status.id] = marital_status.hasHusband_Wifes;
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
        complete: function () {
            // Hide loader after request completes (success or error)
            $('.page-content').removeClass('dimmed');
            $('.loader-container').hide();
        }
    });

    // Handle marital status change
    // $('select[name="marital_status"]').change(function() {
    //     const selectedId = $(this).val();
    //     const hasSiblings = selectedId ? marital_status_siblings_array[selectedId] : 0;
    //     const hasHusband = selectedId ? marital_status_husband_array[selectedId] : 0;
    //     $gender = $('select[name="gender"]').val();

    //     if (hasHusband === 1) {
    //         if (gender === '1') { // Male
    //             $('.wifes-count').show();
    //             $('input[name="wifes_count"]').prop('required', true);
    //         } else { // Female or unselected
    //             $('.wifes-count').hide();
    //             $('input[name="wifes_count"]').val('1').prop('required', false);
    //         }
    //     } else {
    //         $('.wifes-count').hide();
    //         $('input[name="wifes_count"]').prop('required', false);
    //     }
    // });

    // Handle marital status change
    $('select[name="marital_status"]').change(function () {
        const selectedId = $(this).val();
        updatefamilyData();
    });


    $('select[name="gender"]').change(function () {
        updatefamilyData();
    });

    function updatefamilyData() {
        
        const selectedId = $('select[name="marital_status"]').val();
        const hasHusband = selectedId ? marital_status_husband_array[selectedId] : 0;
        const hasSiblings = selectedId ? marital_status_siblings_array[selectedId] : 0;
        const gender = $('select[name="gender"]').val();

        if (hasHusband === 1) {
            if (gender === '1') { // Male
        		$('.wifes-count').show();
        		$('input[name="wifes_count"]').val('1').prop('required', true);
        		hasSiblings === 1 ? $('.children-count').show() : $('.children-count').hide();
            hasSiblings === 1 ? $('input[name="children_count"]').val('1').prop('required', true) : $('input[name="children_count"]').val('0').prop('required', false);
        		//$('input[name="children_count"]').val(hasSiblings).prop('required', hasSiblings === 1);
            } else { // Female or unselected
                $('.wifes-count').hide();
                $('input[name="wifes_count"]').val('1').prop('required', false);
                hasSiblings === 1 ? $('.children-count').show() : $('.children-count').hide();
                hasSiblings === 1 ? $('input[name="children_count"]').val('1').prop('required', true) : $('input[name="children_count"]').val('0').prop('required', false);
        		//$('.children-count').toggle(hasSiblings === 1);
        		//$('input[name="children_count"]').val(hasSiblings).prop('required', hasSiblings === 1);
            }
        } else {
            $('.wifes-count').hide();
            $('input[name="wifes_count"]').val('0').prop('required', false);
            hasSiblings === 1 ? $('.children-count').show() : $('.children-count').hide();
            hasSiblings === 1 ? $('input[name="children_count"]').val('0').prop('required', true) : $('input[name="children_count"]').val('0').prop('required', false);
            //$('.children-count').toggle(hasSiblings === 1);
            //$('input[name="children_count"]').val(hasSiblings).prop('required', hasSiblings === 1);
        }
    }

    $('#full_name').on('input', function () {
        const fullName = $(this).val();
        const nameParts = fullName.trim().split(' ');
        var fatherName = '';

        // Return empty if less than 2 parts
        if (nameParts.length < 2) {
            fatherName = '';
        }
        else {
            for (i=1; i<nameParts.length; i++){
                fatherName = fatherName += nameParts[i] + ' ';
            }
        }
        // const fatherName = nameParts.length >= 2 ? nameParts[1] : '';
        $('#father_name').val(fatherName);
    });
});