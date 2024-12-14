<?php
    session_start(); // Start the session

    // Include configuration for root and base URL
    require_once(dirname(__DIR__) . '/config.php'); // Use dirname(__DIR__) to go up one directory
    require_once(ROOT_PATH . '/includes/head.php'); // Use ROOT_PATH to resolve the filesystem path
    // Include the database configuration
    require_once(ROOT_PATH . '/database/config/db_config.php');
    require_once(ROOT_PATH . '/includes/header.php');

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login page if not logged in
        header("Location: " . BASE_URL . "/auth/login.php");
        exit(); // Ensure no further script execution
    }

    

    // Fetch featured and active movies
    $sql = "SELECT * FROM `movies` WHERE `status` = 'active'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Fetch all rows as an associative array
    $movies = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Close the connection
    mysqli_close($conn);


?>

<section id="rooms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div id="hero_section">
                    <div class="hero_Section_Wrapper px-4 py-5 text-center">
                        <img class="d-block mx-auto mb-4" src="<?= BASE_URL ?>/assets/img/logo.png" alt="" width="72" height="57">
                        <h1 class="display-5 fw-bold">Your Next Favorite Movie Awaits</h1>
                        <div class="col-lg-6 mx-auto">
                            <p class="lead mb-4">Dive into a world of action, drama, and adventure. Explore top-rated hits and hidden gems, all in one place. Ready to find your next obsession?</p>
                            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                                <a type="button" href="<?= BASE_URL ?>/views/rooms.php" class="btn btn-outline-secondary btn-lg w-100 px-4">Choose your Room</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid rooms_Container">
        <h3 class="px-3 my-3 fw-bold">ΔΙΑΘΕΣΙΜΕΣ ΤΑΙΝΙΕΣ</h3>
        <hr />

        <div id="rooms_section">
            <div class="rooms_Section_Wrapper row px-4 py-5 text-center w-100">
                <?php foreach ($movies as $index => $movie): ?>
                    <div class="movie_Card_Col col-3 d-flex">
                        <div class="card movie_Card m-auto <?= $index === 0 ? 'active' : '' ?>">
                            <img src="<?= BASE_URL ?>/assets/img/movies/<?= htmlspecialchars($movie['img_poster']) ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($movie['name']) ?> <small>(<?= htmlspecialchars($movie['release_year']) ?>)</small></h5>
                                <p class="card-text"><?= htmlspecialchars($movie['description']) ?></p>
                                <a href="<?= BASE_URL ?>/views/movie.php?id=<?= htmlspecialchars($movie['id']) ?>" class="btn btn-cinemaxxing">ΚΑΝΤΕ ΚΡΑΤΗΣΗ</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</section>

<?php require_once(ROOT_PATH . '/includes/scripts.php'); ?>
