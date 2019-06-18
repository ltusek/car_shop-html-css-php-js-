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
        <h2>Automobil unesen u bazu</h2>

        <figure>

            <?php
            if(isset($_POST['submit'])){
                define('UPLPATH', 'images/');

                $marka = $_POST['marka'];
                $model = $_POST['model'];
                $sifra = $_POST['sifra'];
                $vrsta = $_POST['kategorija'];
                $opis = $_POST['opis'];
                $cijena = $_POST['cijena'];
                $arhiviraj = (isset($_POST['arhiviraj'])) ? 1 : 0;

                

                # strtolower - Returns string with all alphabetic characters converted to lowercase.
                # strrchr - Find the last occurrence of a character in a string
                $ext = strtolower(strrchr($_FILES['picture']['name'], "."));

                $_picture = $_FILES['picture']['name'];

                copy($_FILES['picture']['tmp_name'], "images/" . $_picture);

                //trying stupid shit with images
                require_once('php_image_magician.php');

                $magicianObj = new imageLib("images/" . $_picture);
                $magicianObj -> resizeImage(640, 480);
                $magicianObj -> saveImage("images/" . $_picture, 100);

                if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif' || $ext == '.jpeg') { # test if format is picture
                echo '<img src="images/' . $_picture . '" />';
                }

                echo '<figcaption><h3>' . $marka . ' ' . $model . '</h3>

                                <div id="kategorija_naslov">
                                <h4>Kategorija: ' . $_POST['kategorija'] . '</h4>
                                <p>' . $_POST['opis'] . '</p></div>
                                <p id="cijena"> Cijena: ' . $_POST['cijena'] . ' kn </p></figcaption>';

                include "dbconn.php";

                $query1 = "SELECT * FROM modeli WHERE modeli.naziv = '$model'";
                $result1 = @mysqli_query($MySQL, $query1);
                $idModel = 0;
                while ($row = @mysqli_fetch_array($result1)) {
                    $idModel = $row['id'];
                }

                $query2 = "SELECT * FROM vrste WHERE vrste.naziv = '$vrsta'";
                $result2 = @mysqli_query($MySQL, $query2);
                $idVrsta = 0;
                while ($row = @mysqli_fetch_array($result2)) {
                    $idVrsta = $row['id'];
                }

                $query3 = "INSERT INTO auti (IDmodel, sifra, IDvrste, opis, cijena, slika, arhiviraj) VALUES('$idModel', '$sifra', '$idVrsta', '$opis', '$cijena', '$_picture', '$arhiviraj')";
                
                $result = mysqli_query($MySQL, $query3) or die("Error querying database");
            }
            
            ?>
        </figure>

    </article>

    <?php include "footer.html"; ?>
</body>

</html>
