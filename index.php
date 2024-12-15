<?php
    session_start(); // Start the session

    // Include configuration for root and base URL
    require_once(__DIR__ . '/config.php');

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login page if not logged in
        header("Location: " . BASE_URL . "/auth/login.php");
        exit(); // Ensure no further script execution
    }

    // Include the database configuration
    require_once(ROOT_PATH . '/database/config/db_config.php');

    // Fetch featured and active movies
    $movies_query = "SELECT * FROM movies WHERE is_featured = 1 AND status = 'active'";
    $movies_result = mysqli_query($conn, $movies_query);

    if (!$movies_result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Fetch all rows as an associative array
    $movies = mysqli_fetch_all($movies_result, MYSQLI_ASSOC);

    // Fetch all rooms
    $rooms_query = "SELECT room_id, room_name FROM rooms";
    $rooms_result = mysqli_query($conn, $rooms_query);

    $rooms = [];
    if (!$rooms_result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $rooms = mysqli_fetch_all($rooms_result, MYSQLI_ASSOC);

    $is_logged_in = isset($_SESSION['user_id']);
    $fullname = $is_logged_in ? $_SESSION['fullname'] : null;

    if ($is_logged_in) {
        $user_id = $_SESSION['user_id']; // Get the logged-in user's ID
        $count_approved = "SELECT COUNT(*) AS `approved_count` FROM `reservations` WHERE `user_id` = ? AND `status` = 'approved'";
        $stmt = mysqli_prepare($conn, $count_approved);
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        mysqli_stmt_execute($stmt);
        $count_approved_result = mysqli_stmt_get_result($stmt);
        $approved_reservations = mysqli_fetch_assoc($count_approved_result)['approved_count'];
    } else {
        $approved_reservations = 0; // Default to 0 if not logged in
    }

    // Close the connection
    mysqli_close($conn);
?>


<?php require_once('includes/head.php'); ?>

<body>

    <?php require_once('includes/header.php'); ?>
    
    <div id="moviesList" class="mt-4"></div>

    <section id="main">
        <div class="container-fluid p-0 m-0">
            <div class="row p-0 m-0 d-flex flex-column">
                <div class="col p-0 m-auto">
                    <div id="cinemaxxingCarousel" class="carousel slide" data-bs-ride="false">
                        <!-- Carousel Indicators -->
                        <div class="carousel-indicators">
                            <?php foreach ($movies as $index => $movie): ?>
                                <button type="button" data-bs-target="#cinemaxxingCarousel" data-bs-slide-to="<?= $index ?>" 
                                        class="<?= $index === 0 ? 'active' : '' ?>" 
                                        aria-current="<?= $index === 0 ? 'true' : 'false' ?>" 
                                        aria-label="Slide <?= $index + 1 ?>"></button>
                            <?php endforeach; ?>
                        </div>

                        <!-- Carousel Items -->
                        <div class="carousel-inner">
                            <?php foreach ($movies as $index => $movie): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <img src="assets/img/featured_movies_slider/<?= htmlspecialchars($movie['img_wallpaper']) ?>" class="d-block w-100" alt="<?= htmlspecialchars($movie['name']) ?>">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h3><?= htmlspecialchars($movie['name']) ?> <small>(<?= htmlspecialchars($movie['release_year']) ?>)</small></h3>
                                        <p><?= htmlspecialchars($movie['description']) ?></p>
                                        <a href="#" class="reservation_Btn">ΚΑΝΤΕ ΚΡΑΤΗΣΗ</a>
                                    </div>

                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Carousel Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#cinemaxxingCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#cinemaxxingCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require_once(ROOT_PATH . '/includes/scripts.php'); ?>
</body>
</html>