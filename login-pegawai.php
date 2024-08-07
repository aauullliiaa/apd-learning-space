<?php
session_start();
require 'src/db/functions.php';

$message = $_SESSION['message'] ?? '';
$alert_type = $_SESSION['alert_type'] ?? '';

unset($_SESSION['message']);
unset($_SESSION['alert_type']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emailOrId = htmlspecialchars($_POST['emailOrId']);
    $password = htmlspecialchars($_POST['password']);

    if (loginUser($emailOrId, $password)) {
        // Arahkan berdasarkan role
        switch ($_SESSION['role']) {
            case 'admin':
                header('Location: admin/index.php');
                break;
            case 'dosen':
                header('Location: dosen/index.php');
                break;
        }
        exit;
    } else {
        $message = "NIP atau password anda salah, silakan coba lagi";
        $alert_type = 'danger';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>APD Learning Space - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <!-- CSS -->
    <link rel="stylesheet" href="src/css/style.css" />
    <!-- Favicon -->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>

<body class="login d-flex align-items-center justify-content-center">
    <div class="container" style="max-width: 600px;">
        <div class="card p-3">
            <div class="card-body">
                <form action="" method="post">
                    <div class="row mb-3 text-center">
                        <h3>Login</h3>
                    </div>
                    <?php if ($message != ""): ?>
                        <div class="alert alert-<?= $alert_type; ?> mt-3" role="alert">
                            <?= $message; ?>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="emailOrId" class="form-label">NIP</label>
                        <input type="text" class="form-control" name="emailOrId" id="emailOrId" required minlength="18"
                            maxlength="18">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="row mb-3 text-center justify-content-center">
                        <div class="col-md-3 submit-button">
                            <button type="submit" name="login" class="btn btn-primary">Login</button>
                        </div>
                    </div>
                </form>
                <div class="row text-center">
                    <small style="font-size: 0.7rem;">Lupa <a href="reset-password-pegawai.php">
                            password?</a></small>
                    <small style="font-size: 0.7rem;">Belum memiliki akun? Silakan <a href="register.php">register</a>
                        disini</small>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>