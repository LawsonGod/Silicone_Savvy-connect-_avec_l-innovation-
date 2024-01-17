DROP DATABASE IF EXISTS projetphp;

CREATE DATABASE projetphp
    DEFAULT CHARACTER SET utf8mb4;

CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) UNIQUE NOT NULL
) ENGINE InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO categories (nom) VALUES
('PC'),
('Smartphone'),
('Tablette'),
('Imprimante'),
('Clavier'),
('Écran');


CREATE TABLE marques (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) UNIQUE NOT NULL
) ENGINE InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO marques (nom) VALUES
('Dell'),
('Apple'),
('HP'),
('Asus'),
('Lenovo'),
('Samsung'),
('Philips'),
('Google'),
('Huawei'),
('Honor'),
('Xiaomi'),
('Acer'),
('Canon'),
('Logitech');

CREATE TABLE clients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    adresse TEXT NOT NULL,
    ville VARCHAR(255) NOT NULL,  
    code_postal VARCHAR(5) NOT NULL,   
    telephone VARCHAR(20) NOT NULL,
    date_enregistrement DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    mot_de_passe VARCHAR(255) NOT NULL
) ENGINE InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO clients (nom, email, adresse, ville, code_postal, telephone, date_enregistrement, mot_de_passe) VALUES
('Client1', 'client1@exemple.fr', 'adresse1', 'ville1', '01000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client1'),
('Client2', 'client2@exemple.fr', 'adresse2', 'ville2', '02000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client2'),
('Client3', 'client3@exemple.fr', 'adresse3', 'ville3', '03000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client3'),
('Client4', 'client4@exemple.fr', 'adresse4', 'ville4', '04000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client4'),
('Client5', 'client5@exemple.fr', 'adresse5', 'ville5', '05000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client5'),
('Client6', 'client6@exemple.fr', 'adresse6', 'ville6', '06000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client6'),
('Client7', 'client7@exemple.fr', 'adresse7', 'ville7', '07000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client7'),
('Client8', 'client8@exemple.fr', 'adresse8', 'ville8', '08000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client8'),
('Client9', 'client9@exemple.fr', 'adresse9', 'ville9', '09000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client9'),
('Client10', 'client10@exemple.fr', 'adresse10', 'ville10', '10000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client10'),
('Client11', 'client11@exemple.fr', 'adresse11', 'ville11', '11000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client11'),
('Client12', 'client12@exemple.fr', 'adresse12', 'ville12', '12000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client12'),
('Client13', 'client13@exemple.fr', 'adresse13', 'ville13', '13000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client13'),
('Client14', 'client14@exemple.fr', 'adresse14', 'ville14', '14000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client14'),
('Client15', 'client15@exemple.fr', 'adresse15', 'ville15', '15000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client15'),
('Client16', 'client16@exemple.fr', 'adresse16', 'ville16', '16000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client16'),
('Client17', 'client17@exemple.fr', 'adresse17', 'ville17', '17000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client17'),
('Client18', 'client18@exemple.fr', 'adresse18', 'ville18', '18000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client18'),
('Client19', 'client19@exemple.fr', 'adresse19', 'ville19', '19000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client19'),
('Client20', 'client20@exemple.fr', 'adresse20', 'ville20', '20000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client20'),
('Client21', 'client21@exemple.fr', 'adresse21', 'ville21', '21000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client21'),
('Client22', 'client22@exemple.fr', 'adresse22', 'ville22', '22000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client22'),
('Client23', 'client23@exemple.fr', 'adresse23', 'ville23', '23000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client23'),
('Client24', 'client24@exemple.fr', 'adresse24', 'ville24', '24000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client24'),
('Client25', 'client25@exemple.fr', 'adresse25', 'ville25', '25000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client25'),
('Client26', 'client26@exemple.fr', 'adresse26', 'ville26', '26000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client26'),
('Client27', 'client27@exemple.fr', 'adresse27', 'ville27', '27000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client27'),
('Client28', 'client28@exemple.fr', 'adresse28', 'ville28', '28000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client28'),
('Client29', 'client29@exemple.fr', 'adresse29', 'ville28', '29000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client29'),
('Client30', 'client30@exemple.fr', 'adresse30', 'ville29', '30000', '0606060606', 
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'client30');



