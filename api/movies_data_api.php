<?php
require_once(dirname(__DIR__) . '/config.php');
require_once(ROOT_PATH . '/database/config/db_config.php');

header('Content-Type: application/json');

// Fetch all movies
$sql = "SELECT * FROM movies";
$result = mysqli_query($conn, $sql);

$data = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
} else {
    die(json_encode(['error' => mysqli_error($conn)]));
}

// Return all data as JSON
echo json_encode(['data' => $data]);

mysqli_close($conn);
?>
