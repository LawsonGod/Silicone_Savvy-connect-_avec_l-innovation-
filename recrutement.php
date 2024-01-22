<?php
global $dbh;
session_start();
include('connect.php');
?>
<?php include('header_nav.php');?>
<div class="container">
    <h1>Recrutement</h1>
    <p>Nous sommes toujours à la recherche de personnes talentueuses pour rejoindre notre équipe. Consultez nos offres d'emploi actuelles et postulez dès aujourd'hui :</p>
    <div class="row">
        <div class="col-md-6">
            <h2>Ingénieur en Développement Web</h2>
            <p>Nous recherchons un ingénieur en développement web expérimenté pour rejoindre notre équipe. Vous serez responsable de la conception et du développement de nos projets web.</p>
            <a href="#" class="btn btn-primary">Postuler</a>
        </div>
        <div class="col-md-6">
            <h2>Spécialiste en Marketing Numérique</h2>
            <p>Nous recherchons un spécialiste en marketing numérique pour promouvoir nos produits et services en ligne. Vous serez chargé de mettre en place des campagnes de marketing efficaces.</p>
            <a href="#" class="btn btn-primary">Postuler</a>
        </div>
    </div>
</div>
</body>
<?php include('footer.php');?>
</html>