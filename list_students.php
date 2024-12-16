<?php
include 'config.php';

// Mengambil data mahasiswa dari database
$query = "SELECT * FROM students";
$students = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            margin: 30px auto;
            max-width: 900px;
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            font-size: 2rem;
            color: #444;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 0.95rem;
        }
        th {
            background-color: #6a11cb;
            color: white;
        }
        tbody tr:hover {
            background-color: #f0f8ff;
        }
        td img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        a {
            text-decoration: none;
            color: #6a11cb;
            font-weight: bold;
        }
        a:hover {
            color: #2575fc;
        }
        .nav {
            text-align: center;
            margin-top: 20px;
        }
        .nav a {
            display: inline-block;
            padding: 10px 20px;
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            margin: 5px;
            transition: all 0.3s ease;
        }
        .nav a:hover {
            background: linear-gradient(45deg, #2575fc, #6a11cb);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(106, 17, 203, 0.3);
        }
        .export-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 5px;
            transition: all 0.3s ease;
        }
        .export-btn:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }
        @media screen and (max-width: 768px) {
            table {
                font-size: 0.9rem;
            }
            th, td {
                padding: 10px;
            }
        }
        @media screen and (max-width: 480px) {
            .container {
                padding: 15px;
            }
            th, td {
                font-size: 0.8rem;
                padding: 8px;
            }
            .nav a {
                padding: 8px 15px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Mahasiswa</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($student = $students->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $student['id']; ?></td>
                    <td><?php echo $student['name']; ?></td>
                    <td><?php echo $student['email']; ?></td>
                    <td>
                        <img src="uploads/<?php echo $student['photo']; ?>" alt="Foto Mahasiswa">
                    </td>
                    <td>
                        <a href="edit_student.php?id=<?php echo $student['id']; ?>">Edit</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="nav">
            <a href="register_student.php">Tambah Mahasiswa</a>
            <a href="index.php">Kembali ke Halaman Utama</a>
            <a href="export_students.php" class="export-btn">Export to PDF</a>
        </div>
    </div>
</body>
</html>