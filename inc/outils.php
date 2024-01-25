<?php
/**
 * Vérifie si l'utilisateur actuel est un administrateur en se basant sur la variable de session "user_type".
 *
 * @return bool  Retourne true si l'utilisateur est un administrateur, sinon retourne false.
 */
function estAdministrateur() {
    return isset($_SESSION["user_type"]) && $_SESSION["user_type"] === "administrateur";
}

/**
 * Vérifie si une valeur est cochée dans un tableau associé à une requête POST.
 *
 * @param mixed $valeur       La valeur à vérifier.
 * @param array $tableauPost  Le tableau associé à une requête POST dans lequel on effectue la recherche.
 *
 * @return string             Retourne 'checked' si la valeur est trouvée dans le tableau POST, sinon une chaîne vide ''.
 */
function estCochee($valeur, $tableauPost) {
    return in_array($valeur, $tableauPost) ? 'checked' : '';
}

/**
 * Récupère toutes les catégories de la base de données.
 *
 * @param PDO $dbh Le gestionnaire de connexion à la base de données.
 *                 C'est un objet PDO qui représente une connexion à la base de données.
 *
 * @return array Retourne un tableau associatif contenant les enregistrements des catégories.
 *               Chaque enregistrement contient l'identifiant (id) et le nom (nom) de la catégorie.
 */
