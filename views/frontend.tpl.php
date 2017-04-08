<!DOCTYPE html>
<html>
    <head>
        <title>Bienvenue sur Smart-Pix</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="public/css/style.css" />
        <link rel="shortcut icon" type="image/ico" href="/public/image/logo.ico"/>
        <!-- FONT A CHANGER -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    </head>
    <header>
        <div class="container">
            <div class="row">
                <section class="col-4">
                    <img src="public/image/logo.png" alt="Smart-Pix Logo" class="logo"/>
                    <nav>
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <input type="text" placeholder="Recherche par photo, catégorie, artiste..."/>
                    </nav>
                </section>
                <section class="col-2">
                    <select>
                        <option>Connexion / Inscription</option>
                    </select>
                </section>
            </div>
        </div>
    </header>
    <body>
        <?php include $this->view.".view.php"; ?>
    </body>
    <footer>
        Smart-Pix © - 2017
    </footer>
</html>
