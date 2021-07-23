<?php
$servername = "localhost";
$username = "user_peternak";
$password = "#user_peternak#";
$dbname = "peternakan_ayam";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function registrasi($data)
{
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $id_grup = strtolower(stripslashes($data["id_grup"]));
    $nama = strtolower(stripslashes($data["nama"]));
    $alamat = strtolower(stripslashes($data["alamat"]));
    $kota = strtolower(stripslashes($data["kota"]));
    $tlp = strtolower(stripslashes($data["tlp"]));
    $email = strtolower(stripslashes($data["email"]));
    $last_login = strtolower(stripslashes($data["last_login"]));
    $create_login = strtolower(stripslashes($data["create_login"]));
    $stok = strtolower(stripslashes($data["stok"]));
    $harga = strtolower(stripslashes($data["harga"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM login WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
				alert('username sudah terdaftar!')
		      </script>";
        return false;
    }


    // cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
				alert('konfirmasi password tidak sesuai!');
		      </script>";
        return false;
    }

    // enkripsi password
    $password = sha1($password);

    // tambahkan userbaru ke database
    mysqli_query(
        $conn,
        "INSERT INTO login VALUES
		('','$username', '$password', 
		'$id_grup', '$nama', '$alamat', 
		'$kota', '$tlp', '$email',
		'$last_login', '$create_login', '$stok',
		'$harga')"
    );

    return mysqli_affected_rows($conn);
}

function carilogin($keyword)
{
    $query = "SELECT * FROM login
					WHERE
				username LIKE '%$keyword%' OR
          		password LIKE '%$keyword%' OR
          		id_grup LIKE '%$keyword%' OR
          		nama LIKE '%$keyword%' OR
          		alamat LIKE '%$keyword%' OR
          		kota LIKE '%$keyword%' OR
				tlp LIKE '%$keyword%' OR
				email LIKE '%$keyword%' OR
				last_login LIKE '%$keyword%' OR
				create_login LIKE '%$keyword%' OR
				stok LIKE '%$keyword%' OR
          		harga LIKE '%$keyword%'
			";
    return query($query);
}

function caritransaksi($keyword)
{
    $query = "SELECT * FROM transaksi
					WHERE
				kd_peternak LIKE '%$keyword%' OR
          		id_penjual LIKE '%$keyword%' OR
          		tgl_transaksi LIKE '%$keyword%' OR
          		waktu_transaksi LIKE '%$keyword%' OR
          		jml LIKE '%$keyword%' OR
          		harga LIKE '%$keyword%' OR
          		total LIKE '%$keyword%'
			";
    return query($query);
}

function carikandang($keyword)
{
    $query = "SELECT * FROM kondisi_kandang
					WHERE
				kd_peternak LIKE '%$keyword%' OR
          		tgl LIKE '%$keyword%' OR
          		waktu LIKE '%$keyword%' OR
          		suhu_1 LIKE '%$keyword%' OR
          		kelembapan_1 LIKE '%$keyword%' OR
				suhu_2 LIKE '%$keyword%' OR
          		kelembapan_2 LIKE '%$keyword%' OR
				suhu_3 LIKE '%$keyword%' OR
          		kelembapan_3 LIKE '%$keyword%' OR
          		jml_ayam LIKE '%$keyword%'
			";
    return query($query);
}
