<?php
session_start();
require_once '../../includes/functions.php';
?>
<?php
if (isset($_SESSION['id'])) {

?>

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

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  </head>


  <body>
    <!-- HEADER -->
    <header>
      <div class="contener">
        <div id="header-wrap">
          <div id="header-logo">
            <a href="../../../">
              <h1>ZI<span>GAMING</span></h1>
            </a>
          </div>
          <div id="header-connection">
            <a class="header-link" href="../../pages/annonce/">
              <button type="submit" class="header-co-contour" name="annonce-btn">
                <i class="fas fa-plus"></i>
              </button>
            </a>
            <a class="header-link" href="../../pages/profil/index.php?id=<?php echo $_SESSION['id'] ?>">
              <button type="submit" class="header-co-contour" name="login-btn">
                <i class="far fa-user-circle"></i>
              </button>
            </a>
          </div>
        </div>
      </div>
    </header>


    <div id="wrapper">
      <div class="grix xs1 sm2 md4 gutter-xs3">


        <?php try {
          $bdd = new PDO('mysql:host=localhost;dbname=zigaming;charset=utf8', 'root', '');
        } catch (Exception $e) {
          die('Erreur : ' . $e->getMessage());
        }

        $id = $_SESSION['id'];

        $reponse = $bdd->query("SELECT numeroAnnonce, console, titre, prix, photo, descriptionJeu FROM annonce WHERE id = '$id' ");

        $variable = "";
        $variable .= "<br>";


        while ($variable = $reponse->fetch()) {

          $jeuToDell = $variable['numeroAnnonce'];

        ?>
         
          <div class="card rounded-3" style="border-radius: 1.6rem;background-color:transparent">
            <div class="card-image">
              <img src="../../assets/membres/annonce/<?php echo $variable['photo'] ?>" style="height:12rem;border-top-left-radius: 1.6rem;border-top-right-radius: 1.6rem;" alt="photoJeu">
            </div>
            <div class="card-content" style="background-color:#333; color:white;height:5rem">
              <h4> <?php echo $variable['titre'] ?></h4>
            </div>
            <div class="card-content" style="background-color:#333; color:white;height:10rem;">
              <p>
                <?php echo stripslashes($variable['descriptionJeu']) ?>
              </p>
            </div>
            <div class="divider"></div>
            <div class="card-footer txt-center" style="background-color:#ea732b;border-bottom-left-radius: 1.6rem;border-bottom-right-radius: 1.6rem; color:white">
              <?php echo $variable['console'];
              ?> |
              <?php echo $variable['prix']
              ?> €
              <div class="grix xs2">
                <div>
                  <a href="../gestionAnnonces/gestion.php?annonce=<?php echo $variable['numeroAnnonce']
                                                                  ?>" class="btn outline txt-black txt-center"><span class="outline-text txt-center">Choisir</span></a>
                </div>
                <div>
                  <form method="post">
                    <input type="submit" name="supprimer_jeu<?php echo $variable['numeroAnnonce']
                                                            ?>" value="Supprimer" class="btn outline txt-black txt-center">
                  </form>

                </div>
              </div>
            </div>
          </div>
          <?php


          if (isset($_POST['supprimer_jeu' . $variable['numeroAnnonce']])) {

            try {
              $bdd = new PDO('mysql:host=localhost;dbname=zigaming;charset=utf8', 'root', '');
            } catch (Exception $e) {
              die('Erreur : ' . $e->getMessage());
            }

            $req = $bdd->prepare("DELETE FROM annonce WHERE numeroAnnonce= '$jeuToDell'");


            $req->execute(['numeroAnnonce' =>  $jeuToDell]);
            $req->closeCursor();
            header('Location: choixGestion.php');
          }
        }
        $variable .= "<br>";

        $reponse->closeCursor();
          ?>
          </div>
      </div>
      <?php
      include "../../partials/php/footer.php";
      ?>


    </div>
    </div>


    <!-- JAVASCRIPT -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <!-- FONT AWESOME KIT -->
    <script src="https://kit.fontawesome.com/e6c2645393.js" crossorigin="anonymous"></script>

  </body>

  </html>


<?php } else {
  header('Location: ../../login/');
}
?>