<?php
    //session_start(); // Start the session

    // Check if the user is logged in
    $is_logged_in = isset($_SESSION['user_id']);
    $fullname = $is_logged_in ? $_SESSION['fullname'] : null;
?>
<header>
    <!-- Desktop Navbar -->
    <nav class="navbar navbar-expand-lg d-none d-lg-block">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= BASE_URL ?>/index.php"><img src="<?= BASE_URL ?>/assets/img/logo.png" alt="Cinemaxxing" width="120"></a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="navbar-nav mx-5 mb-lg-0 cinemaxxing_Navbar">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= BASE_URL ?>/index.php">ΑΡΧΙΚΗ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/views/movies.php">ΤΑΙΝΙΕΣ</a>
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
                    <?php if ($is_logged_in): ?>
                    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-user"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end user_Dropdown">
                                <li class="nav-item text-center">
                                    <span class="nav-link">Welcome,</span><small><?= htmlspecialchars($fullname) ?>!</small>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= BASE_URL ?>/auth/login.php"><i class="fas fa-sign-out-alt me-2"></i>ΑΠΟΣΥΝΔΕΣΗ</a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/auth/register.php">ΕΓΓΡΑΦΗ</a>
                        </li>
                        <li class="divider"></li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/auth/login.php">ΣΥΝΔΕΣΗ</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mobile Off-Canvas Menu -->
    <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <a class="navbar-brand" href="<?= BASE_URL ?>/index.php"><img src="assets/img/logo.png" alt="Cinemaxxing" width="120"></a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= BASE_URL ?>/index.php">ΑΡΧΙΚΗ</a>
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