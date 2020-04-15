<?php require_once('recuperation.php'); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include "../../partials/php/head.php";
    ?>
</head>

<body>
    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="contener">
            <!-- CONTACT -->
            <h4 id="form-title">Récupération de mot de passe</h4>
            <div id="contact-wrap">
                <div class="contact-box">
                    <?php if ($section == 'code') { ?>
                        Un code de vérification vous a été envoyé par mail à <?= $_SESSION['recup_mail'] ?>
                        <br />
                        <form method="post" id="form">
                            <input type="text" class="form-item" placeholder="Code de vérification" name="verif_code" /><br />
                            <input type="submit" id="submit" value="Valider" name="verif_submit" />
                        </form>
                    <?php } elseif ($section == "changemdp") { ?>
                        Nouveau mot de passe pour <?= $_SESSION['recup_mail'] ?>
                        <form method="post" id="form">
                            <input type="password" class="form-item" placeholder="Nouveau mot de passe" name="change_mdp" /><br />
                            <input type="password" class="form-item" placeholder="Confirmation du mot de passe" name="change_mdpc" /><br />
                            <input type="submit" id="submit" value="Valider" name="change_submit" />
                        </form>
                    <?php } else { ?>
                        <form method="post" id="form">
                            <input type="email" class="form-item" placeholder="Votre adresse mail" name="recup_mail" /><br />
                            <input type="submit" id="submit" value="Valider" name="recup_submit" />
                        </form>
                    <?php } ?>
                    <div id="msg-box">
                        <?php
                        if (isset($error)) {
                            echo $error;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>