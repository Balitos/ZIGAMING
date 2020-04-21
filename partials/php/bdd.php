<?php
// try {
//     $bdd = new PDO('mysql:host=db5000380300.hosting-data.io;dbname=dbs367003;charset=utf8', 'dbu525275', '^pc%MAjwsWVhc3pM', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
// } catch (Exception $e) {
//     die('Erreur : ' . $e->getMessage());
// }

try {
    $bdd = new PDO('mysql:host=localhost;dbname=zigaming;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>