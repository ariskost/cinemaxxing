<?php
require_once(__DIR__ . '/../../../config.php');
require_once(ROOT_PATH . '/database/config/db_config.php');
require_once(ROOT_PATH . '/includes/head.php');

// Start the session
session_start();

// Check user type for access
if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'employee') {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $release_year = (int)$_POST['release_year'];
    $status = trim($_POST['status']);
    $description = trim($_POST['description']);

    // Validate required fields
    if (empty($name) || empty($release_year) || empty($status) || empty($description)) {
        die("All fields are required.");
    }

    // Handle file uploads
    $poster_dir = ROOT_PATH . '/assets/img/movies/';
    $wallpaper_dir = ROOT_PATH . '/assets/img/movies/';

    $img_poster = $_FILES['img_poster'];
    $img_wallpaper = $_FILES['img_wallpaper'];

    // Validate and move poster
    if ($img_poster['error'] === UPLOAD_ERR_OK) {
        $poster_filename = basename($img_poster['name']);
        $poster_path = $poster_dir . $poster_filename;
        move_uploaded_file($img_poster['tmp_name'], $poster_path);
    } else {
        die("Failed to upload poster.");
    }

    // Validate and move wallpaper
    if ($img_wallpaper['error'] === UPLOAD_ERR_OK) {
        $wallpaper_filename = basename($img_wallpaper['name']);
        $wallpaper_path = $wallpaper_dir . $wallpaper_filename;
        move_uploaded_file($img_wallpaper['tmp_name'], $wallpaper_path);
    } else {
        die("Failed to upload wallpaper.");
    }

    // Insert movie into the database
    $sql = "INSERT INTO movies (name, release_year, status, description, img_poster, img_wallpaper) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sissss', $name, $release_year, $status, $description, $poster_filename, $wallpaper_filename);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: " . BASE_URL . "/views/admin/movies/index.php?success=1");
        exit();
    } else {
        die("Failed to add movie: " . mysqli_error($conn));
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= BASE_URL ?>/assets/vendor/bootstrap-5.2.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/admin.css" rel="stylesheet">
    <title>Add Movie</title>
</head>
<body>
    
    <div id="wrapper">
        <!-- Sidebar -->
        <?php require_once(ROOT_PATH . '/includes/admin/sidebar.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <?php require_once(ROOT_PATH . '/includes/admin/topbar.php'); ?>

                <main class="container-fluid mt-5">
                    <div class="container_header mb-4">
                        <h3 class="add_Movie_Title">Add New Movie</h3>
                        <a href="<?= BASE_URL ?>/views/admin/movies/index.php" class="back_To_Movies">Back to Movies</a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form action="#" method="POST" enctype="multipart/form-data">
                                <!-- Movie Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Movie Name</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>

                                <!-- Release Year -->
                                <div class="mb-3">
                                    <label for="release_year" class="form-label">Release Year</label>
                                    <input type="number" id="release_year" name="release_year" class="form-control" required>
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-select" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
                                </div>

                                <!-- File Upload for img_poster -->
                                <div class="mb-3">
                                    <label for="img_poster" class="form-label">Movie Poster</label>
                                    <input type="file" id="img_poster" name="img_poster" class="form-control" accept="image/*" required>
                                </div>

                                <!-- File Upload for img_wallpaper -->
                                <div class="mb-3">
                                    <label for="img_wallpaper" class="form-label">Movie Wallpaper</label>
                                    <input type="file" id="img_wallpaper" name="img_wallpaper" class="form-control" accept="image/*" required>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Add Movie</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
    <script src="<?= BASE_URL ?>/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/vendor/bootstrap-5.2.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
