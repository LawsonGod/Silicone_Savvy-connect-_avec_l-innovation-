<?php
global $dbh;
session_start();
include('connect.php');
require_once ('./inc/outils.php');
?>
<?php include('head_header_nav.php');?>
<div class="container">
    <h1>Qui sommes-nous ?</h1>
    <p class="lead">Dans le cadre de la formation Bac +2 Développeur web – Temps Plein reconversion en 1 an (+30 ans) à la Coding
        Factory, nous sommes un groupe de travail en équipe agile composé de Robin BIDOT et Godwill LAWSON. Notre projet éducatif
        consistait à créer un site de e-commerce en utilisant les technologies suivantes : HTML5, CSS3, PHP, SQL, et Bootstrap.</p>
    <p class="lead">Le projet a été officiellement commencé le mardi 16 janvier après-midi et présenté le mercredi 24 janvier après-midi dans le
        cadre de notre formation.</p>
    <p class="lead">Nous sommes actuellement à la recherche d'un stage de deux mois minimum à partir du 6 mai 2024 pour mettre en pratique nos
        compétences en développement web.</p>
</div>
<?php include('footer.php');?>