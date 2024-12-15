<?php
    require_once(dirname(__DIR__) . '/config.php');
    require_once(ROOT_PATH . '/database/config/db_config.php');

    header('Content-Type: application/json');

    // Fetch reservation ID
    $reservationId = $_POST['id'] ?? null;

    if ($reservationId) {
        $sql = "UPDATE reservations SET status = 'rejected' WHERE reservation_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $reservationId);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["success" => true, "message" => "Reservation rejected successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to reject reservation."]);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid reservation ID."]);
    }
    mysqli_close($conn);
?>