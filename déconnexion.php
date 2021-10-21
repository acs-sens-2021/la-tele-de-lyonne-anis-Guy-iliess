<?php
session_start();


unset($_SESSION['users']);


header('Location: connexion.php');
exit;