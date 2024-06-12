<?php 

include "koneksi.php";

    if($_SERVER['REQUEST_METHOD']=='POST'){

        $mode = $_POST['mode'];
        $respon = array();
        $respon['respon']= '0';
        switch($mode){
            case 'insert':
                $kategori = $_POST['kategori'];
                $harga = $_POST['harga'];
                $sql = "INSERT INTO kategori(kategori, harga) VALUES('$kategori', '$harga')";
                $result = mysqli_query($conn,$sql);
                $respon['respon']= "1";
                echo json_encode($respon);
                exit();
                break;
            case 'show_data':
                $sql = "SELECT * FROM kategori";
                $result = mysqli_query($conn,$sql);

                if(mysqli_num_rows($result)>0){
                    header("Access-Control-Allow-Origin: *");
                    header("Content-Type: application/json");
                    $data_kategori = array();
                    while ($data = mysqli_fetch_assoc($result)) {
                        array_push($data_kategori, $data);
                    }
                    echo json_encode($data_kategori);
                    exit();
                } else {
                    $data_kategori = array();
                    echo json_encode($data_kategori);
                }
                break;
            case 'delete':
                $id = $_POST['id_kategori'];
                $sql = "DELETE FROM kategori WHERE id_kategori = '$id'";
                $result = mysqli_query($conn, $sql);
                $respon['respon'] = "1";
                echo json_encode($respon);
                exit();
                break;
            case 'edit':
                $id = $_POST['id_kategori'];
                $kategori = $_POST['kategori'];
                $harga = $_POST['harga'];
                $sql = "UPDATE kategori SET kategori = '$kategori', harga = '$harga' WHERE id_kategori = '$id'";
                $result = mysqli_query($conn, $sql);
                $respon['respon'] = "1";
                echo json_encode($respon);
                exit();
                break;
        }
    }

?>