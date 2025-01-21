$(document).ready(function () {
    function loadSections($select) {
        // Show loader before making the AJAX request
        $('.page-content').addClass('dimmed');
        $('.loader-container').show();

        return $.ajax({
            url: 'API/academic/load_sections.php',
            method: 'GET',
            success: function (response) {
                if (response.status === 'success') {
                    // If a specific select element is provided, only update that one
                    const $targets = $select || $('select[name="sections[]"]');
                    
                    $targets.each(function() {
                        const currentValue = $(this).val(); // Store current selection
                        $(this).empty();
                        $(this).append('<option value="">اختر القطاع</option>');

                        response.data.forEach(section => {
                            $(this).append(`<option value="${section.id}">${section.section_name}</option>`);
                        });

                        // Restore previous selection if it existed
                        if (currentValue) {
                            $(this).val(currentValue);
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: response.message || 'حدث خطأ في تحميل القطاعات'
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
    }

    // Initial load of sections
    loadSections();

    // Handle dynamic section loading for new entries
    $(document).on('click', '#addAcademicBtn', function() {
        // Wait for DOM to update with new entry
        setTimeout(() => {
            const $newEntry = $('.academic-entry:last-child select[name="sections[]"]');
            if ($newEntry.length) {
                loadSections($newEntry);
            }
        }, 100);
    });
});