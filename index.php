<?php

include "timerLogout.php";
// Initialize the session
//session_start();
 
// If session variable is not set it will redirect to login page
?>

<!DOCTYPE html>
<html>

<?php

    $activePage = "index";
?>

<head>
    <?php include "head.html"; ?>  
</head>

<body>
    <?php include "header.html"; ?>
    <?php include "navigation.php"; ?>

    <article class="wrapper">
        <h2>Automobili na prodaju</h2>
        <figure>
            <img src="img/car1.jpg" alt="">
            <figcaption>
                <h3>2010 Ford Escape XLT</h3>
                <p>Cijena: 80,000 kn</p>
            </figcaption>
        </figure>
        <figure>
            <img src="img/car2.jpg" alt="">
            <figcaption>
                <h3>2006 Dodge Ram 1500 4dr Quad</h3>
                <p>Cijena: 105,000 kn</p>
            </figcaption>
        </figure>
        <figure>
            <img src="img/car3.jpg" alt="">
            <figcaption>
                <h3>2007 Ford Mustang V6 Deluxe</h3>
                <p>Cijena: 150,000 kn</p>
            </figcaption>
        </figure>
        <figure>
            <img src="img/car4.jpg" alt="">
            <figcaption>
                <h3>2013 Hyundai Genesis 3.8L</h3>
                <p>Cijena: 120,000 kn</p>
            </figcaption>
        </figure>
        <figure>
            <img src="img/car5.jpg" alt="">
            <figcaption>
                <h3>2005 Chevrolet Colorado Z85 2dr Standard</h3>
                <p>Cijena: 79,000 kn</p>
            </figcaption>
        </figure>
        <figure>
            <img src="img/car6.jpg" alt="">
            <figcaption>
                <h3>2006 Chrysler Town & Country</h3>
                <p>Cijena: 60,000 kn</p>
            </figcaption>
        </figure>
    </article>

    <section>
        <iframe width="" height="400" src="https://www.youtube.com/embed/fuKKwhejD_w" frameborder="0" allow="autoplay; encrypted-media"
            allowfullscreen></iframe>
        <iframe width="" height="400" src="https://www.youtube.com/embed/y2bB8yskixc" frameborder="0" allow="autoplay; encrypted-media"
            allowfullscreen></iframe>
    </section>

    <?php include "footer.html"; ?>  
</body>

</html>