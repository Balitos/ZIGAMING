<?php
session_start();

include_once('../../partials/php/bdd.php');

if (isset($_SESSION['id']) and !empty($_SESSION['id'])) {
    if (isset($_GET['id']) and !empty($_GET['id'])) {
        $id_message = intval($_GET['id']);
        $msg = $bdd->prepare('SELECT * FROM messages WHERE id = ? AND id_destinataire = ?');
        $msg->execute(array($_GET['id'], $_SESSION['id']));
        $msg_nbr = $msg->rowCount();
        $m = $msg->fetch();
        $p_exp = $bdd->prepare('SELECT pseudo FROM membres WHERE id = ?');
        $p_exp->execute(array($m['id_expediteur']));
        $p_exp = $p_exp->fetch();
        $p_exp = $p_exp['pseudo'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include "../../partials/php/head.php";
    ?>
    <title>Lecture de messages - zigaming</title>
</head>

<body>
    <!-- HEADER -->
    <?php
    if (isset($_SESSION['id'])) {
        include "../../partials/php/headerCo.php";
    } else {
        include "../../partials/php/header.php";
    }
    ?>

    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="contener">
            <div id="lecture-container">
                <div id="lecture-navbar">
                    <a href="../receptionMessage/">Boîte de réception</a>
                    <a href="../envoiMessage/index.php?r=<?= $p_exp ?>&o=<?= urlencode($m['objet']) ?>">Répondre</a>
                    <a href="supprimer.php?id=<?= $m['id'] ?>">Supprimer</a>
                </div>
                <div id="lecture-msg">
                    <h3 id="lecture-title">Lecture du message #<?= $id_message ?></h3>
                    <div id="lecture-content">
                        <?php if ($msg_nbr == 0)
                        {
                            echo "Erreur";
                        }
                        else
                        {
                        ?>
                        <div class="lecture-content-text" id="destinataire">
                            <b><?= $p_exp ?></b> vous a envoyé:
                        </div>
                        <div class="lecture-content-text">
                            <b>Objet:</b> <?= $m['objet'] ?>
                        </div>
                        <div class="lecture-content-text">
                            <?= nl2br($m['message']) ?>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
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
        $lu = $bdd->prepare('UPDATE messages SET lu = 1 WHERE id = ?');
        $lu->execute(array($m['id']));
    }
}
?>