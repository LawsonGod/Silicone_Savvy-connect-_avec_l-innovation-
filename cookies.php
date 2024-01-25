<?php
global $dbh;
session_start();
include('connect.php');
require_once ('./inc/outils.php');
?>
<?php include('head_header_nav.php'); ?>
<div class="container-fluid mt-5">
    <h1 class="text-center">Exprimez vos choix</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-body">
                    <h3>Cookies et outils fonctionnels</h3>
                    <p class="text-justify">Ces cookies et outils fonctionnels sont indispensables à la navigation sur le site et au respect de vos préférences en matière de confidentialité pour les cookies non nécessaires au fonctionnement du site. Ils ne peuvent donc pas être désactivés.</p>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-body">
                    <h3>Cookies de personnalisation</h3>
                    <p class="text-justify">Acceptez-vous le dépôt et la lecture de cookies afin que Silicone Savvy et nos partenaires personnalisent votre expérience ? Si vous choisissez « oui », vous choisissez une qualité de navigation optimale, rendant votre expérience plus agréable et adaptée à votre dispositif.</p>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-body">
                    <h3>Cookies analytiques</h3>
                    <p class="text-justify">Acceptez-vous le dépôt et la lecture de cookies afin d’analyser votre navigation et nous permettre avec nos partenaires de mesurer l’audience de notre site ? NB : Certains cookies de mesures d’audience ne nécessitent pas de consentement et ne peuvent donc pas être désactivés.</p>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-body">
                    <h3>Cookies publicitaires</h3>
                    <p class="text-justify">Acceptez-vous le dépôt et la lecture de cookies afin d’analyser vos centres d’intérêts pour vous proposer avec nos partenaires des publicités personnalisées ? Si vous choisissez « oui », vous recevrez des publicités adaptées à vos centres d’intérêts.</p>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Valider mes choix</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Sélectionnez le bouton "Valider mes choix" par son ID ou sa classe CSS
        var boutonValider = document.querySelector(".btn-primary");

        // Ajoutez un gestionnaire d'événement au clic sur le bouton
        boutonValider.addEventListener("click", function () {
            // Affichez la popup avec le message
            alert("Votre demande est bien prise en compte. Bonne navigation sur notre site.");
        });
    });
</script>
<?php include('footer.php'); ?>