<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الجمعية السودانية للمدربين - تسجيل مدرب جديد</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tippy.js/2.5.4/tippy.css"
        integrity="sha512-wYhtIFU+mDV48662uSmS8BA6uIuSRXB15B014+WdZgtU1Umfn/v8+Yq3hidRunKqTBmhBijyyuqSzCxmj6KlTg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/mazer.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/custom.css">
</head>

<body>
    <!-- Loader -->
    <div class="loader-container">
        <span class="loader"></span>
    </div>

    <div id="app">

        <div id="main" class="layout-horizontal">
            <header class="mb-5">
                <nav class="navbar navbar-expand-lg">
                    <div class="container">
                        <a href="index.php" class="navbar-brand">نظام المدربين</a>
                        <div class="collapse navbar-collapse">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a href="index.php" class="nav-link active">تسجيل مدرب جديد</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>

            <div class="content-wrapper container">
                <div class="page-content">
                    <section class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>تسجيل مدرب جديد</h4>
                                </div>
                                <div class="card-body">
                                    <form id="registrationForm" class="needs-validation" novalidate>
                                        <!-- Progress Steps -->
                                        <div class="progress-steps mb-4">
                                            <div class="step active" data-step="1">معلومات عامة</div>
                                            <div class="step" data-step="2">المؤهلات</div>
                                            <div class="step" data-step="3">الخبرات</div>
                                            <div class="step" data-step="4">المهارات والهوايات</div>
                                            <div class="step" data-step="5">الصحة والاستعداد</div>
                                            <div class="step" data-step="6">ملفات إضافية</div>
                                        </div>

                                        <!-- Step 1: General Information -->
                                        <div class="step-content" id="step1">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">الاسم الكامل</label>
                                                    <input type="text" id="full_name" name="full_name" class="form-control" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">النوع</label>
                                                    <select name="gender" class="form-select" required>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">تاريخ الميلاد</label>
                                                    <input type="text" name="birthdate" class="form-control" placeholder="mm/dd/yyyy" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">الرقم الوطني</label>
                                                    <input type="number" name="national_id" class="form-control" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">الموطن الأصلي</label>
                                                    <input type="text" name="origin_place" class="form-control"
                                                        required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">عنوان السكن</label>
                                                    <input type="text" name="address" class="form-control" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">الحالة الاجتماعية</label>
                                                    <select name="marital_status" class="form-select" required>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3 wifes-count" style="display: none;">
                                                    <label class="form-label" id="martial_married_input_name">عدد الزوجات</label>
                                                    <input type="number" name="wifes_count" class="form-control"
                                                        min="0">
                                                </div>
                                                <div class="col-md-6 mb-3 children-count" style="display: none;">
                                                    <label class="form-label">عدد الأطفال</label>
                                                    <input type="number" name="children_count" class="form-control"
                                                        min="0">
                                                </div>
                                                <div class="col-12 mt-4">
                                                    <h5>بيانات الوالدين</h5>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">اسم الوالد</label>
                                                    <input type="text" id="father_name" name="father_name" class="form-control" readonly>
                                                    <div class="form-check mt-2">
                                                        <input type="checkbox" name="father_alive"
                                                            class="form-check-input" id="fatherAlive" checked>
                                                        <label class="form-check-label" for="fatherAlive">على قيد
                                                            الحياة</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">اسم الوالدة</label>
                                                    <input type="text" name="mother_name" class="form-control" required>
                                                    <div class="form-check mt-2">
                                                        <input type="checkbox" name="mother_alive"
                                                            class="form-check-input" id="motherAlive" checked>
                                                        <label class="form-check-label" for="motherAlive">على قيد
                                                            الحياة</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Step 1: General Information -->

                                        <!-- Step 2: Qualifications -->
                                        <div class="step-content" id="step2" style="display: none;">
                                            <h4>المؤهلات:</h4>
                                            <div id="academicHistory"></div>
                                            <button type="button" class="btn btn-primary mt-3" id="addAcademicBtn">
                                                إضافة مؤهل
                                            </button>
                                        </div>
                                        <!-- End Step 2: Qualifications -->

                                        <!-- Step 3: Experiences -->
                                        <div class="step-content" id="step3" style="display: none;">
                                            <h4>الخبرات العملية:</h4>
                                            <div id="experienceRecords"></div>
                                            <button type="button" class="btn btn-primary mt-3" id="addExperienceBtn">
                                                خبرة جديدة
                                            </button>
                                            <h4 class="mt-3">الدورات التدريبية السابقة:</h4>
                                            <div id="trainingsRecords"></div>
                                            <button type="button" class="btn btn-primary mt-3" id="addTrainingsBtn">
                                                دورة تدريبية جديدة
                                            </button>
                                        </div>
                                        <!-- End Step 3: Experiences -->

                                        <!-- Step 4: Skills & Hoppies -->
                                        <div class="step-content" id="step4" style="display: none;">
                                            <h4>المهارات الشخصية:</h4>
                                            <div id="skillsRecords"></div>
                                            <button type="button" class="btn btn-primary mb-3" id="addSkillBtn">
                                                مهارة جديدة
                                            </button>
                                            <h4>الهوايات:</h4>
                                            <div id="hoppiesRecords"></div>
                                            <button type="button" class="btn btn-primary" id="addHoppiesBtn">
                                                هواية جديدة
                                            </button>
                                        </div>
                                        <!-- End Step 4: Skills & Hoppies -->

                                        <!-- Step 5: Health -->
                                        <div class="step-content" id="step5" style="display: none;">
                                            <div class="health-progress mb-4">
                                                <label class="form-label">الحالة العامة</label>
                                                <input type="range" class="form-range" name="health_status" id="healthProgress" min="0"
                                                    max="100" step="10" value="0">
                                                <span class="measurement-value" id="healthOutput">0</span>
                                            </div>
                                            <h4>الأمراض المزمنة: (إن وجد)</h4>
                                            <div id="illnessRecords"></div>
                                            <button type="button" class="btn btn-primary mb-3" id="addillnessBtn">
                                                إضافة
                                            </button>
                                            <h4>الممارسات الرياضية:</h4>
                                            <div id="sportsRecords"></div>
                                            <button type="button" class="btn btn-primary mb-3" id="addSportBtn">
                                                إضافة رياضة
                                            </button>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <div class="training-progress">
                                                        <label class="form-label">مستوى الصحة النفسية</label>
                                                        <input type="range" class="form-range" name="mental_health" id="mentalProgress"
                                                            min="0" max="5" step="1" value="0">
                                                        <span class="measurement-value" id="mental">5</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">الأمراض التي تعاني منها سابقاً:</label>
                                                <textarea name="previous-illness" class="form-control"
                                                    id="previous-illness"></textarea>
                                            </div>
                                        </div>
                                        <!-- End Step 5: Health -->

                                        <!-- Step 6: File Upload -->
                                        <div class="step-content" id="step6" style="display: none;">
                                            <div class="mb-4">
                                                <label class="form-label">الصورة الشخصية</label>
                                                <div id="ProfileDropzone" class="dropzone"></div>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">السيرة الذاتية</label>
                                                <div id="cvDropzone" class="dropzone"></div>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">الشهادات</label>
                                                <div id="certificatesDropzone" class="dropzone"></div>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">مرفقات إضافية</label>
                                                <div id="otherAttachmentsDropzone" class="dropzone"></div>
                                            </div>
                                        </div>
                                        <!-- End Step 6: File Upload -->
                                </div>
                                <!-- Navigation Buttons -->
                                <div class="d-flex justify-content-between m-2">
                                    <button type="button" class="btn btn-secondary prev-step"
                                        style="display: none;">السابق</button>
                                    <button type="button" class="btn btn-primary next-step">التالي</button>
                                    <button type="submit" class="btn btn-success submit-form"
                                        style="display: none;">حفظ</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="assets/js/helpers/genders_helper.js"></script>
    <script src="assets/js/helpers/marital_status_helper.js"></script>
    <script src="assets/js/helpers/academic/degrees_helper.js"></script>
    <script src="assets/js/helpers/academic/sections_helper.js"></script>
    <script src="assets/js/registration.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tippy.js/2.5.4/tippy.js"
        integrity="sha512-1YEQZacaGmEd4cE8dsoYDUAdY0KwKf7hS/CcN8Xl5HUHBt0JGQicTIRv2TDT6tG2AftqDKoP+06Qd3OkHWd7WA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/health.js"></script>
</body>
</html>