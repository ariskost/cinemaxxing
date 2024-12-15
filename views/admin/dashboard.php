<?php
require_once(__DIR__ . '/../../config.php');
require_once(ROOT_PATH . '/database/config/db_config.php');
require_once(ROOT_PATH . '/includes/head.php');

// Start the session (important to access $_SESSION)
session_start();

// Check user type for access
if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'employee') {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= BASE_URL ?>/assets/vendor/bootstrap-5.2.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/sb-admin-2.min.css" rel="stylesheet">
    
    <title>Dashboard</title>
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <?php require_once(ROOT_PATH . "/includes/admin/sidebar.php"); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <?php require_once(ROOT_PATH . "/includes/admin/topbar.php"); ?>

                <!-- Main Content -->
                <main class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Welcome, <?= htmlspecialchars($_SESSION['fullname']) ?>!</h1>
                    <p class="lead">This is your dashboard where you can manage movies and reservations.</p>
                </main>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/vendor/bootstrap-5.2.3/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/sb-admin-2.min.js"></script>
</body>
</html>
