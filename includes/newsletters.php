<?php 
session_start();
if(!empty($_POST)){
    $_SESSION['post'] = $_POST;
    if(isset($_POST['email']) && !empty($_POST['email'])){

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['message'][] = 'Email invalide';
        }
        if (isset($_SESSION['message'])) {
            header('Location: newsletters.php');
            exit;
        }
        require_once 'includes/connect.php';
        $sql= "INSERT INTO `newsletters`(`mail`, `created_date`, `updated_date`, verfied) VALUES ";
    }
}
?>
<form method="post">
            <div class="news">
                <p class="texte2">Je m’abonne pour recevoir les meilleurs articles</p>
                <input class="input" type="email" name="email" placeholder="mon email*">
                <button class="button" type="submit">je reçois les newsletters</button>
            </div>
        </form>