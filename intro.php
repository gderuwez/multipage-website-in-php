<?php
include './source/head.php';
include './source/content_page.php';
$im1 = './assets/images/pic05.jpg';
$im1a;
$bname = 'A propos de nous';
$bcontent = 'Ballon Rouge ASBL';
$s1name = 'Historique';
$s1content = "Créée en 1991, par l’asbl Vie Féminine, l’asbl « le Ballon Rouge » est située boulevard de l'Abattoir 27-28 à 1000 Bruxelles";
$s21im = './assets/images/pic06.jpg';
$s21ima;
$s2h1name = 'Vocations';
$s2h1content = "a pour raison sociale l’accueil et l’éducation des enfants de 0 à 6 ans, mais s'occupe plus principalement des enfant de 0-3 ans et plus particulièrement d’enfants de parents issus du monde du travail, de demandeurs d’emploi en formation, de personnes fragilisées socialement. Elle peut organiser toute activité lui permettant de réaliser son objet dans une perspective de service d’éducation et de promotion des familles. La participation des usagers à la vie du service doit être effective. L’association peut aussi prêter son concours et s’intéresser à toutes activités similaires à son objet. L’association entend exercer son activité en conformité avec les options fondamentales du mouvement Vie Féminine.";
$s22im = './assets/images/pic07.jpg';
$s22ima;
$s2h2name = "Nos services";
$s2h2content = "L’asbl offre aux parents deux services : un service d’accueillantes conventionnées sur l’ensemble des communes de la Région bruxelloise et une Halte-accueil, «  l’Aquarelle », située rue du Tivoli, 45 à Laeken (depuis mai 2005). Celle-ci accueille des enfants dont la plupart des parents sont en formation ou en insertion socioprofessionnelle.";
$s3name = "Status";
$s3content = "Le Ballon Rouge est reconnu comme asbl. Ses statuts ont été déposés en décembre 2005 et publiés au moniteur belge le 23 décembre 2005.";
head('Ballon Rouge', 'alt style2');
@content($im1, $im1a, $bname, $bcontent, $s1name, $s1content, $s21im, $s21ima, $s2h1name, $s2h1content, $s22im, $s22ima, $s2h2name, $s2h2content, $s3name, $s3content);
include './source/footer.php';
?>
