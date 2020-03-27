<!DOCTYPE html>
<html lang="fr">

<head>
  <?php
  include "../../partials/php/head.php";
  ?>
  <!-- Axentix CSS minified version -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/axentix@0.5.2/dist/css/axentix.min.css">

  <!-- Axentix JS minified version -->
  <script src="https://cdn.jsdelivr.net/npm/axentix@0.5.2/dist/js/axentix.min.js"></script>
</head>

<body>



  <?php
  //include "../../partials/php/header.php";
  ?>
  <!-- HEADER -->
  <div class="grix xs1 txt-center grey light-3">
    <div>
      <h3>Vends ton article</h3>
    </div>

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
                <label for="titre">Name</label>
              </div>
              <div class="form-field">
                <input type="text" id="titre" class="form-control" placeholder="Ex : Call of duty, Battlefield..." />
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
                <textarea id="description" class="form-control" placeholder="Ex : Acheter en précommande je n'ai pas aimé.."></textarea>
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
              <label class="txt-center" for="select">Console</label>
              </div>
              <div class="form-field">
              <select class="form-control">
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
              <label class="txt-center" for="select">Etat du jeu</label>
              </div>
              <div class="form-field">
              <select class="form-control">
                <option>1 (Neuf)</option>
                <option>2 (Presque neuf)</option>
                <option>3 (Abimé)</option>
                <option>4 (Très abimés)</option>
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
                <input type="number" id="prix" class="form-control" placeholder="0.00 €"></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>


    <!-- FONT AWESOME KIT -->
    <script src="https://kit.fontawesome.com/e6c2645393.js" crossorigin="anonymous"></script>
</body>

</html>


<!--

try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=zigaming;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}