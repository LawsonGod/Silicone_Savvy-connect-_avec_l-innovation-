<?php
global $dbh;
session_start();
include('connect.php');
require_once ('./inc/outils.php');
?>
<?php include('head_header_nav.php'); ?>
<div class="container mt-5">
    <h1 class="mb-4">Questions fréquentes</h1>
    <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading1">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                    Comment passer une commande sur notre site ?
                </button>
            </h2>
            <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Pour passer une commande, suivez ces étapes :
                    <ul>
                        <li>Connectez-vous à votre compte ou créez-en un si vous n'en avez pas.</li>
                        <li>Parcourez notre catalogue de produits.</li>
                        <li>Sélectionnez les produits que vous souhaitez acheter et ajoutez-les à votre panier.</li>
                        <li>Accédez à votre panier, vérifiez les articles et procédez au paiement.</li>
                        <li>Choisissez votre mode de paiement et suivez les étapes pour finaliser la commande.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading2">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                    Quels sont les modes de paiement acceptés ?
                </button>
            </h2>
            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Nous acceptons les modes de paiement suivants :
                    <ul>
                        <li>Carte de crédit (Visa, MasterCard, etc.)</li>
                        <li>PayPal</li>
                        <li>Virement bancaire</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading3">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                    Combien de temps faut-il pour la livraison ?
                </button>
            </h2>
            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    La durée de livraison dépend de votre emplacement et du mode d'expédition que vous choisissez. Généralement, les livraisons standard prennent entre 3 et 7 jours ouvrables.
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>