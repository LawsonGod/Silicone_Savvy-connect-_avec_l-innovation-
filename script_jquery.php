<script>
    $(document).ready(function() {
        $(".nav-item.dropdown").hover(function() {
            $.ajax({
                url: "get_marques.php",
                method: "POST",
                data: {categorie: 'Catégories'},
                success: function(response) {
                    $("#categorie-info").html(response);
                },
                error: function(xhr, status, error) {
                    console.error("Erreur AJAX : ", xhr, status, error);
                }
            });
        }, function() {
            $("#categorie-info").empty();
        });
    });
</script>