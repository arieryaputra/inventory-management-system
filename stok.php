<?php
include 'koneksi.php';

// Aktifkan error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];
    $tanggal_update = date('Y-m-d');

    $sql = "INSERT INTO stok (id_produk, jumlah, tanggal_update) VALUES ('$id_produk', '$jumlah', '$tanggal_update')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Stok berhasil ditambahkan!');</script>";
    } else {
        echo "<script>alert('Gagal menambah stok: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Stok - Sistem Persediaan</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header dengan Logo -->
    <header class="header">
        <div class="logo">
            <img src="assets/logo.png" alt="InventoryApp Logo">
            <h1>Kelola Stok</h1>
        </div>
    </header>

    <div class="container">
        <nav>
            <a href="index.html"><i class="fas fa-home"></i> Kembali</a>
        </nav>

        <!-- Form Tambah Stok -->
        <form method="POST" onsubmit="return validateForm()">
            <label for="id_produk"><i class="fas fa-box"></i> Produk</label>
            <select name="id_produk" id="id_produk" required>
                <option value="" disabled selected>Pilih Produk</option>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM produk");
                if (!$result) {
                    echo "<option value='' disabled>Error: " . mysqli_error($conn) . "</option>";
                } elseif (mysqli_num_rows($result) == 0) {
                    echo "<option value='' disabled>Tidak ada produk tersedia</option>";
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id_produk']}'>{$row['nama_produk']} - Rp " . number_format($row['harga'], 2, ',', '.') . " (Oleh: {$row['nama']})</option>";
                    }
                }
                ?>
            </select>
            <label for="jumlah"><i class="fas fa-cubes"></i> Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" placeholder="Masukkan jumlah stok" required>
            <button type="submit"><i class="fas fa-plus"></i> Tambah Stok</button>
        </form>

        <!-- Daftar Stok -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Tanggal Update</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($conn, "SELECT s.*, p.nama_produk FROM stok s JOIN produk p ON s.id_produk = p.id_produk");
                if (!$result) {
                    echo "<tr><td colspan='4' style='text-align: center;'>Error: " . mysqli_error($conn) . "</td></tr>";
                } elseif (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$row['id_stok']}</td>
                            <td>{$row['nama_produk']}</td>
                            <td>{$row['jumlah']}</td>
                            <td>{$row['tanggal_update']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' style='text-align: center;'>Belum ada stok.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <footer>
        <p>© 2025 Sistem Persediaan. All Rights Reserved.</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>