<?php
require_once(__DIR__ . '/../config.php'); // Include the configuration file
require_once(ROOT_PATH . '/includes/head.php'); // Use ROOT_PATH to resolve the filesystem path

$message = ''; // Initialize a message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $user_username = trim($_POST['username']);
    $age = (int) $_POST['age'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];
    $user_type = $_POST['user_type'];

    // Validation
    if (empty($fullname) || empty($email) || empty($user_username) || empty($age) || empty($password) || empty($password_confirmation)) {
        $message = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Invalid email format.';
    } elseif ($password !== $password_confirmation) {
        $message = 'Passwords do not match.';
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert the user into the database
        require_once(ROOT_PATH . '/database/config/db_config.php');

        $sql = "INSERT INTO `users` (`fullname`, `email`, `username`, `type`, `age`, `password`, `created_at`) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'ssssis', $fullname, $email, $user_username, $user_type, $age, $hashed_password);
            if (mysqli_stmt_execute($stmt)) {
                $message = 'Registration successful! <a href="' . BASE_URL . '/auth/login.php">Login here</a>';
            } else {
                $message = 'Registration failed: ' . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            $message = 'Database error: ' . mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <section id="login">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 order-lg-0 order-1">
                        <img src="<?= BASE_URL ?>/assets/img/register.webp" alt="Image" class="img-fluid">
                    </div>
                    <div class="col-md-6 order-lg-1 order-0 contents">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <h3 class="auth_Title">Register</h3>
                                    <hr class="spacer">
                                </div>
                                <?php if (!empty($message)): ?>
                                    <div class="alert alert-info"><?= $message ?></div>
                                <?php endif; ?>
                                <form action="" method="post" class="my-3">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control auth_Form_Input" id="fullname" name="fullname" placeholder="Fullname" required />
                                        <label for="fullname">Fullname</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control auth_Form_Input" id="email" name="email" placeholder="name@example.com" required />
                                        <label for="email">Email</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control auth_Form_Input" id="username" name="username" placeholder="Username" required />
                                        <label for="username">Username</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control auth_Form_Input" id="age" name="age" placeholder="Age" required />
                                        <label for="age">Age</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control auth_Form_Input" id="password" name="password" placeholder="Password" required />
                                        <label for="floatingPassword">Password</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control auth_Form_Input" id="password_confirmation" name="password_confirmation" placeholder="Password" required />
                                        <label for="password_confirmation">Confirm Password</label>
                                    </div>
                 
                                    <input type="hidden" name="user_type" value="client" />
                                    <input type="submit" value="Register" class="btn btn-block btn-primary w-100">
                                </form>
                                <span class="already_a_user me-3">Already have an account yet?</span>
                                <a href="<?= BASE_URL ?>/auth/login.php">Login Here</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php require_once(ROOT_PATH . '/includes/scripts.php'); ?>
</body>
</html>
