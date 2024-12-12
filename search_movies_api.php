<?php
    // Allow cross-origin requests
    header("Access-Control-Allow-Origin: *"); // Allow requests from all origins
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Specify allowed HTTP methods
    header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Specify allowed headers
    header('Content-Type: application/json');
    
    // Correct path to db_config.php
    require_once(__DIR__ . '/database/config/db_config.php'); // Adjust path if necessary

    // Get the search query
    $searchQuery = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : '';

    // Fetch movies matching the search query
    $sql = "SELECT `name`, `img_poster` FROM `movies` WHERE (`name` LIKE '%$searchQuery%') AND `status` = 'active'";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Create an array of movies
    $movies = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $movies[] = $row;
    }

    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode($movies);

    // Close the connection
    mysqli_close($conn);
?>
