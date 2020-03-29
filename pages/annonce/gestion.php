<?php
session_start();

try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=zigaming;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


    $getAnnonce = intval($_GET['annonce']);
    $requser = $bdd->prepare('SELECT id, numeroAnnonce, titre, prix, photo, descriptionJeu FROM annonce WHERE numeroAnnonce = ?');
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
    if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'])
            {
                ?>
                <div class="card airforce light-1">
                <div class="card-image">
                    <img src="../../assets/membres/annonce/<?php echo $userinfo['photo']; ?>" alt="photoJeu" />
                    </div>
                    <div class="card-header"> <?php echo $userinfo['titre']; ?> </div>
                    <div class="divider"></div>
                    <div class="card-content">
                            <?php echo stripslashes($userinfo['descriptionJeu'])?>
                    </div>
                <div class="divider"></div>
                <div class="card-footer"> <?php echo $userinfo['prix']; ?>€</div>
                
               </div>
      <?php     
      } else {
    header('Location: ../login/');
     }?>

    </div>



  </div>
  <!-- JAVASCRIPT -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>

  <!-- FONT AWESOME KIT -->
  <script src="https://kit.fontawesome.com/e6c2645393.js" crossorigin="anonymous"></script>
</body>

</html>