<?php
/**
 * Created by PhpStorm.
 * User: Aurel Bertrand
 * Date: 04/12/2016
 * Time: 10:02
 */
if($_GET['tru']==1)
{
    setcookie("email", $_GET['email'], time()+25); // On crée un cookie qui expirera 25 secondes plus tard pour des raisons de sécurité.
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
    <meta http-equiv=Content-Type content="text/html; charset=iso-8859-1">
    <?php
    if($_GET['tru']==2)
    {
        ?>
        <meta http-equiv="refresh" content="1; url=http://www.MonSite.fr/" /> <!-- Redirection vers la page d'accueil du site si on a entré son e-mail. -->
    <?php
    }
    else
    {
        ?>
        <meta http-equiv="refresh" content="25; url=http://www.MonSite.fr/" /> <!-- Redirection vers la page d'accueil du site si on tarde trop à entrer son e-mail. -->
    <?php
    }
    ?>
    <title>Validation de votre désinscription de la newsletter de MonSite.fr</title>
</head>
<body>
<p align="center"><font size="5">Validation de votre désinscription</font></p>
<?php
if($_GET['tru']==1) //si la variable $_GET['tru'] est égale à 1
    // On affiche le formulaire.
{
    ?>
    <font color="red">Attention, vous avez 25 secondes pour remplir le formulaire. Passé ce délai, celui-ci ne sera plus valide.</font>
    <form method="post" action="desinscription.php?tru=2">
        Entrez votre adresse e-mail : <input type="text" name="email" size="25" /><br />
        <input type="submit" value="Envoyer" name="submit" /> <input type="reset" name="reset" value="Effacer" />
    </form>
<?php
}
elseif($_GET['tru']==2) // Sinon, si la variable $_GET['tru'] est égale à 2.
{
    mysql_connect("localhost", "login", "pass");
    mysql_select_db("db");
    $email_mail = mysql_real_escape_string($_COOKIE['email']);
    $email_entre = mysql_real_escape_string($_POST['email']);
    if($email_entre==$email_mail) // Si les deux adresses e-mail sont identiques.
    {
        mysql_query("DELETE FROM newsletter WHERE email='" . $email_entre ."'"); //On supprime l'adresse de la BDD.
        echo "Vous avez bien été désinscrit de la newsletter de familov.com ! Vous allez être redirigé dans 1 seconde.";
    }
    else
    {
        echo "Vous n'avez pas entré la bonne adresse e-mail !!";
    }
}
else
{
    echo "Il y a eu une erreur.";
}
?>
</body>
</html>