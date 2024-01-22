<?php
global $dbh;
session_start();
include('connect.php');
?>
<?php include('head_header_nav.php');?>
<div class="container">
    <h1>Écrire un avis</h1>
    <p>Partagez votre avis avec nous :</p>
    <form action="" method="post">
        <div class="form-group">
            <label for="note">Note (sur 5) :</label>
            <input type="number" class="form-control" id="note" name="note" min="1" max="5" required>
        </div>
        <div class="form-group">
            <label for="commentaire">Commentaire :</label>
            <textarea class="form-control" id="commentaire" name="commentaire" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Soumettre l'avis</button>
    </form>
</div>
<?php include('footer.php');?>