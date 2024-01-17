-- *************************** REQUETES ***********************************


-- ********** Produits **************

-- Retirer un produit de la liste :
DELETE FROM produits WHERE id = 1;

-- Selectionner des produits par tranche de prix :
SELECT * FROM produits 
WHERE prix BETWEEN 50 AND 100;

-- Sélectionner des produits d'une certaine catégorie qui se trouvent 
-- dans une tranche de prix spécifique par tri croissant:
SELECT * FROM produits 
WHERE categorie_id = [id_categorie] 
AND prix BETWEEN [prix_minimal] AND [prix_maximal]
ORDER BY prix ASC; 

-- Sélectionner des produits d'une certaine catégorie qui se trouvent 
-- dans une tranche de prix spécifique par tri décroissant:
SELECT * FROM produits 
WHERE categorie_id = [id_categorie] 
AND prix BETWEEN [prix_minimal] AND [prix_maximal]
ORDER BY prix DESC; 

-- Sélectionner tous les produits dans le panier d'un client spécifique
SELECT c.id AS ClientID, c.nom AS ClientNom, p.id AS ProduitID, p.nom AS ProduitNom, pp.quantite 
FROM clients c 
JOIN paniers pa ON c.id = pa.utilisateur_id 
JOIN paniers_produits pp ON pa.id = pp.panier_id 
JOIN produits p ON pp.produit_id = p.id 
WHERE c.id = 3;

-- Calculer le total du panier pour un client spécifique
SELECT c.id AS ClientID, c.nom AS ClientNom, SUM(p.prix * pp.quantite) AS TotalPrix
FROM clients c
JOIN paniers pa ON c.id = pa.utilisateur_id
JOIN paniers_produits pp ON pa.id = pp.panier_id
JOIN produits p ON pp.produit_id = p.id
WHERE c.id = 3
GROUP BY c.id;

-- Lister les paniers avec les informations des clients et les détails des produits
SELECT c.nom AS NomClient, pa.id AS PanierID, p.nom AS NomProduit, p.prix, pp.quantite
FROM clients c
JOIN paniers pa ON c.id = pa.utilisateur_id
JOIN paniers_produits pp ON pa.id = pp.panier_id
JOIN produits p ON pp.produit_id = p.id;

-- Lister les produits avec des promotions actives et leurs catégories
SELECT p.nom AS NomProduit, c.nom AS NomCategorie, pr.pourcentage_remise
FROM produits p
JOIN categories c ON p.categorie_id = c.id
JOIN promotions pr ON p.id = pr.produit_id
WHERE pr.date_debut <= CURRENT_TIMESTAMP AND pr.date_fin >= CURRENT_TIMESTAMP;