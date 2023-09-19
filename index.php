<?php
 session_start();
 if (isset($_SESSION['nom'])) {
    $user = $_SESSION['nom'];
 } else {
    header ('location: inscription.php');
 }
 ?>

 <html>
 <head>
 <meta charset="utf-8">
 <!-- importer le fichier de style -->
 <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
 </head>
 <body style='background:#fff;'>
 <div id="content">
 <?php
 // afficher un message
 echo "Bienvenue $user, vous êtes connecté";
 ?>
 </div>
 </body>
</html>