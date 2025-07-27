<?php
require 'db_config.php';
require 'functions.php';
check_login();

// Proses CRUD langsung tanpa banyak validasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tambah'])) {
        $nama = sanitize($_POST['nama']);
        $stok = (int)$_POST['stok'];
        $harga = (float)$_POST['harga'];
        
        quick_query("INSERT INTO items (name, quantity, price) VALUES ('$nama', $stok, $harga)");
    }
    elseif (isset($_POST['update'])) {
        $id = (int)$_POST['id'];
        $stok = (int)$_POST['stok'];
        
        quick_query("UPDATE items SET quantity = $stok WHERE id = $id");
    }
    elseif (isset($_POST['hapus'])) {
        $id = (int)$_POST['id'];
        quick_query("DELETE FROM items WHERE id = $id");
    }
    
    // Redirect untuk menghindari resubmit
    redirect('dashboard.php');
}

// Ambil data barang
$items = quick_query("SELECT * FROM items ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Stok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
    function konfirmasiHapus(id) {
        if (confirm('Hapus barang ini?')) {
            document.getElementById('hapus-'+id).submit();
        }
    }
    </script>
    <style>
    body { padding: 20px; background-color: #f8f9fa; }
    .card { margin-bottom: 20px; }
    .table-responsive { overflow-x: auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Manajemen Stok Barang</h1>
        
        <!-- Form Tambah Barang -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tambah Barang Baru</h5>
                <form method="POST">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" name="nama" class="form-control" placeholder="Nama Barang" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="stok" class="form-control" placeholder="Stok" required min="0">
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="harga" class="form-control" placeholder="Harga" required min="0" step="100">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" name="tambah" class="btn btn-primary w-100">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Daftar Barang -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Daftar Stok Barang</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Barang</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($item = $items->fetch_assoc()): ?>
                            <tr>
                                <td><?= $item['id'] ?></td>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                        <div class="input-group input-group-sm">
                                            <input type="number" name="stok" value="<?= $item['quantity'] ?>" 
                                                   class="form-control" min="0" style="width: 80px;">
                                            <button type="submit" name="update" class="btn btn-outline-primary">Update</button>
                                        </div>
                                    </form>
                                </td>
                                <td><?= format_rupiah($item['price']) ?></td>
                                <td>
                                    <form method="POST" id="hapus-<?= $item['id'] ?>" class="d-inline">
                                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                        <button type="button" name="hapus" class="btn btn-danger btn-sm" 
                                                onclick="konfirmasiHapus(<?= $item['id'] ?>)">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Footer Kecil -->
        <div class="text-center mt-5 text-muted small">
            &copy; <?= date('Y') ?> Sistem Stok Barang
        </div>
    </div>
</body>
</html>
