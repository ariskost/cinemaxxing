<?php
    session_start();

    // Include required files
    require_once(dirname(__DIR__) . '/config.php'); // Use dirname(__DIR__) to go up one directory
    require_once(ROOT_PATH . '/includes/head.php'); // Use ROOT_PATH to resolve the filesystem path
    // Include the database configuration
    require_once(ROOT_PATH . '/database/config/db_config.php');

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: " . BASE_URL . "/auth/login.php");
        exit();
    }

    // Validate query parameters
    if (!isset($_GET['room_id']) || !isset($_GET['movie_id'])) {
        die("Room and Movie IDs are required.");
    }

    $room_id = (int) $_GET['room_id'];
    $movie_id = (int) $_GET['movie_id'];
    $user_id = $_SESSION['user_id'];

    // Fetch user details
    $sqlUser = "SELECT fullname, username, email FROM users WHERE user_id = ?";
    $stmtUser = mysqli_prepare($conn, $sqlUser);
    mysqli_stmt_bind_param($stmtUser, 'i', $user_id);
    mysqli_stmt_execute($stmtUser);
    $resultUser = mysqli_stmt_get_result($stmtUser);
    $user = mysqli_fetch_assoc($resultUser);

    // Fetch movie details
    $sqlMovie = "SELECT name, age_restriction_limit, price_per_unit FROM movies WHERE id = ?";
    $stmtMovie = mysqli_prepare($conn, $sqlMovie);
    mysqli_stmt_bind_param($stmtMovie, 'i', $movie_id);
    mysqli_stmt_execute($stmtMovie);
    $resultMovie = mysqli_stmt_get_result($stmtMovie);
    $movie = mysqli_fetch_assoc($resultMovie);

    // Fetch room details
    $sqlRoom = "SELECT room_name, price_per_seat, timezone FROM rooms WHERE room_id = ?";
    $stmtRoom = mysqli_prepare($conn, $sqlRoom);
    mysqli_stmt_bind_param($stmtRoom, 'i', $room_id);
    mysqli_stmt_execute($stmtRoom);
    $resultRoom = mysqli_stmt_get_result($stmtRoom);
    $room = mysqli_fetch_assoc($resultRoom);

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

    // Close the database connection
    mysqli_close($conn);

    require_once(ROOT_PATH . '/includes/header.php');

?>

<div class="container mt-5">
        <h1 class="text-center">Reservation Summary</h1>
        <hr>

        <form action="<?= BASE_URL ?>/api/complete_reservation.php" method="POST">
            <!-- User Details -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fullname" value="<?= htmlspecialchars($user['fullname']) ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                </div>
            </div>

            <!-- Room Details -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="room_name" class="form-label">Room</label>
                    <input type="text" class="form-control" id="room_name" value="<?= htmlspecialchars($room['room_name']) ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label for="price_per_seat" class="form-label">Price per Seat</label>
                    <input type="text" class="form-control" id="price_per_seat" value="<?= htmlspecialchars($room['price_per_seat']) ?>" readonly>
                </div>
            </div>

            <!-- Movie Details -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="movie_name" class="form-label">Movie</label>
                    <input type="text" class="form-control" id="movie_name" value="<?= htmlspecialchars($movie['name']) ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label for="age_limit" class="form-label">Age Restriction</label>
                    <input type="text" class="form-control" id="age_limit" value="<?= htmlspecialchars($movie['age_restriction_limit']) ?>" readonly>
                </div>
            </div>

            <!-- Seat Selector -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="number_of_seats" class="form-label">Number of Seats</label>
                    <select class="form-select" name="number_of_seats" id="number_of_seats" required>
                        <option value="" disabled selected>-Seats-</option>
                        <?php for ($i = 1; $i <= 4; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="total_amount" class="form-label">Total Amount (€)</label>
                    <input type="text" class="form-control" id="total_amount" name="total_amount" value="0.00" readonly>
                </div>
            </div>

            <!-- Hidden Inputs -->
            <input type="hidden" id="price_per_seat" name="price_per_seat" value="<?= htmlspecialchars($room['price_per_seat']) ?>">


            <!-- Timezone Selection -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="timezone" class="form-label">Available Timezones</label>
                    <select class="form-select" name="timezone" id="timezone" required>
                        <option value="" disabled selected>- Select Timezone -</option>
                        <?php
                        // Decode the JSON string from the database
                        $timezones = json_decode($room['timezone'], true);

                        if (!empty($timezones) && is_array($timezones)) {
                            foreach ($timezones as $timezone): ?>
                                <option value="<?= htmlspecialchars($timezone) ?>"><?= htmlspecialchars($timezone) ?></option>
                            <?php endforeach;
                        } else {
                            echo "<option disabled>No available timezones</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>



            <!-- Hidden Inputs -->
            <input type="hidden" name="user_id" value="<?= $user_id ?>">
            <input type="hidden" name="room_id" value="<?= $room_id ?>">
            <input type="hidden" name="movie_id" value="<?= $movie_id ?>">

            <input type="hidden" id="hidden_price_per_seat" value="<?= htmlspecialchars($room['price_per_seat']) ?>">

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Complete Reservation</button>
            </div>
        </form>
    </div>

    <script src="<?= BASE_URL ?>/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/vendor/bootstrap-5.2.3/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const seatSelector = document.getElementById("number_of_seats");
            const pricePerSeatInput = document.getElementById("price_per_seat");
            const totalAmountField = document.getElementById("total_amount");

            const pricePerSeat = parseFloat(pricePerSeatInput.value);

            if (isNaN(pricePerSeat)) {
                console.error("Invalid price per seat value:", pricePerSeat);
            }

            seatSelector.addEventListener("change", function () {
                const numberOfSeats = parseInt(seatSelector.value);

                if (!isNaN(numberOfSeats) && !isNaN(pricePerSeat)) {
                    const totalAmount = numberOfSeats * pricePerSeat;
                    totalAmountField.value = totalAmount.toFixed(2);
                } else {
                    console.error("Invalid inputs: numberOfSeats =", numberOfSeats, "pricePerSeat =", pricePerSeat);
                    totalAmountField.value = "0.00"; // Default to 0.00 if invalid
                }
            });
        });

    </script>
