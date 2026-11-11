<?php
include 'koneksi.php';

$query_total = mysqli_query($conn,
    "SELECT SUM(jumlah) AS total FROM pengeluaran"
);
$data_total = mysqli_fetch_assoc($query_total);
$total = $data_total['total'] ?? 0;

$query_jumlah = mysqli_query($conn,
    "SELECT COUNT(*) AS jumlah FROM pengeluaran"
);
$data_jumlah = mysqli_fetch_assoc($query_jumlah);

$query = mysqli_query($conn,
    "SELECT * FROM pengeluaran ORDER BY tanggal DESC, id DESC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ezyAPP - Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <h2 class="logo">tina s</h2>
        <p class="subtitle">FINANCIAL MANAGEMENT</p>

        <nav>
            <a href="index.php" class="active">Dashboard</a>
            <a href="create.php">Tambah Pengeluaran</a>
        </nav>

        <div class="sidebar-bottom">
            Household Finance System
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <header class="topbar">
            <div>
                <h2>Dashboard</h2>
                <p>Selamat datang di tina!</p>
            </div>
        </header>

        <section class="welcome">
            <h2>Ringkasan Keuangan</h2>
            <p>Pantau pengeluaran rumah tangga dengan lebih mudah.</p>
        </section>

        <!-- STATISTIK -->
        <section class="stats">

            <div class="stat-card">
                <p>Total Pengeluaran</p>
                <h2>Rp <?= number_format($total, 0, ',', '.') ?></h2>
                <span>Seluruh pengeluaran tercatat</span>
            </div>

            <div class="stat-card">
                <p>Jumlah Transaksi</p>
                <h2><?= $data_jumlah['jumlah'] ?></h2>
                <span>Total catatan pengeluaran</span>
            </div>

        </section>

        <!-- TABEL -->
        <section class="data-section">

            <div class="section-header">
                <div>
                    <h2>Data Pengeluaran</h2>
                    <p>Daftar seluruh pengeluaran rumah tangga.</p>
                </div>

                <a href="create.php" class="btn-add">
                    + Tambah Data
                </a>
            </div>

            <div class="table-container">

                <table>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis Kebutuhan</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>

                    <?php
                    $no = 1;

                    if (mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_assoc($query)) {
                    ?>

                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['tanggal']) ?></td>
                        <td><?= htmlspecialchars($row['jenis_kebutuhan']) ?></td>
                        <td><?= htmlspecialchars($row['keterangan']) ?></td>
                        <td>Rp <?= number_format($row['jumlah'], 0, ',', '.') ?></td>

                        <td>
                            <a class="btn-edit"
                                href="edit.php?id=<?= $row['id'] ?>">Edit</a>

                            <a class="btn-delete"
                                href="delete.php?id=<?= $row['id'] ?>"
                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                Hapus
                            </a>
                        </td>
                    </tr>

                    <?php
                        }
                    } else {
                    ?>

                    <tr>
                        <td colspan="6">Belum ada data pengeluaran.</td>
                    </tr>

                    <?php } ?>

                </table>

            </div>

        </section>

        <footer>
            &copy; 2026 tina safitri - Household Finance Management
        </footer>

    </main>

</div>

</body>
</html>