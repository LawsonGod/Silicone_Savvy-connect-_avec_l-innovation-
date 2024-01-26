<?php
global $dbh;
session_start();
include('connect.php');
require_once ('./inc/outils.php');
?>
<?php include('head_header_nav.php'); ?>
<div class="container mt-5">
    <h1 class="mb-4">MENTIONS LÉGALES</h1>
    <div class="row">
        <div class="col-md-6">
            <h5>Nom social et forme juridique</h5>
            <p>Silicone Savvy SAS</p>
            <h5>Adresse postale du siège</h5>
            <p>3 rue Armand Moisant – 75015 Paris France</p>
            <h5>Numéro et ville du RCS</h5>
            <p>Registre du commerce et des sociétés de Paris</p>
            <h5>Registre du commerce</h5>
            <p>999 999 999 R.C.S. Paris</p>
            <h5>Numéro de TVA intracommunautaire</h5>
            <p>FR 99999999999</p>
        </div>
        <div class="col-md-6">
            <h5>Numéro de téléphone</h5>
            <p>+33 1 99 99 99 99</p>
            <h5>Adresse courriel</h5>
            <p>silicone-savvy@exemple.fr</p>
            <h5>Direction</h5>
            <p>Godwill</p>
            <h5>Directeur de la publication</h5>
            <p>Robin</p>
            <h5>Capital Social</h5>
            <p>999.999,99 €</p>
        </div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.8183188422777!2d2.3151058762509265!3d48.84260407133003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e670339b3ecdf3%3A0x22cc6fe95f5a4dc9!2s3%20Rue%20Armand%20Moisant%2C%2075015%20Paris!5e0!3m2!1sfr!2sfr!4v1705774169217!5m2!1sfr!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>
<?php include('footer.php'); ?>