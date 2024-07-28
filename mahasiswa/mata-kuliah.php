<?php
session_start();
require '../src/db/functions.php';
checkRole('mahasiswa');

$matkul = retrieve("SELECT * FROM mata_kuliah");
$id = $_GET["id"];

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
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <!-- CSS -->
  <link rel="stylesheet" href="../src/css/style.css" />
</head>
<nav class="navbar navbar-expand-lg shadow-sm fixed-top bg-navbar">
  <div class="container">
    <a class="navbar-brand" href="../mahasiswa/index.php#home">
      <img src="../src/images/logo kampus.png" alt="Logo" width="40px" />
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="index.php#home" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            Home
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php#about">About</a></li>
            <li>
              <a class="dropdown-item" href="index.php#vision-mission">Visi dan Misi</a>
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
          <a class="nav-link" href="profile.php">Profil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" onclick="confirmLogout()">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<section class="hero-matkul d-flex justify-content-center align-items-center" id="mata-kuliah">
  <h1>Mata Kuliah</h1>
</section>
</header>

<body>
  <div class="container">
    <div class="row daftar-matkul">
      <?php foreach ($matkul as $row): ?>
        <ul>
          <li>
            <a href="../mahasiswa/detail-matkul.php?id=<?= $row["id"] ?>"><?= $row["nama"]; ?> </a>
          </li>
        </ul>
      <?php endforeach; ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
    <script>
      function confirmLogout(){
        if (confirm("Apakah anda yakin ingin keluar?")){
          window.location.href = "../logout.php"
        }
      }
    </script>
</body>

</html>