<?php
session_start();
require_once '../../includes/functions.php';
?>


<!DOCTYPE html>
<html lang="fr">

<head>
  <link rel="stylesheet" href="style.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>ZIGAMING</title>
  <!-- Axentix CSS minified version -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/axentix@0.5.2/dist/css/axentix.min.css">

  <!-- Axentix JS minified version -->
  <script src="https://cdn.jsdelivr.net/npm/axentix@0.5.2/dist/js/axentix.min.js"></script>
</head>

<body>

  <?php
  if (isset($_SESSION['id'])) {
  ?>

    <h3>Choisis l'article que à modifié / supprimer</h3>
    <div class="grix xs4">



      <?php try {
        $bdd = new PDO('mysql:host=localhost;dbname=zigaming;charset=utf8', 'root', '');
      } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
      }

      $id = $_SESSION['id'];

      $reponse = $bdd->query("SELECT numeroAnnonce, titre, prix, photo, descriptionJeu FROM annonce WHERE id = '$id' ");

      $variable = "";
      $variable .= "<br>";


      while ($variable = $reponse->fetch()) {



        echo    '<div class="card airforce light-1">';
        echo    '<div class="card-image">';
        echo    '<img src="../../assets/membres/annonce/' . $variable['photo'] . ' " alt="photoJeu" />';
        echo    '</div>';
        echo    '<div class="card-header">' . $variable['titre'] . '</div>';
        echo    '<div class="divider"></div>';
        echo    '<div class="card-content">';
        echo            stripslashes($variable['descriptionJeu']);
        echo    '</div>';
        echo    '<div class="divider"></div>';
        echo            '<div class="card-footer">' . $variable['prix'] . '€</div>';
        echo            '<a href="../annonce/gestion.php?annonce='.$variable['numeroAnnonce'].' " class="btn outline txt-black txt-center"><span class="outline-text txt-center">Choisir</span></a>';
        echo    '</div>';
      }
      $variable .= "<br>";

      $reponse->closeCursor();
      return $variable; ?>


    </div>


  <?php } else {
    header('Location: ../login/');
  }
  ?>

  </div>
  <!-- JAVASCRIPT -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>

  <!-- FONT AWESOME KIT -->
  <script src="https://kit.fontawesome.com/e6c2645393.js" crossorigin="anonymous"></script>
</body>

</html>