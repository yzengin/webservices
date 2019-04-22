<?php

    $response = array();

    if (isset($_POST['kisi_ad'])) {
        $kisi_ad = $_POST['kisi_ad'];
   
        //DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE değişkenleri alınır.
        require_once __DIR__ . '/db_config.php';
        
        // Bağlantı oluşturuluyor.
        $baglanti = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
        
        // Bağlanti kontrolü yapılır.
        if (!$baglanti) {
            die("Hatalı bağlantı : " . mysqli_connect_error());
        }
        
        $sqlsorgu = "SELECT * FROM kisiler WHERE kisiler.kisi_ad like '%$kisi_ad%'";
        $result = mysqli_query($baglanti, $sqlsorgu);
        
        if (mysqli_num_rows($result) > 0) {

            $response["kisiler"] = array();
            
            while ($row = mysqli_fetch_assoc($result)) {
       
                $kisiler = array();
                
                $kisiler["kisi_id"] = $row["kisi_id"];
                $kisiler["kisi_ad"] = $row["kisi_ad"];
                $kisiler["kisi_tel"] = $row["kisi_tel"];

                array_push($response["kisiler"], $kisiler);
            }
      
            $response["success"] = 1;
            
            echo json_encode($response);
            
        }
        //bağlantı koparılır.
        mysqli_close($baglanti);
        
        
    } else {

        $response["success"] = 0;
        $response["message"] = "Required field(s) is missing";

        echo json_encode($response);
}
?>




