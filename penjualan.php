<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];

    // Ambil harga produk
    $result = mysqli_query($conn, "SELECT harga FROM produk WHERE id_produk = '$id_produk'");
    $produk = mysqli_fetch_assoc($result);
    $harga = $produk['harga'];
    $subtotal = $harga * $jumlah;
    $tanggal = date('Y-m-d H:i:s');

    // Tambah penjualan
    $sql = "INSERT INTO penjualan (tanggal_penjualan, total_harga) VALUES ('$tanggal', '$subtotal')";
    mysqli_query($conn, $sql);
    $id_penjualan = mysqli_insert_id($conn);

    // Tambah detail penjualan
    $sql = "INSERT INTO detail_penjualan (id_penjualan, id_produk, jumlah, harga_satuan, subtotal) 
            VALUES ('$id_penjualan', '$id_produk', '$jumlah', '$harga', '$subtotal')";
    mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Penjualan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Penjualan</h1>
        <nav><a href="index.html">Kembali</a></nav>

        <!-- Form Penjualan -->
        <form method="POST" onsubmit="return validateForm()">
            <label>Produk</label>
            <select name="id_produk" required>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM produk");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['id_produk']}'>{$row['nama_produk']} - Rp {$row['harga']}</option>";
                }
                ?>
            </select>
            <label>Jumlah</label>
            <input type="number" name="jumlah" required>
            <button type="submit">Tambah Penjualan</button>
        </form>

        <!-- Daftar Penjualan -->
        <table>
            <tr>
                <th>ID Penjualan</th>
                <th>Tanggal</th>
                <th>Total Harga</th>
            </tr>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM penjualan");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$row['id_penjualan']}</td>
                    <td>{$row['tanggal_penjualan']}</td>
                    <td>{$row['total_harga']}</td>
                </tr>";
            }
            ?>
        </table>
    </div>
    <script src="script.js"></script>
</body>
</html>