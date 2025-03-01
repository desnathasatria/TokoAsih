<?php 

include "koneksi.php";

    if($_SERVER['REQUEST_METHOD']=='POST'){

        $mode = $_POST['mode'];
        $respon = array();
        $respon['respon']= '0';
        switch($mode){
            case 'insert':
                $nama_pelanggan = $_POST['nama_pelanggan'];
                $kategori = $_POST['kategori'];
                $alamat = $_POST['alamat'];
                $berat = $_POST['berat'];
                $harga = $_POST['harga'];
                $imstr = $_POST['image'];
                $file = $_POST['file']; 
                $path = "images/";

                $sql = "INSERT INTO laundry(nama_pelanggan, kategori, alamat, berat, harga, foto, tanggal_input)
                    VALUES('$nama_pelanggan','$kategori','$alamat','$berat','$harga','$file',now());";
                $result = mysqli_query($conn,$sql);
                if ($result) {
                    if(file_put_contents($path.$file, base64_decode($imstr))==false){
                        $respon['respon']= "0";
                        echo json_encode($respon);
                        exit();
                    } else {
                        $respon['respon']= "1";
                        echo json_encode($respon);
                        exit();
                    }
                }
                break;
            case 'show_data':
                $sql = "SELECT id, nama_pelanggan, kategori, alamat, berat, harga,
                    CONCAT('http://192.168.43.51/web_service_laundry/images/', foto) AS img, tanggal_input
                    FROM laundry";
                $result = mysqli_query($conn,$sql);

                if(mysqli_num_rows($result)>0){
                    header("Access-Control-Allow-Origin: *");
                    header("Content-Type: application/json");
                    $data_laundry = array();
                    while ($data = mysqli_fetch_assoc($result)) {
                        array_push($data_laundry, $data);
                    }
                    echo json_encode($data_laundry);
                    exit();
                } else {
                    $data_laundry = array();
                    echo json_encode($data_laundry);
                }
                break;
            case 'get_kategori':
                // $sql = "SELECT kategori, harga FROM kategori";
                $sql = "SELECT CONCAT(kategori, ' : ', harga,'/kg') AS kategori, harga FROM kategori;";
                $result = mysqli_query($conn, $sql);
            
                if (mysqli_num_rows($result) > 0) {
                    header("Access-Control-Allow-Origin: *");
                    header("Content-type: application/json; charset=UTF-8");
            
                    $kategori_harga = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $kategori = $row['kategori'];
                        $harga = $row['harga'];
            
                        $kategori_harga[] = array("kategori" => $kategori, "harga" => $harga);
                    }
            
                    echo json_encode($kategori_harga);
                }
                break;
                
            // case 'get_kategori':
            //     $sql = "SELECT kategori FROM kategori";
            //     $result = mysqli_query($conn,$sql);
            //     if (mysqli_num_rows($result)>0) {
            //         header("Access-Control-Allow-Origin: *");
            //         header("Content-type: application/json; charset=UTF-8");

            //         $nama_kategori = array();
            //             while($nama = mysqli_fetch_assoc($result)){
            //                 array_push($nama_kategori, $nama);
            //             }
            //         echo json_encode($nama_kategori);
            //     }
            //     break;
            // case 'get_harga':
            //     $kategori = $_POST['kategori']; // Kategori yang dipilih dari aplikasi
            
            //     // Query SQL untuk mendapatkan harga berdasarkan kategori
            //     $sql = "SELECT harga FROM kategori WHERE kategori = '$kategori'";
            //     $result = mysqli_query($conn, $sql);
            
            //     if (mysqli_num_rows($result) > 0) {
            //         $row = mysqli_fetch_assoc($result);
            //         $harga = $row['harga'];
            
            //         // Mengirimkan harga sebagai respons JSON
            //         $response = array('harga' => $harga);
            //         header("Access-Control-Allow-Origin: *");
            //         header("Content-type: application/json; charset=UTF-8");
            //         echo json_encode($response);
            //     }
            //     break;
                
            
            case 'delete':
                $id = $_POST['id'];

                $sql = "DELETE FROM laundry WHERE id = '$id'";
                $result = mysqli_query($conn,$sql);
                
                $respon['respon']= "1";
                echo json_encode($respon);
                exit();
                break;
            case 'edit':
                $id = $_POST['id'];
                $nama_pelanggan = $_POST['nama_pelanggan'];
                $kategori = $_POST['kategori'];
                $alamat = $_POST['alamat'];
                $berat = $_POST['berat'];
                $harga = $_POST['harga'];
                $imstr = $_POST['image'];
                $file = $_POST['file'];
                $path = "images/";

                if ($imstr == "") {
                    $sql = "UPDATE laundry SET nama_pelanggan = '$nama_pelanggan', kategori = '$kategori', alamat = '$alamat',
                        berat = '$berat', harga = '$harga' , tanggal_input = now() WHERE id = '$id'";
                    $result = mysqli_query($conn,$sql);
                    if ($result) {
                        $respon['respon']= "1";
                        echo json_encode($respon);
                        exit();
                    }
                } else {
                    $sql = "UPDATE laundry SET nama_pelanggan = '$nama_pelanggan', kategori = '$kategori', alamat = '$alamat',
                        berat = '$berat', harga = '$harga', foto = '$file', tanggal_input = now()
                        WHERE id = '$id'";
                    $result = mysqli_query($conn,$sql);
                    if(file_put_contents($path.$file, base64_decode($imstr))==false){
                        $respon['respon']= "0";
                        echo json_encode($respon);
                        exit();
                    } else {
                        $respon['respon']= "1";
                        echo json_encode($respon);
                        exit();
                    }
                }
                break;
        }
    }

?>