CREATE TABLE produits (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) UNIQUE NOT NULL,
    categorie_id INT NOT NULL,
    marque_id INT NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    quantite_stock INT NOT NULL DEFAULT 0,
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,  
    FOREIGN KEY (categorie_id) REFERENCES categories(id),
    FOREIGN KEY (marque_id) REFERENCES marques(id)
) ENGINE InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO produits (nom, categorie_id, marque_id, prix, quantite_stock, description, image) VALUES
('Produit1', '1', '1', '599.99', '50', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/pc.avif'),
('Produit2', '1', '1', '699.99', '35', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/pc.avif'),
('Produit3', '1', '1', '999.99', '40', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/pc.avif'),
('Produit4', '1', '3', '649', '30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/pc.avif'),
('Produit5', '1', '3', '749', '50', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/pc.avif'),
('Produit6', '1', '4', '1199', '35', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/pc.avif'),
('Produit7', '1', '4', '1899', '10', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/pc.avif'),
('Produit8', '1', '5', '349', '30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/pc.avif'),
('Produit9', '1', '5', '699.99', '50', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/pc.avif'),
('Produit10', '1', '5', '899', '35', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/pc.avif'),
('Produit11', '1', '2', '1699', '40', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/pc.avif'),
('Produit12', '1', '2', '1999', '30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/pc.avif'),
('Produit13', '1', '2', '2199', '50', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/pc.avif'),
('Produit14', '1', '12', '749', '35', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/pc.avif'),
('Produit15', '1', '12', '449', '40', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/pc.avif'),
('Produit16', '1', '9', '799', '30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/pc.avif'),

('Produit17', '3', '2', '899', '50', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/tab.avif'),
('Produit18', '3', '2', '999', '35', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/tab.avif'),
('Produit19', '3', '6', '649', '40', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/tab.avif'),
('Produit20', '3', '6', '799', '30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/tab.avif'),
('Produit21', '3','10' , '199', '50', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/tab.avif'),
('Produit22', '1', '9', '399', '35', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/tab.avif'),

('Produit23', '2', '11', '99', '40', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit24', '2', '11', '119', '30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit25', '2', '11', '149', '50', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit26', '2', '11', '209', '35', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit27', '2', '11', '599.99', '40', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit28', '2', '11', '399.50', '30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit29', '2', '11', '179', '50', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit30', '2', '11', '349', '35', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit31', '2', '2', '1299', '40', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit32', '2', '2', '999', '30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit33', '2', '2', '1499', '50', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit34', '2', '2', '1099.99', '35', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit35', '2', '6', '299', '40', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit36', '2', '6', '249', '30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit37', '2', '6', '399', '50', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit38', '2', '6', '899', '35', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit39', '2', '6', '1150', '40', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit40', '2', '6', '649.50', '30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit41', '2', '8', '450', '50', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit42', '2', '8', '550', '35', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit43', '2', '8', '650', '40', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit44', '2', '8', '750', '30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit45', '2', '8', '750', '50', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit46', '2', '9', '1299', '35', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit47', '2', '9', '199', '40', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit48', '2', '9', '399', '30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit49', '2', '9', '799', '50', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit50', '2', '10', '149', '35', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit51', '2', '10', '199', '40', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit52', '2', '10', '299', '30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),
('Produit53', '2', '10', '599', '50', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/smartphone.avif'),

('Produit54', '6', '1', '99', '35', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/ecran.avif'),
('Produit55', '6', '12', '149', '40', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/ecran.avif'),
('Produit56', '6', '2', '599', '30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/ecran.avif'),
('Produit57', '6', '5', '199', '50', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/ecran.avif'),
('Produit58', '6', '7', '299', '35', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/ecran.avif'),

('Produit59', '4', '3', '79', '40', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/imprimante.avif'),
('Produit60', '4', '13', '299', '30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/imprimante.avif'),

('Produit61', '5', '14', '49', '50', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/clavier.avif'),
('Produit62', '5', '14', '29', '35', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/clavier.avif'),
('Produit63', '5', '2', '129', '20', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '/assets/clavier.avif');

CREATE TABLE commandes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client_id INT NOT NULL,
    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    statut VARCHAR(50) NOT NULL,
    montant_total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (client_id) REFERENCES clients(id)
) ENGINE InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO commandes (client_id, date, statut, montant_total) VALUES
('2', '2023-09-07', 'Livré', '299'),
('7', '2023-08-31', 'Livré', '599'),
('11', '2023-12-22', 'Livré', '450'),
('12', '2023-12-29', 'Livré', '1299'),
('13', '2023-07-24', 'Livré', '1099.99'),
('4', '2023-03-25', 'Livré', '699'),
('8', '2023-10-18', 'Annulé', '999'),
('21', '2023-08-21', 'Livré', '649.50'),
('24', '2023-09-05', 'Livré', '1499'),
('27', '2024-01-15', 'En cours', '449');

CREATE TABLE expeditions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    commande_id INT NOT NULL,
    methode VARCHAR(255) NOT NULL,
    cout DECIMAL(10,2) NOT NULL,
    date_livraison_estimee DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (commande_id) REFERENCES commandes(id)
) ENGINE InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO expeditions (commande_id, methode, cout, date_livraison_estimee) VALUES
( '1', 'Standard', '9.5', '2023-09-14'),
( '2', 'Standard', '9.5', '2023-09-07'),
( '3', 'Standard', '9.5', '2024-01-02'),
( '4', 'Express', '15', '2023-12-30'),
( '5', 'Eco', '5.5', '2023-08-24'),
( '6', 'Eco', '5.5', '2023-04-25'),
( '8', 'Express', '15', '2023-08-23'),
( '9', 'Express', '15', '2023-09-06'),
( '10', 'Eco', '15', '2023-01-15');

CREATE TABLE evaluations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    produit_id INT NOT NULL,
    note INT NOT NULL DEFAULT 0,
    commentaire TEXT,
    date_publication DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES clients(id),
    FOREIGN KEY (produit_id) REFERENCES produits(id)
) ENGINE InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE paniers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL DEFAULT 1,
    date_ajout DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES clients(id),
    FOREIGN KEY (produit_id) REFERENCES produits(id)
) ENGINE InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE paniers_produits (
    panier_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL DEFAULT 1,
    PRIMARY KEY (panier_id, produit_id),
    FOREIGN KEY (panier_id) REFERENCES paniers(id),
    FOREIGN KEY (produit_id) REFERENCES produits(id)
) ENGINE InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE promotions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    produit_id INT NOT NULL,
    pourcentage_remise INT NOT NULL DEFAULT 0,
    date_debut DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_fin DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produit_id) REFERENCES produits(id)
) ENGINE InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    message TEXT NOT NULL,
    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    statut VARCHAR(50) NOT NULL DEFAULT 'actif',
    FOREIGN KEY (utilisateur_id) REFERENCES clients(id)
) ENGINE InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE requetes_recherche (
    id INT PRIMARY KEY AUTO_INCREMENT,
    requete TEXT NOT NULL,
    utilisateur_id INT NOT NULL,
    date_recherche DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    nombre_resultats INT NOT NULL DEFAULT 0,
    FOREIGN KEY (utilisateur_id) REFERENCES clients(id)
) ENGINE InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE journaux_securite (
    id INT PRIMARY KEY AUTO_INCREMENT,
    evenement TEXT NOT NULL,
    utilisateur_id INT NOT NULL,
    horodatage DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    adresse_ip VARCHAR(15) NOT NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES clients(id)
) ENGINE InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE administrateurs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL,
    derniere_connexion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO administrateurs (nom, email, mot_de_passe, role, derniere_connexion) VALUES
('Administrateur1', 'administrateur1@exemple.fr', 'administrateur1', 'Administrateur principal', '2017-12-28'),
('Administrateur2', 'administrateur2@exemple.fr', 'administrateur2', 'Administrateur secondaire', '2017-12-28');