<?php
    session_start();

    require 'connexion.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="fontawesome/css/all.min.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <title>TERMINAL BANK | site officiel</title>
</head>
<body>
    <header id="accueil">
        <section class="haut-de-page"> <!--haut-de-page-->
            <div class="container">
                <div class="row">
                    <div class="col-md-4 text-logo">
                        <a href="#accueil">T<span class="bank">bank</span></a> 
                    </div>
                    <div class="col-md-4 social">
                       <a href="wwww.facebook.com" target="blank"><i class="fab fa-facebook"></i></a>  <a href="www.twitter.com" target="blank"><i class="fab fa-twitter"></i></a>  <a href="www.google-plus.com"><i class="fab fa-google-plus"></i></a>
                    </div>
                    <div class="col-md-4 user-icon">
                        <a href="loggin.php"><i class="fa fa-user"></i></a> 
                    </div>
                </div>
            </div>
        </section>  <!--E.haut-de-page-->
    </header>

    <div class="container">
        <div class="alert alert-success">
           felicitation <?php echo $_SESSION['nom'].' '; ?> <?php echo $_SESSION['prenoms'].' '; ?>  !! Votre inscription s'est effectuée avec succes !
        </div>
        <div>
            <div class="row">
                <div class="col-md-6">
                    <i class="fa fa-arrow-left"></i> <a href="index.html"> Continuer sur le site</a>
                </div>

                <div class="col-md-6">
                    <a href="register.php" class="btn btn-outline-primary" type="button" role="button"> S'inscrire</a>
                    <a href="loggin.php"class="btn btn-primary" type="button" role="button"> Se connecter</a>
                </div>
            </div>
        </div>
        
    </div>

    <footer class="registered-footer"> <!--Footer-->
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1>TERMINAL BANK</h1>
                    <P>fiabilité, securité, experience <br/>
                        dk-terminal@bank.ci  |  21 22 23 24 | 68 00 00 00
                    </P>
                </div>
                <div class="col-sm-6">
                    <i class="fa fa-user-circle"></i>
                    <h2>Espace membre</h2>
                    <h5>transfert, retrait, consultation</h5>
                    <a href="register.php" class="btn btn-outline-primary" type="button" role="button"> S'inscrire</a>
                    <a href="loggin.php"class="btn btn-primary" type="button" role="button"> Se connecter</a>
                </div>
            </div>  
            <div class="col-sm-12">
                <div class="copyright">
                    <div>
                        <i class="fa fa-copyright"></i>  copyright - tout droit reservé a TERMINAL BANK
                        <p>site creer par <span id="dk-codeur">DK-codeur</span></p>
                    </div>
                </div>
            </div>
        </div>
        
    </footer> <!--E.Footer-->

    <script src="bootstrap/js/jquery-3.2.1.slim.min.js"></script>
    <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
</body>
</html>