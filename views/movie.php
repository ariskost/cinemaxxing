<?php
    session_start();
    require_once(__DIR__ . '/../config.php');
    require_once(ROOT_PATH . '/database/config/db_config.php');

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login page if not logged in
        header("Location: " . BASE_URL . "/auth/login.php");
        exit(); // Ensure no further script execution
    }

    // Get the movie ID from the query string
    $movie_id = isset($_GET['id']) ? intval($_GET['id']) : null;

    if (!$movie_id) {
        die("Invalid Movie ID");
    }

    // Fetch movie details from the database
    $sql = "SELECT * FROM `movies` WHERE `id` = ? AND `status` = 'active'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $movie_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) === 0) {
        die("Movie not found.");
    }

    $movie = mysqli_fetch_assoc($result);

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

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    require_once(ROOT_PATH . '/includes/head.php');
    require_once(ROOT_PATH . '/includes/header.php');
?>

<section class="movie-details py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <img src="<?= BASE_URL ?>/assets/img/movies/<?= htmlspecialchars($movie['img_poster']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($movie['name']) ?>">
            </div>
            <div class="col-md-8">
                <h1 class="display-4"><?= htmlspecialchars($movie['name']) ?> <small>(<?= htmlspecialchars($movie['release_year']) ?>)</small></h1>
                <p class="lead"><?= htmlspecialchars($movie['description']) ?></p>
                <p><strong>Category:</strong> <?= htmlspecialchars($movie['category'] ?? 'Unknown') ?></p>
                <p><strong>Age Restriction:</strong> <?= htmlspecialchars($movie['age_restriction_limit'] ?? 'Unknown') ?></p>
                <p><strong>Duration:</strong> <?= htmlspecialchars($movie['duration'] ?? 'Unknown') ?></p>
                <p><strong>Rating:</strong> <?= htmlspecialchars($movie['imdb_rating'] ?? 'Not Rated') ?></p>
                <a href="#" class="btn btn-cinemaxxing">ΚΑΝΤΕ ΚΡΑΤΗΣΗ</a>
            </div>
        </div>
    </div>
</section>

<?php require_once(ROOT_PATH . '/includes/scripts.php'); ?>