<?php
include('include/db.php'); // Database connection

// Fetch existing data from the database (id = 3)
$sql = "SELECT * FROM about WHERE id = 1";
$result = $conn->query($sql);

$existingImage = "";
$existingHeading = "";
$existingDescription = "";

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $existingImage = $row['images'];
    $existingHeading = $row['heading'];
    $existingDescription = $row['description'];
}

// Handle form submission
if (isset($_POST['submit'])) {
    $heading = $_POST['heading'];
    $description = $_POST['description'];

    $targetDir = "uploads/about_img/";
    $fileName = basename($_FILES["image"]["name"]);
    $uploadOk = false;

    // File uploaded
    if (!empty($fileName)) {
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array(strtolower($fileType), $allowedTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                $uploadOk = true;
            } else {
                echo "<p style='color: red;'>Image upload failed.</p>";
            }
        } else {
            echo "<p style='color: red;'>Only JPG, JPEG, PNG, GIF, WEBP files are allowed.</p>";
        }
    }

    // Prepare SQL query
    if ($uploadOk) {
        $sql = "UPDATE about SET images = ?, heading = ?, description = ? WHERE id = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $fileName, $heading, $description);
        $existingImage = $fileName; // update current image
    } else {
        // Update without changing the image
        $sql = "UPDATE about SET heading = ?, description = ? WHERE id = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $heading, $description);
    }

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Data updated successfully!</p>";
        $existingHeading = $heading;
        $existingDescription = $description;
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>



<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>

    <meta charset="utf-8" />
    <title>Form Advanced | Velzon - Admin & Dashboard Template</title>
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


        <!-- removeNotificationModal -->
        <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="NotificationModalbtn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-2 text-center">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                            <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                <h4>Are you sure ?</h4>
                                <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                            <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete
                                It!</button>
                        </div>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->

            <?php include('include/header.php'); ?>

            <?php
            include('include/sidenav.php');
            ?>

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
                                <h4 class="mb-sm-0"> ABOUT US </h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                        <li class="breadcrumb-item active">About </li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0"> Custom country select input </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">

                                        <form action="" method="POST" enctype="multipart/form-data">
                                            <div class="col-lg-6">

                                                <!-- Heading Input -->
                                                <div class="mt-3">
                                                    <label class="form-label" for="heading">Heading *</label>
                                                    <input type="text" id="heading" name="heading"
                                                        class="form-control rounded-end flag-input"
                                                        placeholder="Heading *"
                                                        value="<?php echo htmlspecialchars($existingHeading); ?>"
                                                        required />
                                                </div>

                                                <!-- Description Textarea -->
                                                <div class="mt-3">
                                                    <label class="form-label" for="description">Description *</label>
                                                    <textarea id="description" name="description"
                                                        class="form-control rounded-end flag-input"
                                                        placeholder="Description" rows="5"
                                                        required><?php echo htmlspecialchars($existingDescription); ?></textarea>
                                                </div>

                                                <!-- Image Upload -->
                                                <div class="mt-3">
                                                    <label class="form-label" for="image">Image *</label>
                                                    <input type="file" id="image" name="image"
                                                        class="form-control rounded-end flag-input" accept="image/*" />

                                                    <!-- Display current image if exists -->
                                                    <?php if (!empty($existingImage)): ?>
                                                        <div class="mt-2">
                                                            <p>Current Image:</p>
                                                            <img src="uploads/about_img/<?php echo htmlspecialchars($existingImage); ?>"
                                                                alt="Current Image" style="max-width: 200px; height: auto;">
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                                <!-- Submit Button -->
                                                <div class="mt-3">
                                                    <button name="submit" class="btn btn-primary"
                                                        type="submit">Submit</button>
                                                </div>

                                            </div>
                                        </form>





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