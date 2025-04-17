<?php
session_start();
include('include/db.php');

// Create admins table if it doesn't exist
$sql_create_table = "CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";
$conn->query($sql_create_table);

// Insert default admin if table is empty
$sql_check_admin = "SELECT * FROM admins";
$result_check = $conn->query($sql_check_admin);
if ($result_check->num_rows === 0) {
    $default_username = 'admin';
    $default_password = password_hash('admin123', PASSWORD_BCRYPT);
    $sql_insert_admin = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    $sql_insert_admin->bind_param("ss", $default_username, $default_password);
    $sql_insert_admin->execute();
}
?>


<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">


<!-- Mirrored from themesbrand.com/velzon/html/master/auth-signup-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 03 Apr 2025 09:30:21 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Sign Up | Velzon - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

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

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>

                            </div>
                            <h1 style="color:white;"> WELCOME </h1>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4 card-bg-fill">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">

                                </div>
                                <div class="p-2 mt-4">

                                    <form method="POST" action="" name="loginForm" onsubmit="return validateForm();">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Adminn UserNme <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="username"
                                                placeholder="Enter username" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label">Admin Password <span
                                                    class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Enter password" required>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit"
                                                name="login">Login</button>
                                        </div>
                                    </form>

                                    <?php
                                    // Handle login
                                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
                                        $admin_user = $_POST['username'];
                                        $admin_pass = $_POST['password'];

                                        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
                                        $stmt->bind_param("s", $admin_user);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        if ($result && $result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                            if (password_verify($admin_pass, $row['password'])) {
                                                $_SESSION["admin"] = $admin_user;
                                                echo "<script>
                alert('Login successful!');
                window.location.href = 'dashboard.php';
            </script>";
                                                exit();
                                            } else {
                                                echo "<p style='color:red;'>Invalid username or password</p>";
                                            }
                                        } else {
                                            echo "<p style='color:red;'>Invalid username or password</p>";
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">Already have an account ? <a href="auth-signin-basic.html"
                                    class="fw-semibold text-primary text-decoration-underline"> Signin </a> </p>
                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                <script>document.write(new Date().getFullYear())</script> Velzon. Crafted with <i
                                    class="mdi mdi-heart text-danger"></i> by Themesbrand
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->





    <!-- JAVASCRIPT -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="assets/js/plugins.js"></script>

    <!-- particles js -->
    <script src="assets/libs/particles.js/particles.js"></script>
    <!-- particles app js -->
    <script src="assets/js/pages/particles.app.js"></script>
    <!-- validation init -->
    <script src="assets/js/pages/form-validation.init.js"></script>
    <!-- password create init -->
    <script src="assets/js/pages/passowrd-create.init.js"></script>
</body>


</html>