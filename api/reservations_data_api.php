<?php
    require_once(dirname(__DIR__) . '/config.php');
    require_once(ROOT_PATH . '/database/config/db_config.php');

    header('Content-Type: application/json');

    $sql = "
        SELECT r.reservation_id, u.fullname as user_fullname, ro.room_name, ro.seats as total_seats,m.name as movie_name, 
            r.number_of_seats, r.timezone, r.total_amount, r.status
        FROM reservations r
        JOIN users u ON r.user_id = u.user_id
        JOIN rooms ro ON r.room_id = ro.room_id
        JOIN movies m ON r.movie_id = m.id
    ";
    $result = mysqli_query($conn, $sql);

    $data = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }

    // Response for DataTable
    $response = [
        "data" => $data
    ];
    echo json_encode($response);
    mysqli_close($conn);
?>