<?php
 if(!empty($_POST)){
   
     if(
        isset($_POST['email'], $_POST['pass'])
        && !empty($_POST['email'])
        && !empty($_POST['pass'])
     ){
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $_SESSION['message'][] = 'L\'email n\'a pas un format valide';
        }
        require_once 'includes/connect.php';
        $sql = 'SELECT * FROM `users` WHERE `mail` = :email;';
        $requete = $db->prepare($sql);
        $requete->bindValue(':email', $_POST['email']);
        $requete->execute();
        $user = $requete->fetch();
  
        if(!$user){
            // $_SESSION['message'][] ='Identifiant ou mot de passe incorrect';
            die('Identifiant ou mot de passe incorrect');
        }
        if(!password_verify($_POST['pass'], $user['password'])){
            // $_SESSION['message'][] ='Identifiant ou mot de passe incorrect';
            die('Identifiant ou mot de passe incorrect');
        }
        // if (isset($_SESSION['message'])) {
        //     header('Location: connexion.php');
        //     exit;
        // }
 
        session_start();
        $_SESSION['user'] = [
            'id' => $user['id'],
            'pseudo' => $user['user_name'],
            'mail' => $user['mail']
        ];
       
        header('Location: dashboard.php');
        exit;
     }
 }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="css/inscription.css">
    <title>login</title>
</head>
<body>
    <main>
        <div class="card">
            <div class="fond"></div>
            <div class="form-container">
            <div class="title"><h1>Welcome Back!</h1></div>
            <form method="post">
              
                <div class="champ">
                    <input type="text" name="email" placeholder="E-mail">
                </div>
                <div class="champ">
                    <input type="password" name="pass" placeholder="Mot de Passe">
                </div>
                
                <button type="submit">Me connecter</button>
            </form>
            <div class="alertes">
                    
                    <!-- if (isset($_SESSION['message'])) {
                        foreach ($_SESSION['message'] as $message) {
                            echo "<p>$message</p>";
                        }
                        unset($_SESSION['message']);
                    }
                     -->
                    
                </div>
            <div class="line"></div>
            <div class="links">
                <a href="#">Mot de Passe oublié?</a>
                <a href="#">Je crée mon compte  </a>
            </div>
            </div>
        </div>
    </main>
  
    </body> 
</body>
</html>