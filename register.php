<?php
include 'helper/connection.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$username = $password = $nama = $jenis_kelamin = $alamat = $email = $telepon = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $nama = $_POST["nama"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $alamat = $_POST["alamat"];
    $email = $_POST["email"];
    $telepon = $_POST["telepon"];

    $id_customer = uniqid('CUS-'); // Generate a unique ID

    $sql = "INSERT INTO customer (id_customer, nama_customer, jk_customer, alamat_customer, email_customer, telp_customer, deleted)
            VALUES ('$id_customer', '$nama', '$jenis_kelamin', '$alamat', '$email', '$telepon', 0)";

    if ($con) {
        if (mysqli_query($con, $sql)) {
            $sql_user = "INSERT INTO user (username, password, tipe_user, id_customer, deleted)
                         VALUES ('$username', '$password', 'Customer', '$id_customer', 0)";

            if (mysqli_query($con, $sql_user)) {
                $_SESSION['registration_success'] = true;
                header('Location: admin/index.php');
                exit();
            } else {
                echo "Error: " . $sql_user . "<br>" . mysqli_error($con);
            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    } else {
        echo "Error: Koneksi database gagal<br>";
    }

    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            color: #1e90ff;
        }
    </style>
</head>
<body>
    <?php
    if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']) {
        echo '<p>Registrasi berhasil. Silakan <a href="admin/index.php">login</a>.</p>';
        unset($_SESSION['registration_success']);
    }
    ?>
    
    
    <form method="post" action="">
    <h2>Register</h2>
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <label for="nama">Nama:</label>
        <input type="text" name="nama" required><br>

        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select name="jenis_kelamin" required>
            <option value="Laki-Laki">Laki-Laki</option>
            <option value="Perempuan">Perempuan</option>
        </select><br>

        <label for="alamat">Alamat:</label>
        <input type="text" name="alamat" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="telepon">Telepon:</label>
        <input type="text" name="telepon" required><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>
