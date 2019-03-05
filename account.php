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
    <title>TERMINAL BANK espace membre</title>
</head>
    <section class="haut-de-page"> <!--haut-de-page-->
        <div class="container">
            <div class="row">
                <div class="col-md-4 text-logo">
                    <a href="#accueil">T<span class="bank">bank</span></a> 
                </div>
                <div class="col-md-4 retour-accueil">
                    <a href="<?php urlencode(index.html)?>" class="link">Retour vers l'accueil</a>
                </div>
                
                <div class="col-md-4 user-connect">
                    <i class="fa fa-user-circle"></i> <div class="user-connect-name"> <?php echo $_SESSION['nom']; ?></div>
                </div>
            </div>
        </div>
    </section>  <!--E.haut-de-page-->

    <div class="container account-header">
        <h1>Votre profile</h1>
        <div class="divider-blue"></div>
    </div>
    <div class="container">
        <a href="transfer.php" class="btn btn-info transfer">Tranferez de l'argent</a>
    </div>
    <section class="info-account">
        <div class="container-fluid">
            <h3>information du client</h3>
            <div class="row">
                <div class="col-md-6">
                    <i class="fa fa-user"></i>
                </div>

                <div class="col-md-6 info-client">
                    Identifiant client : 0002019000<?php echo $_SESSION['id_user'] ?> <br/><br/>
                    Nom :   <?php echo $_SESSION['nom']; ?>                     <br/><br/>
                    Prenoms :  <?php echo $_SESSION['prenoms']; ?>              <br/><br/>
                    Telephone :  <?php echo $_SESSION['telephone'] ?>           <br/><br/>
                    Email :   <?php echo $_SESSION['email'] ?>                  <br/><br/>
                    Solde courant:<span class="solde"> <?php echo $_SESSION['solde'] ?> </span><br/>
                </div>
            </div>
        </div>
    </section>

    <footer> <!--Footer-->
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

<?php

?>