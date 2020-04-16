<?php
session_start();

try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=zigaming;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($_SESSION['id']) and !empty($_SESSION['id'])) {
    $msg = $bdd->prepare('SELECT * FROM messages WHERE id_destinataire = ? ORDER BY id DESC');
    $msg->execute(array($_SESSION['id']));
    $msg_nbr = $msg->rowCount();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include "../../partials/php/head.php";
    ?>
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
        <a href="../envoiMessage/">Nouveau message</a><br /><br /><br />
        <h3>Votre boîte de réception:</h3>
        <?php
        if ($msg_nbr == 0) {
            echo "Vous n'avez aucun message...";
        }
        while ($m = $msg->fetch()) {
            $p_exp = $bdd->prepare('SELECT pseudo FROM membres WHERE id = ?');
            $p_exp->execute(array($m['id_expediteur']));
            $p_exp = $p_exp->fetch();
            $p_exp = $p_exp['pseudo'];
        ?>
            <a href="../lectureMessage/index.php?id=<?= $m['id'] ?>" <?php if ($m['lu'] == 1) { ?><span style="color:grey"><?php } ?><b><?= $p_exp ?></b> vous a envoyé un message<br />
            <b>Objet:</b> <?= $m['objet'] ?><?php if ($m['lu'] == 1) { ?></span><?php } ?></a><br />
            -------------------------------------<br />
        <?php
        }
        ?>
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
?>