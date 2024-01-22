<?php
global $dbh;
session_start();
include('connect.php');
?>
<?php include('head_header_nav.php');?>
<div class="container">
    <h1>Lire les avis</h1>
    <p>Consultez les avis de nos clients satisfaits :</p>
    <ul class="list-group">
        <li class="list-group-item">
            <h4>Avis 1</h4>
            <p>Note : 5/5</p>
            <p>Commentaire : Excellent site ! Le service client est exceptionnel, et les produits sont de grande qualité.</p>
        </li>
        <li class="list-group-item">
            <h4>Avis 2</h4>
            <p>Note : 4.5/5</p>
            <p>Commentaire : J'adore ce site. Les produits sont super, mais parfois les livraisons prennent un peu de temps.</p>
        </li>
        <li class="list-group-item">
            <h4>Avis 3</h4>
            <p>Note : 5/5</p>
            <p>Commentaire : C'est le meilleur site que j'ai jamais utilisé ! Des produits de haute qualité et une livraison rapide.</p>
        </li>
        <li class="list-group-item">
            <h4>Avis 4</h4>
            <p>Note : 4.8/5</p>
            <p>Commentaire : Très satisfait de mes achats ici. Le service client est très réactif et serviable.</p>
        </li>
        <li class="list-group-item">
            <h4>Avis 5</h4>
            <p>Note : 4.7/5</p>
            <p>Commentaire : Bonne expérience globale, mais j'aimerais voir plus de variété dans les produits proposés.</p>
        </li>
        <li class="list-group-item">
            <h4>Avis 6</h4>
            <p>Note : 4.5/5</p>
            <p>Commentaire : Je recommande ce site à tous mes amis. Les prix sont compétitifs et la navigation est facile.</p>
        </li>
        <li class="list-group-item">
            <h4>Avis 7</h4>
            <p>Note : 4.9/5</p>
            <p>Commentaire : J'ai été agréablement surpris par la qualité des produits. La livraison était également rapide et bien emballée.</p>
        </li>
        <li class="list-group-item">
            <h4>Avis 8</h4>
            <p>Note : 4.6/5</p>
            <p>Commentaire : Très bon site pour les achats en ligne. J'apprécie la facilité de navigation et les offres spéciales régulières.</p>
        </li>
        <li class="list-group-item">
            <h4>Avis 9</h4>
            <p>Note : 4.8/5</p>
            <p>Commentaire : Service client exceptionnel. Ils ont résolu rapidement un problème de livraison que j'ai rencontré.</p>
        </li>
        <li class="list-group-item">
            <h4>Avis 10</h4>
            <p>Note : 4.7/5</p>
            <p>Commentaire : Dans l'ensemble, une expérience positive. Je recommande ce site pour leurs produits de qualité.</p>
        </li>
    </ul>
</div>
</body>
<?php include('footer.php');?>
</html>