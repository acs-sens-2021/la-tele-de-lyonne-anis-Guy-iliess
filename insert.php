<?php
session_start();

if (!empty($_POST)) {
    if (isset($_POST['category']) && isset($_POST['title']) && isset($_POST['video']) && !empty($_POST['category']) && !empty($_POST['title']) && !empty($_POST['video'])) {
        $category = strip_tags($_POST['category']);
        $title = strip_tags($_POST['title']);
        $video = strip_tags($_POST['video']);
        $link = "tmplink.html/tmp/";
        $my_file = $my_description = NULL;
        $u_id = 1;

        // Verif & assignement description si existante
        if (isset($_POST['description']) && !empty($_POST['description'])) {
            $my_description = strip_tags($_POST['description']);
        }

        // Verif & assignement fichier si existant
        if (isset($_FILES['file']) && !empty($_FILES['file'])) {
            $uniqName = md5(uniqid('', true));
            $name = $_FILES['file']['name'];
            $tabExtension = explode('.', $name);
            $extension = strtolower(end($tabExtension));
            $extensions = ['jpg', 'png', 'jpeg', 'svg'];
            $types = ['image/svg', 'image/jpeg', 'image/png'];

            // Verif si le fichier est conforme (extension acceptée, taille max respectée & aucune erreur)
            if (!in_array($_FILES['file']['type'], $types) || !in_array($extension, $extensions) || 4194304 < $_FILES['file']['size']) {
                $_SESSION['msg_error'][] = "Votre fichier n'est pas conforme, il doit peser moins de 4Mo et respecter le format autorisé (jpeg, jpg, png, svg)";
                header('Location: insert.php');
                exit;
            }
            if ($_FILES['file']['error'] != 0) {
                $_SESSION['msg_error'][] = "Une erreur a eu lieu durant la récupération de votre fichier";
                header('Location: insert.php');
                exit;
            }
            $my_file = $uniqName . "." . $extension;
            move_uploaded_file($_FILES['file']['tmp_name'], __DIR__ . "/img/uploaded/" . $my_file);
        }

        require_once 'includes/connect.php';

        $sql = "INSERT INTO `articles` (`category`, `title`, `description`, `link`, `video`, `picture`, `user_id`) VALUES (:category, :title, :my_description, :link, :video, :my_file, :u_id);";

        $requete = $db->prepare($sql);

        $requete->bindValue(':category', $category);
        $requete->bindValue(':title', $title);
        $requete->bindValue(':link', $link);
        $requete->bindValue(':video', $video);
        $requete->bindValue(':u_id', $u_id);

        $paramDescrip = ($my_description != NULL) ? PDO::PARAM_STR : PDO::PARAM_NULL;
        $paramFile = ($my_file != NULL) ? PDO::PARAM_STR : PDO::PARAM_NULL;
        $requete->bindValue(':my_description', $my_description, $paramDescrip);
        $requete->bindValue(':my_file', $my_file, $paramFile);

        $requete->execute();
        header('Location: insert.php');
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
    <link rel="shortcut icon" href="./img/logo-tv-de-lyonnne.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/insert.css">
    <title>Insertion Article</title>
</head>

<body>
    <main>
        <h1 class="titre">Insertion d'article</h1>
        <?php
        if (isset($_SESSION['msg_error'])) {
            foreach ($_SESSION['msg_error'] as $message) {
                echo '<p style="text-align: center; font-size: 16px; color: black; font-weight: bold">';
                echo "$message";
                echo '</p>';
            }
            unset($_SESSION['msg_error']);
        }
        ?>
        <form method="post" enctype="multipart/form-data">
            <h2>Catégorie :</h2>
            <select name="category" id="category">Categorie
                <?php
                require_once 'includes/connect.php';

                $sql = "SELECT `name` FROM `emissions`";
                $requete = $db->prepare($sql);
                $requete->execute();

                $liste = $requete->fetch();

                while ($liste) {
                    echo '<option>';
                    echo $liste["name"];
                    echo '</option>';
                    $liste = $requete->fetch();
                }
                ?>
            </select>
            <h2>Titre :</h2>
            <textarea name="title" id="title" cols="50" rows="10" maxlength="100"></textarea>

            <h2>Description : (optionnelle)</h2>
            <textarea name="description" id="description" cols="50" rows="10"></textarea>

            <h2>Lien de la vidéo en rapport :</h2>
            <textarea name="video" id="video" cols="50" rows="10"></textarea>

            <h2>Image de l'article : (optionnelle)</h2>
            <input type="file" accept=".png, .jpg, .jpeg, .svg" name="file" id="file">

            <button type="submit">Envoyer l'article</button>
        </form>
    </main>
</body>

</html>