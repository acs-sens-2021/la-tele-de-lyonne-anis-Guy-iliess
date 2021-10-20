<?php
session_start();

if (isset($_POST['category']) && isset($_POST['title']) && isset($_POST['video']) && !empty($_POST['category']) && !empty($_POST['title']) && !empty($_POST['video'])) {
    $category = strip_tags($_POST['category']);
    $title = strip_tags($_POST['title']);
    $video = strip_tags($_POST['video']);
    $date_creation = date('Y-m-d');
    $u_id = 1;
    $link = "tmplink.html/tmp/";

    // 0 = none, 1 = description, 2 = file, 3 = description + file
    $optional = 0;

    if (isset($_POST['description']) && !empty($_POST['description'])) {
        $my_description = strip_tags($_POST['description']);
        $optional += 1;
    }
    if (isset($_FILES['file']) && !empty($_FILES['file'])) {
        $uniqName = uniqid('', true);
        $name = $_FILES['file']['name'];

        $tabExtension = explode('.', $name);
        $extension = strtolower(end($tabExtension));
        //Tableau des extensions que l'on accepte
        $extensions = ['jpg', 'png', 'jpeg', 'gif', 'svg'];

        if (in_array($extension, $extensions)) {
            $uniqName = $uniqName . "." . $extension;
            $my_file = "./img/uploaded/" . $category . "/" . $uniqName;
            move_uploaded_file($_FILES['file']['tmp_name'], $my_file);
            $optional += 2;
        }
    }

    require_once 'includes/connect.php';

    $sql = "INSERT INTO `articles` (`category`, `title`, `link`, `video`, `user_id`) VALUES (:category, :title, :link, :video, :u_id);";

    if ($optional === 1) {
        $sql = "INSERT INTO `articles` (`category`, `title`, `description`, `link`, `video`, `user_id`) VALUES (:category, :title, :my_description, :link, :video, :u_id);";
    }
    if ($optional === 2) {
        $sql = "INSERT INTO `articles` (`category`, `title`,`link`, `video`, `picture`, `user_id`) VALUES (:category, :title, :link, :video, :my_file, :u_id);";
    }
    if ($optional === 3) {
        $sql = "INSERT INTO `articles` (`category`, `title`, `description`, `link`, `video`, `picture`, `user_id`) VALUES (:category, :title, :my_description, :link, :video, :my_file, :u_id);";
    }

    $requete = $db->prepare($sql);

    $requete->bindValue(':category', $category);
    $requete->bindValue(':title', $title);
    $requete->bindValue(':link', $link);
    $requete->bindValue(':video', $video);
    $requete->bindValue(':u_id', $u_id);

    if ($optional === 1) {
        $requete->bindValue(':my_description', $my_description);
    }
    if ($optional === 2) {
        $requete->bindValue(':my_file', $my_file);
    }
    if ($optional === 3) {
        $requete->bindValue(':my_description', $my_description);
        $requete->bindValue(':my_file', $my_file);
    }

    $requete->execute();
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