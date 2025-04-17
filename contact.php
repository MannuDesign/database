<?php
include('include/db.php');

$lastData = [];

// Fetch the latest data
$result = $conn->query("SELECT * FROM contactid WHERE id = 1");
if ($result && $result->num_rows > 0) {
    $lastData = $result->fetch_assoc();
}

if (isset($_POST['submit'])) {
    // Collect form data
    $number = $_POST['number'];
    $m_number = $_POST['m_number'];
    $email = $_POST['email'];
    $emailid = $_POST['emailid'];
    $location = $_POST['location'];

    // Debugging: Check the submitted data
    // var_dump($number, $m_number, $email, $emailid, $location); // You can remove this after checking

    if (!empty($lastData)) {
        // Update existing record
        $id = $lastData['id'];

        // Prepare update statement
        $stmt = $conn->prepare("UPDATE contactid SET number=?, m_number=?, email=?, emailid=?, location=? WHERE id=1");
        $stmt->bind_param("sssss", $number, $m_number, $email, $emailid, $location);
    } else {
        // Insert new record if no data exists
        $stmt = $conn->prepare("INSERT INTO contactid (number, m_number, email, emailid, location) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $number, $m_number, $email, $emailid, $location);
    }

    // Execute and check if successful
    if ($stmt->execute()) {
        echo "<script>alert('Data saved successfully'); window.location.href='';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}
?>



<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">



<head>

    <meta charset="utf-8" />
    <title> Form Advanced | Velzon - Admin & Dashboard Template </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- multi.js css -->
    <link rel="stylesheet" type="text/css" href="assets/libs/multi.js/multi.min.css" />
    <!-- autocomplete css -->
    <link rel="stylesheet" href="assets/libs/%40tarekraafat/autocomplete.js/css/autoComplete.css">

    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->

            <?php include('include/header.php'); ?>

            <?php include('include/sidenav.php'); ?>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div
                                class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                                <h4 class="mb-sm-0">Contact</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                        <li class="breadcrumb-item active">Form Advanced</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <!-- <h4 class="card-title mb-0"> Add-Service.php </h4> -->
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="container mt-5">
                                            <h2 class="mb-4">Contact Form</h2>

                                            <form action="" method="post" enctype="multipart/form-data">
    <div class="card card-body shadow">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Phone Number</label>
                <input type="text" name="number" class="form-control" placeholder="Phone Number *" required
                    value="<?= isset($lastData['number']) ? htmlspecialchars($lastData['number']) : '' ?>">
            </div>

            <div class="col-12">
                <label class="form-label">Mobile Number</label>
                <input type="text" name="m_number" class="form-control" placeholder="Mobile Number *" required
                    value="<?= isset($lastData['m_number']) ? htmlspecialchars($lastData['m_number']) : '' ?>">
            </div>

            <div class="col-12">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Your Email *" required
                    value="<?= isset($lastData['email']) ? htmlspecialchars($lastData['email']) : '' ?>">
            </div>

            <div class="col-12">
                <label class="form-label">Email ID</label>
                <input type="email" name="emailid" class="form-control" placeholder="Enter Your Email ID *" required
                    value="<?= isset($lastData['emailid']) ? htmlspecialchars($lastData['emailid']) : '' ?>">
            </div>

            <div class="col-12">
                <label class="form-label">Location</label>
                <textarea name="location" class="form-control" rows="4" placeholder="Enter location..." required><?= isset($lastData['location']) ? htmlspecialchars($lastData['location']) : '' ?></textarea>
            </div>

            <div class="col-12 mt-3">
                <button class="btn btn-primary" name="submit" type="submit">Submit</button>
            </div>
        </div>
    </div>
</form>


                                        </div>







                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <?php include('include/footer.php'); ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <!-- JAVASCRIPT -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="assets/js/plugins.js"></script>

    <!-- multi.js -->
    <script src="assets/libs/multi.js/multi.min.js"></script>
    <!-- autocomplete js -->
    <script src="assets/libs/%40tarekraafat/autocomplete.js/autoComplete.min.js"></script>

    <!-- init js -->
    <script src="assets/js/pages/form-advanced.init.js"></script>
    <!-- input spin init -->
    <script src="assets/js/pages/form-input-spin.init.js"></script>
    <!-- input flag init -->
    <script src="assets/js/pages/flag-input.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

</body>

</html>