function obtenirCategories($dbh) {
    $stmt = $dbh->query('SELECT id, nom FROM categories');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère toutes les marques de la base de données.
 *
 * @param PDO $dbh Le gestionnaire de connexion à la base de données.
 *                 C'est un objet PDO qui représente une connexion à la base de données.
 *
 * @return array Retourne un tableau associatif contenant les enregistrements des marques.
 *               Chaque enregistrement contient l'identifiant (id) et le nom (nom) de la marque.
 */
function obtenirMarques($dbh) {
    $stmt = $dbh->query('SELECT id, nom FROM marques');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Construit une requête SQL pour récupérer des produits en fonction de critères de filtrage spécifiés.
 *
 * @param array $parametres Un tableau associatif contenant les critères de filtrage pour les produits.
 *                          Ces critères peuvent inclure des éléments comme des mots clés, des filtres par marque, catégorie,
 *                          tranche de prix, tri et quantité en stock.
 *
 * @return array Retourne un tableau contenant la requête SQL construite et les paramètres associés.
 *               - 'sql' : La chaîne de la requête SQL générée.
 *               - 'parametres' : Un tableau des paramètres utilisés dans la requête préparée.
 */
function construireRequeteSQL($parametres) {
    $sql = "SELECT
        p.id,  
        p.nom AS NomProduit,
        c.nom AS NomCategorie,
        m.nom AS NomMarque,
        p.prix AS Prix,
        pr.pourcentage_remise AS PourcentageRemise,
        CASE
            WHEN pr.pourcentage_remise > 0 THEN (p.prix - (p.prix * pr.pourcentage_remise / 100))
            ELSE p.prix
        END AS PrixApresRemise,
        p.quantite_stock AS QuantiteStock,
        p.image AS Image  
    FROM produits p
    INNER JOIN categories c ON p.categorie_id = c.id
    INNER JOIN marques m ON p.marque_id = m.id
    LEFT JOIN promotions pr ON p.id = pr.produit_id";

    $conditions = [];
    $parametresRequete = [];

    if (isset($parametres['motCle']) && !empty($parametres['motCle'])) {
        $motCle = '%' . $parametres['motCle'] . '%';
        $conditions[] = "p.nom LIKE ?";
        $parametresRequete[] = $motCle;
    }

    if (!empty($parametres['filtreMarques'])) {
        $marquesPlaceholder = implode(', ', array_fill(0, count($parametres['filtreMarques']), '?'));
        $conditions[] = "p.marque_id IN ($marquesPlaceholder)";
        $parametresRequete = array_merge($parametresRequete, $parametres['filtreMarques']);
    }

    if (!empty($parametres['filtreCategories'])) {
        $categoriesPlaceholder = implode(', ', array_fill(0, count($parametres['filtreCategories']), '?'));
        $conditions[] = "p.categorie_id IN ($categoriesPlaceholder)";
        $parametresRequete = array_merge($parametresRequete, $parametres['filtreCategories']);
    }

    if (!empty($parametres['tranchePrix'])) {
        $prixRange = explode('-', $parametres['tranchePrix']);
        if (count($prixRange) == 2) {
            $conditions[] = "p.prix >= ? AND p.prix <= ?";
            $parametresRequete[] = $prixRange[0];
            $parametresRequete[] = $prixRange[1];
        } elseif ($parametres['tranchePrix'] == '1000') {
            $conditions[] = "p.prix >= 1000";
        }
    }

    if (!empty($conditions)) {
        $sql .= ' WHERE ' . implode(' AND ', $conditions);
    }

    if (isset($parametres['tri'])) {
        $orderBy = $parametres['tri'];
        $sql .= $orderBy == 'asc' ? ' ORDER BY Prix ASC' : ' ORDER BY Prix DESC';
    } else {
        $sql .= ' ORDER BY p.id ASC';
    }

    // Filtre pour la quantité en stock
    if (isset($parametres['quantiteStock'])) {
        $quantiteStock = $parametres['quantiteStock'] == 'inf' ? 10 : 11;
        $operator = $parametres['quantiteStock'] == 'inf' ? '<=' : '>=';
        $conditions[] = "p.quantite_stock $operator ?";
        $parametresRequete[] = $quantiteStock;
    }

    return [
        'sql' => $sql,
        'parametres' => $parametresRequete
    ];
}

/**
 * Récupère les produits filtrés en fonction des critères de recherche spécifiés.
 *
 * @param PDO $dbh Le gestionnaire de connexion à la base de données.
 * @param array $parametres Un tableau associatif contenant les critères de filtrage.
 *                          Ces critères peuvent inclure des éléments tels que mot clé, catégorie, marque, prix, etc.
 *
 * @return array Retourne un tableau associatif de tous les produits qui correspondent aux critères de filtrage.
 */
function obtenirProduitsFiltres($dbh, $parametres) {
    $donneesRequete = construireRequeteSQL($parametres);
    $sql = $donneesRequete['sql'];
    $parametresRequete = $donneesRequete['parametres'];

    $stmt = $dbh->prepare($sql);
    $stmt->execute($parametresRequete);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Ajoute un avis sur un produit dans la base de données.
 *
 * @param PDO $dbh Le gestionnaire de connexion à la base de données.
 * @param int $product_id L'identifiant du produit sur lequel l'avis est donné.
 * @param int $user_id L'identifiant de l'utilisateur qui donne l'avis.
 * @param int $note La note attribuée au produit, doit être entre 1 et 5.
 * @param string $commentaire Le commentaire associé à l'avis.
 *
 * @return bool Retourne true si l'avis est ajouté avec succès, false en cas d'échec.
 */
function ajouterAvis($dbh, $product_id, $user_id, $note, $commentaire) {
    // Vérification si la note est valide (entre 1 et 5)
    if ($note >= 1 && $note <= 5) {
        $sql = "INSERT INTO evaluations (produit_id, utilisateur_id, note, commentaire) VALUES (:product_id, :user_id, :note, :commentaire)";
        $stmt = $dbh->prepare($sql);

        $stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":note", $note, PDO::PARAM_INT);
        $stmt->bindParam(":commentaire", $commentaire, PDO::PARAM_STR);

        // Exécution de la requête d'insertion de l'avis
        if ($stmt->execute()) {
            return true; // Succès : avis ajouté avec succès
        } else {
            return false; // Échec : erreur lors de l'ajout de l'avis
        }
    } else {
        return false; // Échec : la note n'est pas valide
    }
}

/**
 * Vérifie la quantité de stock disponible pour un produit.
 *
 * @param PDO $dbh Le gestionnaire de connexion à la base de données.
 * @param int $product_id L'identifiant du produit pour lequel la quantité en stock est vérifiée.
 * @param int $quantiteDemandee La quantité demandée du produit.
 *
 * @return bool True si la quantité demandée est disponible en stock, false sinon.
 */
function verifierQuantiteStock($dbh, $product_id, $quantiteDemandee) {
    $stmt = $dbh->prepare("SELECT quantite_stock FROM produits WHERE id = :product_id");
    $stmt->execute([':product_id' => $product_id]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    return $produit && $produit['quantite_stock'] >= $quantiteDemandee;
}

/**
 * Ajoute ou met à jour un produit dans le panier d'un utilisateur connecté.
 *
 * @param PDO $dbh Le gestionnaire de connexion à la base de données.
 * @param int $utilisateur_id L'identifiant de l'utilisateur auquel ajouter le produit dans le panier.
 * @param int $product_id L'identifiant du produit à ajouter au panier.
 * @param int $quantite La quantité du produit à ajouter au panier.
 *
 * @return void
 */
function ajouterProduitAuPanierUtilisateur($dbh, $utilisateur_id, $product_id, $quantite) {
    if (!verifierQuantiteStock($dbh, $product_id, $quantite)) {
        $_SESSION['erreur'] = "La quantité demandée pour le produit dépasse le stock disponible.";
        return;
    }
    // Vérification si l'utilisateur a déjà un panier
    $requetePanier = $dbh->prepare('SELECT id FROM paniers WHERE utilisateur_id = :utilisateur_id');
    $requetePanier->execute([':utilisateur_id' => $utilisateur_id]);
    $panier = $requetePanier->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur n'a pas de panier, on en crée un
    if (!$panier) {
        $insertPanier = $dbh->prepare('INSERT INTO paniers (utilisateur_id) VALUES (:utilisateur_id)');
        $insertPanier->execute([':utilisateur_id' => $utilisateur_id]);
        $panier_id = $dbh->lastInsertId();
    } else {
        $panier_id = $panier['id'];
    }

    // Vérification si le produit est déjà dans le panier de l'utilisateur
    $requeteProduit = $dbh->prepare('SELECT quantite FROM paniers_produits WHERE panier_id = :panier_id AND produit_id = :produit_id');
    $requeteProduit->execute([':panier_id' => $panier_id, ':produit_id' => $product_id]);
    $produitPanier = $requeteProduit->fetch(PDO::FETCH_ASSOC);

    // Si le produit est déjà dans le panier, on met à jour la quantité
    if ($produitPanier) {
        $nouvelleQuantite = $produitPanier['quantite'] + $quantite;
        $updateProduit = $dbh->prepare('UPDATE paniers_produits SET quantite = :quantite WHERE panier_id = :panier_id AND produit_id = :produit_id');
        $updateProduit->execute([':quantite' => $nouvelleQuantite, ':panier_id' => $panier_id, ':produit_id' => $product_id]);
    } else {
        // Sinon, on ajoute le produit au panier de l'utilisateur
        $insertProduit = $dbh->prepare('INSERT INTO paniers_produits (panier_id, produit_id, quantite) VALUES (:panier_id, :produit_id, :quantite)');
        $insertProduit->execute([':panier_id' => $panier_id, ':produit_id' => $product_id, ':quantite' => $quantite]);
    }
}

/**
 * Ajoute un produit au panier d'un utilisateur non connecté (panier de session).
 *
 * @param int $product_id L'identifiant du produit à ajouter au panier de session.
 * @param int $quantite La quantité du produit à ajouter au panier de session.
 *
 * @return void
 */
function ajouterProduitAuPanierSession($product_id, $quantite) {
    global $dbh;

    if (!verifierQuantiteStock($dbh, $product_id, $quantite)) {
        $_SESSION['erreur'] = "La quantité demandée pour le produit dépasse le stock disponible.";
        return;
    }

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
    }

    // Si le produit est déjà dans le panier de session, on met à jour la quantité
    if (isset($_SESSION['panier'][$product_id])) {
        $_SESSION['panier'][$product_id]['quantite'] += $quantite;
    } else {
        // Sinon, on ajoute le produit au panier de session
        $_SESSION['panier'][$product_id] = $quantite;
    }
}

/**
 * Transfère le panier de session vers le panier de l'utilisateur après la connexion.
 *
 * @param PDO $dbh Le gestionnaire de connexion à la base de données.
 * @param int $utilisateur_id L'identifiant de l'utilisateur auquel transférer le panier de session.
 *
 * @return void
 */
function transfererPanierSessionVersUtilisateur($dbh, $utilisateur_id) {
    if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
        foreach ($_SESSION['panier'] as $product_id => $quantite) {
            ajouterProduitAuPanierUtilisateur($dbh, $utilisateur_id, $product_id, $quantite);
        }
        unset($_SESSION['panier']);  // Vider le panier de session après le transfert
    }
}

/**
 * Retire un produit du panier d'un utilisateur connecté.
 *
 * @param PDO $dbh Le gestionnaire de connexion à la base de données.
 * @param int $utilisateur_id L'identifiant de l'utilisateur à partir duquel retirer le produit du panier.
 * @param int $product_id L'identifiant du produit à retirer du panier de l'utilisateur.
 *
 * @return void
 */
function retirerProduitDuPanierUtilisateur($dbh, $utilisateur_id, $product_id) {
    $requetePanier = $dbh->prepare('SELECT id FROM paniers WHERE utilisateur_id = :utilisateur_id');
    $requetePanier->execute([':utilisateur_id' => $utilisateur_id]);
    $panier = $requetePanier->fetch(PDO::FETCH_ASSOC);

    if ($panier) {
        $panier_id = $panier['id'];
        $supprimerProduit = $dbh->prepare('DELETE FROM paniers_produits WHERE panier_id = :panier_id AND produit_id = :produit_id');
        $supprimerProduit->execute([':panier_id' => $panier_id, ':produit_id' => $product_id]);
    }
}

/**
 * Affiche un message d'erreur dans une alerte rouge.
 *
 * @param string $message Le message d'erreur à afficher.
 * @return void
 */
function afficherMessageErreur($message) {
    echo '<div class="alert alert-danger">' . htmlspecialchars($message) . '</div>';
}

/**
 * Récupère la liste des catégories depuis la base de données.
 *
 * @param PDO $dbh Le gestionnaire de connexion à la base de données.
 * @return array Un tableau associatif contenant les catégories (id, nom).
 */
function recupererCategories($dbh) {
    $stmt_cat = $dbh->query('SELECT id, nom FROM categories');
    return $stmt_cat->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère la liste des marques depuis la base de données.
 *
 * @param PDO $dbh Le gestionnaire de connexion à la base de données.
 * @return array Un tableau associatif contenant les marques (id, nom).
 */
function recupererMarques($dbh) {
    $stmt_marque = $dbh->query('SELECT id, nom FROM marques');
    return $stmt_marque->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Valide le nom d'un produit en vérifiant s'il ne contient pas de caractères spéciaux.
 *
 * @param string $nom Le nom du produit à valider.
 * @return bool True si le nom est valide, false sinon.
 */
function validerNomProduit($nom) {
    return !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $nom);
}

/**
 * Ajoute un produit à la base de données avec ses informations.
 *
 * @param PDO $dbh Le gestionnaire de connexion à la base de données.
 * @param string $nom Le nom du produit.
 * @param int $categorie_id L'identifiant de la catégorie du produit.
 * @param int $marque_id L'identifiant de la marque du produit.
 * @param float $prix Le prix du produit.
 * @param int $quantite_stock La quantité en stock du produit.
 * @param string $description La description du produit.
 * @param string $image_extension L'extension de l'image du produit.
 *
 * @return string Un message de succès ou d'erreur.
 */
function ajouterProduit($dbh, $nom, $categorie_id, $marque_id, $prix, $quantite_stock, $description, $image_extension) {
    $image_path = './assets/' . $nom . '.' . $image_extension;
    $allowed_extensions = ["avif", "png", "jpeg", "jpg"];
    $max_file_size = 3000 * 1024;

    if (!in_array($image_extension, $allowed_extensions) || $_FILES["image"]["size"] > $max_file_size) {
        return "L'extension du fichier image n'est pas valide ou le fichier est trop volumineux.";
    }

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)) {
        return "Une erreur s'est produite lors de l'enregistrement de l'image.";
    }

    $sql = "INSERT INTO produits (nom, categorie_id, marque_id, prix, quantite_stock, description, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $dbh->prepare($sql);

    if ($stmt->execute([$nom, $categorie_id, $marque_id, $prix, $quantite_stock, $description, $image_path])) {
        return "Le produit a été ajouté avec succès.";
    } else {
        return "Erreur lors de l'ajout du produit.";
    }
}

