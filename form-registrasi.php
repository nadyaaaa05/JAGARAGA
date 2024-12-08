<?php
session_start();
include 'config/koneksi.php'; // Koneksi ke database

// Variabel untuk menyimpan pesan error atau sukses
$error = '';
$success = '';

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validasi: Cek apakah email sudah digunakan
    $queryCheck = "SELECT * FROM pemilik_rental WHERE email = '$email'";
    $resultCheck = mysqli_query($conn, $queryCheck);

    if (mysqli_num_rows($resultCheck) > 0) {
        $error = "Email sudah digunakan. Silakan gunakan email lain.";
    } else {
        // Simpan data ke database
        $queryInsert = "INSERT INTO pemilik_rental (nama_pemilik, email, password, nomor_telepon, alamat) 
                        VALUES ('$username', '$email', '$password', '', '')";

        if (mysqli_query($conn, $queryInsert)) {
            $success = "Akun berhasil dibuat. Silakan <a href='login.php'>login</a>.";
        } else {
            $error = "Terjadi kesalahan saat mendaftar. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun</title>
    <style>
        /* Reset */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #2c3e50, #82ccdd);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Form Container */
        .form-container {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-container h2 {
            font-size: 24px;
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .form-container input {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-container input:focus {
            outline: none;
            border-color: #6c5ce7;
            box-shadow: 0 0 4px rgba(108, 92, 231, 0.4);
        }

        .form-container button {
            width: 100%;
            padding: 12px 15px;
            margin-top: 10px;
            background-color: #6c5ce7;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .form-container button:hover {
            background: linear-gradient(135deg, #2c3e50, #82ccdd);
        }

        .form-container p {
            margin-top: 15px;
            font-size: 14px;
            text-align: center;
        }

        .form-container p a {
            color: #6c5ce7;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .form-container p a:hover {
            color: #4834d4;
        }

        /* Error or Success Message */
        .form-container .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        .form-container .success {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }

        /* Responsif */
        @media (max-width: 480px) {
            .form-container {
                padding: 20px;
            }

            .form-container h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Buat Akun</h2>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Nama Pengguna" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register">Buat Akun</button>
            <p>Sudah punya akun? <a href="login.php">Masuk</a></p>
        </form>
    </div>
</body>
</html>
