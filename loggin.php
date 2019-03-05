<?php
    session_start();

    require 'connexion.php';

    $email = $pass = "";
    $emailError = $passError = $compteError = "";
    $isSuccess = false;

        //function
    function verifyInput($var)
        {
            $var = trim($var);
            $var = stripslashes($var);
            $var = htmlspecialchars($var);
            return $var;
        }
    
    function verifyEmail($var)
        {
            return filter_var($var, FILTER_VALIDATE_EMAIL);
        }

    if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $email = verifyInput($_POST['email']);
            $pass  = verifyInput($_POST['pass']);

            $isSuccess = true;

            if(!verifyEmail($email))
                {
                    $emailError = 'email invalide';
                    $isSuccess = false;
                }

            if(empty($email))
                {
                    $emailError = 'Votre Email';
                }

            if(empty($pass))
                {
                    $passError = 'votre mot de passe';
                    $isSuccess = false;
                }

            if($isSuccess)
                {
                    $req = $Database->prepare('SELECT * FROM user WHERE email = ? AND passe = ? ');
                    $req->execute(array($email, $pass));

                    // $req2 = $Database->prepare('SELECT compte.solde FROM compte INNER JOIN user WHERE compte.id_user = ?  ');                        
                    // $req2->execute(array($id_user));
                    // $id = $req2->fetch();

                    $userExiste = $req->rowCount();
                    if($userExiste == 1)
                        {
                            // $compteError = 'bravooooooooo';
                            $userInfo = $req->fetch();
                            
                            $_SESSION['id_user'] = $userInfo['id_user'];
                            $_SESSION['nom'] = $userInfo['nom'];
                            $_SESSION['prenoms'] = $userInfo['prenoms'];
                            $_SESSION['telephone'] = $userInfo['telephone'];
                            $_SESSION['email'] = $userInfo['email'];
                            $_SESSION['solde'] = $userInfo['solde'];
                            
                            header("location:  account.php?id=".$_SESSION['id_user']);

                        }

                    else
                        {
                            $compteError = 'email ou mot de passe incorrect';
                        }
                }
        }

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
    <title>TERMINAL BANK connexion</title>
</head>
    <section class="haut-de-page"> <!--haut-de-page-->
        <div class="container container-register">
            <div class="row">
                <div class="col-md-4 text-logo">
                    <a href="#accueil">T<span class="bank">bank</span></a> 
                </div>
                <div class="col-md-4 retour-accueil">
                <a href="index.html" class="link">Retour vers l'accueil</a>                </div>
                <div class="col-md-4 mt-3 bouton-connexion">
                    <a href="register.php" class="btn btn-outline-light" type="button" role="button"> S'inscrire</a>
                    <a href="loggin.php" class="btn btn-light" type="button" role="button"> Se connecter</a>
                </div>
            </div>
        </div>
    </section>  <!--E.haut-de-page-->
    <div class="container container-register">
        <div class="membre">
            Espace membre
        </div>
        <div class="divider-blue-membre"></div>
        <p class="membre-p">connectez-vous à votre espace privé</p>

        <div class="formulaire-connexion">
            <i class="fa fa-user-circle"></i>
            <div class="message-error"><?php echo $compteError; ?></div>
            
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="email">Email  <span class="message-error"> <?php echo $emailError; ?> </span></label> 
                <input type="text" name="email" id="email" class="form-control" placeholder="Votre email" value="<?php echo $email; ?>">


                <label for="pass">Mot de passe <span class="message-error"> <?php echo $passError; ?> </span> </label>
                <input type="password" name="pass" id="pass" class="form-control" placeholder="password" value="<?php echo $pass; ?>">

                <input class="btn btn-primary mt-4" type="submit" value="Se connecter">
                <a href="#" class="btn btn-outline-info mt-4" type="button" role="button"> Aide</a><br/>
                
                <p class="membre-p">vous n'avez pas de compte ?</p>
                <a href="register.php" class="btn btn-info btn-md bouton-sinscrire" type="button" role="button"> Inscrivez vous</a>
            </form>
        </div>
    </div>  
    <footer class="footer-loggin"> <!--Footer-->
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