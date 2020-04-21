<?php
session_start();
include_once('../../partials/php/bdd.php');

if (isset($_SESSION['id']) and !empty($_SESSION['id'])) {
    if (isset($_POST['envoi_message'])) {
        if (isset($_POST['destinataire'], $_POST['message'], $_POST['objet']) and !empty($_POST['destinataire']) and !empty($_POST['message']) and !empty($_POST['objet'])) {
            $destinataire = htmlspecialchars($_POST['destinataire']);
            $message = htmlspecialchars($_POST['message']);
            $objet = htmlspecialchars($_POST['objet']);
            $id_destinataire = $bdd->prepare('SELECT id FROM membres WHERE pseudo = ?');
            $id_destinataire->execute(array($destinataire));
            $dest_exist = $id_destinataire->rowCount();
            if ($dest_exist == 1) {
                $id_destinataire = $id_destinataire->fetch();
                $id_destinataire = $id_destinataire['id'];
                $ins = $bdd->prepare('INSERT INTO messages(id_expediteur,id_destinataire,message,objet) VALUES (?,?,?,?)');
                $ins->execute(array($_SESSION['id'], $id_destinataire, $message, $objet));
                $error = "Votre message a bien été envoyé !";
            } else {
                $error = "Cet utilisateur n'existe pas...";
            }
        } else {
            $error = "Veuillez compléter tous les champs";
        }
    }
    $destinataires = $bdd->query('SELECT pseudo FROM membres ORDER BY pseudo');
    if (isset($_GET['r']) and !empty($_GET['r'])) {
        $r = htmlspecialchars($_GET['r']);
    }
    if (isset($_GET['o']) and !empty($_GET['o'])) {
        $o = urldecode($_GET['o']);
        $o = htmlspecialchars($_GET['o']);
        if (substr($o, 0, 3) != 'RE:') {
            $o = "RE:" . $o;
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include "../../partials/php/head.php";
    ?>
    <title> Envoyez de message - zigaming </title>
</head>

<body>
    <!-- HEADER -->
    <?php
    if (isset($_SESSION['id']))
    {
        include "../../partials/php/headerCo.php";
    }
    else
    {
        include "../../partials/php/header.php";
    }
    ?>

    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="contener">
            <div id="envoi-container">
                <div id="formulaire">
                    <form method="POST">
                        <div class="register-form-inputs">
                            <div class="register-input-box">
                                <label>Destinataire:</label>
                                <input type="text" name="destinataire" <?php if (isset($r)) { echo 'value="' . $r . '"'; } ?> />
                            </div>

                            <div class="register-input-box">
                                <label>Objet:</label>
                                <input type="text" name="objet" <?php if (isset($o)) { echo 'value="' . $o . '"'; } ?> />
                            </div>

                            <div class="register-input-box">
                                <label>Message:</label>
                                <textarea id="register-input-box-textarea" placeholder="Votre message" name="message"></textarea>
                            </div>
                        </div>
                        <input type="submit" value="Envoyer" name="envoi_message" class="form-submit" />
                        <div id="gestion-erreurs">
                            <?php if (isset($error))
                            {
                                echo '<span style="color:red">' . $error . '</span>';
                            }
                            ?>
                        </div>
                    </form>
                </div>
                <div id="envoi-navbar">
                    <a href="../receptionMessage/">Boîte de réception</a>
                </div>
            </div>
        </div>
    </div>


    <!-- FOOTER -->
    <?php
    include "../../partials/php/footer.php";
    ?>

    <!-- FONT AWESOME KIT -->
    <script src="https://kit.fontawesome.com/e6c2645393.js" crossorigin="anonymous"></script>
    </body>

    </html>

<?php
}
else
{
    header('Location: ../login/');
}
?>