<?php
require_once 'config.php';

$keyword = "";
if (isset($_POST['bcari'])) {
    $keyword = $_POST['tcari'];
} elseif (isset($_POST['breset'])) {
    $keyword = "";
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Mahasiswa - Universitas Gunadarma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<link rel="stylesheet" href="style.css">
    <div class="container mt-5">
        <h1 class="text-center text-white">Data Mahasiswa</h1>
        <h1 class="text-center text-white">Universitas Gunadarma</h1>
        <p class="text-center text-white-50 mb-4">Welcome Back, <?= isset($_SESSION["username"]) ? htmlspecialchars($_SESSION["username"]) : 'Admin Ganteng dan Cantik'; ?></p>
        <div class="row">
            <div class="col-md-10 mx-auto">

                <!-- tombol Tambah -->
                        <div class="d-flex justify-content-center mb-3">
                            <a href="index.php" class="btn btn-primary">Tambah Data Mahasiswa</a>
                        </div>

                <div class="card">
                    <div class="card-header bg-dark text-light">    
                        Data Mahasiswa
                    </div>
                    <div class="card-body bg-dark text-light">
                        
                        <!-- form Pencarian -->
                        <div class="row">
                            <div class="col-md-7 mx-auto">
                                <form method="POST" action="">
                                    <div class="input-group mb-3">
                                        <input type="text" name="tcari" value="<?= htmlspecialchars($keyword) ?>" class="form-control" placeholder="Cari berdasarkan nama...">
                                        <button class="btn btn-primary" name="bcari" type="submit">Cari</button>
                                        <button class="btn btn-danger" name="breset" type="submit">Reset</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Tabel Data -->
                        <table class="table table-bordered table-dark table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th>No.</th>
                                    <th>Email</th>
                                    <th>Nama</th>
                                    <th>Tingkat</th>
                                    <th>Tanggal Diterima</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $query = "SELECT * FROM tmahasiswa WHERE nama LIKE ? ORDER BY id DESC";
                                $stmt = $mysqli->prepare($query);
                                $search_keyword = "%" . $keyword . "%";
                                $stmt->bind_param("s", $search_keyword);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while ($data = $result->fetch_assoc()) :
                                ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($data['email']) ?></td>
                                    <td><?= htmlspecialchars($data['nama']) ?></td>
                                    <td><?= htmlspecialchars($data['tingkat']) ?></td>
                                    <td><?= htmlspecialchars($data['tanggal_diterima']) ?></td>
                                    <td class="text-center">
                                        <a href="index.php?hal=edit&id=<?= $data['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="index.php?hal=hapus&id=<?= $data['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">Hapus</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>