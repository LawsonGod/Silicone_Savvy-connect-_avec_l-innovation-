<?php include('head_header_nav.php');?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h2>Connexion</h2>
            <form action="connexion.php" method="post">
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </form>
            <p><a href="#" id="inscriptionLink">S'inscrire</a></p>
        </div>
        <div class="col-md-6" id="inscriptionForm" style="display:none;">
            <h2>Inscription</h2>
            <form action="inscription.php" method="post">
                <div class="form-group">
                    <label for="new_email">Adresse email</label>
                    <input type="email" class="form-control" id="new_email" name="new_email" required>
                </div>
                <div class="form-group">
                    <label for="new_password">Mot de passe</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="nom">Alias</label>
                    <input type="text" class="form-control" id="nom" name="alias" required>
                </div>
                <div class="form-group">
                    <label for="adresse">Adresse</label>
                    <input type="text" class="form-control" id="adresse" name="adresse" required>
                </div>
                <div class="form-group">
                    <label for="ville">Ville</label>
                    <input type="text" class="form-control" id="ville" name="ville" required>
                </div>
                <div class="form-group">
                    <label for="code_postal">Code Postal</label>
                    <input type="text" class="form-control" id="code_postal" name="code_postal" required>
                </div>
                <div class="form-group">
                    <label for="telephone">Téléphone</label>
                    <input type="text" class="form-control" id="telephone" name="telephone" required>
                </div>
                <button type="submit" class="btn btn-success">S'inscrire</button>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#inscriptionLink").click(function(){
            $("#inscriptionForm").show();
        });
    });
</script>
</body>
<?php include('script_jquery.php'); ?>
<?php include('footer.php');?>
</html>
