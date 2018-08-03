<?php
$entry = '';
foreach ($_GET as $key => $value) {
  $entry = $key;
  $entry = filter_var($entry, FILTER_SANITIZE_STRING);
}
switch ($entry) {
  case 'home':
  case '':
    include './views/home_content.php';
    include './partials/head.php';
    include './partials/home_page.php';
    include './partials/footer.php';
    break;
  case 'aquarelle':
    include './views/aquarelle_content.php';
    include './partials/head.php';
    include './partials/content_page.php';
    include './partials/footer.php';
    break;
  case 'accueil':
    include './views/accueil_content.php';
    include './partials/head.php';
    include './partials/content_page.php';
    include './partials/footer.php';
    break;
  case 'contact':
    include './views/contact_content.php';
    include './partials/head.php';
    include './partials/treatment_form.php';
    include './partials/contact_page.php';
    include './partials/footer.php';
    break;
  case 'intro':
  case 'ASBL':
  case 'ballon rouge':
    include './views/intro_content.php';
    include './partials/head.php';
    include './partials/content_page.php';
    include './partials/footer.php';
    break;
  case 'form-logs';
    include './partials/form-logs.php';
    break;
  default:
    include './views/404.php';
    break;
}
?>
