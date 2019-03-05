<?php
    session_start();
    require 'connexion.php';

        //initialise
    $nom = $prenoms = $telephone = $email = $pass = $confirm  = "";
    $nomError = $prenomsError = $telephoneError = $emailError = $passError = $confirmError = "";
    $isSuccess = false;
    $emailOK = false;
    $emailTo = $email;

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

    function verifyPhone($var)
        {
            return preg_match('/^[0-9 ]+$/', $var);
        }

            //submit
    if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $nom        = verifyInput($_POST['nom']);
            $prenoms    = verifyInput($_POST['prenoms']);
            $email      = verifyInput($_POST['email']);
            $telephone  = verifyInput($_POST['telephone']);
            $pass       = verifyInput($_POST['pass']);
            $confirm    = verifyInput($_POST['pass']);

            $isSuccess = true;
            $emailOK = true;
            $emailText = "";


            if(empty($nom))
                {
                    $nomError = 'Votre nom';
                    $isSuccess = false;
                }

            else
                {
                    $emailText .="Nom : $nom\n";
                }

            
            if(empty($prenoms))
                {
                    $prenomsError = 'Votre prenoms';
                    $isSuccess = false;
                }

            else
                {
                    $emailText .="Prenoms : $prenoms\n";
                }


            if(!verifyEmail($email))
                {
                    $emailError = 'email invalide';
                    $isSuccess = false;
                }
            else
                {
                    $req = $Database->prepare('SELECT id_user FROM user WHERE email = ?');
                    $req->execute(array($email));

                    $verifyUser = $req->fetch();
                    if($verifyUser)
                        {
                            $emailError = 'Cet mail existe deja';
                            $emailOK = false;
                        }

                    else
                        {
                            $emailText .="Email : $email\n";
                        }
                }

            if(!verifyPhone($telephone))
                {
                    $telephoneError = 'numero incorrect';
                    $isSuccess = false;
                }


            if(empty($pass))
                {
                    $passError = 'mot de passes vide';
                    $isSuccess = false;
                }

            else  
                {
                    $emailText .="PassWord : $pass\n";
                }
                

            //insert
            if($isSuccess && $emailOK)
                {
                    $req = $Database->prepare('INSERT INTO user SET nom = ?, prenoms = ?, telephone = ?, email = ?, passe = ?');
                    $req->execute(array($nom, $prenoms, $telephone, $email, $pass));

                    $header = "from : TERMINAL BANK Inc <dorgeleskoble[@]gmail.com>\r\nReply-To: dorgeleskoble[@]gmail.com";
                    mail($emailTo, "Inscription Reussie", "bonjour $nom  $prenoms votre inscription a ete effectuee avec succes\n vos identifiants sont\n Email : $email \n Password : $pass \n\n Conectez vous  \, $header");

                    $nom = $prenoms = $telephone = $email = $pass = $confirm  = "";

                   
                    $_SESSION['nom'] = $_POST['nom'];
                    $_SESSION['prenoms'] = $_POST['prenoms'];

                    header('location: registered.php?name='.$_SESSION['nom']) ;
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
    <title>Inscription</title>
</head>
    <section class="haut-de-page"> <!--haut-de-page-->
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 text-logo">
                    <a href="#accueil">T<span class="bank">bank</span></a> 
                </div>
                <div class="col-md-4 col-sm-4 social">
                    <a href="wwww.facebook.com" target="blank"><i class="fab fa-facebook"></i></a>  <a href="www.twitter.com" target="blank"><i class="fab fa-twitter"></i></a>  <a href="www.google-plus.com"><i class="fab fa-google-plus"></i></a>
                </div>
                <div class="col-md-4 col-sm-4 mt-3 bouton-connexion">
                    <a href="register.php" class="btn btn-outline-light" type="button" role="button"> S'inscrire</a>
                    <a href="loggin.php" class="btn btn-light" type="button" role="button"> Se connecter</a>
                </div>
            </div>
        </div>
    </section>  <!--E.haut-de-page-->
    
        <div class="container">
            <div class="membre">
                M'inscrire
            </div>
            <div class="divider-blue-membre"></div>
            <p class="membre-p">Inscrivez-vous et decouvrez notre expertise</p>

        
                <div class="user-icon-register"><i class="fa fa-user"></i></div>
            <section class="block-inscription">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="formulaire-inscription col-lg-offset-1"> <!-- form-->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nom">Nom  <span class="message-error"> <?php echo $nomError; ?> </span></label> 
                                <input type="text" name="nom" id="nom" class="form-control" placeholder="votre nom" value="<?php echo $nom; ?>">

                                <label for="prenoms">Prenoms  <span class="message-error"> <?php echo $prenomsError; ?> </span></label>
                                <input type="text" name="prenoms" id="prenoms" class="form-control" placeholder="Votre prenoms" value="<?php echo $prenoms; ?>">

                                <label for="email">Email  <span class="message-error"> <?php echo $emailError; ?> </span></label> 
                                <input type="text" name="email" id="email" class="form-control" placeholder="Votre email" value="<?php echo $email; ?>">
                            </div>

                            <div class="col-md-6">
                                <label for="telephone">Telephone <span class="message-error"> <?php echo $telephoneError; ?> </span></label> 
                                <input type="number" name="telephone" id="telephone" class="form-control" placeholder="Votre telephone" value="<?php echo $telephone; ?>">
                            
                                <label for="pass">Mot de passe  <span class="message-error"> <?php echo $passError; ?> </span></label> 
                                <input type="password" name="pass" id="pass" class="form-control" placeholder="Entre un mot de passe" value="<?php echo $pass; ?>">
                                            
                                <label for="confirm"> Confirmer Mot de passe  <span class="message-error"><?php echo $confirmError; ?> </span></label> 
                                <input type="password" name="confirm" id="confirm" class="form-control" placeholder="Confirmer mot de passe" value="<?php echo $confirm; ?>">
                            </div> 
                        </div>
                        <div class="boutons-inscription">
                            <input class="btn btn-primary mt-4" type="submit" value="S'inscrire"> 
                            <a href="#" class="btn btn-outline-info mt-4" type="button" role="button"> Aide</a><br/>
                        </div>
                        
                        <div class="container register-log-button">
                            <div class="register-text">déja un compte ?</div><br/><br/>
                            <a href="loggin.php" class="btn btn-info btn-md bouton-sinscrire" type="submit" role="button"> Se connecter</a>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    

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

    