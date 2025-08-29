<?php
require 'fungsi.php';

// Proses form
if (isset($_POST['aksi'])) {
    switch ($_POST['aksi']) {
        case 'tambah':
            tambahBarang($conn, $_POST['nama'], $_POST['stok']);
            break;
        case 'hapus':
            hapusBarang($conn, $_POST['id']);
            break;
        case 'kurangi':
            kurangiStok($conn, $_POST['id'], $_POST['jumlah']);
            break;
        case 'tambah_stok':
            tambahStok($conn, $_POST['id'], $_POST['jumlah']);
            break;
    }
    header("Location: index.php");
    exit;
}

$data = ambilSemuaBarang($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Stok Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold text-primary">
                <i class="bi bi-box-seam me-2"></i>Aplikasi Manajemen Stok Barang
            </h1>
            <div class="bg-primary text-white px-3 py-2 rounded">
                <span class="fw-semibold">Total Items:</span> 
                <span class="badge bg-white text-primary ms-1"><?= $data->num_rows ?></span>
            </div>
        </div>

        <!-- Form Tambah Barang -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah Barang Baru</h5>
            </div>
            <div class="card-body">
                <form method="post" class="row g-3 align-items-end">
                    <input type="hidden" name="aksi" value="tambah">
                    <div class="col-md-5">
                        <label class="form-label fw-semibold">Nama Barang</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama barang" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Stok Awal</label>
                        <input type="number" name="stok" class="form-control" min="0" placeholder="Jumlah" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-lg me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Daftar Barang -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0"><i class="bi bi-table me-2 text-primary"></i>Daftar Stok Barang</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Nama Barang</th>
                                <th>Stok</th>
                                <th width="40%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($data->num_rows > 0): ?>
                                <?php while ($row = $data->fetch_assoc()): ?>
                                <tr>
                                    <td class="ps-4 fw-semibold"><?= htmlspecialchars($row['nama']) ?></td>
                                    <td>
                                        <span class="badge bg-success bg-opacity-10 text-success fs-6 px-3 py-2">
                                            <i class="bi bi-box me-1"></i><?= $row['stok'] ?> unit
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2">
                                            <!-- Hapus -->
                                            <form method="post" class="d-inline">
                                                <input type="hidden" name="aksi" value="hapus">
                                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-light text-danger border">
                                                    <i class="bi bi-trash me-1"></i> Hapus
                                                </button>
                                            </form>

                                            <!-- Kurangi -->
                                            <form method="post" class="d-inline d-flex gap-1">
                                                <input type="hidden" name="aksi" value="kurangi">
                                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                <input type="number" name="jumlah" min="1" max="<?= $row['stok'] ?>" 
                                                       class="form-control form-control-sm" style="width:80px" 
                                                       placeholder="Qty" required>
                                                <button type="submit" class="btn btn-sm btn-outline-warning">
                                                    <i class="bi bi-dash-lg"></i> Kurangi
                                                </button>
                                            </form>

                                            <!-- Tambah -->
                                            <form method="post" class="d-inline d-flex gap-1">
                                                <input type="hidden" name="aksi" value="tambah_stok">
                                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                <input type="number" name="jumlah" min="1" 
                                                       class="form-control form-control-sm" style="width:80px" 
                                                       placeholder="Qty" required>
                                                <button type="submit" class="btn btn-sm btn-outline-success">
                                                    <i class="bi bi-plus-lg"></i> Tambah
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                        Belum ada data barang
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>