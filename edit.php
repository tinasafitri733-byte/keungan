<?php
include 'koneksi.php';

$id = $_GET['id'] ?? 0;

$stmt = mysqli_prepare($conn,
    "SELECT * FROM pengeluaran WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data pengeluaran tidak ditemukan!");
}

if (isset($_POST['update'])) {

    $tanggal = $_POST['tanggal'];
    $jenis = $_POST['jenis_kebutuhan'];
    $keterangan = $_POST['keterangan'];
    $jumlah = $_POST['jumlah'];

    $update = mysqli_prepare($conn,
        "UPDATE pengeluaran
        SET tanggal = ?, jenis_kebutuhan = ?,
        keterangan = ?, jumlah = ?
        WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $update, "sssii",
        $tanggal, $jenis, $keterangan, $jumlah, $id
    );

    if (mysqli_stmt_execute($update)) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Gagal memperbarui data!";
    }
}

$kategori = [
    "Belanja", "Makanan", "Listrik",
    "Transportasi", "Kesehatan", "Lainnya"
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengeluaran - ezyAPP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="layout">

    <aside class="sidebar">

        <h2 class="logo">ezyAPP</h2>
        <p class="subtitle">FINANCIAL MANAGEMENT</p>

        <nav>
            <a href="index.php">Dashboard</a>
            <a href="create.php">Tambah Pengeluaran</a>
        </nav>

        <div class="sidebar-bottom">
            Household Finance System
        </div>

    </aside>

    <main class="main-content">

        <header class="topbar">
            <h2>Edit Pengeluaran</h2>
            <p>Perbarui catatan pengeluaran rumah tangga.</p>
        </header>

        <section class="form-section">

            <div class="form-heading">
                <h2>Form Edit Pengeluaran</h2>
                <p>Ubah informasi pengeluaran berikut.</p>
            </div>

            <?php if (isset($error)) { ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php } ?>

            <form method="POST" class="expense-form">

                <label>Tanggal Pengeluaran</label>
                <input type="date" name="tanggal"
                    value="<?= htmlspecialchars($data['tanggal']) ?>"
                    required>

                <label>Jenis Kebutuhan</label>
                <select name="jenis_kebutuhan" required>

                    <?php foreach ($kategori as $item) { ?>

                        <option value="<?= htmlspecialchars($item) ?>"
                            <?= ($data['jenis_kebutuhan'] == $item)
                            ? 'selected' : '' ?>>

                            <?= htmlspecialchars($item) ?>

                        </option>

                    <?php } ?>

                </select>

                <label>Keterangan</label>
                <textarea name="keterangan" rows="4"><?= htmlspecialchars($data['keterangan']) ?></textarea>

                <label>Jumlah Pengeluaran (Rp)</label>
                <input type="number" name="jumlah"
                    value="<?= htmlspecialchars($data['jumlah']) ?>"
                    min="1" required>

                <div class="form-actions">

                    <button type="submit" name="update">
                        Update Data
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