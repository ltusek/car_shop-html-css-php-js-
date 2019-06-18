<?php
    include "dbconn.php";
    $query = "DELETE FROM auti WHERE id = $_POST[idBrisanja]";
    $result = mysqli_query($MySQL, $query) or die('Brisanje neuspjesno.'); 
    mysqli_close($MySQL);
    header("Location: administrator.php");
?>