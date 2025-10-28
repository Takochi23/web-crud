<?php
session_start();
 
// cek jika pengguna belum login, maka alihkan ke halaman login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


//koneksi Database
$server = "localhost";

?>

<?php
//koneksi Database
$server = "localhost";
$user = "root";
$password = "";
$database = "tmahasiswa";

$koneksi = mysqli_connect($server, $user, $password, $database) or die(mysqli_error($koneksi));

//jika tombol simpan diklik
if (isset($_POST['bsimpan'])) {

    // Pengujian apakah data akan diedit atau disimpan baru
    if (isset($_POST['id']) && $_POST['id'] != "") {
        // Data akan diedit
        $ubah = mysqli_query($koneksi, "UPDATE tmahasiswa SET
                                            email = '$_POST[temail]',
                                            nama = '$_POST[tnama]',
                                            tingkat = '$_POST[ttingkat]',
                                            tanggal_diterima = '$_POST[ttanggal_diterima]'
                                        WHERE id = '$_POST[id]'
                                      ");
        if ($ubah) {
            echo "<script>
                    alert('Ubah data sukses!');
                    document.location='data_mahasiswa.php';
                 </script>";
        } else {
            echo "<script>
                    alert('Ubah data GAGAL!');
                    document.location='index.php';
                 </script>";
        }
    } else {
        // data akan disimpan baru
        $simpan = mysqli_query($koneksi, "INSERT INTO tmahasiswa (email, nama, tingkat, tanggal_diterima)
                                          VALUES ('$_POST[temail]',
                                                  '$_POST[tnama]',
                                                  '$_POST[ttingkat]',
                                                  '$_POST[ttanggal_diterima]')
                                        ");
        if ($simpan) {
            echo "<script>
                    alert('Sukses Tersimpan');
                    document.location='data_mahasiswa.php';
                 </script>";
        } else {
            echo "<script>
                    alert('GAGAL SIMPAN');
                    document.location='index.php';
                 </script>";
        }
    }
}


//deklarasi untuk menampung data yang akan diedit
$vkode = "";
$vemail = "";
$vnama = "";
$vtingkat = "";
$vttanggal_diterima = "";

//pengujian jika tombol edit atau hapus
if (isset($_GET['hal'])) {

    if ($_GET['hal'] == "edit") {
        //tampilkan data yang akan diedit
        $tampil = mysqli_query($koneksi, "SELECT * FROM tmahasiswa WHERE id = '$_GET[id]'");
        $data = mysqli_fetch_array($tampil);
        if ($data) {
            //jika data ditemukan, maka data ditampung ke dalam variabel
            $vkode = $data['id'];
            $vemail = $data['email'];
            $vnama = $data['nama'];
            $vtingkat = $data['tingkat'];
            $vttanggal_diterima = $data['tanggal_diterima'];
        }
    } else if ($_GET['hal'] == "hapus") {
        // hapus data
        $hapus = mysqli_query($koneksi, "DELETE FROM tmahasiswa WHERE id = '$_GET[id]'");
        if ($hapus) {
            echo "<script>
                    alert('Hapus data sukses!');
                    document.location='data_mahasiswa.php';
                 </script>";
        } else {
            echo "<script>
                    alert('Hapus data GAGAL!');
                    document.location='data_mahasiswa.php';
                 </script>";
        }
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Input Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body style="background-color: #0c0c1c;">
    <div class="container mt-5">
      <h1 class="text-center text-light text-shadow">Data Mahasiswa</h1>
      <h1 class="text-center text-light text-shadow">Universitas Gunadarma</h1>
      <br>

      <div class="d-flex justify-content-center mb-3">
          <a href="data_mahasiswa.php" class="btn btn-primary">Lihat Data Mahasiswa</a>
          <span style="display: inline;">""</span>
          <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
      </div>

      <div class="row">
          <div class="col-md-7 mx-auto">
              <div class="card">
                  <div class="card-header bg-dark text-light">
                      Form Input Data Mahasiswa
                  </div>
                  <div class="card-body bg-dark text-light">
                      <form method="POST">
                          <input type="hidden" name="id" value="<?= $vkode ?>">

                          <div class="mb-3">
                              <label class="form-label">Email Mahasiswa</label>
                              <input type="email" name="temail" value="<?= $vemail ?>" class="form-control" placeholder="name@example.com" required>
                          </div>
                          <div class="mb-3">
                              <label class="form-label">Nama Mahasiswa</label>
                              <input type="text" name="tnama" value="<?= $vnama ?>" class="form-control" placeholder="Input Nama Mahasiswa" required>
                          </div>
                          <div class="mb-3">
                              <label class="form-label">Tingkat Mahasiswa</label>
                              <select class="form-select" name="ttingkat">
                                  <option value="<?= $vtingkat ?>"><?= ($vtingkat) ? $vtingkat : '-Pilih-' ?></option>
                                  <option value="Tingkat Satu">Tingkat Satu</option>
                                  <option value="Tingkat Dua">Tingkat Dua</option>
                                  <option value="Tingkat Tiga">Tingkat Tiga</option>
                                  <option value="Tingkat Empat">Tingkat Empat</option>
                              </select>
                          </div>
                          <div class="mb-3">
                              <label class="form-label">Tanggal Diterima</label>
                              <input type="date" name="ttanggal_diterima" value="<?= $vttanggal_diterima ?>" class="form-control" required>
                          </div>
                          <div class="text-center mt-4">
                              <button class="btn btn-primary" type="submit" name="bsimpan">Simpan</button>
                              <button class="btn btn-danger" type="reset" name="breset">Kosongkan</button>
                          </div>
                      </form>
                  </div>
                  <div class="card-footer bg-dark">
                  </div>
              </div>
          </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>