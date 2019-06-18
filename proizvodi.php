<?php include "timerLogout.php"; ?>
<!DOCTYPE html>
<html>
<?php

    $activePage = "proizvodi";
?>
<head>
    <?php include "head.html"; ?>  
</head>

<body>
    <?php include "header.html"; ?>

    <?php include "navigation.php"; ?>

    <article class="wrapper">
        <h2>Automobili na prodaju</h2>
       

        <?php 
        
        define('UPLPATH', 'images/');
        
        include "dbconn.php";
        $query  = "SELECT modeli.naziv as models, marke.naziv as markes, vrste.naziv as vrst, auti.* FROM auti INNER JOIN modeli ON modeli.id = auti.IDmodel INNER JOIN vrste ON vrste.id = auti.IDvrste INNER JOIN marke ON marke.id = modeli.IDmarke";
        $result = @mysqli_query($MySQL, $query) or die('Error querying databese.');
        while($row = @mysqli_fetch_array($result)){
            if($row['arhiviraj'] == 1){
                echo '<figure><img src="images/' . $row['slika'] . '" />';

                echo '<figcaption><h3>' . $row['markes'] . ' ' . $row['models'] . '</h3>
                <div id="kategorija_naslov">
                <h4>Kategorija: ' . $row['vrst'] . '</h4>
                <p>' . $row['opis'] . '</p></div>
                <p id="cijena"> Cijena: ' . $row['cijena'] . ' kn </p></figcaption></figure>';
            }        
        }
    
        ?>
   
       
    </article>

    <?php include "footer.html"; ?>  

</body>

</html>
