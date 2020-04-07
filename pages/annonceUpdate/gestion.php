<?php
session_start();
require_once '../../includes/functions.php';

try {
  $bdd = new PDO('mysql:host=127.0.0.1;dbname=zigaming;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}


$getAnnonce = intval($_GET['annonce']);
$requser = $bdd->prepare('SELECT id, numeroAnnonce, titre, console, prix, photo, descriptionJeu FROM annonce WHERE numeroAnnonce = ?');
$requser->execute(array($getAnnonce));
$userinfo = $requser->fetch();
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


  <h3>Que faire ?</h3>
  <div class="grix xs3 pos-xs2">
    <?php
    if (isset($_SESSION['id'])) {
    ?>
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="card airforce light-1">
          <div class="card-image">
            <img src="../../../assets/membres/annonce/<?php echo $userinfo['photo']; ?>" alt="photoJeu" />
          </div>
          <input type="file" name="update_photo">
          <div class="grix xs2 card-header"> <?php echo $userinfo['titre']; ?>
            <div>
              <input type="text" name="update_titre" class="txt-center" placeholder="Nouveau titre">
            </div>
          </div>

          <div class="divider"></div>
          <div class="grix xs2 card-content">
            <?php echo stripslashes($userinfo['descriptionJeu']) ?>
            <textarea name="update_description" class="form-control" placeholder="Nouvelle description"></textarea>
          </div>
          <div class="divider"></div>
          <div class="grix xs2 card-content">
            <?php echo stripslashes($userinfo['console']) ?>
            <select class="form-control" name="update_console">
              <option>PS4</option>
              <option>XBOXONE</option>
              <option>PS3</option>
              <option>xbox360</option>
            </select>
          </div>
          <div class="divider"></div>
          <div class="grix xs2 card-footer"> <?php echo $userinfo['prix']; ?>€
            <div>
              <input type="number" name="update_prix" class="txt-center" placeholder="Nouveau prix">
            </div>
          </div>
          <div class="grix xs3">
            <div class="pos-xs2">
              <input type="submit" name="submit_annonce" value="Modifier" class="btn outline txt-black txt-center">
            </div>
          </div>
      </form>
  </div>





<?php

      if (isset($_POST['update_titre']) and !empty($_POST['update_titre'])) {
        $update_titre = htmlspecialchars($_POST['update_titre']);
        update('annonce', 'titre', $update_titre, $getAnnonce);
        header('Location: choixGestion.php');
      }

      if (isset($_POST['update_description']) and !empty($_POST['update_description'])) {
        $update_description = htmlspecialchars(addslashes($_POST['update_description']));
        update('annonce', 'descriptionJeu', $update_description, $getAnnonce);
        header('Location: choixGestion.php');
      }
      if (isset($_POST['update_prix']) and !empty($_POST['update_prix'])) {
        $update_prix = htmlspecialchars($_POST['update_prix']);
        update('annonce', 'prix', $update_prix, $getAnnonce);
        header('Location: choixGestion.php');
      }
      if (isset($_POST['update_console']) and !empty($_POST['update_console'])) {
        $update_console = $_POST['update_console'];
        update('annonce', 'console', $update_console, $getAnnonce);
        header('Location: choixGestion.php');
      }

      if (isset($_FILES['update_photo']) and !empty($_FILES['update_photo']['name'])) {
        $tailleMax = 2097152;
        $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
        if ($_FILES['update_photo']['size'] <= $tailleMax) {
          $extensionUpload = strtolower(substr(strrchr($_FILES['update_photo']['name'], '.'), 1));
          if (in_array($extensionUpload, $extensionsValides)) {
            $chemin = "../../../assets/membres/annonce/" . $getAnnonce . "." . $extensionUpload;
            $resultat = move_uploaded_file($_FILES['update_photo']['tmp_name'], $chemin);
            if ($resultat) {
              $updatephoto = $bdd->prepare("UPDATE annonce SET photo = :update_photo WHERE numeroAnnonce ='$getAnnonce'");
              $updatephoto->execute([
                'update_photo' => $getAnnonce . "." . $extensionUpload,
              ]);
              header('Location: choixGestion.php');
            } else {
              $msg = "Erreur durant l'importation de votre photo";
            }
          } else {
            $msg = "Votre photo doit être au format jpg, jpeg, gif ou png";
          }
        } else {
          $msg = "Votre photo ne doit pas dépasser 2Mo";
        }
      }
    } else {
      header('Location: ../../login/');
    } ?>

</div>



</div>
<!-- JAVASCRIPT -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>

<!-- FONT AWESOME KIT -->
<script src="https://kit.fontawesome.com/e6c2645393.js" crossorigin="anonymous"></script>
</body>

</html>