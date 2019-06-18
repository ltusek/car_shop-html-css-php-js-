<?php include "timerLogout.php"; ?>

<!DOCTYPE html>
<?php
$activePage = "unos";


include "dbconn.php";
$query2 = "SELECT * FROM vrste ORDER BY vrste.naziv ASC";
$result2 = @mysqli_query($MySQL, $query2);
$option2 = '';
while ($row = @mysqli_fetch_array($result2)) {
    $option2 .= '<option value = "' . $row['naziv'] . '">' . $row['naziv'] . '</option>';
}

$query1 = "SELECT * FROM marke ORDER BY marke.naziv ASC";
$result1 = @mysqli_query($MySQL, $query1);
$option1 = '';
while ($row = @mysqli_fetch_array($result1)) {
    $option1 .= '<option value = "' . $row['naziv'] . '">' . $row['naziv'] . '</option>';
}


?>

<html>
<head>
    <?php include "head.html"; ?>  

    <script type="text/javascript">

        function validate() {
            var slanje = true;     
            
            if (document.forma.marka.value == "-1") {
                document.forma.marka.style.borderColor="red";
                document.getElementById("porukaMarka").innerHTML="Marka automobila mora biti odabrana!";
                slanje = false;
            }else{
                document.forma.marka.style.borderColor="grey";
                document.getElementById("porukaMarka").innerHTML="";
            }

            if(document.forma.model.value == "-1") {
                document.forma.model.style.borderColor="red";
                document.getElementById("porukaModel").innerHTML="Model automobila mora biti odabran!";
                slanje=false;
            }else{
                document.forma.model.style.borderColor="grey";
                document.getElementById("porukaModel").innerHTML="";
            }

            if (document.forma.sifra.value.length != 10) {
                document.forma.sifra.style.borderColor="initial";
                document.getElementById("porukaSifra").innerHTML="Sifra automobila mora imati 10 znakova!";
                slanje=false;
            }else{
                document.forma.sifra.style.borderColor="grey";
                document.getElementById("porukaSifra").innerHTML="";
            }

            if (document.forma.kategorija.value == "-1") {
                document.forma.kategorija.style.borderColor="red";
                document.getElementById("porukaKategorija").innerHTML="Marka automobila mora biti odabrana!";
                slanje = false;
            }else{
                document.forma.kategorija.style.borderColor="grey";
                document.getElementById("porukaKategorija").innerHTML="";
            }

            if (document.forma.opis.value.length < 10 || document.forma.opis.length > 100 ) {
                document.forma.opis.style.borderColor="red";
                document.getElementById("porukaOpis").innerHTML="Opis automobila mora imati 10 do 100 znakova!";
                slanje=false;
            }else{
                document.forma.opis.style.borderColor="grey";
                document.getElementById("porukaOpis").innerHTML="";
            }

            if (document.forma.cijena.value == "") {
                document.forma.cijena.style.borderColor="red";
                document.getElementById("porukaCijena").innerHTML="Cijena automobila mora biti navedena!";
                slanje=false;
            }else{
                document.forma.cijena.style.borderColor="initial";
                document.getElementById("porukaCijena").innerHTML="";
            }
            
            
            return slanje;
        }

        function validateForm(){
            if(validate()){

                if (document.getElementById("arh").checked==true){
                    var a = confirm ("Jeste li sigurni da zelite arhivirati?");
                    if(a == false)
                        return false;
                    return true;
                }else return true;
            }             
            else return false;
        }

        function resetForm(){
            document.getElementById("porukaMarka").innerHTML="";
            document.getElementById("porukaModel").innerHTML="";
            document.getElementById("porukaSifra").innerHTML="";
            document.getElementById("porukaKategorija").innerHTML="";
            document.getElementById("porukaOpis").innerHTML="";
            document.getElementById("porukaCijena").innerHTML="";

            document.forma.marka.style.borderColor="grey";
            document.forma.model.style.borderColor="grey";
            document.forma.sifra.style.borderColor="initial";
            document.forma.kategorija.style.borderColor="grey";
            document.forma.opis.style.borderColor="grey";
            document.forma.cijena.style.borderColor="initial";
        }

       
    </script>

</head>

<body>
    <?php include "header.html"; ?>

    <?php include "navigation.php"; ?>

    <article class="wrapper">
        <h2>Unesite novi automobil</h2>
        <form enctype="multipart/form-data" action="skripta.php" name="forma" id="formaUnos" method="POST" onsubmit="return validateForm();" onreset="return resetForm();"> 
            <div id="form_element">
                <label for="marka">Marka:</label>
                <select id="marka" required name="marka" class="action">
                    <option value="-1">Odaberite marku:</option>
                    <?php echo $option1; ?>
                </select>
                <span class="formaValidate" id="porukaMarka"></span>
            </div>
            <div id="form_element">
                <label for="model">Model:</label>

                <select id="model" required name="model" class="action">
                    <option value="-1">Odaberite model:</option>
                </select>

                <span class="formaValidate" id="porukaModel"></span>
            </div>
            <div id="form_element">
                <label for="sifra">Sifra:</label>
                <input name="sifra" type="text" placeholder="Unesi sifru:">
                <span class="formaValidate" id="porukaSifra"></span>
            </div>

            <div id="form_element">
                <label for="kategorija">Vrsta:</label>
                <select id="kategorija" required name="kategorija">
                    <option value="-1">Odaberite vrstu:</option>

                    <?php echo $option2; ?>

                </select>
                <span class="formaValidate" id="porukaKategorija"></span>
            </div>

            <div id="form_element">
                <label for="opis">Opis: </label>
                <textarea id="opis" name="opis"></textarea>
                <span class="formaValidate" id="porukaOpis"></span>
            </div>

            <div id="form_element">
                <label for="cijena">Cijena:</label>
                <input id="cijena" name="cijena" type="number">
                <span class="formaValidate" id="porukaCijena"></span>
            </div>

            <div id="form_element">
                <label for="picture">Slika:</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
                <input type="file" name="picture" id="picture">
            </div>


            <div id="form_element">
                <label>Arhiviraj:</label>
                <input type="checkbox" name="arhiviraj" value="1" id="arh" />

            </div>

            <div id="form_element">
                <input name="submit" type="submit" value="Submit!">
                <input name="reset" type="reset" value="Resetiraj!">

            </div>


        </form>

    </article>

    <?php include "footer.html"; ?>  

</body>

</html>


<script>
$(document).ready(function(){
 $('.action').change(function(){
  if($(this).val() != '')
  {
   var action = $(this).attr("id");
   var query = $(this).val();
   var result = '';
   if(action == "marka")
   {
    result = 'model';
   }

   $.ajax({
    url:"dobaviModele.php",
    method:"POST",
    data:{action:action, query:query},
    success:function(data){
     $('#'+result).html(data);
    }
   })
  }
 });
});
</script>