/**
 * Ajoute une promotion à un produit avec des dates de début et de fin.
 *
 * @param PDO $dbh Le gestionnaire de connexion à la base de données.
 * @param int $produit_id L'identifiant du produit auquel ajouter la promotion.
 * @param float $pourcentage_remise Le pourcentage de remise de la promotion.
 * @param string $date_debut_promo La date de début de la promotion (au format Y-m-d).
 * @param string $date_fin_promo La date de fin de la promotion (au format Y-m-d).
 *
 * @return string Un message de succès ou d'erreur.
 */
function ajouterPromotion($dbh, $produit_id, $pourcentage_remise, $date_debut_promo, $date_fin_promo) {
    $date_debut = new DateTime($date_debut_promo);
    $date_fin = new DateTime($date_fin_promo);

    // Vérifier que la date de fin est supérieure à la date de début
    if ($date_fin <= $date_debut) {
        return "La date de fin de la promotion doit être après la date de début.";
    }

    $sql = "INSERT INTO promotions (produit_id, pourcentage_remise, date_debut, date_fin) VALUES (?, ?, ?, ?)";
    $stmt = $dbh->prepare($sql);

    if ($stmt->execute([$produit_id, $pourcentage_remise, $date_debut_promo, $date_fin_promo])) {
        return "La promotion a été ajoutée avec succès.";
    } else {
        return "Erreur lors de l'ajout de la promotion.";
    }
}

/**
 * Valide que le champ "Prix" est un nombre décimal (double).
 *
 * @param float $prix Le prix à valider.
 * @return bool True si le prix est valide, false sinon.
 */
function validerPrix($prix) {
    // Utilisez is_numeric pour vérifier si la valeur est un nombre
    return is_numeric($prix);
}

/**
 * Récupère le nom de la catégorie à partir de son identifiant.
 *
 * @param PDO $dbh Le gestionnaire de connexion à la base de données.
 * @param int $cat_id L'identifiant de la catégorie.
 * @return string Le nom de la catégorie, ou une chaîne vide si la catégorie n'est pas trouvée.
 */
function getNomCategorie($dbh, $cat_id) {
    try {
        $stmtCat = $dbh->prepare("SELECT nom FROM categories WHERE id = :cat_id");
        $stmtCat->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
        $stmtCat->execute();

        if ($stmtCat->rowCount() > 0) {
            return $stmtCat->fetch(PDO::FETCH_ASSOC)['nom'];
        }
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération du nom de la catégorie : " . $e->getMessage();
    }
    return '';
}

/**
 * Récupère la liste des produits appartenant à une catégorie donnée, avec les éventuelles promotions appliquées.
 *
 * @param PDO $dbh Le gestionnaire de connexion à la base de données.
 * @param int $cat_id L'identifiant de la catégorie.
 * @return array Un tableau contenant les informations des produits de la catégorie, ou un tableau vide en cas d'erreur.
 */
function getProduitsByCategorie($dbh, $cat_id) {
    try {
        $stmt = $dbh->prepare("SELECT p.*, 
                                      pr.pourcentage_remise,
                                      CASE 
                                          WHEN pr.pourcentage_remise IS NOT NULL THEN p.prix - (p.prix * pr.pourcentage_remise / 100)
                                          ELSE p.prix
                                      END AS prix_apres_remise
                               FROM produits p
                               LEFT JOIN promotions pr ON p.id = pr.produit_id AND CURRENT_TIMESTAMP BETWEEN pr.date_debut AND pr.date_fin
                               WHERE p.categorie_id = :cat_id");
        $stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
        $stmt->execute();

        $products = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = $row;
        }

        return $products;
    } catch (PDOException $e) {
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
    }
    return array();
}

