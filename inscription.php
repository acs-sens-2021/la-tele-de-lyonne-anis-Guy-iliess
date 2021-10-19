<?php
session_start();
if (!empty($_POST)) {
    $_SESSION['post'] = $_POST;
    if (
        isset($_POST['pseudo'], $_POST['prenom'], $_POST['nom'], $_POST['email'], $_POST['pass'])
        && !empty($_POST['pseudo'])
        && !empty($_POST['prenom'])
        && !empty($_POST['nom'])
        && !empty($_POST['email'])
        && !empty($_POST['pass'])
    ) {
        $pseudo = strip_tags($_POST['pseudo']);
        $prenom = strip_tags($_POST['prenom']);
        $nom = strip_tags($_POST['nom']);

        if (strlen($pseudo) < 5) {
            $_SESSION['message'][] = 'le pseudo est court';
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['message'][] = 'Email invalide';
        }
        if (strlen($_POST['pass']) < 12) {
            $_SESSION['message'][] = 'Le mot de passe est trop court';
        }
        if (isset($_SESSION['message'])) {
            header('Location: inscription.php');
            exit;
        }
        $pass = password_hash($_POST['pass'], PASSWORD_ARGON2ID);
        require_once "includes/connect.php";
        $sql = "INSERT INTO `users`(`user_name`, `firstname`, `lastname`, `mail`, `password`, `roles`) VALUES (:pseudo, :prenom, :nom, :email, '$pass', '[\"ROLE_USERS\"]');";
        $requete = $db->prepare($sql);
        $requete->bindValue(':pseudo', $pseudo);
        $requete->bindValue(':prenom', $prenom);
        $requete->bindValue(':nom', $nom);
        $requete->bindValue(':email', $_POST['email']);
        $requete->execute();
      
        $id = $db->lastInsertId();
        $_SESSION['user'] = [
            'id' => $id,
            'user_name' => $pseudo,
            'email' => $_POST['email']
        ];
        header('Location: dashboard.php');
        exit;
    } else {
        $_SESSION['message'][] = 'Il faut tout remplir';
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/inscription.css">
    <title>inscription</title>
</head>

<body>
    <main>
        <div class="card">
            <div class="fond"></div>
            <div class="form-container">
                <div class="title">
                    <h1>Créer un compte</h1>
                </div>
                <form method="post">
                    <div class="champ">
                        <input type="text" name="pseudo" placeholder="pseudo" value="<?php echo $_SESSION['post']['pseudo'] ?? "";
                                                                                        ?>">
                    </div>
                    <div class="champ">
                        <input type="text" name="nom" placeholder="Nom" value="<?php
                                                                                echo $_SESSION['post']['nom'] ?? "";
                                                                                ?>">
                    </div>
                    <div class="champ">
                        <input type="text" name="prenom" placeholder="Prénom" value="<?php
                                                                                        echo $_SESSION['post']['prenom'] ?? "";
                                                                                        ?>">
                    </div>
                    <div class="champ">
                        <input type="text" name="email" placeholder="E-mail" value="<?php
                                                                                    echo $_SESSION['post']['email'] ?? "";
                                                                                    ?>">
                    </div>
                    <div class="champ">
                        <input type="password" name="pass" placeholder="Mot de Passe">
                    </div>
                    <button type="submit">M'inscrire</button>
                </form>
                <div class="alertes">
                    <?php
                    if (isset($_SESSION['message'])) {
                        foreach ($_SESSION['message'] as $message) {
                            echo "<p>$message</p>";
                        }
                        unset($_SESSION['message']);
                    }
                    ?>
                </div>
                <div class="line"></div>
                <div class="links">

                    <a href="#">j'ai déja un compte? je me connect!</a>
                </div>
            </div>
        </div>
    </main>
    <?php unset($_SESSION['post']); ?>
</body>

</html>