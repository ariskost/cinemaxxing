<?php
    require_once('db_config.php');

    // Fetch featured and active movies
    $sql = "SELECT * FROM movies WHERE is_featured = 1 AND status = 'active'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Fetch all rows as an associative array
    $movies = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Close the connection
    mysqli_close($conn);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinemaxxing</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/vendor/bootstrap-5.2.3/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
</head>
<body>
    
    <header>
        <!-- Desktop Navbar -->
        <nav class="navbar navbar-expand-lg d-none d-lg-block">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"><img src="assets/img/logo.png" alt="imageRender" width="120"></a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav mx-5 mb-lg-0 cinemaxxing_Navbar">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">ΑΡΧΙΚΗ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="compress-image.php">ΤΑΙΝΙΕΣ</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                ΚΑΤΗΓΟΡΙΕΣ
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">ΔΡΑΣΗΣ</a></li>
                                <li><a class="dropdown-item" href="#">ΤΡΟΜΟΥ</a></li>
                                <li><a class="dropdown-item" href="#">ΚΩΜΩΔΙΕΣ</a></li>
                                <li><a class="dropdown-item" href="#">ΡΟΜΑΝΤΙΚΕΣ</a></li>
                                <li><a class="dropdown-item" href="#">ΕΠ. ΦΑΝΤΑΣΙΑΣ</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item disabled" href="#">More Tools Coming Soon</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                ΑΙΘΟΥΣΕΣ
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Comfort</a></li>
                                <li><a class="dropdown-item" href="#">Family</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item disabled" href="#">More Rooms Coming Soon</a></li>
                            </ul>
                        </li>
                        
                    </ul>
                    <form id="searchForm" class="d-flex search_Element mx-auto" role="search">
                        <input id="searchInput" class="form-control" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-dark" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                    
                    <ul class="navbar-nav mx-5 mb-lg-0 cinemaxxing_Navbar">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">ΕΓΓΡΑΦΗ</a>
                        </li>
                        <li class="divider"></li>
                        <li class="nav-item">
                            <a class="nav-link" href="compress-image.php">ΣΥΝΔΕΣΗ</a>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Mobile Off-Canvas Menu -->
        <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
            <div class="offcanvas-header">
                <a class="navbar-brand" href="index.php"><img src="assets/img/logo.png" alt="Cinemaxxing" width="120"></a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">ΑΡΧΙΚΗ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">ΤΑΙΝΙΕΣ</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            ΚΑΤΗΓΟΡΙΕΣ
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">ΔΡΑΣΗΣ</a></li>
                            <li><a class="dropdown-item" href="#">ΤΡΟΜΟΥ</a></li>
                            <li><a class="dropdown-item" href="#">ΚΩΜΩΔΙΕΣ</a></li>
                            <li><a class="dropdown-item" href="#">ΡΟΜΑΝΤΙΚΕΣ</a></li>
                            <li><a class="dropdown-item" href="#">ΕΠ. ΦΑΝΤΑΣΙΑΣ</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item disabled" href="#">More Tools Coming Soon</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            ΑΙΘΟΥΣΕΣ
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Comfort</a></li>
                            <li><a class="dropdown-item" href="#">Family</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item disabled" href="#">More Rooms Coming Soon</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
        
        <nav class="navbar d-lg-none">
            <a class="navbar-brand d-lg-none mx-3" href="index.php"><img src="assets/img/logo.png" alt="Cinemaxxing" width="120"></a>
            <!-- Mobile Navbar Toggle Button -->
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </header>

    <div id="moviesList" class="mt-4">
        <div class="container"></div>
    </div>


    

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




    <script src="assets/vendor/bootstrap-5.2.3/js/bootstrap.bundle.js"></script>

    <script src="assets/js/app.js"></script>

    <script>
        const BASE_PATH = "<?php echo 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/'; ?>";
    </script>
</body>
</html>