<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {

    $tanggal = $_POST['tanggal'];
    $jenis = $_POST['jenis_kebutuhan'];
    $keterangan = $_POST['keterangan'];
    $jumlah = $_POST['jumlah'];

    $query = mysqli_prepare($conn,
        "INSERT INTO pengeluaran
        (tanggal, jenis_kebutuhan, keterangan, jumlah)
        VALUES (?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $query, "sssi",
        $tanggal, $jenis, $keterangan, $jumlah
    );

    if (mysqli_stmt_execute($query)) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Gagal menyimpan data!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengeluaran - ezyAPP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="layout">

    <aside class="sidebar">
        <h2 class="logo">ezyAPP</h2>
        <p class="subtitle">FINANCIAL MANAGEMENT</p>

        <nav>
            <a href="index.php">Dashboard</a>
            <a href="create.php" class="active">Tambah Pengeluaran</a>
        </nav>

        <div class="sidebar-bottom">
            Household Finance System
        </div>
    </aside>

    <main class="main-content">

        <header class="topbar">
            <h2>Tambah Pengeluaran</h2>
            <p>Catat pengeluaran rumah tangga kamu.</p>
        </header>

        <section class="form-section">

            <div class="form-heading">
                <h2>Form Pengeluaran</h2>
                <p>Lengkapi informasi pengeluaran berikut.</p>
            </div>

            <?php if (isset($error)) { ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php } ?>

            <form method="POST" class="expense-form">

                <label>Tanggal Pengeluaran</label>
                <input type="date" name="tanggal" required>

                <label>Jenis Kebutuhan</label>
                <select name="jenis_kebutuhan" required>
                    <option value="">Pilih kategori</option>
                    <option value="Belanja">Belanja</option>
                    <option value="Makanan">Makanan</option>
                    <option value="Listrik">Listrik</option>
                    <option value="Transportasi">Transportasi</option>
                    <option value="Kesehatan">Kesehatan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>

                <label>Keterangan</label>
                <textarea name="keterangan" rows="4"
                    placeholder="Contoh: Membeli kebutuhan dapur"></textarea>

                <label>Jumlah Pengeluaran (Rp)</label>
                <input type="number" name="jumlah"
                    min="1" placeholder="Contoh: 150000" required>

                <div class="form-actions">
                    <button type="submit" name="simpan">
                        Simpan Pengeluaran
                    </button>

                    <a href="index.php" class="btn-back">
                        Kembali
                    </a>
                </div>

            </form>

        </section>

    </main>

</div>

</body>
</html>