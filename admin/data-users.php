<?php
session_start();
require '../src/db/functions.php';
checkRole('admin');

$role = isset($_GET['role']) ? $_GET['role'] : '';
$users = [];

if ($role == 'mahasiswa') {
    $stmt = $db->prepare("SELECT u.id, u.email, dm.nama, dm.nim, dm.alamat, dm.telepon, dm.tempatlahir, dm.tanggallahir, dm.foto, dm.kelas
                           FROM users u
                           JOIN daftar_mahasiswa dm ON u.id = dm.user_id
                           WHERE u.role = 'mahasiswa'");
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);
} elseif ($role == 'dosen') {
    $stmt = $db->prepare("SELECT u.id, u.email, dd.nama, dd.nip, dd.alamat, dd.telepon, dd.tempatlahir, dd.tanggallahir, dd.foto
                           FROM users u
                           JOIN daftar_dosen dd ON u.id = dd.user_id
                           WHERE u.role = 'dosen'");
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);
}

$message = "";
$alert_class = "";

// Ambil pesan dan alert dari session jika ada
if (isset($_SESSION['message']) && isset($_SESSION['alert_class'])) {
    $message = $_SESSION['message'];
    $alert_class = $_SESSION['alert_class'];

    // Hapus pesan dari session setelah ditampilkan
    unset($_SESSION['message']);
    unset($_SESSION['alert_class']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>APD Learning Space - Data Pengguna</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <!-- CSS -->
    <link rel="stylesheet" href="../src/css/style.css" />
</head>
<header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm fixed-top bg-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php#home">
                <img src="../src/images/logo kampus.png" alt="Logo" width="40px" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#home" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Home
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php#about">About</a></li>
                            <li>
                                <a class="dropdown-item" href="index.php#kata-sambutan">Kata Sambutan</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php#alamat">Alamat dan Kontak</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#home" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Data Pengguna
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="data-users.php">Data Pengguna</a></li>
                            <li>
                                <a class="dropdown-item" href="input-data-dosen.php">Input Data Dosen</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#home" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Perkuliahan
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="jadwal-kuliah.php">Jadwal Kuliah</a></li>
                            <li><a class="dropdown-item" href="mata-kuliah.php">Mata Kuliah</a></li>
                            <li><a class="dropdown-item" href="tambah-matkul.php">Tambah Mata Kuliah</a></li>
                            <li><a class="dropdown-item" href="jadwal-pergantian.php">Pergantian</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End of Navbar -->
    <section class="mhs-hero d-flex align-items-center justify-content-center">
        <h1>Data Pengguna</h1>
    </section>
</header>

<body>
    <div class="container">
        <form action="" method="get" class="mb-2">
            <div class="mb-3">
                <label for="role" class="form-label">Pilih Role:</label>
                <div class="row">
                    <div class="col-sm-2">
                        <select id="role" name="role" class="form-select" required>
                            <option value="">Pilih Role</option>
                            <option value="mahasiswa" <?= ($role == 'mahasiswa') ? 'selected' : ''; ?>>Mahasiswa</option>
                            <option value="dosen" <?= ($role == 'dosen') ? 'selected' : ''; ?>>Dosen</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col submit-button">
                    <button type="submit" class="btn">Lihat Data</button>
                </div>
            </div>
        </form>
        <div class="row mb-2">
            <div class="col submit-button">
                <a href="index.php"><button class="btn btn-light">Kembali</button></a>
            </div>
        </div>
        <div class="card p-3">
            <div class="card-body">
                <?php if ($message): ?>
                    <div class="alert alert-<?= $alert_class ?> alert-dismissible fade show" role="alert">
                        <?= $message ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <div class="table-responsive">
                    <?php if (!empty($role)): ?>
                        <h3>Data Pengguna dengan role <?= htmlspecialchars(ucwords($role)) ?></h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Pengguna</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Telepon</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Alamat</th>
                                    <th><?= $role == 'mahasiswa' ? 'Kelas' : 'NIP' ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= htmlspecialchars($user['id']) ?></td>
                                        <td><?= htmlspecialchars($user['nama']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= htmlspecialchars($user['telepon']) ?></td>
                                        <td><?= htmlspecialchars($user['tempatlahir']) ?></td>
                                        <td><?= htmlspecialchars($user['tanggallahir']) ?></td>
                                        <td><?= htmlspecialchars($user['alamat']) ?></td>
                                        <td><?= htmlspecialchars($role == 'mahasiswa' ? $user['kelas'] : $user['nip']) ?></td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Pilih role untuk melihat data pengguna.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>