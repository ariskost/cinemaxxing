<?php
require_once(__DIR__ . '/../config.php'); // Include the configuration file
require_once(ROOT_PATH . '/includes/head.php'); // Use ROOT_PATH to resolve the filesystem path
session_start(); // Start the session

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_username = trim($_POST['username']);
    $user_password = $_POST['password'];

    if (empty($user_username) || empty($user_password)) {
        $message = 'Both fields are required.';
    } else {
        require_once(ROOT_PATH . '/database/config/db_config.php');

        $sql = "SELECT `user_id`, `fullname`, `username`, `email`, `password`, `type` 
                FROM `users` 
                WHERE `email` = ? OR `username` = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'ss', $user_username, $user_username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            // Debugging block
            if (!$result) {
                die('Query failed: ' . mysqli_error($conn));
            }

            if (mysqli_num_rows($result) === 0) {
                echo "Debugging: No match found.";
                echo " Input Username: |$user_username|";
                exit();
            }

            $user = mysqli_fetch_assoc($result);

            // Debug fetched user
            // echo '<pre>';
            // print_r($user);
            // echo '</pre>';
            // exit();

            if (password_verify($user_password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['type'] = $user['type'];
                
                //header("Location: " . BASE_URL . "/index.php");
                // Redirect based on user type
                if ($user['type'] === 'employee') {
                    header("Location: " . BASE_URL . "/views/admin/dashboard.php");
                } else {
                    header("Location: " . BASE_URL . "/index.php");
                }

                exit();
            } else {
                $message = 'Invalid password.';
            }
        } else {
            die('Database error: ' . mysqli_error($conn));
        }

        mysqli_close($conn);
    }
}
?>

<body>
    <section id="login">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <img src="<?= BASE_URL ?>/assets/img/login.webp" alt="Image" class="img-fluid">
                    </div>
                    <div class="col-md-6 contents">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <h3 class="auth_Title">Sign In</h3>
                                    <hr class="spacer">
                                </div>
                                <?php if (!empty($message)): ?>
                                    <div class="alert alert-danger"><?= $message ?></div>
                                <?php endif; ?>
                                <form action="<?= BASE_URL ?>/auth/login.php" method="post" class="my-3">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control auth_Form_Input" id="username" name="username" placeholder="Your Username..." required />
                                        <label for="username">Username</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control auth_Form_Input" id="password" name="password" placeholder="Your Password..." required />
                                        <label for="password">Password</label>
                                    </div>
                                    <input type="submit" value="Log In" class="btn btn-block btn-primary w-100">
                                </form>
                                <span class="not_a_user me-3">Dont have an account yet?</span>
                                <a href="<?= BASE_URL ?>/auth/register.php">Register Here</a>
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

