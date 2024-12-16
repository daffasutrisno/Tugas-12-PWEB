<?php
include 'config.php';

// Cek apakah ID mahasiswa diberikan melalui URL
if (!isset($_GET['id'])) {
    die("ID mahasiswa tidak ditemukan.");
}

$id = $_GET['id'];
$query = "SELECT * FROM students WHERE id = $id";
$result = $conn->query($query);

// Cek apakah data mahasiswa ditemukan
if ($result->num_rows == 0) {
    die("Mahasiswa tidak ditemukan.");
}

$student = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Proses upload foto jika ada file baru
    if ($_FILES['photo']['name']) {
        $photo = $_FILES['photo'];
        $photoName = time() . '_' . basename($photo['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . $photoName;

        if (move_uploaded_file($photo['tmp_name'], $targetFile)) {
            // Hapus foto lama jika ada
            if (file_exists("uploads/" . $student['photo'])) {
                unlink("uploads/" . $student['photo']);
            }
            $photoQuery = ", photo = '$photoName'";
        } else {
            echo "Gagal mengupload foto.";
            exit;
        }
    } else {
        $photoQuery = ""; // Tidak mengganti foto
    }

    // Update data mahasiswa
    $updateQuery = "UPDATE students SET name = '$name', email = '$email' $photoQuery WHERE id = $id";
    if ($conn->query($updateQuery) === TRUE) {
        header("Location: list_students.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: #333;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
        }
        h1 {
            text-align: center;
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #444;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="email"], input[type="file"] {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.3s ease;
        }
        input:focus {
            border-color: #6a11cb;
        }
        button {
            padding: 12px;
            font-size: 1rem;
            font-weight: 700;
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        button:hover {
            background: linear-gradient(45deg, #2575fc, #6a11cb);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(106, 17, 203, 0.3);
        }
        .nav {
            text-align: center;
            margin-top: 20px;
        }
        .nav a {
            display: inline-block;
            padding: 10px 20px;
            background: #6a11cb;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .nav a:hover {
            background: #2575fc;
        }
        @media screen and (max-width: 768px) {
            h1 {
                font-size: 1.5rem;
            }
            button, .nav a {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Mahasiswa</h1>
        <form method="POST" enctype="multipart/form-data">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" value="<?php echo $student['name']; ?>" required>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo $student['email']; ?>" required>
            <label for="photo">Foto</label>
            <input type="file" name="photo" id="photo" accept="image/*">
            <button type="submit">Simpan Perubahan</button>
        </form>
        <div class="nav">
            <a href="list_students.php">Kembali ke Daftar Mahasiswa</a>
        </div>
    </div>
</body>
</html>