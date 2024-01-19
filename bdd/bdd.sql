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
    alias VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    adresse TEXT NOT NULL,
    ville VARCHAR(255) NOT NULL,  
    code_postal VARCHAR(5) NOT NULL,   
    telephone VARCHAR(20) NOT NULL,
    date_enregistrement DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    mot_de_passe VARCHAR(255) NOT NULL
) ENGINE InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO clients (nom, alias, email, adresse, ville, code_postal, telephone, date_enregistrement, mot_de_passe) VALUES
('Client1','alias1', 'client1@exemple.fr', 'adresse1', 'ville1', '01000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$FehN3MUZFW1DXSpc.M1x4.YHYMKN9DWLhe5xtVLaZCYibl1oSM36S'),
('Client2', 'alias2','client2@exemple.fr', 'adresse2', 'ville2', '02000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$MzHgERJ1SW9BJVKZuny0JuYcVMDZRqAvcSLEhXkp71PuZi0V8bobC'),
('Client3', 'alias3','client3@exemple.fr', 'adresse3', 'ville3', '03000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$xs3aa8x2qgDYlpwB9PKKy.tjLBEmciIRmcGEtIqQJ44NmF3Dza8ki'),
('Client4','alias4', 'client4@exemple.fr', 'adresse4', 'ville4', '04000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$gOng5C5ArEeY/X6ZW1HMGucAWLyXwgGxx7eD71UHto0.Q8MafU5zu'),
('Client5','alias5', 'client5@exemple.fr', 'adresse5', 'ville5', '05000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$fzeYqtadmWVwoQWp0FokCeqpS0fWzv0eW/i/JW3QYkc8T3unryZCG'),
('Client6','alias6', 'client6@exemple.fr', 'adresse6', 'ville6', '06000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$2TldTjsEEJ.hACjBC8iPIuNVHK99n2Tm.dsBu6CbfUpE/3h0rJjuO'),
('Client7','alias7', 'client7@exemple.fr', 'adresse7', 'ville7', '07000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$2HETQezoWCWexeKnT7Izy.qvuXmmwTKfHawOAcxZnLoEJsGvJKK9m'),
('Client8','alias8','client8@exemple.fr', 'adresse8', 'ville8', '08000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$DWQajc5LwYa7Pj9oaYdTLOmW0PAR/zBGdA1YAykKH9CNZZqiH4gnC'),
('Client9','alias9', 'client9@exemple.fr', 'adresse9', 'ville9', '09000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$a1SYBHvvbYofQkvMm1Iit.Kt.05zm1GQp3h0TcHpHmJfaAVI1LNhK'),
('Client10','alias10', 'client10@exemple.fr', 'adresse10', 'ville10', '10000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$vT2EqN56LALP28fNLzzpH.TAPF0EhFO6G4NZx18i5/dsiry3e5xzC'),
('Client11','alias11', 'client11@exemple.fr', 'adresse11', 'ville11', '11000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$JHjgN0f/WlKv5SzS0ywU4.IxGN5vFVVGtTT9F446QJ3.NGv.S59Sa'),
('Client12','alias12', 'client12@exemple.fr', 'adresse12', 'ville12', '12000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$fPejaw.pL/4EFkO1/axIMu76nlIW1miqB8jd4suDNyYEtcrRz/zTC'),
('Client13','alias13', 'client13@exemple.fr', 'adresse13', 'ville13', '13000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$IkpDzYFv5gGyO3IbIZSFhOlQLrrxe3TlyEZ.w2sLixL1d4AFCbgLq'),
('Client14','alias14', 'client14@exemple.fr', 'adresse14', 'ville14', '14000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$FGaAMSJyuIvyLsAlVniJb.QCjHeGS6xZHdms6ZQGxC5scl2i./ici'),
('Client15','alias15', 'client15@exemple.fr', 'adresse15', 'ville15', '15000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$8JEL5v1Czm6U8J1CkCXDzeD9RCbuJIgqjp9Mj9Hh3Z1.pRHbeKRoC'),
('Client16','alias16', 'client16@exemple.fr', 'adresse16', 'ville16', '16000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$IHBYDAiXNmh2S86iQFTvr.JXKRKRwFFFWcPo03nJBzs0MJIk/y.DS'),
('Client17','alias17', 'client17@exemple.fr', 'adresse17', 'ville17', '17000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$8DW6asQtvc5.WZQkOuUGrubtwPWktNOFS0MDVARao01qvseby12..'),
('Client18','alias18', 'client18@exemple.fr', 'adresse18', 'ville18', '18000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$3cUYvdDEujl6dZCyDGKEieWGfzdtslrkp04K3ogk74fXpmYNzCkye'),
('Client19','alias19', 'client19@exemple.fr', 'adresse19', 'ville19', '19000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$ewOGdIui764xB2bMuVgN5eO5vQK/kmc4qSA..UpkH2yiUbzr4UBxm'),
('Client20','alias20', 'client20@exemple.fr', 'adresse20', 'ville20', '20000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$msbY1zMfF6.eT/nQoV4SXelyBa/YN2tofD2mfgpBTfQ9Ar/2hUuZq'),
('Client21', 'alias21','client21@exemple.fr', 'adresse21', 'ville21', '21000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$Xqq9pe2F/3PaOsJWZQA.VOqi0h.QtjIWTWxOgkB0bGQS3prsYsSo2'),
('Client22', 'alias22','client22@exemple.fr', 'adresse22', 'ville22', '22000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$UTizL3E5CWesGLRPHqqL2.48ZU6/WT87P8/YrS5auzLQngHBczEOm'),
('Client23','alias23', 'client23@exemple.fr', 'adresse23', 'ville23', '23000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$CZ/RxQrxwF.rLOAdu7UsnOrOMtzFLzpt3cYmSfIac9nYq29NOG5EC'),
('Client24','alias24', 'client24@exemple.fr', 'adresse24', 'ville24', '24000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$dgHffOx94U3qlGKSJocqrejsVQPa9md9wAXjN..bk2LiwIh3X3H32'),
('Client25','alias25', 'client25@exemple.fr', 'adresse25', 'ville25', '25000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$Me/SKtKMfaTx1Z1xskZSQezFGD14w.eFFnLxwJ.GeA99ZaYewbaSe'),
('Client26', 'alias26','client26@exemple.fr', 'adresse26', 'ville26', '26000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$RinKnrci6bcgsTBW6ncRP.eM8q5HeR5AutJvmWo/uk9lQLmhLt.8m'),
('Client27','alias27', 'client27@exemple.fr', 'adresse27', 'ville27', '27000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$9pnJPJXjMxGf8REpku6lneCT9Bg2mAQnPYkkNAwGWFr1G8Ffg0RDy'),
('Client28','alias28', 'client28@exemple.fr', 'adresse28', 'ville28', '28000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$YZ48ZNQvzWo4iUWGDeGAe.C9sEKXYRd2qcgPdd5fC9mAcx5OAhgCu'),
('Client29','alias29', 'client29@exemple.fr', 'adresse29', 'ville28', '29000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$T.ZAyjSMnLHhqV5PvVAube8Gk.e5KncDA0myaqL73OejgGyLFRkFG'),
('Client30','alias30', 'client30@exemple.fr', 'adresse30', 'ville29', '30000', '0606060606',
  DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY),'$2y$10$57ygbmeivLAs.2MpluEuDeWaXYs4aY4GX/g4lSIlnT2J7zJU6eTti');



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
('Produit1', '1', '1', '599.99', '50',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/pc.avif'),
('Produit2', '1', '1', '699.99', '35',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/pc.avif'),
('Produit3', '1', '1', '999.99', '40',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/pc.avif'),
('Produit4', '1', '3', '649', '30',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/pc.avif'),
('Produit5', '1', '3', '749', '50',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/pc.avif'),
('Produit6', '1', '4', '1199', '35',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/pc.avif'),
('Produit7', '1', '4', '1899', '10',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/pc.avif'),
('Produit8', '1', '5', '349', '30',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/pc.avif'),
('Produit9', '1', '5', '699.99', '50',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/pc.avif'),
('Produit10', '1', '5', '899', '35',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/pc.avif'),
('Produit11', '1', '2', '1699', '40',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/pc.avif'),
('Produit12', '1', '2', '1999', '30',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/pc.avif'),
('Produit13', '1', '2', '2199', '50',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/pc.avif'),
('Produit14', '1', '12', '749', '35',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/pc.avif'),
('Produit15', '1', '12', '449', '40',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/pc.avif'),
('Produit16', '1', '9', '799', '30',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/pc.avif'),

('Produit17', '3', '2', '899', '50',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/tab.avif'),
('Produit18', '3', '2', '999', '35',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/tab.avif'),
('Produit19', '3', '6', '649', '40',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/tab.avif'),
('Produit20', '3', '6', '799', '30',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/tab.avif'),
('Produit21', '3','10' , '199', '50',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/tab.avif'),
('Produit22', '3', '9', '399', '35',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/tab.avif'),

('Produit23', '2', '11', '99', '40',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit24', '2', '11', '119', '30',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit25', '2', '11', '149', '50',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit26', '2', '11', '209', '35',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit27', '2', '11', '599.99', '40',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit28', '2', '11', '399.50', '30',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit29', '2', '11', '179', '50',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit30', '2', '11', '349', '35',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit31', '2', '2', '1299', '40',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit32', '2', '2', '999', '30',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit33', '2', '2', '1499', '50',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit34', '2', '2', '1099.99', '35',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit35', '2', '6', '299', '40',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit36', '2', '6', '249', '30',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit37', '2', '6', '399', '50',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit38', '2', '6', '899', '35',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit39', '2', '6', '1150', '40',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit40', '2', '6', '649.50', '30',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit41', '2', '8', '450', '50',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit42', '2', '8', '550', '35',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit43', '2', '8', '650', '40',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit44', '2', '8', '750', '30',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit45', '2', '8', '750', '50',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit46', '2', '9', '1299', '35',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit47', '2', '9', '199', '40',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit48', '2', '9', '399', '30',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit49', '2', '9', '799', '50',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit50', '2', '10', '149', '35',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit51', '2', '10', '199', '40',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit52', '2', '10', '299', '30',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit53', '2', '10', '599', '50',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),

('Produit54', '6', '1', '99', '35',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/ecran.avif'),
('Produit55', '6', '12', '149', '40',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/ecran.avif'),
('Produit56', '6', '2', '599', '30',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/ecran.avif'),
('Produit57', '6', '5', '199', '50',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/ecran.avif'),
('Produit58', '6', '7', '299', '35',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/ecran.avif'),

('Produit59', '4', '3', '79', '40',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/imprimante.avif'),
('Produit60', '4', '13', '299', '30',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/imprimante.avif'),

('Produit61', '5', '14', '49', '50',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/clavier.avif'),
('Produit62', '5', '14', '29', '35',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/clavier.avif'),
('Produit63', '5', '2', '129', '20',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/clavier.avif');

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
note INT NOT NULL DEFAULT 0 CHECK (note >= 0 AND note <= 5),
commentaire TEXT,
date_publication DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (utilisateur_id) REFERENCES clients(id),
FOREIGN KEY (produit_id) REFERENCES produits(id)
) ENGINE InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO evaluations (utilisateur_id, produit_id, note, commentaire)
VALUES
    (1, 1, 5, 'Excellent produit, fortement recommandé !'),
    (2, 1, 4, 'Très bon, mais légèrement cher.'),
    (7, 1, 4, 'Bon produit, répond à mes besoins.'),
    (13, 1, 5, 'Excellent, je recommande vivement.'),
    (2, 2, 4, 'Très bon, mais légèrement cher.'),
    (3, 3, 3, 'Moyen, répond aux attentes.'),
    (4, 4, 2, 'Peut-être amélioré, manque certaines fonctionnalités.'),
    (5, 5, 1, 'Pas satisfait de la qualité.'),
    (6, 6, 0, 'Mauvaise expérience, ne recommande pas.'),
    (7, 7, 4, 'Bon produit, répond à mes besoins.'),
    (8, 8, 3, 'Assez bon, mais pourrait être mieux.'),
    (9, 9, 5, 'Parfait, dépasse mes attentes!'),
    (10, 10, 2, 'Pas totalement satisfait.'),
    (11, 11, 4, 'Très bon rapport qualité-prix.'),
    (12, 12, 1, 'Déçu par la qualité.'),
    (13, 13, 5, 'Excellent, je recommande vivement.'),
    (14, 14, 3, 'Correct, mais rien d\'exceptionnel.'),
    (15, 15, 2, 'Peut faire mieux.'),
    (16, 16, 4, 'Très pratique et efficace.'),
    (17, 17, 1, 'Ne répond pas à mes attentes.'),
    (18, 18, 5, 'Fantastique, au-dessus de la norme!'),
    (19, 19, 3, 'Moyen, mais acceptable.'),
    (20, 20, 4, 'Bonne qualité, satisfait de mon achat.'),
    (21, 21, 2, 'Qualité inférieure à ce que j\'attendais.'),
    (22, 22, 4, 'Bon achat, je suis content.'),
    (23, 23, 1, 'Pas à la hauteur de mes attentes.'),
    (24, 24, 3, 'Passable, mais peut être amélioré.'),
    (25, 25, 5, 'Superbe! Très satisfait.'),
    (26, 26, 2, 'Médiocre, attendait mieux.'),
    (27, 27, 4, 'Très bon produit, fonctionne bien.'),
    (28, 28, 3, 'Assez bon, mais a des limites.'),
    (29, 29, 1, 'Très décevant, ne recommande pas.'),
    (30, 30, 5, 'Exceptionnel, hautement recommandé!'),
    (1, 31, 4, 'Très bon, fiable et efficace.'),
    (2, 32, 2, 'Pas totalement convaincu.'),
    (3, 33, 3, 'Correct, mais pas extraordinaire.'),
    (4, 34, 1, 'Insatisfaisant, beaucoup de problèmes.'),
    (5, 35, 5, 'Excellent choix, très heureux avec.'),
    (6, 36, 4, 'Bonne qualité et performance.'),
    (7, 37, 3, 'Assez satisfaisant pour le prix.'),
    (8, 38, 2, 'Pourrait être amélioré sous certains aspects.'),
    (9, 39, 1, 'Déçu, ne correspond pas à mes attentes.'),
    (10, 40, 5, 'Parfait en tous points!'),
    (11, 41, 4, 'Très satisfaisant, recommandé.'),
    (12, 42, 3, 'Bon, mais a ses limites.'),
    (13, 43, 2, 'Moyen, peut être mieux.'),
    (14, 44, 1, 'Pas impressionné, manque de qualité.'),
    (15, 45, 5, 'Excellent, dépasse les attentes.'),
    (16, 46, 4, 'Très bien, répond aux besoins.'),
    (17, 47, 3, 'Acceptable, mais pas extraordinaire.'),
    (18, 48, 2, 'Peut mieux faire, assez basique.'),
    (19, 49, 1, 'Insatisfaisant, ne recommande pas.'),
    (20, 50, 5, 'Exceptionnel, qualité supérieure.'),
    (21, 51, 4, 'Très bon, solide et fiable.'),
    (22, 52, 3, 'Correct, mais sans plus.'),
    (23, 53, 2, 'Moyen, nécessite des améliorations.'),
    (24, 54, 1, 'Décevant, attendait mieux.'),
    (25, 55, 5, 'Parfait, hautement recommandé.'),
    (26, 56, 4, 'Bonne qualité, très fonctionnel.'),
    (27, 57, 3, 'Assez bon, mais pas le meilleur.'),
    (28, 58, 2, 'Peut-être amélioré, fonctionnalités limitées.'),
    (29, 59, 1, 'Peu satisfaisant, qualité médiocre.'),
    (30, 60, 5, 'Excellent, très efficace.'),
    (1, 61, 4, 'Très bon, recommande.'),
    (2, 62, 3, 'Bon, mais pourrait être amélioré.'),
    (3, 63, 2, 'Moyen, pas à la hauteur des attentes.');


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
pourcentage_remise INT NOT NULL DEFAULT 0 CHECK (pourcentage_remise >= 5 AND pourcentage_remise <= 60),
date_debut DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
date_fin DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (produit_id) REFERENCES produits(id)
) ENGINE InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO promotions (produit_id, pourcentage_remise, date_debut, date_fin)
VALUES
    (1, 10, '2024-01-01 00:00:00', '2024-02-01 00:00:00'),
    (2, 15, '2024-01-01 00:00:00', '2024-02-01 00:00:00'),
    (3, 20, '2024-01-01 00:00:00', '2024-02-01 00:00:00'),
    (4, 25, '2024-01-01 00:00:00', '2024-02-01 00:00:00'),
    (5, 30, '2024-01-01 00:00:00', '2024-02-01 00:00:00'),
    (6, 35, '2024-01-01 00:00:00', '2024-02-01 00:00:00'),
    (7, 40, '2024-01-01 00:00:00', '2024-02-01 00:00:00'),
    (8, 45, '2024-01-01 00:00:00', '2024-02-01 00:00:00'),
    (9, 50, '2024-01-01 00:00:00', '2024-02-01 00:00:00'),
    (10, 55, '2024-01-01 00:00:00', '2024-02-01 00:00:00'),
    (11, 60, '2024-01-01 00:00:00', '2024-02-01 00:00:00'),
    (12, 12, '2024-01-01 00:00:00', '2024-02-01 00:00:00'),
    (13, 18, '2024-01-01 00:00:00', '2024-02-01 00:00:00'),
    (14, 22, '2024-01-01 00:00:00', '2024-02-01 00:00:00'),
    (15, 27, '2024-01-01 00:00:00', '2024-02-01 00:00:00'),
    (16, 33, '2024-01-01 00:00:00', '2024-02-01 00:00:00'),
    (17, 37, '2024-01-01 00:00:00', '2024-02-01 00:00:00'),
    (18, 43, '2024-01-01 00:00:00', '2024-02-01 00:00:00'),
    (19, 47, '2024-01-01 00:00:00', '2024-02-01 00:00:00'),
    (20, 53, '2024-01-01 00:00:00', '2024-02-01 00:00:00');

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
('Administrateur1', 'administrateur1@exemple.fr', '$2y$10$vXTXTV7Cx4FfuzwLuITCQul0wCtBGUluqdD2iiKwlSVtMVb7Tot0a', 'Administrateur principal', '2017-12-28'),
('Administrateur2', 'administrateur2@exemple.fr', '$2y$10$/L9yuD35pYAmdYcoiqArce5qm1Cwh9EzR/KWz6fPpWVfSgmmX/eCO', 'Administrateur secondaire', '2017-12-28');


-- Liste des produits
SELECT image, nom, prix
FROM produits;

-- Infos pour un produit
SELECT
    produits.image,
    produits.nom AS nom_produit,
    produits.prix,
    produits.description,
    categories.nom AS nom_categorie,
    marques.nom AS nom_marque
FROM
    produits
        INNER JOIN categories ON produits.categorie_id = categories.id
        INNER JOIN marques ON produits.marque_id = marques.id
WHERE produits.id = 5;

-- Liste des produits par prix croissant
SELECT image, nom, prix
FROM produits
ORDER BY prix ASC;

-- Liste des produits par prix décroissant
SELECT image, nom, prix
FROM produits
ORDER BY prix DESC;

-- Liste des produits de la catégorie 1
SELECT produits.image, produits.nom, produits.prix, categories.nom AS categorie
FROM produits
         INNER JOIN categories ON produits.categorie_id = categories.id
WHERE categories.id = '1'
ORDER BY categories.nom;

-- Liste des produits de la marque 1
SELECT produits.image, produits.nom, produits.prix, marques.nom AS marque
FROM produits
         INNER JOIN marques ON produits.marque_id = marques.id
WHERE marques.id = '1'
ORDER BY marques.nom;

-- Liste des produits de la catégorie 1 et de la marque 2
SELECT produits.image, produits.nom, produits.prix, categories.nom AS categorie, marques.nom AS marque
FROM produits
         INNER JOIN categories ON produits.categorie_id = categories.id
         INNER JOIN marques ON produits.marque_id = marques.id
WHERE categories.id = '1' AND marques.id = '2'
ORDER BY categories.nom, marques.nom;

-- Recherche par mot clé
SELECT image, nom, prix
FROM produits
WHERE nom LIKE '%ordinateur%';
