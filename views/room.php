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

    

    if (!isset($_GET['room_id']) || empty($_GET['room_id'])) {
        die("Room ID is required.");
    }
    
    $room_id = (int) $_GET['room_id'];
    
    // Fetch room details
    $sqlRoom = "SELECT room_name FROM rooms WHERE room_id = ?";
    $stmtRoom = mysqli_prepare($conn, $sqlRoom);
    mysqli_stmt_bind_param($stmtRoom, 'i', $room_id);
    mysqli_stmt_execute($stmtRoom);
    $resultRoom = mysqli_stmt_get_result($stmtRoom);
    
    if (mysqli_num_rows($resultRoom) === 0) {
        die("Room not found.");
    }
    
    $room = mysqli_fetch_assoc($resultRoom);
    
    // Fetch movies assigned to this room
    $sqlMovies = "
        SELECT m.id, m.name, m.img_poster, m.release_year, m.description
        FROM movies m
        JOIN movie_room mr ON m.id = mr.movie_id
        WHERE mr.room_id = ?
    ";
    $stmtMovies = mysqli_prepare($conn, $sqlMovies);
    mysqli_stmt_bind_param($stmtMovies, 'i', $room_id);
    mysqli_stmt_execute($stmtMovies);
    $resultMovies = mysqli_stmt_get_result($stmtMovies);
    
    $movies = mysqli_fetch_all($resultMovies, MYSQLI_ASSOC);

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
        <h3 class="px-3 my-3 fw-bold">ΔΙΑΘΕΣΙΜΕΣ ΤΑΙΝΙΕΣ | <?= htmlspecialchars($room['room_name']) ?></h3>
        <hr />

        <div id="rooms_section">
            <div class="rooms_Section_Wrapper row px-4 py-5 text-center w-100">
                <?php if (empty($movies)): ?>
                    <p class="text-center">No movies available in this room.</p>
                <?php else: ?>
                    <?php foreach ($movies as $movie): ?>
                        <div class="movie_Card_Col col-4 d-flex">
                            <div class="card movie_Card m-auto <?= $index === 0 ? 'active' : '' ?>">
                                <img src="<?= BASE_URL ?>/assets/img/movies/<?= htmlspecialchars($movie['img_poster']) ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($movie['name']) ?> <small>(<?= htmlspecialchars($movie['release_year']) ?>)</small></h5>
                                    <p class="card-text"><?= htmlspecialchars($movie['description']) ?></p>
                                    <a href="<?= BASE_URL ?>/views/reservation_summary.php?room_id=<?= htmlspecialchars($room_id) ?>&movie_id=<?= htmlspecialchars($movie['id']) ?>" id="reservation_Btn" class="btn btn-cinemaxxing">ΚΑΝΤΕ ΚΡΑΤΗΣΗ</a>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</section>

<?php require_once(ROOT_PATH . '/includes/scripts.php'); ?>
