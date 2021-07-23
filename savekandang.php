<?php
include 'database.php';
// if (count($_POST) > 0) {
//     if ($_POST['type'] == 1) {

//         // if (
//         //     !empty($_POST['kd_peternak']) || !empty($_POST['tgl']) ||
//         //     !empty($_POST['waktu']) || !empty($_POST['suhu_1']) ||
//         //     !empty($_POST['kelembapan_1']) || !empty($_POST['suhu_2']) ||
//         //     !empty($_POST['kelembapan_2']) || !empty($_POST['suhu_3']) ||
//         //     !empty($_POST['kelembapan_3']) || !empty($_POST['jml_ayam']) ||
//         //     !empty($_FILES['foto_ayam']['name'])

//         // ) {
//         $uploadedFile = '';
//         if (!empty($_FILES["foto_ayam"]["type"])) {
//             $fileName = time() . '_' . $_FILES['foto_ayam']['name'];
//             $valid_extensions = array("jpeg", "jpg", "png");
//             $temporary = explode(".", $_FILES["foto_ayam"]["name"]);
//             $file_extension = end($temporary);
//             if ((($_FILES["hard_file"]["type"] == "image/png") || ($_FILES["foto_ayam"]["type"] == "image/jpg") || ($_FILES["foto_ayam"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)) {
//                 $sourcePath = $_FILES['foto_ayam']['tmp_name'];
//                 $targetPath = "../img/" . $fileName;
//                 if (move_uploaded_file($sourcePath, $targetPath)) {
//                     $uploadedFile = $fileName;
//                 }
//             }
//         }

//         $kd_peternak = $_POST['kd_peternak'];
//         $tgl = $_POST['tgl'];
//         $waktu = $_POST['waktu'];
//         $suhu_1 = $_POST['suhu_1'];
//         $kelembapan_1 = $_POST['kelembapan_1'];
//         $suhu_2 = $_POST['suhu_2'];
//         $kelembapan_2 = $_POST['kelembapan_2'];
//         $suhu_3 = $_POST['suhu_3'];
//         $kelembapan_3 = $_POST['kelembapan_3'];
//         $jml_ayam = $_POST['jml_ayam'];


//         //include database configuration file
//         include_once 'database.php';

//         //insert form data in the database
//         $insert = $conn->query("INSERT INTO kondisi_kandang 
//                                 (kd_peternak,tgl,waktu,
//                                 suhu_1,kelembapan_1,suhu_2,
//                                 kelembapan_2,suhu_3,kelembapan_3,
//                                 jml_ayam,foto_ayam) 
//                                 VALUES 
//                                 ('" . $kd_peternak . "','" . $tgl . "','" . $waktu . "',
//                                 '" . $suhu_1 . "','" . $kelembapan_1 . "','" . $suhu_2 . "',
//                                 '" . $kelembapan_2 . "','" . $suhu_3 . "','" . $kelembapan_3 . "',
//                                 '" . $jml_ayam . "','" . $uploadedFile . "')");

//         echo $insert ? 'ok' : 'err';
//     }
// }

if (count($_POST) > 0) {
    if ($_POST['type'] == 1) {

        $kd_peternak = $_POST['kd_peternak'];
        $tgl = $_POST['tgl'];
        $waktu = $_POST['waktu'];
        $suhu_1 = $_POST['suhu_1'];
        $kelembapan_1 = $_POST['kelembapan_1'];
        $suhu_2 = $_POST['suhu_2'];
        $kelembapan_2 = $_POST['kelembapan_2'];
        $suhu_3 = $_POST["suhu_3"];
        $kelembapan_3 = $_POST['kelembapan_3'];
        $jml_ayam = $_POST["jml_ayam"];
        $foto_ayam = upload();
        if (!$foto_ayam) {
            return false;
        }

        $sql = "INSERT INTO `kondisi_kandang`
                ( `kd_peternak`, `tgl`,
                `waktu`,`suhu_1`,
                `kelembapan_1`,`suhu_2`,`kelembapan_2`,
                `suhu_3`,`kelembapan_3`,`jml_ayam`,`foto_ayam`) 
		            VALUES 
                ('$kd_peternak','$tgl',
                '$waktu','$suhu_1',
                '$kelembapan_1','$suhu_2','$kelembapan_2',
                '$suhu_3','$kelembapan_3','$jml_ayam','$foto_ayam')";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}


function upload()
{
    echo "<pre>";
    print_r($_FILES);
    $namaFile = $_FILES["foto_ayam"]['name'];
    $ukuranFile = $_FILES["foto_ayam"]['size'];
    $error = $_FILES["foto_ayam"]['error'];
    $tmpName = $_FILES["foto_ayam"]['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "<script>
				alert('pilih gambar terlebih dahulu!');
			  </script>";
        return false;
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
				alert('yang anda upload bukan gambar!');
			  </script>";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if ($ukuranFile > 1000000) {
        echo "<script>
				alert('ukuran gambar terlalu besar!');
			  </script>";
        return false;
    }

    // lolos pengecekan, gambar siap diupload
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, '../img/' . $namaFileBaru);

    return $namaFileBaru;
}


if (count($_POST) > 0) {
    if ($_POST['type'] == 2) {
        $id = $_POST['id'];
        $kd_peternak = $_POST['kd_peternak'];
        $tgl = $_POST['tgl'];
        $waktu = $_POST['waktu'];
        $suhu_1 = $_POST['suhu_1'];
        $kelembapan_1 = $_POST['kelembapan_1'];
        $suhu_2 = $_POST['suhu_2'];
        $kelembapan_2 = $_POST['kelembapan_2'];
        $suhu_3 = $_POST['suhu_3'];
        $kelembapan_3 = $_POST['kelembapan_3'];
        $jml_ayam = $_POST['jml_ayam'];
        $foto_ayam = $_POST['foto_ayam'];
        $sql = "UPDATE `kondisi_kandang` SET 
                    `kd_peternak`='$kd_peternak',`tgl`='$tgl',
                    `waktu`='$waktu',`suhu_1`='$suhu_1',`kelembapan_1`='$kelembapan_1',
                    `suhu_2`='$suhu_2',`kelembapan_2`='$kelembapan_2',`suhu_3`='$suhu_3',`kelembapan_3`='$kelembapan_3',
                    `jml_ayam`='$jml_ayam',`foto_ayam`='$foto_ayam'
                WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}
if (count($_POST) > 0) {
    if ($_POST['type'] == 3) {
        $id = $_POST['id'];
        $sql = "DELETE FROM `kondisi_kandang` WHERE id=$id ";
        if (mysqli_query($conn, $sql)) {
            echo $id;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}
if (count($_POST) > 0) {
    if ($_POST['type'] == 4) {
        $id = $_POST['id'];
        $sql = "DELETE FROM kondisi_kandang WHERE id in ($id)";
        if (mysqli_query($conn, $sql)) {
            echo $id;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}