/**
 * Récupère les informations du client à partir de son identifiant.
 *
 * @param PDO $dbh Le gestionnaire de connexion à la base de données.
 * @param int $client_id L'identifiant du client.
 *
 * @return array Les informations du client sous forme de tableau associatif.
 */
function getClientInfo($dbh, $client_id) {
    try {
        $stmtClient = $dbh->prepare("SELECT * FROM clients WHERE id = :client_id");
        $stmtClient->bindParam(':client_id', $client_id, PDO::PARAM_INT);
        $stmtClient->execute();
        $clientInfo = $stmtClient->fetch(PDO::FETCH_ASSOC);
        return $clientInfo;
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des informations du client : " . $e->getMessage();
        return array();
    }
}

/**
 * Récupère les commandes passées par un client à partir de son identifiant.
 *
 * @param PDO $dbh Le gestionnaire de connexion à la base de données.
 * @param int $client_id L'identifiant du client.
 *
 * @return array Un tableau contenant les commandes du client.
 */
function getCommandesClient($dbh, $client_id) {
    try {
        $stmtCommandes = $dbh->prepare("SELECT c.*, e.methode, e.cout, e.date_livraison_estimee FROM commandes c LEFT JOIN expeditions e ON c.id = e.commande_id WHERE c.client_id = :client_id");
        $stmtCommandes->bindParam(':client_id', $client_id, PDO::PARAM_INT);
        $stmtCommandes->execute();
        $commandes = $stmtCommandes->fetchAll(PDO::FETCH_ASSOC);
        return $commandes;
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des commandes du client : " . $e->getMessage();
        return array();
    }
}

/**
 * Récupère les évaluations faites par un client à partir de son identifiant.
 *
 * @param PDO $dbh Le gestionnaire de connexion à la base de données.
 * @param int $client_id L'identifiant du client.
 *
 * @return array Un tableau contenant les évaluations faites par le client.
 */
function getEvaluationsClient($dbh, $client_id) {
    try {
        $stmtEvaluations = $dbh->prepare("SELECT e.*, p.nom AS produit_nom FROM evaluations e JOIN produits p ON e.produit_id = p.id WHERE e.utilisateur_id = :client_id");
        $stmtEvaluations->bindParam(':client_id', $client_id, PDO::PARAM_INT);
        $stmtEvaluations->execute();
        $evaluations = $stmtEvaluations->fetchAll(PDO::FETCH_ASSOC);
        return $evaluations;
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des évaluations du client : " . $e->getMessage();
        return array();
    }
}

/**
 * Fonction pour gérer l'authentification de l'utilisateur.
 *
 * Cette fonction permet d'authentifier un utilisateur en vérifiant son email et son mot de passe.
 *
 * @param PDO $dbh Le gestionnaire de connexion à la base de données.
 * @param string $email L'adresse email de l'utilisateur à authentifier.
 * @param string $password Le mot de passe de l'utilisateur à vérifier.
 * @param string $table Le nom de la table dans la base de données où rechercher l'utilisateur.
 * @param string $userType Le type de l'utilisateur ('client' ou 'administrateur').
 *
 * @return bool Retourne true si l'authentification réussit, false en cas d'échec.
 */
function login($dbh, $email, $password, $table, $userType) {
    // Préparation de la requête SQL pour récupérer l'utilisateur par son email
    $query = $dbh->prepare("SELECT * FROM $table WHERE email = :email");
    $query->execute(['email' => $email]);

    // Vérification s'il y a un résultat
    if ($query->rowCount() == 1) {
        $user = $query->fetch(PDO::FETCH_ASSOC);
        // Vérification du mot de passe en utilisant la fonction password_verify
        if (password_verify($password, $user['mot_de_passe'])) {
            // Réinitialisation de l'ID de session pour des raisons de sécurité
            session_regenerate_id();
            $_SESSION['user_type'] = $userType;
            $_SESSION['client_id'] = $user['id'];
            $_SESSION['email'] = $email;
            $_SESSION['nom'] = $user['nom'];

            // Stockage des informations spécifiques à l'utilisateur (client ou administrateur)
            if ($userType === 'client') {
                $_SESSION['alias'] = $user['alias'];
                $_SESSION['adresse'] = $user['adresse'];
                $_SESSION['ville'] = $user['ville'];
                $_SESSION['code_postal'] = $user['code_postal'];
                $_SESSION['telephone'] = $user['telephone'];
                $_SESSION['date_enregistrement'] = $user['date_enregistrement'];
            } else if ($userType === 'administrateur') {
                $_SESSION['role'] = $user['role'];
                $_SESSION['email'] = $email;
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['derniere_connexion'] = $user['derniere_connexion'];
            }

            // Redirection vers la page d'accueil après une connexion réussie
            header('Location: index.php');
            exit;
        }
    }
    // Si l'authentification échoue, la fonction retourne false
    return false;
}

/**
 * Fonction pour récupérer les informations actuelles du client depuis la base de données.
 *
 * @param PDO $dbh Connexion à la base de données.
 * @param int $client_id Identifiant du client.
 * @return array|false Tableau associatif contenant les informations du client ou false en cas d'erreur.
 */
