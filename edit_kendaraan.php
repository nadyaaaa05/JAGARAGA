<?php
session_start();
include 'config/koneksi.php'; // Menghubungkan ke database

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Arahkan ke halaman login jika belum login
    exit();
}

// Ambil ID pengguna dari sesi login
$user_id = $_SESSION['user_id'];

// Cek apakah ada ID kendaraan yang dikirimkan untuk diedit
if (isset($_GET['id'])) {
    $kendaraan_id = $_GET['id'];

    // Query untuk mengambil data kendaraan berdasarkan ID dan pemilik
    $query = "SELECT * FROM mobil WHERE id_mobil = '$kendaraan_id' AND id_pemilik = '$user_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $kendaraan = mysqli_fetch_assoc($result);
    } else {
        // Jika kendaraan tidak ditemukan, redirect ke halaman kendaraan saya
        header('Location: kendaraan_saya.php');
        exit();
    }
} else {
    // Jika tidak ada ID yang diberikan, redirect ke halaman kendaraan saya
    header('Location: kendaraan_saya.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kendaraan</title>
    <style>
        /* Reset CSS */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            display: flex;
            min-height: 100vh;
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

        /* Konten Utama */
        .content {
            margin-left: 270px;
            padding: 40px 20px;
            flex: 1;
            background-color: #f8f9fa;
        }

        h1 {
            text-align: center;
            font-size: 32px;
            color: #34495e;
            margin-bottom: 30px;
            text-transform: uppercase;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #6c5ce7;
            border-bottom: 2px solid #6c5ce7;
            padding-bottom: 5px;
            margin-left: 10px;
        }

        /* Form Edit */
        .edit-form {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .edit-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2d3436;
        }

        .edit-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #34495e;
        }

        .edit-form input[type="text"],
        .edit-form input[type="number"],
        .edit-form textarea,
        .edit-form input[type="file"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .edit-form input[type="text"]:focus,
        .edit-form input[type="number"]:focus,
        .edit-form textarea:focus,
        .edit-form input[type="file"]:focus {
            border-color: #6c5ce7;
            outline: none;
        }

        .edit-form textarea {
            resize: vertical;
            height: 100px;
        }

        .edit-form button {
            width: 100%;
            padding: 15px;
            background-color: #6c5ce7;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .edit-form button:hover {
            background-color: #4834d4;
            transform: scale(1.02);
        }

        /* Responsif */
        @media (max-width: 768px) {
            .content {
                margin-left: 0;
                padding: 20px;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .edit-form {
                padding: 20px;
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
        <h1>Edit Kendaraan</h1>
        <div class="edit-form">
            <h2>Edit Data Kendaraan</h2>
            <form action="prosess/proses_edit_kendaraan.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $kendaraan['id_mobil']; ?>">

                <label for="merek">Merek Kendaraan:</label>
                <input type="text" id="merek" name="merek" value="<?php echo htmlspecialchars($kendaraan['nama_mobil']); ?>" required>

                <label for="tipe">Tipe Kendaraan:</label>
                <input type="text" id="tipe" name="tipe" value="<?php echo htmlspecialchars($kendaraan['tipe_mobil']); ?>" required>

                <label for="harga">Harga Sewa per Hari:</label>
                <input type="number" id="harga" name="harga" value="<?php echo htmlspecialchars($kendaraan['harga_per_hari']); ?>" min="0" required>

                <label for="deskripsi">Deskripsi Kendaraan:</label>
                <textarea id="deskripsi" name="deskripsi" required><?php echo htmlspecialchars($kendaraan['deskripsi']); ?></textarea>

                <label for="gambar">Gambar Kendaraan:</label>
                <input type="file" id="gambar" name="gambar" accept="image/*">
                <p style="font-size: 14px; color: #7f8c8d;">* Kosongkan jika tidak ingin mengganti gambar.</p>

                <button type="submit">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</body>
</html>
