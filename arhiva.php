<?php
    include "dbconn.php";

    $arhiva = $_POST[arhiviraj];

    if($arhiva != 1){
        $arhiva = 0;
    }
 
    $query = "UPDATE auti SET arhiviraj = $arhiva WHERE id = $_POST[idZaPromjenu]";
    $result = mysqli_query($MySQL, $query) or die('Arhiviranje neuspjesno.'); 

    mysqli_close($MySQL);
    header("Location: administrator.php");
?>