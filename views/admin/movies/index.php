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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= BASE_URL ?>/assets/vendor/bootstrap-5.2.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/admin.css" rel="stylesheet">
    <title>Movies</title>
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

                <!-- Main Content -->
                <main class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Movies</h1>

                    <!-- Movies Table -->
                    <div class="table-responsive">
                        <table id="moviesTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Poster</th>
                                    <th>Name</th>
                                    <th>Release Year</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/vendor/bootstrap-5.2.3/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/sb-admin-2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#moviesTable').DataTable({
                ajax: "<?= BASE_URL ?>/api/movies_data_api.php",
                columns: [
                    { data: 'id' },
                    { 
                        data: 'img_poster',
                        render: function (data) {
                            return `<img src="<?= BASE_URL ?>/assets/img/movies/${data}" alt="Poster" width="50">`;
                        }
                    },
                    { data: 'name' },
                    { data: 'release_year' },
                    { data: 'status' },
                    {
                        data: null,
                        render: function (data) {
                            return `
                                <button class="btn btn-danger btn-sm delete-movie" data-id="${data.id}">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>`;
                        }
                    }
                ],
                pageLength: 10, // Default to 10 movies per page
                dom: '<"row"<"col-6 search_Movies_Wrapper"f><"col-6 text-end action_Column"B>>tipr', // Customize layout
                initComplete: function () {
                    // Append "Add Movie" button to the filter row
                    const addMovieButton = `
                        <a href="<?= BASE_URL ?>/views/admin/movies/add_movie.php" class="add_Movie btn btn-success ms-3">
                            <i class="fas fa-plus"></i> Add Movie
                        </a>`;
                    $('.action_Column').append(addMovieButton);
                }
            });

            // Delete functionality
            $('#moviesTable').on('click', '.delete-movie', function () {
                const movieId = $(this).data('id');
                if (confirm('Are you sure you want to delete this movie?')) {
                    $.ajax({
                        url: 'delete_movie.php',
                        type: 'POST',
                        data: { id: movieId },
                        success: function (response) {
                            alert(response.message);
                            if (response.success) {
                                $('#moviesTable').DataTable().ajax.reload();
                            }
                        },
                        error: function () {
                            alert('An error occurred while deleting the movie.');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
