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
                    <h1 class="h3 mb-4 text-gray-800">Reservations</h1>

                    <!-- Reservations Table -->
                    <div class="table-responsive">
                        <table id="reservationsTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Room</th>
                                    <th>Movie</th>
                                    <th>Seats</th>
                                    <th>Timezone</th>
                                    <th>Total Amount (€)</th>
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
            // Initialize DataTable
            $('#reservationsTable').DataTable({
                ajax: "<?= BASE_URL ?>/api/reservations_data_api.php", // API endpoint
                columns: [
                    { data: 'reservation_id' },
                    { data: 'user_fullname' },
                    { 
                        data: null,
                        render: function (data) {
                            return `${data.room_name} (Seats: ${data.total_seats})`;
                        }
                    },
                    { data: 'movie_name' },
                    { data: 'number_of_seats' },
                    { data: 'timezone' },
                    { data: 'total_amount' },
                    { data: 'status' },
                    {
                        data: null,
                        render: function (data) {
                            return `
                                <button class="btn btn-success btn-sm approve-reservation" data-id="${data.reservation_id}">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                                <button class="btn btn-danger btn-sm reject-reservation" data-id="${data.reservation_id}">
                                    <i class="fas fa-times"></i> Reject
                                </button>`;
                        }
                    }
                ],
                pageLength: 10 // Default to 10 reservations per page
            });

            // Approve functionality
            $('#reservationsTable').on('click', '.approve-reservation', function () {
                const reservationId = $(this).data('id');
                if (confirm('Are you sure you want to approve this reservation?')) {
                    $.ajax({
                        url: "<?= BASE_URL ?>/api/approve_reservation.php",
                        type: 'POST',
                        data: { id: reservationId },
                        success: function (response) {
                            alert(response.message);
                            if (response.success) {
                                $('#reservationsTable').DataTable().ajax.reload();
                            }
                        },
                        error: function () {
                            alert('An error occurred while approving the reservation.');
                        }
                    });
                }
            });

            // Reject functionality
            $('#reservationsTable').on('click', '.reject-reservation', function () {
                const reservationId = $(this).data('id');
                if (confirm('Are you sure you want to reject this reservation?')) {
                    $.ajax({
                        url: "<?= BASE_URL ?>/api/reject_reservation.php",
                        type: 'POST',
                        data: { id: reservationId },
                        success: function (response) {
                            alert(response.message);
                            if (response.success) {
                                $('#reservationsTable').DataTable().ajax.reload();
                            }
                        },
                        error: function () {
                            alert('An error occurred while rejecting the reservation.');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
