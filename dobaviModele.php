<?php
if(isset($_POST["action"]))
{
 include "dbconn.php";

 $output1 = '';
 $sql = "SELECT modeli.* FROM modeli INNER JOIN marke on marke.id = modeli.IDMarke WHERE marke.naziv = '".$_POST["query"]."' ORDER BY modeli.naziv ASC";
 $resultX = @mysqli_query($MySQL, $sql);
 while ($row = @mysqli_fetch_array($resultX)) {
    $output1 .= '<option value = "' . $row['naziv'] . '">' . $row['naziv'] . '</option>';
}
echo $output1;
}
?>
