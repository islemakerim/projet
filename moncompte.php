<?php

require('inc/config.php');
require('inc/fonctions.php');

connected(); //UTILISATEUR CONNECTÉ OU NON SINON RENVOIE CONNEXION.PHP

if(isset($_POST['edit'])){
    $email = htmlspecialchars($_POST['email']);
    if(!empty($email)){
        if($email != $_SESSION['email']){
            $req_edit_email = $db->prepare('UPDATE users SET email = ? WHERE id = ?');
            $req_edit_email->execute([$email, $_SESSION['id']]);
            $_SESSION['email'] = $email;
            $_SESSION['message_success'] = "Vos informations ont bien été mis à jour.";
        }else{
            $_SESSION['message_error'] = "Vous devez choisir une adresse email différente que celle que vous utilisiez actuellement.";
        }
    }else{
        $_SESSION['message_error'] = "Vous devez obligatoirement définir une adresse email valide.";
    }
}
?>

<!DOCTYPE HTML>
<html>
<?php require('inc/header.php'); ?>
<body>

<div class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
    <div class="container">
        <a href="#" class="navbar-brand">CodeStoryRimbaud</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><i class="fa fa-home"></i> Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="deconnexion.php"><i class="fa fa-power-off"></i> Déconnexion</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="container" style="margin-top: 60px;">
    <?php   
        if(isset($_SESSION['message_error'])){
            echo '<div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><i class="fa fa-remove"></i> Une erreur est survenue...</strong> <br>' . $_SESSION['message_error'] . '
                    </div>';
            unset($_SESSION['message_error']);
        }
        if(isset($_SESSION['message_success'])){
            echo '<div class="alert alert-dismissible alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong><i class="fa fa-check-circle"></i> Bravo!</strong> <br>' . $_SESSION['message_success'] . '
                        </div>';
            unset($_SESSION['message_success']);
        }
    ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="">Nom d'utilisateur</label>
            <input type="text" class="form-control" value="<?= $_SESSION['username']; ?>" disabled>
            <small class="form-text text-muted">Le nom d'utilisateur vous servira lorsque vous souhaiterez accéder au site.</small>
        </div>

        <div class="form-group">
            <label for="">E-mail</label>
            <input name="email" type="email" class="form-control" placeholder="Entrer votre adresse email" value="<?= $_SESSION['email']; ?>">
            <small class="form-text text-muted">L'email doit-être obligatoirement valide.</small>
        </div>
        <button type="submit" name="edit" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Modifier</button>
    </form>
</div>


<script src="https://bootswatch.com/_vendor/jquery/dist/jquery.min.js"></script>
</body>
</html>
