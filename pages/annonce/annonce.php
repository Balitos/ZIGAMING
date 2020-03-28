<?php session_start();

try {
  $bdd = new PDO('mysql:host=127.0.0.1;dbname=zigaming;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}



if (isset($_POST['annonce_submit'])) {

  if (!empty($_POST['titre']) and !empty($_POST['description']) and !empty($_POST['console']) and !empty($_POST['etat']) and !empty($_POST['prix'])) {
    $titreJeu = $_POST["titre"];
    $descriptionJeu = addslashes($_POST["description"]);
    $console = $_POST["console"];
    $etatJeu = $_POST["etat"];
    $prix = $_POST["prix"];
    $idVendeur = $_SESSION['id'];


    $req = $bdd->prepare("INSERT INTO annonce SET titre= '$titreJeu', descriptionJeu= '$descriptionJeu', console= '$console' , etat= '$etatJeu', prix='$prix', id='$idVendeur'");

    $req->execute(['titre' => $titreJeu, 'descriptionJeu' => $descriptionJeu, 'etat' => $etatJeu, 'console' => $console, 'prix' => $prix, 'id' => $idVendeur]);
    $req->closeCursor();

    header("Location: ../../index.php");
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

  <title>ZIGAMING</title>
  <!-- Axentix CSS minified version -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/axentix@0.5.2/dist/css/axentix.min.css">

  <!-- Axentix JS minified version -->
  <script src="https://cdn.jsdelivr.net/npm/axentix@0.5.2/dist/js/axentix.min.js"></script>
</head>

<body>

  <div class="grix xs1 txt-center grey light-3">
    <div>
      <h3>Vends ton article</h3>
    </div>
    <form name="formulaire_annonce" method="POST" onsubmit="return verif_champ(prix)">
      <div class="gutter-xs4 sm-4 xl-4 md-4 container">
        <div class="card rounded-3 white">
          <div class="card-content">
            <div>
              <br>
              <label for="titre">Ajouter une photo</label>
            </div>
            <div class="form-field">
              AJOUTER UNE PHTOTOTOOTOTOTO
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
                <label for="titre">Titre</label>
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
                <label for="description">Description</label>
              </div>
              <div class="form-field">
                <textarea id="description" name="description" class="form-control" placeholder="Ex : Acheter en précommande je n'ai pas aimé.."></textarea>
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
                <label class="txt-center" for="console">Console</label>
              </div>
              <div class="form-field">
                <select class="form-control" name="console">
                  <option>PS4</option>
                  <option>XBOXONE</option>
                  <option>PS3</option>
                  <option>xbox360</option>
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
                <label class="txt-center" for="etat">Etat du jeu</label>
              </div>
              <div class="form-field">
                <select class="form-control" name="etat">
                  <option>Neuf</option>
                  <option>Presque neuf</option>
                  <option>Abimé</option>
                  <option>Très abimés</option>
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
                <label for="prix">Prix</label>
              </div>
              <div class="form-field">
                <input type="number" id="prix" name="prix" class="form-control" placeholder="0.00 €"></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
      <input type="submit" name="annonce_submit" value="Envoyez vos jeux">
  </div>

  <div class="txt-center"id="gestion-erreurs">
    <?php
    if (isset($erreur)) {
      echo $erreur;
    } ?>
  </div>
  <!-- JAVASCRIPT -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
  
  <!-- FONT AWESOME KIT -->
  <script src="https://kit.fontawesome.com/e6c2645393.js" crossorigin="anonymous"></script>
</body>

</html>