<?php
    require_once('db_config.php');

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
