<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= BASE_URL ?>/views/admin/dashboard.php">
        <div class="sidebar-brand-icon">
            <i class="fas fa-film"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Cinemaxxing</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?= BASE_URL ?>/views/admin/dashboard.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Movies -->
    <li class="nav-item">
        <a class="nav-link" href="<?= BASE_URL ?>/views/admin/movies/index.php">
            <i class="fas fa-fw fa-film"></i>
            <span>Movies</span>
        </a>
    </li>
    <!-- Nav Item - Reservations -->
    <li class="nav-item">
        <a class="nav-link" href="<?= BASE_URL ?>/views/admin/reservations/index.php">
            <i class="fas fa-fw fa-file"></i>
            <span>Reservations</span>
        </a>
    </li>

    <!-- Add more navigation items here -->
</ul>
