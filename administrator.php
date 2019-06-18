<?php session_start();?>

<?php
if(!isset($_SESSION['username']) || empty($_SESSION['username']) || !$_SESSION['level'] == '1'){
  header("location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
<?php

    $activePage = "administrator";
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
        $query  = "SELECT modeli.naziv as models, marke.naziv as markes, auti.id as idauta, vrste.naziv as vrst, auti.* FROM auti INNER JOIN modeli ON modeli.id = auti.IDmodel INNER JOIN vrste ON vrste.id = auti.IDvrste INNER JOIN marke ON marke.id = modeli.IDmarke";
        $result = @mysqli_query($MySQL, $query) or die('Error querying databese.');
        while($row = @mysqli_fetch_array($result)){
            
                echo '<figure><img src="images/' . $row['slika'] . '" />';

                echo '<figcaption><p class="autosi">ID: '. $row['idauta'] . '</p>
                <h3>'. $row['markes'] . ' ' . $row['models'] . '</h3>
                <div id="kategorija_naslov">
                <h4>Kategorija: ' . $row['vrst'] . '</h4>
                <p>' . $row['opis'] . '</p></div>
                <p id="cijena"> Cijena: ' . $row['cijena'] . ' kn </p></figcaption></figure>';
       
        }
    
        ?>
    </article>

    <div class="administriraj wrapper">
        <form action="delete.php" method="POST" class="admin">
            <label for="idBris">Brisanje po id:</label>
            <input type="number" name="idBrisanja" id="idBris" placeholder="Unesi id automobila za brisanje:"><br>
            <input type="submit" value="Obriši"/>
        </form>
        <form action="arhiva.php" method="POST" class="admin">
            <label for="promjenaVidljivosti">Arhiva po id:</label>
            <input type="number" name="idZaPromjenu" id="promjenaVidljivosti" placeholder="Unesi id automobila za promjenu arhive:">
            <label for="arh">Arhiviraj:</label>
            <input type="checkbox" name="arhiviraj" value="1" id="arh" />
            <input type="submit" value="Arhiviraj"/>
        </form>
    </div>

    <?php include "footer.html"; ?>  

</body>

</html>
