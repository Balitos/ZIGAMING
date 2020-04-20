<?php
session_start();

include_once('../../partials/php/bdd.php');


if (isset($_GET['recherche']) and !empty($_GET['recherche']) and isset($_GET['filtre_console']) and !empty($_GET['filtre_console'])){
    $filtre_vide = "NULL"; 
    $recherche = htmlspecialchars($_GET['recherche']);
    $filtre_console= htmlspecialchars($_GET['filtre_console']);


    $articles = $bdd->query("SELECT * FROM annonce
    WHERE titre 
    LIKE '%" . $recherche . "%'
    AND console = '$filtre_console'");   


    include "page_recherche.php";
}

else if (isset($_GET['filtre_console']) and empty($_GET['filtre_console']) and isset($_GET['recherche']) and empty($_GET['recherche'])){
    $recherche = htmlspecialchars("TOUT");

    $articles = $bdd->query("SELECT * FROM annonce");
    include "page_recherche.php";
}

else if (isset($_GET['filtre_console']) and !empty($_GET['filtre_console']) and isset($_GET['recherche']) and empty($_GET['recherche'])){
    $filtre_console= htmlspecialchars($_GET['filtre_console']);

    $recherche = htmlspecialchars("JEU PS4");
    $articles = $bdd->query("SELECT * FROM annonce
    WHERE console ='$filtre_console'");

    include "page_recherche.php";
}




else if (isset($_GET['recherche']) and !empty($_GET['recherche']) and isset($_GET['filtre_console']) and empty($_GET['filtre_console'])){
    
$recherche = htmlspecialchars($_GET['recherche']);
$filtre_console= htmlspecialchars($_GET['filtre_console']);



$articles = $bdd->query('SELECT * FROM annonce
WHERE titre 
LIKE "%' . $recherche . '%"'); 

    include "page_recherche.php";

} else {
    header("Location: ../../");;
}
