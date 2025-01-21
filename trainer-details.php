<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الجمعية السودانية للمدربين - تفاصيل المدرب</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
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
                                    <a href="trainers.php" class="nav-link">قائمة المدربين</a>
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
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4>تفاصيل المدرب</h4>
                                        <a href="trainers.php" class="btn btn-secondary">عودة</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="trainerDetails">
                                        <!-- Content will be loaded dynamically -->
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
    <script src="assets/js/trainers/trainer-details.js"></script>
</body>
</html>