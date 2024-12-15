<?php
    session_start();

    // Include configuration for root and base URL
    require_once(dirname(__DIR__) . '/config.php'); 
    require_once(ROOT_PATH . '/includes/head.php'); 
    require_once(ROOT_PATH . '/includes/header.php'); 

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: " . BASE_URL . "/auth/login.php");
        exit();
    }

    $room_id = isset($_GET['room_id']) ? (int)$_GET['room_id'] : null;
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <img src="<?= BASE_URL ?>/assets/img/success.png" alt="Success" class="mb-4" width="100">
            <h1 class="display-4 text-success">Reservation Successful!</h1>
            <p class="lead">Thank you for your reservation! Your booking has been successfully submitted and is currently under review. You will receive a confirmation soon.</p>
            <hr class="my-4">

            <div class="alert alert-info">
                <strong>Note:</strong> All reservations are initially marked as <b>Pending</b>. You can check the status of your reservation from your profile or contact us for assistance.
            </div>

            <div class="mt-4">
                <a href="<?= BASE_URL ?>/index.php" class="btn btn-primary btn-lg me-2">
                    <i class="fas fa-home"></i> Return to Home
                </a>
                <a href="<?= BASE_URL ?>/views/room.php?room_id=<?= htmlspecialchars($room_id) ?>" class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-plus-circle"></i> Make Another Reservation
                </a>


            </div>
        </div>
    </div>
</div>

<?php require_once(ROOT_PATH . '/includes/scripts.php'); ?>
