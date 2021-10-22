<?php 
if(!empty($_POST)){
    $_SESSION['post'] = $_POST;
    if(isset($_POST['email']) && !empty($_POST['email'])){

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            // $_SESSION['message'][] = 'Email invalide';
            die('Email invalide');
        }
        // if (isset($_SESSION['message'])) {
        //     header('Location: newsletters.php');
        //     exit;
        // }
        require_once 'includes/connect.php';
        // $mail = "SELECT * FROM `newsletters` WHERE mail = ";
        $sql= "INSERT INTO `newsletters`(`mail`) VALUES (:email)";
        $requete = $db->prepare($sql);
        $requete->bindValue(':email', $_POST['email']);
       
        $requete->execute();
    }else {
        // $_SESSION['message'][] = 'Il faut tout remplir';
        die('Il faut tout remplir');
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