<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Proses upload foto
    $photo = $_FILES['photo'];
    $photoName = time() . '_' . basename($photo['name']);
    $targetDir = "uploads/";
    $targetFile = $targetDir . $photoName;

    // Cek apakah folder uploads ada, jika tidak, buat folder
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Pindahkan file ke folder uploads
    if (move_uploaded_file($photo['tmp_name'], $targetFile)) {
        $query = "INSERT INTO students (name, email, photo) VALUES ('$name', '$email', '$photoName')";
        if ($conn->query($query) === TRUE) {
            header("Location: list_students.php");
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Gagal mengupload foto.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }
        h1 {
            text-align: center;
            font-size: 2.5rem;
            color: #fff;
            margin-bottom: 20px;
        }
        form {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
        }
        form label {
            font-weight: 500;
            margin-bottom: 10px;
            display: block;
            color: #444;
        }
        .form-group {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }
        input, button {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1rem;
            box-sizing: border-box;
        }
        input:focus {
            outline: none;
            border-color: #6a11cb;
            box-shadow: 0 0 5px rgba(106, 17, 203, 0.5);
        }
        button {
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        button:hover {
            background: linear-gradient(45deg, #2575fc, #6a11cb);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(106, 17, 203, 0.3);
        }
        .back-button {
            margin-top: 20px;
            text-align: center;
        }
        .back-button a {
            display: inline-block;
            padding: 10px 20px;
            background: white;
            color: #6a11cb;
            border: 2px solid #6a11cb;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .back-button a:hover {
            background: #6a11cb;
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div>
        <h1>Registrasi Mahasiswa</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" name="name" id="name" placeholder="Masukkan Nama" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Masukkan Email" required>
            </div>
            <div class="form-group">
                <label for="photo">Foto</label>
                <input type="file" name="photo" id="photo" accept="image/*" required>
            </div>
            <button type="submit">Daftar</button>
        </form>
        <div class="back-button">
            <a href="index.php">Kembali ke Halaman Utama</a>
        </div>
    </div>
</body>
</html>
