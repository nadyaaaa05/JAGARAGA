<?php
session_start();
include 'config/koneksi.php'; // Menghubungkan ke database

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Arahkan ke halaman login jika belum login
    exit();
}

// Ambil ID pengguna dari sesi
$user_id = $_SESSION['user_id'];

// Query untuk mengambil data kendaraan yang dimiliki oleh pengguna
$queryMobil = "SELECT * FROM mobil WHERE id_pemilik = '$user_id'";
$resultMobil = mysqli_query($conn, $queryMobil);

$queryMotor = "SELECT * FROM motor WHERE id_pemilik = '$user_id'";
$resultMotor = mysqli_query($conn, $queryMotor);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kendaraan Saya</title>
    <style>
        /* Reset CSS */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
        }

   /* Sidebar */
  .sidebar {
      width: 250px;
      height: 100vh;
      background: linear-gradient(135deg, #2c3e50, #82ccdd);
      color: white;
      position: fixed;
      display: flex;
      flex-direction: column;
      padding-top: 20px;
      box-shadow: 2px 0 8px rgba(0, 0, 0, 0.2);
    }

    .sidebar h2 {
      text-align: center;
      font-size: 22px;
      margin-bottom: 20px;
      text-transform: uppercase;
      color: white;
      border-bottom: 2px solid white;
      padding-bottom: 10px;
    }

    .sidebar a {
      text-decoration: none;
      color: white;
      font-size: 16px;
      padding: 12px 15px;
      border-radius: 8px;
      margin: 10px 0;
      transition: all 0.3s ease;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: rgba(255, 255, 255, 0.3);
      padding-left: 20px;
    }

        /* Content */
        .content {
            margin-left: 270px;
            padding: 20px;
            flex: 1;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
            font-size: 36px;
            color: #2d3436;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        h2 {
            font-size: 28px;
            margin: 30px 0 10px;
            color: #0984e3;
            text-align: left;
            padding-left: 20px;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* Card Layout */
        .cards {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background: linear-gradient(135deg, #2c3e50, #82ccdd);
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 300px;
            text-align: center;
            color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 3px solid white;
        }

        .card h4 {
            margin: 15px 0;
            font-size: 20px;
            font-weight: bold;
        }

        .card p {
            margin: 10px 15px;
            font-size: 14px;
            color: #dfe6e9;
        }

        .cta-button {
            display: inline-block;
            margin: 10px 10px 20px;
            padding: 10px 20px;
            background-color: #d63031;
            color: white;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .cta-button:hover {
            background-color: #c0392b;
            transform: scale(1.05);
        }

        .cta-button.edit {
            background-color: #00cec9;
        }

        .cta-button.edit:hover {
            background-color: #00b894;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .content {
                margin-left: 0;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .cards {
                flex-direction: column;
                align-items: center;
            }

            .card {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Menu</h2>
        <a href="beranda.php">Beranda</a>
        <a href="pesan_kendaraan.php">Pesan Kendaraan</a>
        <a href="daftar_kendaraan.php">Daftar Kendaraan</a>
        <a href="voucher.php">Voucher</a>
        <a href="kendaraan_saya.php" class="active">Kendaraan Saya</a>
    </div>

    <!-- Content -->
    <div class="content">
        <h1>Kendaraan Saya</h1>
        <h2>Kendaraan Mobil</h2>
        <div class="cards">
            <?php while ($row = mysqli_fetch_assoc($resultMobil)) : ?>
            <div class="card">
                <img src="asset/<?php echo $row['gambar_url']; ?>" alt="<?php echo htmlspecialchars($row['nama_mobil']); ?>">
                <h4><?php echo htmlspecialchars($row['nama_mobil']); ?></h4>
                <p>Rp <?php echo number_format($row['harga_per_hari'], 0, ',', '.'); ?> / hari</p>
                <p><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                <a href="edit_kendaraan.php?id=<?php echo $row['id_mobil']; ?>" class="cta-button edit">Edit</a>
                <a href="prosess/proses_hapus_kendaraan.php?id=<?php echo $row['id_mobil']; ?>&type=mobil" class="cta-button">Hapus</a>
            </div>
            <?php endwhile; ?>
        </div>

        <h2>Kendaraan Motor</h2>
        <div class="cards">
            <?php while ($row = mysqli_fetch_assoc($resultMotor)) : ?>
            <div class="card">
                <img src="asset/<?php echo $row['gambar_url']; ?>" alt="<?php echo htmlspecialchars($row['nama_motor']); ?>">
                <h4><?php echo htmlspecialchars($row['nama_motor']); ?></h4>
                <p>Rp <?php echo number_format($row['harga_per_hari'], 0, ',', '.'); ?> / hari</p>
                <p><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                <a href="edit_kendaraan.php?id=<?php echo $row['id_motor']; ?>" class="cta-button edit">Edit</a>
                <a href="prosess/proses_hapus_kendaraan.php?id=<?php echo $row['id_motor']; ?>&type=motor" class="cta-button">Hapus</a>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
