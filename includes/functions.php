<?php

function update($nom_table, $elementUpdate, $post, $numeroAnnonce){

    
  try {
    $bdd = new PDO('mysql:host=localhost;dbname=zigaming;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
    
    $req = $bdd->prepare("UPDATE $nom_table SET $elementUpdate = '$post' WHERE numeroAnnonce= '$numeroAnnonce' ");

    $req->execute(['numeroAnnonce' => $numeroAnnonce, $elementUpdate => $post]);
    $req->closeCursor();

}
