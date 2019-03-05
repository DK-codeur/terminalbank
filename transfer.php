<?php
    session_start();
    require 'connexion.php';

    $desole = $receiver = $nom = $prenoms = "";
    $oldMontant = $montant = 0;
    $tranfer_success = $receiverError = $montantError = "";
    $isSuccess = false;

    function verifyInput($var)
        {
            $var = trim($var);
            $var = stripslashes($var);
            $var = htmlspecialchars($var);
            return $var;
        }


    if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $receiver = verifyInput($_POST['receiver']);
            $montant = verifyInput(($_POST['montant']));

            $isSuccess = true;

            if(empty($receiver))
                {
                    $receiverError = 'le numero de compte du destinataire svp';
                    $isSuccess = false;
                }

            if(empty($montant))
                {
                    $montantError = 'Veillez entrer un montant';
                    $isSuccess = false;
                }

            elseif($montant < 500)
                {
                    $montantError = 'Entrer un montant superieur à <strong>500</stront> ';
                    $isSuccess = false;
                }


            if($isSuccess)
                {
                    $req = $Database->prepare('SELECT * FROM user WHERE id_user = ?');
                    $req->execute(array($receiver));
            
                    $userExiste = $req->rowCount();
                    
                    if($userExiste == 1)

                        {
                            $userInfo = $req->fetch();

                            if($userInfo['id_user'] == $_SESSION['id_user'])
                                {
                                    $desole = '<i class="fa fa-exclamation-triangle"></i> desole vous ne pouvez pas vous transfere';
                                    $montant = $receiver = "";
                                    $Database = NULL;
                                }

                            elseif ($_SESSION['solde'] = 0)
                                {
                                    $desole = '<i class="fa fa-exclamation-triangle"></i> solde insiffisant';
                                    $montant = $receiver = "";
                                    $Database = NULL;
                                }

                            else
                                {

                                    $nom = $userInfo['nom'];
                                    $prenoms = $userInfo['prenoms'];
                                    $oldMontant = $userInfo['solde'];

                                    $oldMontant = $oldMontant + ($montant);
                                    // var_dump($oldMontant);
                                    

                                    $req = $Database->prepare('UPDATE user SET solde = ? WHERE id_user = ?');
                                    $req->execute(array($oldMontant, $receiver));

                                    // $tranfer_success = "vous venez de transferer un montant de <strong>$montant</strong> au compte 0002019000 $receiver ($nom $prenoms)\n Votre solde actuel : " ;


                                    //retire
                                    $req = $Database->prepare('SELECT * FROM user WHERE id_user = ?');
                                    $req->execute(array($_SESSION['id_user']));

                                    $userSession = $req->rowCount();
                                    $sessionInfo = $req->fetch();

                                    $sessId = $sessionInfo['id_user'];
                                    $sessSolde = $sessionInfo['solde'];

                                    $sessSolde = $sessSolde - $montant;

                                    $req = $Database->prepare('UPDATE user SET solde = ? WHERE id_user = ?');
                                    $req->execute(array($sessSolde, $_SESSION['id_user']));

                                    $tranfer_success = "vous venez de transferer un montant de <strong>$montant</strong> au compte 0002019000 $receiver ($nom $prenoms)\n Votre solde actuel : $sessSolde" ;

                                    $montant = $receiver = "";
                                    $Database = NULL;

                                } 
                                
                        }        

                    else
                        {
                           $receiverError = 'numero invalide'; 
                           $montant = $receiver = "";
                           $Database = NULL;
                        }

                    // $userExiste = $req->rowCount();
                    // if($userExiste == 1)
                    //     {
                    //         $userInfo = $req->fetch();

                    //     }
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
    <title>TERMINAL BANK espace membre</title>
</head>
    <section class="haut-de-page"> <!--haut-de-page-->
        <div class="container">
            <div class="row">
                <div class="col-md-4 text-logo">
                    <a href="#accueil">T<span class="bank">bank</span></a> 
                </div>
                <div class="col-md-4 retour-accueil">
                    <a href="index.html" class="link">Retour vers l'accueil</a>
                </div>
                
                <div class="col-md-4 user-connect">
                    <i class="fa fa-user-circle"></i> <div class="user-connect-name"> <?php echo $_SESSION['nom']; ?></div>
                </div>
            </div>
        </div>
    </section>  <!--E.haut-de-page-->

    <div class="container">
        <div class="account-header">        
            <h1>Transferez de l'argent en toute sécurité</h1>
        </div>
        <div class="divider-blue"></div>
            
        <?php echo '<div class="alert alert-success">' .$tranfer_success. '</div>'; ?>
        <div class="desole"> <?php echo $desole; ?> </div>
                 
        <div class="col-md-12">
           
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="formulaire-connexion">
                    <div class="form-group">
                        <label for="receiver">beneficiere  <span class="message-error"><?php echo $receiverError; ?></span> </label> 
                        <input type="Number" name="receiver" id="receiver" class="form-control mb-4" placeholder="0002019000" value="<?php echo $receiver; ?>">

                        <label for="montant">Montant  <span class="message-error"><?php echo $montantError; ?> </span></label>  
                        <input type="number" name="montant" id="montant" class="form-control mb-4" placeholder="Entrer le Montant" value="<?php echo $montant ?>">
                        <button type="submit" name="button" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Envoyer</button>

                        <a href="account.php" type="submit" class="btn btn-outline-info"> Retour</a>
                    </div>
                </div>
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