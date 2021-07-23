<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location:index.php?pesan=gagal");
    exit;
}

if ($_SESSION['id_grup'] == "penjual") {
    header("Location:index.php?pesan=gagal");
}

include 'backend/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kondisi Kandang</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="1.css">
    <script src="ajax/ajaxkandang.js"></script>
</head>

<body id="purple">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg ">
        <!-- Container wrapper -->
        <div class="container-fluid">

            <!-- Navbar brand -->
            <a class="navbar-brand" href="#"><i class="fas fa-store-alt"></i>&nbsp;Kondisi Kandang</a>

            <!-- Toggle button -->
            <button class="navbar-toggler text-white" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <!-- Link -->
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-mdb-toggle="modal" data-mdb-target="#addFarmModal"><i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Data</a>
                    </li>
                    <li class="nav-item">
                        <a href="JavaScript:void(0);" class="nav-link" id="delete_multiple"><i class="fas fa-trash"></i>&nbsp;&nbsp;Hapus</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="grafikkandang.php" class="nav-link"><i class="fas fa-chart-area"></i>&nbsp;&nbsp;Grafik</a>
                    </li> -->
                    <?php if ($_SESSION['id_grup'] == "admin") { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-table"></i> Lihat Data Tabel Lain
                            </a>
                            <!-- Dropdown menu-->
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item text-dark" href="login.php"><i class="fas fa-user-friends"></i> Tabel Login</a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-dark" href="transaksi.php"><i class="fas fa-file-invoice-dollar"></i> Tabel Transaksi</a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if ($_SESSION['id_grup'] == "admin") { ?>
                        <!-- Link -->
                        <li class="nav-item">

                            <a class="nav-link" href="halaman-admin.php"><i class="fas fa-home"></i>&nbsp;Halaman Utama</a>
                        </li>
                    <?php } ?>

                    <!-- Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-alt"></i>
                            <?php echo $_SESSION["username"]; ?> (<?php echo $_SESSION["id_grup"]; ?>)
                        </a>
                        <!-- Dropdown menu -->
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item text-dark" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </li>
                        </ul>
                    </li>

                </ul>

                <!-- Search-->
                <!-- <form class="w-auto" action="" method="post">
                    <div class="d-flex flex-row mb-3" style="height:35px;">
                        <div class="p-2">
                            <input type="text" class="form-control" autofocusz placeholder="Search" aria-label="Search" name="keyword" id="keyword" autocomplete="off">
                        </div>
                        <div class="p-2">
                            <button type="submit" name="cari" id="tombol-cari" class="btn btn-secondary">Cari!</button>
                        </div>
                    </div>
                </form> -->

            </div>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
    <div id="main">
        <div class="table-responsive">
            <table class="table table-sm table-hover table-bordered table-light">
                <thead>
                    <tr>
                        <th id="head">
                            <span class="custom-checkbox">

                                <label for="selectAll"></i></label>
                                <input type="checkbox" id="selectAll">
                            </span>
                        </th>
                        <th id="head">Menu</th>
                        <th id="head">KD_Peternak</th>
                        <th id="head">Tanggal</th>
                        <th id="head">Waktu</th>
                        <th id="head">Suhu_1</th>
                        <th id="head">Kelembapan_1</th>
                        <th id="head">Suhu_2</th>
                        <th id="head">Kelembapan_2</th>
                        <th id="head">Suhu_3</th>
                        <th id="head">Kelembapan_3</th>
                        <th id="head">Jumlah Ayam</th>
                        <th id="head">Foto Ayam</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM kondisi_kandang");
                    $i = 1;
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr id="<?php echo $row["id"]; ?>">
                            <td>
                                <span class="custom-checkbox">
                                    <input type="checkbox" class="user_checkbox" data-user-id="<?php echo $row["id"]; ?>">
                                    <label for="checkbox2"></label>
                                </span>
                            </td>
                            <td>
                                <a href="#" id="tablink" class="btn btn-primary btn-sm edit" data-mdb-toggle="modal" data-mdb-target="#editFarmModal">
                                    <i class="fas fa-edit update" data-toggle="tooltip" data-id="<?php echo $row["id"]; ?>" data-kd_peternak="<?php echo $row["kd_peternak"]; ?>" data-tgl="<?php echo $row["tgl"]; ?>" data-waktu="<?php echo $row["waktu"]; ?>" data-suhu_1="<?php echo $row["suhu_1"]; ?>" data-kelembapan_1="<?php echo $row["kelembapan_1"]; ?>" data-suhu_2="<?php echo $row["suhu_2"]; ?>" data-kelembapan_2="<?php echo $row["kelembapan_2"]; ?>" data-suhu_3="<?php echo $row["suhu_3"]; ?>" data-kelembapan_3="<?php echo $row["kelembapan_3"]; ?>" data-jml_ayam="<?php echo $row["jml_ayam"]; ?>" data-foto_ayam="<?php echo $row["foto_ayam"]; ?>"></i>
                                </a>
                                <a href="#" id="tablink" data-mdb-toggle="modal" data-mdb-target="#deleteFarmModal" class="btn btn-danger btn-sm delete" data-id="<?php echo $row["id"]; ?>"><i class="fas fa-trash-alt" data-toggle="tooltip"></i></a>
                            </td>
                            <td><?php echo $row["kd_peternak"]; ?></td>
                            <td><?php echo $row["tgl"]; ?></td>
                            <td><?php echo $row["waktu"]; ?></td>
                            <td><?php echo $row["suhu_1"]; ?></td>
                            <td><?php echo $row["kelembapan_1"]; ?></td>
                            <td><?php echo $row["suhu_2"]; ?></td>
                            <td><?php echo $row["kelembapan_2"]; ?></td>
                            <td><?php echo $row["suhu_3"]; ?></td>
                            <td><?php echo $row["kelembapan_3"]; ?></td>
                            <td><?php echo $row["jml_ayam"]; ?></td>
                            <td><img src="img/<?= $row["foto_ayam"]; ?>" width="50"></td>
                        </tr>
                    <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Add Modal HTML -->
    <div id="addFarmModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="user_form" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-store-alt"></i>&nbsp;Tambah Data Kondisi Kandang</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-outline mb-4">
                            <input type="text" id="kd_peternak" name="kd_peternak" class="form-control" autocomplete="off" required />
                            <label class="form-label" for="kd_peternak"><i class="fas fa-store-alt"></i> KD_peternak</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="text" id="tgl" name="tgl" class="form-control" autocomplete="off" required readonly />
                            <label class="form-label" for="tgl"><i class="fas fa-calendar-alt"></i> Tanggal</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="text" id="waktu" name="waktu" class="form-control" autocomplete="off" required readonly />
                            <label class="form-label" for="waktu"><i class="fas fa-clock"></i> Waktu</label>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline">
                                    <input type="number" id="suhu_1" name="suhu_1" class="form-control" autocomplete="off" required />
                                    <label class="form-label" for="suhu_1"><i class="fas fa-temperature-high"></i> Suhu_1</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline">
                                    <input type="number" id="kelembapan_1" name="kelembapan_1" class="form-control" autocomplete="off" required />
                                    <label class="form-label" for="kelembapan_1"><i class="fas fa-temperature-low"></i> Kelembapan_1</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline">
                                    <input type="number" id="suhu_2" class="form-control" name="suhu_2" autocomplete="off" required />
                                    <label class="form-label" for="suhu_2"><i class="fas fa-temperature-high"></i> Suhu_2</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline">
                                    <input type="number" id="kelembapan_2" name="kelembapan_2" class="form-control" autocomplete="off" required />
                                    <label class="form-label" for="kelembapan_2"><i class="fas fa-temperature-low"></i> Kelembapan_2</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline">
                                    <input type="number" id="suhu_3" name="suhu_3" class="form-control" autocomplete="off" required />
                                    <label class="form-label" for="suhu_3"><i class="fas fa-temperature-high"></i> Suhu_3</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline">
                                    <input type="number" id="kelembapan_3" name="kelembapan_3" class="form-control" autocomplete="off" required />
                                    <label class="form-label" for="kelembapan_3"><i class="fas fa-temperature-low"></i> Kelembapan_3</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline">
                                    <input type="number" id="jml_ayam" name="jml_ayam" class="form-control" autocomplete="off" required />
                                    <label class="form-label" for="jml_ayam"><i class="fas fa-archive"></i> Jumlah Ayam</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline">
                                    <input type="file" id="foto_ayam" class="form-control" name="foto_ayam" autocomplete="off" required />
                                    <label class="form-label" for="foto_ayam"><i class="fas fa-image"></i> Foto ayam</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="1" name="type">
                        <input type="button" class="btn btn-danger" data-mdb-dismiss="modal" value="Batal">
                        <button type="button" class="btn btn-primary" id="btn-add">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal tambah data -->
    <!-- Edit Modal HTML -->
    <div id="editFarmModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="update_form">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-edit"></i>&nbsp;Edit Data Kondisi Kandang</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_u" name="id" class="form-control" required>
                        <div class="form-outline mb-4">
                            <input type="text" id="kd_peternak_u" name="kd_peternak" class="form-control" autocomplete="off" required />
                            <label class="form-label" for="kd_peternak"><i class="fas fa-store-alt"></i> KD_peternak</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="text" id="tgl_u" name="tgl" class="form-control" autocomplete="off" required />
                            <label class="form-label" for="tgl"><i class="fas fa-calendar-alt"></i> Tanggal</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="text" id="waktu_u" name="waktu" class="form-control" autocomplete="off" required />
                            <label class="form-label" for="waktu"><i class="fas fa-clock"></i> Waktu</label>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline">
                                    <input type="number" id="suhu_1_u" name="suhu_1" class="form-control" autocomplete="off" required />
                                    <label class="form-label" for="suhu_1"><i class="fas fa-temperature-high"></i> Suhu_1</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline">
                                    <input type="number" id="kelembapan_1_u" name="kelembapan_1" class="form-control" autocomplete="off" required />
                                    <label class="form-label" for="kelembapan_1"><i class="fas fa-temperature-low"></i> Kelembapan_1</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline">
                                    <input type="number" id="suhu_2_u" class="form-control" name="suhu_2" autocomplete="off" required />
                                    <label class="form-label" for="suhu_2"><i class="fas fa-temperature-high"></i> Suhu_2</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline">
                                    <input type="number" id="kelembapan_2_u" name="kelembapan_2" class="form-control" autocomplete="off" required />
                                    <label class="form-label" for="kelembapan_2"><i class="fas fa-temperature-low"></i> Kelembapan_2</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline">
                                    <input type="number" id="suhu_3_u" name="suhu_3" class="form-control" autocomplete="off" required />
                                    <label class="form-label" for="suhu_3"><i class="fas fa-temperature-high"></i> Suhu_3</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline">
                                    <input type="number" id="kelembapan_3_u" name="kelembapan_3" class="form-control" autocomplete="off" required />
                                    <label class="form-label" for="kelembapan_3"><i class="fas fa-temperature-low"></i> Kelembapan_3</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline">
                                    <input type="number" id="jml_ayam_u" name="jml_ayam" class="form-control" autocomplete="off" required />
                                    <label class="form-label" for="jml_ayam"><i class="fas fa-archive"></i> Jumlah Ayam</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline">
                                    <input type="text" id="foto_ayam_u" class="form-control" name="foto_ayam" autocomplete="off" required />
                                    <label class="form-label" for="foto_ayam"><i class="fas fa-image"></i> Foto ayam</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="2" name="type">
                        <input type="button" class="btn btn-danger" data-mdb-dismiss="modal" value="Batal">
                        <button type="button" class="btn btn-primary" id="update">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal HTML -->
    <div id="deleteFarmModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>

                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-trash"></i>&nbsp;Hapus Data Kondisi Kandang</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_d" name="id" class="form-control">
                        <p>Apakah Yakin Ingin Menghapus Data Ini ?</p>
                        <p class="text-warning"><small>Langkah Ini Tidak Bisa Diulang.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-danger" data-mdb-dismiss="modal" value="Cancel">
                        <button type="button" class="btn btn-primary" id="delete">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div style="height:40px;">
    </div>
    <footer class="text-center text-white text-lg-start fixed-bottom" id="footer">
        <!-- Copyright -->
        <div class="text-center p-3 text-white">
            © 2021 Copyright:
            <a href="https://polines.ac.id/">polines.ac.id</a>
        </div>
        <!-- Copyright -->
    </footer>
</body>
<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
<!-- date -->
<script>
    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    document.getElementById("tgl").value = date;
</script>
<!-- time -->
<script>
    var today = new Date();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    document.getElementById("waktu").value = time;
</script>

</html>