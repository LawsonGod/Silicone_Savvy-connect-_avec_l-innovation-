<?php
global $dbh;
session_start();
include('connect.php');
require_once ('./inc/outils.php');
?>
<?php include('head_header_nav.php');?>
<div class="container">
    <h1>PROTECTION DES DONNÉES</h1>
    <div id="accordion">
        <div class="card">
            <div class="card-header" id="heading1">
                <h2 class="mb-0">
                    <button type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse2">
                        QUI EST RESPONSABLE DU TRAITEMENT DE VOS DONNÉES PERSONNELLES ?
                    </button>
                </h2>
            </div>
            <div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#accordion">
                <div class="card-body">
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="heading2">
                <h2 class="mb-0">
                    <button type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                        POURQUOI UTILISONS-NOUS VOS DONNÉES PERSONNELLES ET SUR QUELLE BASE LÉGALE ?
                    </button>
                </h2>
            </div>
            <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordion">
                <div class="card-body">
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="heading3">
                <h2 class="mb-0">
                    <button type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                        QUELLES SONT LES DONNÉES PERSONNELLES QUE NOUS COLLECTONS ?
                    </button>
                </h2>
            </div>
            <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordion">
                <div class="card-body">
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="heading4">
                <h2 class="mb-0">
                    <button type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                        COMBIEN DE TEMPS CONSERVONS-NOUS VOS DONNÉES PERSONNELLES ?
                    </button>
                </h2>
            </div>
            <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordion">
                <div class="card-body">
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="heading5">
                <h2 class="mb-0">
                    <button type="button" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                        AVEC QUI PARTAGEONS-NOUS VOS DONNÉES PERSONNELLES ?
                    </button>
                </h2>
            </div>
            <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordion">
                <div class="card-body">
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="heading6">
                <h2 class="mb-0">
                    <button type="button" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                        VOS DONNÉES PERSONNELLES SONT-ELLES PARTAGÉES EN DEHORS DE L’UE OU DU ROYAUME-UNI ?
                    </button>
                </h2>
            </div>
            <div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#accordion">
                <div class="card-body">
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="heading7">
                <h2 class="mb-0">
                    <button type="button" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                        QUELS SONT VOS DROITS SUR VOS DONNÉES PERSONNELLES ET COMMENT LES EXERCER ?
                    </button>
                </h2>
            </div>
            <div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordion">
                <div class="card-body">
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="heading8">
                <h2 class="mb-0">
                    <button type="button" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                        MISES À JOUR DE LA POLITIQUE
                    </button>
                </h2>
            </div>
            <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordion">
                <div class="card-body">
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="heading9">
                <h2 class="mb-0">
                    <button type="button" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                        LEXIQUE SUR LES DONNÉES PERSONNELLES
                    </button>
                </h2>
            </div>
            <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordion">
                <div class="card-body">
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.collapse').hide();
        $('.card-header').click(function() {
            var contentId = $(this).find('button').attr('data-target');
            $(contentId).slideToggle();
            $('.collapse').not(contentId).slideUp();
        });
    });
</script>
<?php include('footer.php'); ?>