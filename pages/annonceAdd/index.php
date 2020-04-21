<?php
session_start();

include_once('../../partials/php/bdd.php');
include_once('../login/cookieconnect.php');

$id = $_SESSION['id'];
$reqannonce = $bdd->prepare("SELECT  numeroAnnonce FROM annonce ORDER BY numeroAnnonce DESC");
$reqannonce->execute(array());
$annonceinfo = $reqannonce->fetch();

$numeroAnnonce = $annonceinfo['numeroAnnonce'];
$numeroAnnonce++;

include_once('../../partials/php/bdd.php');

if (isset($_POST['annonce_submit'])) {

  if (!empty($_POST['titre']) and !empty($_POST['descriptionJeu']) and !empty($_POST['console']) and !empty($_POST['etat']) and !empty($_POST['prix'])) {
    $titreJeu = htmlspecialchars($_POST["titre"]);
    $descriptionJeu = htmlspecialchars(addslashes($_POST["descriptionJeu"]));
    $console = $_POST["console"];
    $etatJeu = $_POST["etat"];
    $prix = htmlspecialchars($_POST["prix"]);
    $idVendeur = $_SESSION['id'];


    if (isset($_FILES['photoJeu']) and !empty($_FILES['photoJeu']['name'])) {
      $tailleMax = 2097152;
      $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
      if ($_FILES['photoJeu']['size'] <= $tailleMax) {
        $extensionUpload = strtolower(substr(strrchr($_FILES['photoJeu']['name'], '.'), 1));
        if (in_array($extensionUpload, $extensionsValides)) {
          $chemin = "../../assets/membres/annonce/" . $numeroAnnonce . "." . $extensionUpload;
          $resultat = move_uploaded_file($_FILES['photoJeu']['tmp_name'], $chemin);
          if ($resultat) {

            $req = $bdd->prepare("INSERT INTO annonce SET photo = :photoJeu, titre = :titre, descriptionJeu = :descriptionJeu, console= :console,
                            etat= :etat, prix= :prix, id= :id");

            $req->execute([
              'photoJeu' => $numeroAnnonce . "." . $extensionUpload, 'titre' => htmlspecialchars($_POST["titre"]),
              'descriptionJeu' => htmlspecialchars(addslashes($_POST["descriptionJeu"])), 'console' => $_POST["console"],
              'etat' => $_POST["etat"], 'prix' => htmlspecialchars($_POST["prix"]), 'id' => $_SESSION['id']
            ]);
            $req->closeCursor();

            header('Location: ../profil/index.php?id=' . $_SESSION['id']);
          } else {
            $erreur = "Erreur durant l'importation de votre photo";
          }
        } else {
          $erreur = "Votre photo doit être au format jpg, jpeg, gif ou png";
        }
      } else {
        $erreur = "Votre photo ne doit pas dépasser 2Mo";
      }
    } else {
      $erreur = "Veuillez ajouter une image à l'annonce";
    }
  } else {
    $erreur = "Tous les champs doivent être complétés !";
  }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
  <link rel="stylesheet" href="style.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Ajouter une annonce</title>
  <!-- Axentix CSS minified version -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/axentix@0.5.2/dist/css/axentix.min.css">

  <!-- Axentix JS minified version -->
  <script src="https://cdn.jsdelivr.net/npm/axentix@0.5.2/dist/js/axentix.min.js"></script>
</head>

<body>

  <?php
  if (isset($_SESSION['id'])) {
  ?>
    <?php
    include "../../partials/php/headerCo.php";
    ?>
    <div id="wrapper">
      <div class="grix xs1 txt-center">
        <div id="raw-title">
          <h3>Vends ton article</h3>
        </div>
        <div class="txt-center" id="gestion-erreurs">
          <?php
          if (isset($erreur)) {
            echo $erreur;
          } ?>
        </div>
        <form name="formulaire_annonce" method="POST" enctype="multipart/form-data">
          <div class="gutter-xs4 sm-4 xl-4 md-4 container">
            <div class="card rounded-3 white">
              <div class="card-content">
                <div class="grix xs1">
                  <div>
                    <label>Choisissez une Photo *</label>
                  </div>
                  <div class="form-field">
                    <input type="file" name="photoJeu"><br><br>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="gutter-xs4 sm-4 xl-4 md-4 container">
            <div class="card rounded-3 white">
              <div class="card-content">
                <div class="grix xs2">
                  <div>
                    <br>
                    <label for="titre">Titre *</label>
                  </div>
                  <div class="form-field">
                    <input type="text" id="titre" name="titre" class="form-control" placeholder="Ex : Call of duty, Battlefield..." />
                  </div>
                </div>

                <div class="divider"></div>
                <br>
                <div class="grix xs2">
                  <div>
                    <br>
                    <label for="description">Description *</label>
                  </div>
                  <div class="form-field">
                    <textarea name="descriptionJeu" class="form-control" placeholder="Ex : Acheter en précommande je n'ai pas aimé.."></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="gutter-xs4 sm-4 xl-4 md-4 container">
            <div class="card rounded-3 white">
              <div class="card-content">
                <div class="grix xs2">
                  <div>
                    <label class="txt-center" for="console">Console *</label>
                  </div>
                  <div class="form-field">
                    <select class="form-control" name="console">
                      <option>PS4</option>
                      <option>Xbox one</option>
                      <option>PS3</option>
                      <option>Xbox 360</option>
                      <option>PC</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="gutter-xs4 sm-4 xl-4 md-4 container">
            <div class="card rounded-3 white">
              <div class="card-content">
                <div class="grix xs2">
                  <div>
                    <label class="txt-center" for="etat">Etat du jeu *</label>
                  </div>
                  <div class="form-field">
                    <select class="form-control" name="etat">
                      <option>Neuf</option>
                      <option>Très bon état</option>
                      <option>Bon état</option>
                      <option>Mauvais état</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="gutter-xs4 sm-4 xl-4 md-4 container">
            <div class="card rounded-3 white">
              <div class="card-content">
                <div class="grix xs2">
                  <div>
                    <label for="prix">Prix *</label>
                  </div>
                  <div class="form-field">
                    <input type="number" id="prix" name="prix" class="form-control" placeholder="0.00 €"></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <input type="submit" name="annonce_submit" value="Envoyer" id="raw-submit">
        </form>
        <br>
      </div>
    </div>
    <!-- FOOTER -->
    <?php
    include "../../partials/php/footer.php";
    ?>
  <?php } else {
    header('Location: ../login/');
  }
  ?>

  <!-- JAVASCRIPT -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>

  <!-- FONT AWESOME KIT -->
  <script src="https://kit.fontawesome.com/e6c2645393.js" crossorigin="anonymous"></script>
</body>

</html>