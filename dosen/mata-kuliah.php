<?php
session_start();
require '../src/db/functions.php';
checkRole('dosen');

$message = $_SESSION['message'] ?? '';
$alert_type = $_SESSION['alert_type'] ?? '';

unset($_SESSION['message']);
unset($_SESSION['alert_type']);

$dosen_id = retrieve("SELECT user_id FROM dosen_profiles WHERE email =?", [$_SESSION['email']])[0]['user_id'];

$approved_courses = retrieve(
  "SELECT * FROM mata_kuliah WHERE dosen_id =? AND status = 'Approved'",
  [$dosen_id]
);

$pending_courses = retrieve(
  "SELECT * FROM mata_kuliah WHERE dosen_id =? AND status = 'Pending'",
  [$dosen_id]
);

$rejected_courses = retrieve(
  "SELECT * FROM mata_kuliah WHERE dosen_id =? AND status = 'Rejected'",
  [$dosen_id]
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>APD Learning Space - Mata Kuliah</title>
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
  <nav class="navbar navbar-expand-lg shadow-sm fixed-top bg-navbar">
    <div class="container">
      <a class="navbar-brand" href="../dosen/index.php#home">
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
              <li>
                <a class="dropdown-item" href="index.php#about">About</a>
              </li>
              <li>
                <a class="dropdown-item" href="index.php#kata-sambutan">Kata Sambutan</a>
              </li>
              <li>
                <a class="dropdown-item" href="index.php#alamat">Alamat dan Kontak</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="mata-kuliah.php">Mata Kuliah</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="dosen.php">Dosen</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="jadwal-kuliah.php">Jadwal Perkuliahan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="edit-profile.php">Profil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <section class="hero-matkul d-flex align-items-center justify-content-center">
    <h1>Mata Kuliah</h1>
  </section>
</header>

<body>
  <div class="container">
    <?php if ($message != ''): ?>
      <div class="alert alert-<?= htmlspecialchars($alert_type); ?>" role="alert">
        <?= htmlspecialchars($message); ?>
      </div>
    <?php endif; ?>

    <div class="card p-2">
      <div class="card-body">
        <p>Silakan tambahkan mata kuliah jika mata kuliah anda belum tersedia disini atau jika anda sudah menambahkan
          mata kuliah anda, hubungi administrator untuk persetujuan mata kuliah.</p>
        <div class="row">
          <div class="col submit-button text-center">
            <a href="tambah-matkul.php"><button class="btn">Tambah Mata Kuliah</button></a>
          </div>
        </div>
      </div>
    </div>
    <div class="row daftar-matkul mt-4">
      <h5>Mata Kuliah yang terdaftar</h5>
      <ul>
        <?php if (empty($approved_courses)): ?>
          <li>Belum ada mata kuliah yang terdaftar.</li>
        <?php else: ?>
          <?php foreach ($approved_courses as $course): ?>
            <li>
              <a href="../dosen/detail-matkul.php?id=<?= $course["id"]; ?>"><?= $course["nama"] ?> -
                <?= $course["kode"] ?></a>
            </li>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div>
    <div class="row daftar-matkul mt-4">
      <h5>Mata kuliah yang belum terdaftar</h5>
      <ul>
        <?php if (empty($pending_courses)): ?>
          <li>Belum ada mata kuliah yang ditambahkan</li>
        <?php else: ?>
          <?php foreach ($pending_courses as $course): ?>
            <li>
              <?= $course['nama']; ?> - <?= $course['kode'] ?>
            </li>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>