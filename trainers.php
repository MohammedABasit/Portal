<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الجمعية السودانية للمدربين - قائمة المدربين</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="assets\libs\datatable\dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="assets/css/mazer.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="assets/css/style.css">
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
                                    <a href="trainers.php" class="nav-link active">قائمة المدربين</a>
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
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4>قائمة المدربين</h4>
                                    <div class="d-flex align-items-center">
                                        <button id="refreshBtn" class="btn btn-primary me-3">
                                            تحديث
                                        </button>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">جدول</span>
                                            <label class="view-toggle mx-2">
                                                <input type="checkbox" id="viewToggle">
                                                <span class="slider"></span>
                                            </label>
                                            <span class="ms-2">بطاقات</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- Table View -->
                                    <div id="tableView">
                                        <table id="trainersTable" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>الصورة</th>
                                                    <th>الاسم</th>
                                                    <th>الرقم الوطني</th>
                                                    <th>النوع</th>
                                                    <th>تاريخ الميلاد</th>
                                                    <th>العنوان</th>
                                                    <th>الإجراءات</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>

                                    <!-- Grid View -->
                                    <div id="gridView" class="row" style="display: none;">
                                        <!-- Grid items will be dynamically added here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/datatable/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="assets/js/trainers/view-switcher.js"></script>
    <script src="assets/js/trainers/trainers-renderer.js"></script>
    <script src="assets/js/trainers/trainers-table.js"></script>
    <script src="assets/js/trainers/main.js"></script>
</body>
</html>