function getClientInfoEditerClient($dbh, $client_id) {
    try {
        $stmtClient = $dbh->prepare("SELECT * FROM clients WHERE id = :client_id");
        $stmtClient->bindParam(':client_id', $client_id, PDO::PARAM_INT);
        $stmtClient->execute();
        return $stmtClient->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * Fonction pour mettre à jour les informations du client dans la base de données.
 *
 * @param PDO $dbh Connexion à la base de données.
 * @param int $client_id Identifiant du client.
 * @param array $data Tableau contenant les nouvelles informations du client.
 * @return bool True en cas de succès, false en cas d'erreur.
 */
function miseAJourClientInfo($dbh, $client_id, $data) {
    try {
        $stmtUpdate = $dbh->prepare("UPDATE clients SET
            nom = :nom,
            alias = :alias,
            email = :email,
            adresse = :adresse,
            ville = :ville,
            code_postal = :code_postal,
            telephone = :telephone,
            mot_de_passe = :mot_de_passe
            WHERE id = :client_id");

        $stmtUpdate->bindParam(':nom', $data['nom'], PDO::PARAM_STR);
        $stmtUpdate->bindParam(':alias', $data['alias'], PDO::PARAM_STR);
        $stmtUpdate->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmtUpdate->bindParam(':adresse', $data['adresse'], PDO::PARAM_STR);
        $stmtUpdate->bindParam(':ville', $data['ville'], PDO::PARAM_STR);
        $stmtUpdate->bindParam(':code_postal', $data['code_postal'], PDO::PARAM_STR);
        $stmtUpdate->bindParam(':telephone', $data['telephone'], PDO::PARAM_STR);
        $stmtUpdate->bindParam(':mot_de_passe', $data['mot_de_passe'], PDO::PARAM_STR);
        $stmtUpdate->bindParam(':client_id', $client_id, PDO::PARAM_INT);

        return $stmtUpdate->execute();
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * Fonction pour récupérer les informations d'un commentaire depuis la base de données.
 *
 * @param PDO $dbh Connexion à la base de données.
 * @param int $commentaireId Identifiant du commentaire.
 * @return array|null Tableau associatif contenant les informations du commentaire ou null si non trouvé.
 */
function getCommentaireInfo($dbh, $commentaireId) {
    try {
        // Récupération des informations du commentaire depuis la base de données
        if ($commentaireId) {
            $stmtCommentaire = $dbh->prepare("SELECT e.*, p.nom AS produit_nom, p.image AS produit_image FROM evaluations e JOIN produits p ON e.produit_id = p.id WHERE e.id = :id");
            $stmtCommentaire->bindParam(':id', $commentaireId, PDO::PARAM_INT);
            $stmtCommentaire->execute();
            return $stmtCommentaire->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    } catch (PDOException $e) {
        echo "Erreur de base de données : " . $e->getMessage();
        return null;
    }
}

/**
 * Fonction pour mettre à jour un commentaire dans la base de données.
 *
 * @param PDO $dbh Connexion à la base de données.
 * @param int $commentaireId Identifiant du commentaire à mettre à jour.
 * @param string $nouveauCommentaire Le nouveau commentaire.
 * @param int $nouvelleNote La nouvelle note.
 * @return bool True en cas de succès, false en cas d'erreur.
 */
function miseAJourDuCommentaire($dbh, $commentaireId, $nouveauCommentaire, $nouvelleNote) {
    try {
        // Exécuter la requête de mise à jour du commentaire dans la base de données
        $stmt = $dbh->prepare("UPDATE evaluations SET commentaire = :commentaire, note = :note WHERE id = :id");
        $stmt->bindParam(':commentaire', $nouveauCommentaire, PDO::PARAM_STR);
        $stmt->bindParam(':note', $nouvelleNote, PDO::PARAM_INT);
        $stmt->bindParam(':id', $commentaireId, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Erreur de base de données : " . $e->getMessage();
        return false;
    }
}

/**
 * Fonction pour valider la quantité en stock (nombre entier).
 *
 * @param int $quantite_stock Quantité en stock à valider.
 * @return bool True si la quantité est valide, false sinon.
 */
function validerQuantiteStock($quantite_stock) {
    return filter_var($quantite_stock, FILTER_VALIDATE_INT) !== false;
}

/**
 * Fonction pour valider le pourcentage de remise (entre 5 et 60).
 *
 * @param int $pourcentage_remise Pourcentage de remise à valider.
 * @return bool True si le pourcentage est valide, false sinon.
 */
function validerPourcentageRemise($pourcentage_remise) {
    return $pourcentage_remise >= 5 && $pourcentage_remise <= 60;
}

/**
 * Fonction pour gérer la mise à jour du produit.
 *
 * @param PDO $dbh Connexion à la base de données.
 * @param int $id Identifiant du produit à mettre à jour.
 * @param string $nom Nouveau nom du produit.
 * @param int $categorie_id Identifiant de la catégorie du produit.
 * @param int $marque_id Identifiant de la marque du produit.
 * @param float $prix Nouveau prix du produit.
 * @param int $quantite_stock Nouvelle quantité en stock.
 * @param string $description Nouvelle description du produit.
 * @return string Message de succès ou d'erreur.
 */
function editerProduit($dbh, $id, $nom, $categorie_id, $marque_id, $prix, $quantite_stock, $description) {
    $sql = "UPDATE produits SET nom = ?, categorie_id = ?, marque_id = ?, prix = ?, quantite_stock = ?, description = ? WHERE id = ?";
    $stmt = $dbh->prepare($sql);

    if ($stmt->execute([$nom, $categorie_id, $marque_id, $prix, $quantite_stock, $description, $id])) {
        return "Le produit a été mis à jour avec succès.";
    } else {
        return "Erreur lors de la mise à jour du produit.";
    }
}

/**
 * Fonction pour récupérer les détails du produit à éditer.
 *
 * @param PDO $dbh Connexion à la base de données.
 * @param int $id Identifiant du produit à récupérer.
 * @return array|null Tableau associatif contenant les détails du produit ou null si non trouvé.
 */
function recupererDetailsProduit($dbh, $id) {
    $sql = "SELECT * FROM produits WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Fonction pour ajouter ou mettre à jour la promotion du produit.
 *
 * @param PDO $dbh Connexion à la base de données.
 * @param int $id_produit Identifiant du produit.
 * @param int $pourcentage_remise Pourcentage de remise.
 * @param string $date_debut_promo Date de début de la promotion (format 'Y-m-d').
 * @param string $date_fin_promo Date de fin de la promotion (format 'Y-m-d').
 */
function gererPromotion($dbh, $id_produit, $pourcentage_remise, $date_debut_promo, $date_fin_promo) {
    // Vérifier si une promotion existe déjà pour ce produit
    $sql_check_promo = "SELECT id FROM promotions WHERE produit_id = ?";
    $stmt_check_promo = $dbh->prepare($sql_check_promo);
    $stmt_check_promo->execute([$id_produit]);
    $existing_promo = $stmt_check_promo->fetch(PDO::FETCH_ASSOC);

    if ($existing_promo) {
        // Mettre à jour la promotion existante
        $sql_update_promo = "UPDATE promotions SET pourcentage_remise = ?, date_debut = ?, date_fin = ? WHERE produit_id = ?";
        $stmt_update_promo = $dbh->prepare($sql_update_promo);
        $stmt_update_promo->execute([$pourcentage_remise, $date_debut_promo, $date_fin_promo, $id_produit]);
    } else {
        // Insérer une nouvelle promotion
        $sql_insert_promo = "INSERT INTO promotions (produit_id, pourcentage_remise, date_debut, date_fin) VALUES (?, ?, ?, ?)";
        $stmt_insert_promo = $dbh->prepare($sql_insert_promo);
        $stmt_insert_promo->execute([$id_produit, $pourcentage_remise, $date_debut_promo, $date_fin_promo]);
    }
}

/**
 * Fonction pour convertir le format de date du formulaire au format de la base de données.
 *
 * @param string $date Date au format 'd/m/Y'.
 * @return string|false Date au format 'Y-m-d' ou false en cas d'erreur.
 */
function convertirFormatDateInverse($date) {
    $elementsDate = explode('/', $date);

    if (count($elementsDate) !== 3) {
        return false;
    }

    $nouveauFormat = $elementsDate[2] . '-' . $elementsDate[1] . '-' . $elementsDate[0] . ' 00:00:00';

    return $nouveauFormat;
}

/**
 * Fonction pour convertir le format de date de la base de données au format du formulaire.
 *
 * @param string $date Date au format 'Y-m-d'.
 * @return string Date au format 'd/m/Y'.
 */
function convertirFormatDate($date) {
    $timestamp = strtotime($date);
    $nouveauFormat = date('d/m/Y', $timestamp);
    return $nouveauFormat;
}

/**
 * Récupère les marques associées à une catégorie donnée.
 *
 * @param PDO $dbh L'objet PDO représentant la connexion à la base de données.
 * @param string $categorie Le nom de la catégorie pour laquelle les marques doivent être récupérées.
 *
 * @return array Un tableau contenant les noms des marques associées à la catégorie, ou un tableau vide en cas d'erreur.
 */
function getMarquesByCategorie($dbh, $categorie) {
    try {
        $stmt = $dbh->prepare(
            "SELECT DISTINCT marques.nom FROM marques 
             JOIN produits ON marques.id = produits.marque_id 
             JOIN categories ON produits.categorie_id = categories.id 
             WHERE categories.nom = :categorie"
        );
        $stmt->bindParam(':categorie', $categorie, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        return [];
    }
}

/**
 * Insère un nouveau client dans la base de données.
 *
 * @param PDO $dbh Connexion à la base de données.
 * @param string $new_email Adresse email du nouveau client.
 * @param string $new_password Mot de passe du nouveau client.
 * @param string $nom Nom du nouveau client.
 * @param string $adresse Adresse du nouveau client.
 * @param string $ville Ville du nouveau client.
 * @param string $code_postal Code postal du nouveau client.
 * @param string $telephone Numéro de téléphone du nouveau client.
 *
 * @return bool Retourne true si l'inscription est réussie, false si l'adresse email est déjà utilisée ou s'il y a une erreur.
 */
function inscrireClient($dbh, $new_email, $new_password, $nom, $adresse, $ville, $code_postal, $telephone) {
    try {
        // Vérifier si l'adresse email est déjà utilisée
        $query = $dbh->prepare("SELECT * FROM clients WHERE email = :email");
        $query->execute(['email' => $new_email]);

        if ($query->rowCount() == 0) {
            // Insérer le nouveau client dans la base de données
            $insertQuery = $dbh->prepare("INSERT INTO clients (nom, email, adresse, ville, code_postal, telephone, mot_de_passe) VALUES (:nom, :email, :adresse, :ville, :code_postal, :telephone, :mot_de_passe)");
            $insertQuery->execute([
                'nom' => $nom,
                'email' => $new_email,
                'adresse' => $adresse,
                'ville' => $ville,
                'code_postal' => $code_postal,
                'telephone' => $telephone,
                'mot_de_passe' => $new_password
            ]);

            return true; // L'inscription est réussie.
        } else {
            return false; // L'adresse email est déjà utilisée par un autre utilisateur
        }
    } catch (PDOException $e) {
        echo "Erreur lors de l'inscription : " . $e->getMessage();
        return false; // Une erreur s'est produite lors de l'inscription
    }
}

/**
 * Récupère le nom de la marque à partir de son identifiant.
 *
 * @param PDO $dbh - L'instance de la base de données
 * @param int $marque_id - L'identifiant de la marque
 * @return string - Le nom de la marque
 */
function getMarqueNom($dbh, $marque_id) {
    try {
        $stmtMarque = $dbh->prepare("SELECT nom FROM marques WHERE id = :marque_id");
        $stmtMarque->bindParam(':marque_id', $marque_id, PDO::PARAM_INT);
        $stmtMarque->execute();

        if ($stmtMarque->rowCount() > 0) {
            return $stmtMarque->fetch(PDO::FETCH_ASSOC)['nom'];
        }
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération du nom de la marque : " . $e->getMessage();
    }
    return '';
}

/**
 * Récupère et affiche les produits d'une marque avec éventuelle remise.
 *
 * @param PDO $dbh - L'instance de la base de données
 * @param int $marque_id - L'identifiant de la marque
 */
function afficherProduitsMarque($dbh, $marque_id) {
    try {
        $stmt = $dbh->prepare("
            SELECT p.*, 
                   pr.pourcentage_remise,
                   CASE 
                       WHEN pr.pourcentage_remise IS NOT NULL THEN p.prix - (p.prix * pr.pourcentage_remise / 100)
                       ELSE p.prix
                   END AS prix_apres_remise
            FROM produits p
            LEFT JOIN promotions pr ON p.id = pr.produit_id AND CURRENT_TIMESTAMP BETWEEN pr.date_debut AND pr.date_fin
            WHERE p.marque_id = :marque_id
        ");
        $stmt->bindParam(':marque_id', $marque_id, PDO::PARAM_INT);
        $stmt->execute();

        $products = '';

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products .= '<div class="col-md-4 mb-4">';
            $products .= '<div class="card">';
            $products .= '<img class="card-img-top" src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['nom']) . '">';
            $products .= '<div class="card-body">';
            $products .= '<h5 class="card-title">' . htmlspecialchars($row['nom']) . '</h5>';
            $products .= '<a href="produit.php?id=' . $row['id'] . '">Voir la fiche du produit</a>';

            if (isset($row['pourcentage_remise']) && $row['pourcentage_remise'] > 0) {
                $nouveauPrix = $row['prix'] - ($row['prix'] * $row['pourcentage_remise'] / 100);
                $nouveauPrix = number_format($nouveauPrix, 2); // Arrondir à 2 décimales

                $products .= '<p class="card-text">Ancien Prix: <del>' . htmlspecialchars($row['prix']) . ' €</del></p>';
                $products .= '<p class="card-text text-danger">Remise: ' . htmlspecialchars($row['pourcentage_remise']) . '%</p>';
                $products .= '<p class="card-text text-danger">Nouveau Prix: ' . $nouveauPrix . ' €</p>';
            } else {
                $products .= '<p class="card-text">Prix: ' . htmlspecialchars($row['prix']) . ' €</p>';
            }

            $products .= '<p class="card-text" style="text-align: justify;">' . htmlspecialchars($row['description']) . '</p>';
            $products .= '</div>';
            $products .= '</div>';
            $products .= '</div>';
        }

        echo $products;
    } catch (PDOException $e) {
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
    }
}

/**
 * Calcule le total du panier.
 *
 * @param PDO $dbh - L'instance de la base de données
 * @return float - Le total du panier
 */
function calculerTotal($dbh) {
    $total = 0;
    if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
        foreach ($_SESSION['panier'] as $product_id => $quantite) {
            $stmt = $dbh->prepare("SELECT prix FROM produits WHERE id = :product_id");
            $stmt->execute([':product_id' => $product_id]);
            $produit = $stmt->fetch(PDO::FETCH_ASSOC);
            $total += $produit['prix'] * $quantite;
        }
    }
    return $total;
}

/**
 * Supprime un produit du panier.
 *
 * @param PDO $dbh - L'instance de la base de données
 */
function supprimerProduitDuPanier($dbh) {
    if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['id'])) {
        $product_id = $_GET['id'];
        unset($_SESSION['panier'][$product_id]);
    }
}

/**
 * Affiche le contenu du panier.
 *
 * @param PDO $dbh - L'instance de la base de données
 */
function afficherContenuDuPanier($dbh) {
    $contenuPanier = '';
    if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
        foreach ($_SESSION['panier'] as $product_id => $quantite) {
            $stmt = $dbh->prepare("SELECT nom, prix FROM produits WHERE id = :product_id");
            $stmt->execute([':product_id' => $product_id]);
            $produit = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalProduit = $produit['prix'] * $quantite;

            $contenuPanier .= "<tr>
                                <td>" . htmlspecialchars($produit['nom']) . "</td>
                                <td>" . htmlspecialchars($produit['prix']) . "</td>
                                <td>" . htmlspecialchars($quantite) . "</td>
                                <td>" . htmlspecialchars($totalProduit) . "</td>
                                <td><a href='panier.php?action=remove&id=$product_id' class='btn btn-danger'>Supprimer</a></td>
                             </tr>";
        }
        $contenuPanier .= "<tr>
                            <td colspan='3'><strong>Total</strong></td>
                            <td><strong>" . calculerTotal($dbh) . "</strong></td>
                            <td></td>
                         </tr>";
    } else {
        $contenuPanier = "<tr><td colspan='5'>Votre panier est vide.</td></tr>";
    }

    echo $contenuPanier;
}

/**
 * Affiche le contenu de la page du panier.
 */
function afficherPagePanier() {
    global $dbh;
    include('head_header_nav.php');

    if (isset($_SESSION['erreur'])) {
        echo "<p class='alert alert-danger'>" . $_SESSION['erreur'] . "</p>";
        unset($_SESSION['erreur']);
    }

    echo "<div class='container'>";
    echo "<h1 class='my-4'>Votre Panier</h1>";
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Produit</th>";
    echo "<th>Prix</th>";
    echo "<th>Quantité</th>";
    echo "<th>Total</th>";
    echo "<th>Action</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    afficherContenuDuPanier($dbh);
    echo "</tbody>";
    echo "</table>";

    if (!empty($_SESSION['panier'])) {
        echo "<div>";
        if (isset($_SESSION['email'])) {
            echo "<a href='expedition.php' class='btn btn-success'>Confirmer la Commande</a>";
        } else {
            echo "<a href='connexion_inscription.php' class='btn btn-success'>Connectez-vous pour continuer</a>";
        }
        echo "<a href='index.php' class='btn btn-primary'>Retour à la page d'accueil</a>";
        echo "</div>";
    } else {
        echo "<p>Votre panier est vide. <a href='index.php' class='btn btn-primary'>Retour à la page d'accueil</a></p>";
    }

    echo "</div>";
    include('script_jquery.php');
    include('footer.php');
}

/**
 * Fonction pour récupérer les informations d'un produit par son ID.
 *
 * @param PDO $dbh Connexion à la base de données
 * @param int $product_id ID du produit à récupérer
 * @return array|null Les informations du produit ou null s'il n'existe pas
 */
function obtenirInformationsProduit(PDO $dbh, $product_id) {
    $sql = 'SELECT produits.image, produits.nom, produits.prix, produits.description, 
                   marques.nom AS nom_marque, categories.nom AS nom_categorie 
            FROM produits 
            INNER JOIN marques ON produits.marque_id = marques.id 
            INNER JOIN categories ON produits.categorie_id = categories.id 
            WHERE produits.id = :product_id';

    $stmt = $dbh->prepare($sql);
    $stmt->execute([':product_id' => $product_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Fonction pour récupérer la note moyenne d'un produit à partir de ses évaluations.
 *
 * @param PDO $dbh Connexion à la base de données
 * @param int $product_id ID du produit
 * @return float La note moyenne ou 0 si aucune évaluation n'existe
 */
function obtenirNoteMoyenneProduit(PDO $dbh, $product_id) {
    $sqlNote = 'SELECT COALESCE(AVG(note), 0) AS note_moyenne FROM evaluations WHERE produit_id = :product_id';
    $stmtNote = $dbh->prepare($sqlNote);
    $stmtNote->execute([':product_id' => $product_id]);
    return $stmtNote->fetch(PDO::FETCH_ASSOC)['note_moyenne'];
}

/**
 * Fonction pour récupérer les évaluations d'un produit.
 *
 * @param PDO $dbh Connexion à la base de données
 * @param int $product_id ID du produit
 * @return array Les évaluations du produit ou un tableau vide s'il n'y en a pas
 */
function obtenirEvaluationsProduit(PDO $dbh, $product_id) {
    $sqlEvaluations = 'SELECT clients.alias, evaluations.note, evaluations.commentaire, evaluations.date_publication 
                       FROM evaluations 
                       INNER JOIN clients ON evaluations.utilisateur_id = clients.id 
                       WHERE evaluations.produit_id = :product_id';
    $stmtEvaluations = $dbh->prepare($sqlEvaluations);
    $stmtEvaluations->execute([':product_id' => $product_id]);
    return $stmtEvaluations->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les produits en promotion avec leur nouveau prix.
 *
 * @param PDO $dbh Connexion à la base de données
 * @return string HTML représentant les produits en promotion
 */
function obtenirProduitsEnPromotion(PDO $dbh): string {
    try {
        $stmt = $dbh->prepare("
            SELECT p.*, 
                   pr.pourcentage_remise,
                   p.prix - (p.prix * pr.pourcentage_remise / 100) AS prix_apres_remise
            FROM produits p
            JOIN promotions pr ON p.id = pr.produit_id
            WHERE CURRENT_TIMESTAMP BETWEEN pr.date_debut AND pr.date_fin
        ");
        $stmt->execute();
        $products = '';

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products .= '<div class="col-md-4 mb-4">';
            $products .= '<div class="card">';
            $products .= '<img class="card-img-top" src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['nom']) . '">';
            $products .= '<div class="card-body">';
            $products .= '<h5 class="card-title">' . htmlspecialchars($row['nom']) . '</h5>';
            $products .= '<a href="produit.php?id=' . $row['id'] . '">Voir la fiche du produit</a>';
            $nouveauPrix = number_format($row['prix_apres_remise'], 2);
            $products .= '<p class="card-text">Ancien Prix: <del>' . htmlspecialchars($row['prix']) . ' €</del></p>';
            $products .= '<p class="card-text text-danger">Remise: ' . htmlspecialchars($row['pourcentage_remise']) . '%</p>';
            $products .= '<p class="card-text text-danger">Nouveau Prix: ' . $nouveauPrix . ' €</p>';
            $products .= '<p class="card-text" style="text-align: justify;">' . htmlspecialchars($row['description']) . '</p>';
            $products .= '</div>';
            $products .= '</div>';
            $products .= '</div>';
        }

        return $products;
    } catch (PDOException $e) {
        return "Erreur lors de l'exécution de la requête : " . $e->getMessage();
    }
}

/**
 * Supprime les produits du panier d'un client.
 *
 * Cette fonction supprime tous les produits du panier d'un client spécifié.
 *
 * @param int $clientId - L'identifiant du client dont les produits du panier doivent être supprimés.
 * @param PDO $dbh - L'instance de la base de données.
 */
function supprimerProduitsPanier($clientId, $dbh) {
    $stmt = $dbh->prepare("DELETE pp FROM paniers_produits pp
                           INNER JOIN paniers p ON pp.panier_id = p.id
                           WHERE p.utilisateur_id = :client_id");
    $stmt->bindParam(':client_id', $clientId, PDO::PARAM_INT);
    $stmt->execute();
}

/**
 * Supprime le panier d'un client.
 *
 * Cette fonction supprime le panier complet d'un client spécifié.
 *
 * @param int $clientId - L'identifiant du client dont le panier doit être supprimé.
 * @param PDO $dbh - L'instance de la base de données.
 */
function supprimerPanier($clientId, $dbh) {
    $stmt = $dbh->prepare("DELETE FROM paniers WHERE utilisateur_id = :client_id");
    $stmt->bindParam(':client_id', $clientId, PDO::PARAM_INT);
    $stmt->execute();
}

/**
 * Supprime les évaluations d'un client.
 *
 * Cette fonction supprime toutes les évaluations d'un client spécifié.
 *
 * @param int $clientId - L'identifiant du client dont les évaluations doivent être supprimées.
 * @param PDO $dbh - L'instance de la base de données.
 */
function supprimerEvaluations($clientId, $dbh) {
    $stmt = $dbh->prepare("DELETE FROM evaluations WHERE utilisateur_id = :client_id");
    $stmt->bindParam(':client_id', $clientId, PDO::PARAM_INT);
    $stmt->execute();
}

/**
 * Supprime les expéditions liées aux commandes d'un client.
 *
 * Cette fonction supprime toutes les expéditions liées aux commandes d'un client spécifié.
 *
 * @param int $clientId - L'identifiant du client dont les expéditions liées aux commandes doivent être supprimées.
 * @param PDO $dbh - L'instance de la base de données.
 */
function supprimerExpeditions($clientId, $dbh) {
    $stmt = $dbh->prepare("DELETE e FROM expeditions e
                           INNER JOIN commandes c ON e.commande_id = c.id
                           WHERE c.client_id = :client_id");
    $stmt->bindParam(':client_id', $clientId, PDO::PARAM_INT);
    $stmt->execute();
}

/**
 * Supprime les commandes d'un client.
 *
 * Cette fonction supprime toutes les commandes d'un client spécifié.
 *
 * @param int $clientId - L'identifiant du client dont les commandes doivent être supprimées.
 * @param PDO $dbh - L'instance de la base de données.
 */
function supprimerCommandes($clientId, $dbh) {
    $stmt = $dbh->prepare("DELETE FROM commandes WHERE client_id = :client_id");
    $stmt->bindParam(':client_id', $clientId, PDO::PARAM_INT);
    $stmt->execute();
}

/**
 * Supprime un client.
 *
 * Cette fonction supprime un client spécifié de la base de données.
 *
 * @param int $clientId - L'identifiant du client à supprimer.
 * @param PDO $dbh - L'instance de la base de données.
 */
function supprimerClient($clientId, $dbh) {
    $stmt = $dbh->prepare("DELETE FROM clients WHERE id = :client_id");
    $stmt->bindParam(':client_id', $clientId, PDO::PARAM_INT);
    $stmt->execute();
}

/**
 * Obtient les informations d'un commentaire par son identifiant.
 *
 * Cette fonction récupère les informations détaillées d'un commentaire spécifié en utilisant son identifiant.
 *
 * @param PDO $dbh - L'instance de la base de données.
 * @param int $commentaireId - L'identifiant du commentaire à récupérer.
 * @return array|false - Un tableau associatif contenant les informations du commentaire ou false si le commentaire n'est pas trouvé.
 */
function obtenirCommentaireParId($dbh, $commentaireId) {
    $stmtCommentaire = $dbh->prepare("SELECT e.*, p.nom AS produit_nom 
    FROM evaluations e
    JOIN produits p ON e.produit_id = p.id
    WHERE e.id = :id");

    $stmtCommentaire->bindParam(':id', $commentaireId, PDO::PARAM_INT);
    $stmtCommentaire->execute();
    return $stmtCommentaire->fetch(PDO::FETCH_ASSOC);
}

/**
 * Supprime toutes les évaluations associées à un produit spécifié.
 *
 * Cette fonction supprime toutes les évaluations (commentaires et notes) liées à un produit donné.
 *
 * @param PDO $dbh - L'instance de la base de données.
 * @param int $productId - L'identifiant du produit pour lequel les évaluations doivent être supprimées.
 * @return void
 */
function supprimerEvaluationsProduit($dbh, $productId) {
    $sqlDeleteEvaluations = "DELETE FROM evaluations WHERE produit_id = :productId";
    $stmt = $dbh->prepare($sqlDeleteEvaluations);
    $stmt->bindParam(":productId", $productId, PDO::PARAM_INT);
    $stmt->execute();
}

/**
 * Supprime toutes les promotions associées à un produit spécifié.
 *
 * Cette fonction supprime toutes les promotions (remises) associées à un produit donné.
 *
 * @param PDO $dbh - L'instance de la base de données.
 * @param int $productId - L'identifiant du produit pour lequel les promotions doivent être supprimées.
 * @return void
 */
function supprimerPromotionProduit($dbh, $productId) {
    $sqlDeletePromotion = "DELETE FROM promotions WHERE produit_id = :productId";
    $stmt = $dbh->prepare($sqlDeletePromotion);
    $stmt->bindParam(":productId", $productId, PDO::PARAM_INT);
    $stmt->execute();
}

/**
 * Supprime un produit de la base de données.
 *
 * Cette fonction supprime un produit spécifié de la base de données.
 *
 * @param PDO $dbh - L'instance de la base de données.
 * @param int $productId - L'identifiant du produit à supprimer.
 * @return void
 */
function supprimerProduit($dbh, $productId) {
    $sqlDeleteProduct = "DELETE FROM produits WHERE id = :productId";
    $stmt = $dbh->prepare($sqlDeleteProduct);
    $stmt->bindParam(":productId", $productId, PDO::PARAM_INT);
    $stmt->execute();
}
?>