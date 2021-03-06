<h1>Connexion</h1>

<?php
/*
 * Pour faire un formulaire, on prépare toutes ses données dans $config,
 * puis on include "form.mod.php" qui génère le form
 */
if (!$userConnected):
$config = array(
    "options" => [
        "method" => "POST",
        "action" => "#",
        "class" => "form-group",
        "submit" => "Se connecter",
        "submitName" => "login"
    ],
    "struc" => [
        "username" => [
            "type" => "text",
            "placeholder" => "Votre identifiant ou votre mail",
            "value" => null,
            "required" => true
        ],
        "pwd" => [
            "type" => "password",
            "placeholder" => "Votre mot de passe",
            "value" => null,
            "required" => true
        ]
    ]
);
?>

    <div class="row">
        <div class="col-4 col-m-2"></div>
        <div class="col-4 col-m-8">
            <?php include "views/modals/form.mod.php"; ?>
            <p>
                <a href="/forgetPassword">Mot de passe oublié ?</a><br>
                Pas de compte ? <a href="/signup">Inscrivez-vous !</a>
            </p>
            <?php else: ?>
                <h2>Vous êtes connecté !</h2>
            <?php endif; ?>
        </div>
    </div>
