<html>
 <head>
  <meta charset="utf-8">
  <title>Panel admina</title>
 </head>
 <body>
     <form method="GET" action="index.php">
         <h3>Wyszukiwanie nazwiska z bazy danych </h3>
 <input type="text" name="szukaj"> <input value="szukaj"  type="submit">
         </form>
  <table border="1">
   <tr>
     <th>Pesel</th>
     <th>Imie</th>
     <th>Nazwisko</th>
     <th>Klasa</th>
   </tr>
<?php
error_reporting(E_ALL ^ E_NOTICE);

      
$baza = new  mysqli("localhost", "root", "", "fabian");
if (mysqli_connect_errno())  die( "Blad: ".mysqli_connect_error() );
$baza->set_charset("utf8");
      

      $szukaj = $_GET['szukaj'];



$sql  = "SELECT count(1) FROM uczen WHERE nazwisko like ?";

$stmt = $baza->prepare($sql);
$stmt->bind_param("s", $szukaj);
$stmt->execute();
$stmt->bind_result($found);
$stmt->fetch();
$stmt->close();

if ($found)
{
    if ($sql =  $baza->prepare("SELECT * FROM uczen where nazwisko like ?"))
{

        $sql->bind_param("s", $szukaj);
        $sql->bind_result($pesel , $imie, $nazwisko, $klasa);
        $sql->execute();
        while ($sql->fetch())
        {
                echo "<tr>
                        <td>$pesel</td>
                        <td>$imie</td>
                        <td>$szukaj</td>
                        <td>$klasa</td>
                   </tr>";
        }

        $sql->close();
 }
else die( "Błąd w zapytaniu SQL! Sprawdź kod SQL w PhpMyAdmin: ". $baza->error );
} else {
    if ($sql =  $baza->prepare("SELECT * FROM uczen"))
{
        $sql->execute();
        $sql->bind_result($pesel , $imie, $nazwisko, $klasa);
        while ($sql->fetch())
        {
                echo "<tr>
                        <td>$pesel</td>
                        <td>$imie</td>
                        <td>$nazwisko</td>
                        <td>$klasa</td>
                        
                   </tr>";
        }
        $sql->close();
 }
else die( "Błąd w zapytaniu SQL! Sprawdź kod SQL w PhpMyAdmin: ". $baza->error );
}



?>
  </table>
 </body>
</html>