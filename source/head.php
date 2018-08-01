
<?php
function head($title, $class){
  echo <<<EOL
  <!DOCTYPE HTML>
  <!--
  	Forty by HTML5 UP
  	html5up.net | @ajlkn
  	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
  -->
  <html>
  <head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="assets/css/main.css" />
  <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
  <title>$title</title>
  </head>
  <body class="is-preload">
  <!-- Wrapper -->
  <div id="wrapper">
  <!-- Header -->
  <header id="header" class=$class>
  <a href="index.html" class="logo"><strong>ASBL</strong> <span>Ballon Rouge</span></a>
  <nav>
    <a href="#menu">Menu</a>
  </nav>
  </header>

  <!-- Menu -->
  <nav id="menu">
  <ul class="links">
    <li><a href="index.php">Home</a></li>
    <li><a href="intro.php">L'ASBL</a></li>
    <li><a href="accueil.php">Accueillantes</a></li>
    <li><a href="aquarelle.php">L'Aquarelle</a></li>
    <li><a href="contact.php">Contact</a></li>
  </ul>
  <ul class="actions stacked">
    <li><a href="#" class="button primary fit">Commencez</a></li>
  </ul>
  </nav>
EOL;
}
 ?>
