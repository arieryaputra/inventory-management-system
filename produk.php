<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kategori = $_POST['id_kategori'];
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];

    $sql = "INSERT INTO produk (id_kategori, nama_produk, harga) VALUES ('$id_kategori', '$nama_produk', '$harga')";
    mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - Sistem Persediaan</title>
    <link rel="stylesheet" href="style.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-box-open"></i> Kelola Produk</h1>
        <nav>
            <a href="index.html"><i class="fas fa-home"></i> Kembali</a>
        </nav>

        <!-- Form Tambah Produk -->
        <form method="POST" onsubmit="return validateForm()">
            <label for="id_kategori"><i class="fas fa-tags"></i> Kategori</label>
            <select name="id_kategori" id="id_kategori" required>
                <option value="" disabled selected>Pilih Kategori</option>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM kategori");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['id_kategori']}'>{$row['nama_kategori']}</option>";
                }
                ?>
            </select>
            <label for="nama_produk"><i class="fas fa-box"></i> Nama Produk</label>
            <input type="text" name="nama_produk" id="nama_produk" placeholder="Masukkan nama produk" required>
            <label for="harga"><i class="fas fa-money-bill"></i> Harga (Rp)</label>
            <input type="number" name="harga" id="harga" step="0.01" placeholder="Masukkan harga" required>
            <button type="submit"><i class="fas fa-plus"></i> Tambah Produk</button>
        </form>

        <!-- Daftar Produk -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kategori</th>
                    <th>Nama Produk</th>
                    <th>Harga (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($conn, "SELECT p.*, k.nama_kategori FROM produk p JOIN kategori k ON p.id_kategori = k.id_kategori");
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$row['id_produk']}</td>
                            <td>{$row['nama_kategori']}</td>
                            <td>{$row['nama_produk']}</td>
                            <td>" . number_format($row['harga'], 2, ',', '.') . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' style='text-align: center;'>Belum ada produk.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="script.js"></script>
	<footer style="text-align: center; padding: 20px; background-color: #2c3e50; color: white; margin-top: 30px; border-radius: 0 0 10px 10px;">
    <p>&copy; 2025 Sistem Persediaan. All Rights Reserved.</p>
</footer>
</body>
</html>