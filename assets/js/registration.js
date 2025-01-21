// Initialize Dropzone
Dropzone.autoDiscover = false;

let currentStep = 1;
const totalSteps = 6;

$(document).ready(function () {
    // Initialize Dropzones with proper configuration
    const dropzones = [
        new Dropzone("#ProfileDropzone", {
            url: "API/Attachments/File_Uploader.php",
            addRemoveLinks: true,
            maxFiles: 1,
            acceptedFiles: ".jpg,.png,.pdf",
            dictDefaultMessage: "قم بإسقاط الصورة الشخصية هنا",
            dictRemoveFile: "حذف الملف",
            dictCancelUpload: "إلغاء التحميل",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            init: function () {
                this.on("sending", function (file, xhr, formData) {
                    formData.append("uploadType", "profile");
                });
                this.on("success", function (file, response) {
                    if (response.success) {
                        file.serverFileName = response.file;
                    }
                });
            }
        }),
        new Dropzone("#cvDropzone", {
            url: "API/Attachments/File_Uploader.php",
            addRemoveLinks: true,
            acceptedFiles: ".pdf,.doc,.docx",
            dictDefaultMessage: "قم بإسقاط السيرة الذاتية هنا",
            dictRemoveFile: "حذف الملف",
            dictCancelUpload: "إلغاء التحميل",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            init: function () {
                this.on("sending", function (file, xhr, formData) {
                    formData.append("uploadType", "cv");
                });
                this.on("success", function (file, response) {
                    if (response.success) {
                        file.serverFileName = response.file;
                    }
                });
            }
        }),
        new Dropzone("#certificatesDropzone", {
            url: "API/Attachments/File_Uploader.php",
            addRemoveLinks: true,
            acceptedFiles: ".pdf,.jpg,.png,.doc,.docx",
            dictDefaultMessage: "قم بإسقاط الشهادات هنا",
            dictRemoveFile: "حذف الملف",
            dictCancelUpload: "إلغاء التحميل",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            init: function () {
                this.on("sending", function (file, xhr, formData) {
                    formData.append("uploadType", "certificates");
                });
                this.on("success", function (file, response) {
                    if (response.success) {
                        file.serverFileName = response.file;
                    }
                });
            }
        }),
        new Dropzone("#otherAttachmentsDropzone", {
            url: "API/Attachments/File_Uploader.php",
            addRemoveLinks: true,
            acceptedFiles: ".pdf,.doc,.docx,.jpg,.png",
            dictDefaultMessage: "قم بإسقاط المرفقات الإضافية هنا",
            dictRemoveFile: "حذف الملف",
            dictCancelUpload: "إلغاء التحميل",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            init: function () {
                this.on("sending", function (file, xhr, formData) {
                    formData.append("uploadType", "other");
                });
                this.on("success", function (file, response) {
                    if (response.success) {
                        file.serverFileName = response.file;
                    }
                });
            }
        })
    ];

    // Academic History Management
    const initAcademicHistory = () => {
        const $academicHistoryContainer = $('#academicHistory');
        const $addAcademicBtn = $('#addAcademicBtn');

        $addAcademicBtn.click(function () {
            const academicEntry = `
                <div class="academic-entry border rounded p-3 mb-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">القطاع</label>
                            <select name="sections[]" class="form-select" required>
                                <option value="">اختر القطاع</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الدرجة العلمية</label>
                            <select name="degree[]" class="form-select" disabled required>
                                <option value="">اختر الدرجة العلمية</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">التخصص</label>
                            <input type="text" name="major[]" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">المؤسسة التعليمية</label>
                            <input type="text" name="institution[]" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">تاريخ التخرج</label>
                            <input type="month" name="graduation_year[]" class="form-control" required>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger remove-academic">حذف</button>
                </div>
            `;
            $academicHistoryContainer.append(academicEntry);
        });

        $(document).on('click', '.remove-academic', function () {
            $(this).closest('.academic-entry').remove();
        });
    };

    // Experience Records Management
    const initExperienceRecords = () => {
        const $experienceRecordsContainer = $('#experienceRecords');
        const $addExperienceBtn = $('#addExperienceBtn');

        $addExperienceBtn.click(function () {
            const experienceEntry = `
                <div class="experience-entry border rounded p-3 mb-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">المؤسسة</label>
                            <input type="text" name="work-institution[]" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الوظيفة</label>
                            <input type="text" name="job[]" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">المدة (بالشهور)</label>
                            <input type="number" name="duration[]" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">تاريخ نهاية المدة</label>
                            <input type="text" name="dateend[]" class="form-control date-end" placeholder="mm/dd/yyyy" required>
                            <div class="form-check mt-2">
                                <input type="checkbox" class="form-check-input working-checkbox" id="working" name="working[]">
                                <label class="form-check-label" for="working">حتى الآن</label>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger remove-experience">حذف</button>
                </div>
            `;
            $experienceRecordsContainer.append(experienceEntry);
        });

        $(document).on('click', '.remove-experience', function () {
            $(this).closest('.experience-entry').remove();
        });

        // Handle working checkbox changes
        $(document).on('change', '.working-checkbox', function() {
            const $dateEnd = $(this).closest('.mb-3').find('.date-end');
            if ($(this).is(':checked')) {
                $dateEnd.hide().prop('required', false);
            } else {
                $dateEnd.show().prop('required', true);
            }
        });
    };

   // Trainings Records Management
    const initTrainingsRecords = () => {
    const $trainingsRecordsContainer = $('#trainingsRecords');
    const $addTrainingsBtn = $('#addTrainingsBtn');
    
    $addTrainingsBtn.click(function () {
    const trainingsEntry = `
    <div class="trainings-entry border rounded p-3 mb-3">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">الدورة التدريبية</label>
                <input type="text" name="training-name[]" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">المؤسسة التدريبية</label>
                <input type="text" name="train-inistitute[]" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">عدد الساعات</label>
                <input type="number" name="period[]" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">تاريخ الحصول عليها</label>
                <input type="text" name="accomplishment[]" class="form-control date-end" placeholder="mm/dd/yyyy" required>
            </div>
        </div>
        <button type="button" class="btn btn-danger remove-trainings">حذف</button>
    </div>
    `;
    $trainingsRecordsContainer.append(trainingsEntry);
    });
    
    $(document).on('click', '.remove-trainings', function () {
    $(this).closest('.trainings-entry').remove();
    });
    };

    // Skills Records Management
    const initSkillsRecords = () => {
        const $skillsRecordsContainer = $('#skillsRecords');
        const $addSkillBtn = $('#addSkillBtn');

        $addSkillBtn.click(function () {
            const skillEntry = `
                <div class="Skill-entry border rounded p-3 mb-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">المهارة</label>
                            <input type="text" name="skill[]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <div class="skill-progress mb-4">
                                <label class="form-label">مستوى المهارة</label>
                                <input type="range" class="form-range" id="skill_level" name="skill_level[]" min="0" max="5" step="1" value="0">
                                <span class="skill-value measurement-value">0</span>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger remove-skill">حذف</button>
                </div>
            `;
            $skillsRecordsContainer.append(skillEntry);
        });

        $(document).on('click', '.remove-skill', function () {
            $(this).closest('.Skill-entry').remove();
        });

        $(document).on('input', 'input[name="skill_level[]"]', function () {
            $(this).closest('.skill-progress').find('.skill-value').text(this.value);
        });
    };

    // Hobbies Records Management
    const initHobbiesRecords = () => {
        const $hobbiesRecordsContainer = $('#hoppiesRecords');
        const $addHobbiesBtn = $('#addHoppiesBtn');

        $addHobbiesBtn.click(function () {
            const hobbieEntry = `
                <div class="hoppie-entry border rounded p-3 mb-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الهواية</label>
                            <input type="text" name="hoppie[]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <div class="hoppie-progress">
                                <label class="form-label">مستوى الإجادة</label>
                                <input type="range" class="form-range" id="hoppie_level" name="hoppie_level[]"
                                    min="0" max="5" step="1" value="0" required>
                                <span class="hoppie-value measurement-value">0</span>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger remove-hoppie">حذف</button>
                </div>
            `;
            $hobbiesRecordsContainer.append(hobbieEntry);
        });

        $(document).on('click', '.remove-hoppie', function () {
            $(this).closest('.hoppie-entry').remove();
        });

        $(document).on('input', 'input[name="hoppie_level[]"]', function () {
            $(this).closest('.hoppie-progress').find('.hoppie-value').text(this.value);
        });
    };

    // Illness Records Management
    const initIllnessRecords = () => {
        const $illnessRecordsContainer = $('#illnessRecords');
        const $addIllnessBtn = $('#addillnessBtn');

        $addIllnessBtn.click(function () {
            const illnessEntry = `
                <div class="illness-entry border rounded p-3 mb-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">نوع المرض</label>
                            <input type="text" name="illness[]" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">تاريخ بدايته</label>
                            <input type="text" name="illness-date[]" placeholder="mm/dd/yyyy" class="form-control" required>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger remove-illness">حذف</button>
                </div>
            `;
            $illnessRecordsContainer.append(illnessEntry);
        });

        $(document).on('click', '.remove-illness', function () {
            $(this).closest('.illness-entry').remove();
        });
    };

    // Sports Records Management
    const initSportsRecords = () => {
        const $sportsRecordsContainer = $('#sportsRecords');
        const $addSportsBtn = $('#addSportBtn');

        $addSportsBtn.click(function () {
            const sportsEntry = `
                <div class="sports-entry border rounded p-3 mb-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">نوع الرياضة</label>
                            <input type="text" name="sport[]" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">دورية تطبيقها</label>
                            <select name="routine[]" class="form-select" required>
                                <option value="">اختر من القائمة</option>
                                <option value="يومي">يومي</option>
                                <option value="اسبوعي">اسبوعي</option>
                                <option value="شهري">شهري</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger remove-sports">حذف</button>
                </div>
            `;
            $sportsRecordsContainer.append(sportsEntry);
        });

        $(document).on('click', '.remove-sports', function () {
            $(this).closest('.sports-entry').remove();
        });
    };

    // Step Navigation
    const showStep = (step) => {
        $('.step-content').hide();
        $(`#step${step}`).show();

        $('.step').removeClass('active');
        $(`.step[data-step="${step}"]`).addClass('active');

        $('.prev-step').toggle(step > 1);
        $('.next-step').toggle(step < totalSteps);
        $('.submit-form').toggle(step === totalSteps);
    };

    const validateStep = (step) => {
        const $step = $(`#step${step}`);
        let isValid = true;

        $step.find('[required]').each(function () {
            if (!this.value) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!isValid) {
            Swal.fire({
                title: 'خطأ في التحقق',
                text: 'يرجى ملء جميع الحقول المطلوبة',
                icon: 'error'
            });
            return false;
        }

        if (step === 4) {
            const skill_value = $('#skill_level').val();
            if (skill_value == 0) {
                Swal.fire({
                    title: 'حقل مطلوب',
                    text: 'يجب تحديد درجة صقل المهارات المذكورة',
                    icon: 'warning'
                });
                return false;
            }
            const hoppie_value = $('#hoppie_level').val();
            if (hoppie_value == 0) {
                Swal.fire({
                    title: 'حقل مطلوب',
                    text: 'يجب تحديد درجة إجادة الهوايات المذكورة',
                    icon: 'warning'
                });
                return false;
            }
        }

        if (step === 5) {
            const healthProgress = $("#healthProgress").val();
            if (healthProgress == 0) {
                Swal.fire({
                    title: 'حقل مطلوب',
                    text: 'لم يتم تحديد درجة حالة الصحة العامة',
                    icon: 'warning'
                });
                return false;
            }
            const mentalProgress = $("#mentalProgress").val();
            if (mentalProgress == 0) {
                Swal.fire({
                    title: 'حقل مطلوب',
                    text: 'لم يتم تحديد درجة حالة الصحة النفسية',
                    icon: 'warning'
                });
                return false;
            }
        }

        if (step === 6) {
            const cvDropzone = Dropzone.forElement("#cvDropzone");
            if (cvDropzone && cvDropzone.files.length === 0) {
                Swal.fire({
                    title: 'حقل مطلوب',
                    text: 'يرجى تحميل السيرة الذاتية',
                    icon: 'warning'
                });
                return false;
            }
            const certificatesDropzone = Dropzone.forElement("#certificatesDropzone");
            if (certificatesDropzone && certificatesDropzone.files.length === 0) {
                Swal.fire({
                    title: 'حقل مطلوب',
                    text: 'يرجى تحميل الشهادات',
                    icon: 'warning'
                });
                return false;
            }
        }

        return true;
    };

    // Initialize all components
    initAcademicHistory();
    initExperienceRecords();
    initSkillsRecords();
    initIllnessRecords();
    initSportsRecords();
    initHobbiesRecords();
    initTrainingsRecords();
    
    // Navigation event handlers
    $('.next-step').click(function () {
        if (validateStep(currentStep) && currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        }
    });

    $('.prev-step').click(function () {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    // Form submission
    $('#registrationForm').submit(function (e) {
        e.preventDefault();

        if (validateStep(currentStep)) {
            const formData = new FormData(this);

            // Add files from dropzones with their categories
            dropzones.forEach((dropzone, index) => {
                const files = dropzone.getAcceptedFiles();
                files.forEach(file => {
                    if (file.serverFileName) {
                        formData.append(`attachment${index}[]`, file.serverFileName);
                    }
                });
            });

            $.ajax({
                url: 'API/Registration/submit_form.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        // Clear form and redirect
                        $('#registrationForm')[0].reset();
                        dropzones.forEach(dropzone => dropzone.removeAllFiles());
                        window.location.href = 'completed.php';
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: response.message
                        });
                    }
                },
                error: function (xhr) {
                    let errorMessage = 'حدث خطأ أثناء التسجيل';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        errorMessage = response.message;
                    } catch (e) {
                        console.error('Error parsing response:', e);
                        let errorMessage = e;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: errorMessage
                    });
                }
            });
        }
    });

    // Show initial step
    showStep(1);

    // Update health and mental progress displays
    $('#healthProgress').on('input', function () {
        $('#healthOutput').text(this.value);
    });

    $('#mentalProgress').on('input', function () {
        $('#mental').text(this.value);
    });
});