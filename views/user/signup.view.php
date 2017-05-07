<h1>Inscription</h1>

<?php
/*
 * Pour faire un formulaire, on prépare toutes ses données dans $config,
 * puis on include "form.mod.php" qui génère le form
 */
$config = array(
    "options" => [
        "method" => "POST",
        "action" => "#",
        "class" => "form-group",
        "id" => "form-subscribe",
        "submit" => "S'inscrire"
    ],
    "struc" => [
        "username" => [
            "type" => "text",
            "placeholder" => "Votre identifiant",
            "value" => (isset($_POST['username'])) ? $_POST['username'] : null,
            "required" => true
        ],
        "email" => [
            "type" => "email",
            "placeholder" => "Votre email",
            "value" => (isset($_POST['email'])) ? $_POST['email'] : null,
            "required" => true
        ],
        "pwd" => [
            "type" => "password",
            "placeholder" => "Votre mot de passe",
            "value" => null,
            "required" => true
        ],
        "confpwd" => [
            "type" => "password",
            "placeholder" => "Confirmation du mot de passe",
            "value" => null,
            "required" => true
        ],
    ]
);

$this->includeModal("form", $config);

?>
