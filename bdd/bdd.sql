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

-- MDP toto
INSERT INTO clients (nom, alias, email, adresse, ville, code_postal, telephone, date_enregistrement, mot_de_passe) VALUES
('Brad Pitt', 'Indiana Jones', 'bradpitt@example.fr', '123 Main Street', 'Los Angeles', '90001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Leonardo DiCaprio', 'James Bond', 'leonardodicaprio@example.fr', '456 Elm Avenue', 'New York', '10001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Angelina Jolie', 'Hulk', 'angelinajolie@example.fr', '789 Oak Street', 'Chicago', '20001', '0606060606', DATE_ADD('2018-01-01', INTERVAL
                                                                                                                 FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Tom Cruise', 'Superman', 'tomcruise@example.fr', '1010 Maple Lane', 'San Francisco', '30001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Jennifer Aniston', 'Harry Potter', 'jenniferaniston@example.fr', '2020 Cedar Road', 'Miami', '40001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('George Clooney', 'Spider-Man', 'georgeclooney@example.fr', '3030 Pine Street', 'Dallas', '50001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Scarlett Johansson', 'Luke Skywalker', 'scarlettjohansson@example.fr', '4040 Birch Avenue', 'Seattle', '60001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Matt Damon', 'Captain America', 'mattdamon@example.fr', '5050 Willow Drive', 'Denver', '70001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Natalie Portman', 'Black Widow', 'natalieportman@example.fr', '6060 Oakwood Circle', 'Phoenix', '80001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Johnny Depp', 'Jack Sparrow', 'johnnydepp@example.fr', '7070 Elmwood Lane', 'Houston', '90001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Cate Blanchett', 'Galadriel', 'cateblanchett@example.fr', '8080 Cedar Avenue', 'Atlanta', '10001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('', 'Iron Man', 'bradleycooper@example.fr', '9090 Maple Road', 'Chicago', '20001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR
(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Emma Stone', 'Hermione Granger', 'emmastone@example.fr', '10101 Oak Avenue', 'San Francisco', '30001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Denzel Washington', 'John Wick', 'denzelwashington@example.fr', '20202 Elm Street', 'Miami', '40001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Julia Roberts', 'Aquaman', 'juliaroberts@example.fr', '30303 Pine Lane', 'Dallas', '50001', '0606060606', DATE_ADD('2018-01-01', INTERVAL
                                                                                                               FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Morgan Freeman', 'Gandalf', 'morganfreeman@example.fr', '40404 Cedar Circle', 'Seattle', '60001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Nicole Kidman', 'Wonder Woman', 'nicolekidman@example.fr', '50505 Willow Road', 'Denver', '70001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Harrison Ford', 'Han Solo', 'harrisonford@example.fr', '60606 Oak Circle', 'Phoenix', '80001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Kate Winslet', 'Rose Dawson', 'katewinslet@example.fr', '70707 Elmwood Drive', 'Houston', '90001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Eddie Redmayne', 'Newt Scamander', 'eddieredmayne@example.fr', '80808 Cedar Lane', 'Atlanta', '10001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Tom Hanks', 'Forrest Gump', 'tomhanks@example.fr', '123 Main Street', 'Los Angeles', '90001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Meryl Streep', 'Miranda Priestly', 'merylstreep@example.fr', '456 Elm Avenue', 'New York', '10001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Robert Downey Jr.', 'Tony Stark', 'robertdowney@example.fr', '789 Oak Street', 'Chicago', '20001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Jennifer Lawrence', 'Katniss Everdeen', 'jenniferlawrence@example.fr', '3030 Pine Street', 'Dallas', '50001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Chris Hemsworth', 'Thor', 'chrishemsworth@example.fr', '4040 Birch Avenue', 'Seattle', '60001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Emma Watson', 'Asterix', 'emmawatson@example.fr', '5050 Willow Drive', 'Denver', '70001', '0606060606', DATE_ADD('2018-01-01', INTERVAL
                                                                                                                 FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Margot Robbie', 'Rocket Raccoon', 'margotrobbie@example.fr', '6060 Oakwood Circle', 'Phoenix', '80001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Gal Gadot', 'Batman', 'galgadot@example.fr', '7070 Elmwood Lane', 'Houston', '90001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Tom Hardy', 'Mad Max', 'tomhardy@example.fr', '111 River Road', 'Houston', '90001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu'),
('Emily Blunt', 'Mary Poppins', 'emilyblunt@example.fr', '222 Lake Street', 'Los Angeles', '90001', '0606060606', DATE_ADD('2018-01-01', INTERVAL FLOOR(RAND() * DATEDIFF('2024-01-16', '2018-01-01')) DAY), '$2y$10$jWnKVghuU1TkzSEXbSgK.epMiBhXtz0ZLudw..qObPBCh3CS4XdWu');


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
('Dell Inspiron 15', '1', '1', '599.36', '4',
 'Profitez de performances à la fois réactives et silencieuses, avec des processeurs Intel® Core™ de 12e génération associés à des options de disques SSD PCIe. Vous recherchez une optimisation graphique ? Des cartes graphiques séparées NVIDIA® sont disponibles (en option).', './assets/DELLinspiron15.avif'),
('Apple iPad (2021) 256 Go Wi-Fi + Cellular Argent', '3', '2', '769', '35',
 'Puissant. Intuitif. Polyvalent. Le nouvel iPad, c\'est un superbe écran Retina de 10.2 pouces, une puissante puce A13 Bionic, une caméra avant ultra grand-angle avec Cadre centré, et la compatibilité avec l\'Apple Pencil et le Smart Keyboard.', './assets/TabletteIpad.jpeg'),
('Logitech K380 Multi-Device Bluetooth', '5', '14', '54.95', '40',
 'Le clavier Logitech K380 Multi-Device Bluetooth Keyboard for Mac apporte le confort de la saisie de bureau sur votre smartphone, tablette ou ordinateur sous macOS, iOS et iPad OS. Connectez-vous à trois dispositifs en même temps et passez instantanément de l\'un à l\'autre.', './assets/ClavierLogitechK380.jpeg'),
('Apple iPhone 14 Pro 256 Go Or', '2', '2', '1199', '30',
 'iPhone 14 Pro. Avec un appareil photo principal de 48 MP pour capturer des détails époustouflants. Dynamic Island et l\'écran toujours activé, qui offrent une toute nouvelle expérience sur iPhone. Et Détection des accidents, une nouvelle fonctionnalité de sécurité qui appelle les secours pour vous.', './assets/Iphone14.jpeg'),
('ASUS ROG Phone 8 Pro Noir Fantôme (16 Go / 512 Go)', '2', '4', '1199.95', '50',
 'Profitez de performances incroyables sans interruption grâce à l\'ASUS ROG Phone 8 Pro. Spécialement conçu pour les jeux vidéos, il embarque un puissant processeur Qualcomm Snapdragon 8 Gen 3, un sublime écran AMOLED 6.78" à résolution Full HD+ de 1080 x 2400 pixels.', './assets/AsusSmartphone.jpeg'),
('Canon i-SENSYS MF553dw', '4', '13', '799.94', '35',
 'Toujours prête pour satisfaire les équipes des petites et moyennes entreprises, l\'imprimante multifonction 4-en-1 (impression, copie, numérisation et télécopie) laser Canon i-SENSYS MF553dw dispose de nombreux atouts pour les besoins quotidiens.', './assets/Imprimante_canon.jpeg'),
('HP 250 G9 (724W9EA)', '1', '3', '549.95', '10',
 'Le PC portable HP 250 G9 est un ordinateur portable fiable, robuste et efficace proposé à un prix très compétitif. Il intègre un processeur Intel Core i3-1215U, 16 Go de mémoire vive DDR4 et un SSD M.2 PCIe de 256 Go. Conçu pour les professionnels, il se montre efficace et facile à transporter.', './assets/PCportableHP250.jpeg'),
('Samsung 34" LED - Odyssey G5 C34G55TWWP', '6', '6', '369.95', '2',
 'Partez à la conquête de succès futurs avec l\'écran gaming Samsung Odyssey G5 C34G55TWWP ! Offrant des performances élevées, une immersion supérieure et un confort permanent, ce modèle vous assurera des conditions rêvées pour atteindre les sommets dans vos jeux préférés.', './assets/EcranSamsungGaming.jpeg'),
('Honor Magic6 Lite 5G Noir', '2', '10', '349.95', '50',
 'Faites parler votre créativité avec le Honor Magic6 Lite 5G. Il offre toute la puissance nécessaire à un fonctionnement sans accrocs. Il est notamment équipé d\'un puissant processeur Qualcomm Snapdragon 6 Gen 1 Octo-Core cadencé à 2.2 GHz, de 8 Go de RAM et d\'une capacité de stockage de 256 Go.', './assets/TelHonor.jpeg'),
('Google Pixel 8 Pro', '2', '8', '949', '35',
 'Présenté officiellement le 4 octobre 2023, le Pixel 8 Pro succède au Pixel 7 Pro en tant que fer de lance du fabricant américain. Ce smartphone haut de gamme est doté d’un écran Super Actua de 6,7 pouces avec un taux de rafraîchissement variant de 1 à 120 Hz. Il est équipé d’une puce Google Tensor G3 couplée à 12 Go de RAM et jusqu’à 1To de stockage interne. Sur le plan de la photo, il possède un triple capteur arrière de 50+48+48 mégapixels qui intègre de nombreuses fonctionnalités avancées et l’IA de Google pour des images de qualité professionnelle. Sous sa coque, une batterie de 5 050 mAh compatible avec la charge rapide à 30 W assure son autonomie.', './assets/Google-Pixel-8-Pro-2.jpeg'),
('Huawei P30 Lite - 4', '2', '9', '1699', '40',
 'Pour la première fois sur la série P lite, l\'Intelligence Artificielle vient donner un coup de pouce à vos photos. La caméra frontale du HUAWEI P30 lite sera en mesure de reconnaitre 8 scènes en temps réel, tandis que l\'appareil photo principal pourra en reconnaitre 22. En résulte un ajustement en temps réel des paramètres photo, aboutissant à des clichés extraordinaires, en toutes circonstances.', './assets/Huaweiphone.jpeg'),
('Acer Nitro 5 AN517-54-53A2', '1', '12', '849.95', '30', 
 'Plongez dans le monde du jeu vidéo avec le PC portable Acer Nitro 5 AN517-54 ! Ce PC portable Gamer est conçu pour offrir des performances remarquables, avec en prime un haut niveau de confort de jeu et un refroidissement efficace !
  Le PC portable Acer Nitro 5 AN517-54-53A2 offre de hautes performances grâce à son processeur Intel Core i5-11400H, ses 16 Go de mémoire DDR4 et sa puce graphique NVIDIA GeForce RTX 3050 avec 4 Go de mémoire dédiée. De plus, son SSD M.2 PCIe de 512 Go apporte un fonctionnement rapide. ', './assets/AcerNitro5.jpeg'),
('Xiaomi Redmi Note 12 Pro+ 5G Bleu', '2', '11', '499.95', '50', 
 'Compatible 5G, le Xiaomi Redmi Note 12 Pro+ 5G est conçu pour vous accompagner tout au long de votre journée. Pour cela, il se dote d\'un superbe écran tactile AMOLED 120 Hz de 6.67" affichant une résolution Full HD+ de 1080 x 2400 pixels, intègre un processeur MediaTek Dimensity 1080 Octo-Core cadencé à 2.0 GHz, un espace de stockage de 256 Go et 8 Go de RAM pour vous assurer fluidité et rapidité lors de toutes vos utilisations.', './assets/Xiaomi.jpeg'),
('Philips 40 LED', '6', '7', '1499.95', '35', 
 'Ce moniteur Philips avec station d\'accueil bénéficie d\'une interface Thunderbolt 4 et d\'une conformité à la norme USB4. La technologie Thunderbolt 4 offre des vitesses de transfert de données très élevées de 40 Gbits/s, une qualité vidéo haute résolution, un transport multi-flux pour la connectivité en série, jusqu\'à 90 W d\'alimentation pour des appareils et une connexion Ethernet stable à 1 Gbit/s, le tout via un seul câble. La configuration en série vous permet de piloter plusieurs moniteurs et périphériques à partir d\'un seul port Thunderbolt sur un ordinateur portable. Connectez le port Thunderbolt de votre ordinateur portable à ce moniteur. Vous pouvez ensuite utiliser le deuxième port Thunderbolt de ce dernier pour connecter un deuxième moniteur 4K.', './assets/philips_ecran.jpeg'),
('Logitech MX Keys S (Graphite)', '5', '14', '199.95', '40', 
 'Le clavier sans fil Logitech MX Keys S est un clavier fin complet qui offre une expérience de frappe fluide et précise ainsi que des Smart Actions personnalisables pour automatiser vos tâches les plus répétitives en une seule touche.', './assets/Clavier_logitech.jpeg'),
('Lenovo V15 G4', '1', '5', '549.95', '30', 
 'À la fois robuste et performant, le PC portable Lenovo V15 G4 est conçu pour vous permettre de travailler dans de bonnes conditions. Avec sa conception robuste et son écran à cadre mince, il offre un juste milieu entre confort et mobilité. L\'ordinateur portable Lenovo V15 G4 IAH (83FS000QFR) offre performance et fonctionnement rapide grâce à son processeur Intel Core i5-12500H, ses 8 Go de mémoire DDR4 et son SSD M.2 PCIe de 256 Go.', './assets/LenovoV15G4.jpeg'),

('Produit17', '3', '2', '899', '50',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/tab.avif'),
('Produit18', '3', '2', '999', '3',
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
('Produit25', '2', '11', '149', '1',
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
('Produit32', '2', '2', '999', '2',
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
('Produit38', '2', '6', '899', '1',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit39', '2', '6', '1150', '40',
 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', './assets/smartphone.avif'),
('Produit40', '2', '6', '649.50', '4',
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
('1', '2023-09-07', 'Livré', '299'),
('1', '2023-08-31', 'Livré', '599'),
('1', '2023-12-22', 'Livré', '450'),
('12', '2023-12-29', 'Livré', '1299'),
('13', '2023-07-24', 'Livré', '1099.99'),
('4', '2023-03-25', 'Livré', '699'),
('1', '2023-10-18', 'Annulé', '999'),
('21', '2023-08-21', 'Livré', '649.50'),
('24', '2023-09-05', 'Livré', '1499'),
('1', '2024-01-15', 'En cours', '449');

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
    date_ajout DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES clients(id)
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

-- MDP godwill et robin
INSERT INTO administrateurs (nom, email, mot_de_passe, role, derniere_connexion) VALUES
('Godwill', 'godwill@exemple.fr', '$2y$10$aDbmZUEd4rulveQwWEKkkuUwLO1eKAoFh9sHKPKnDTHGJTNxTgo2m', 'Administrateur principal',
 '2017-12-28'),
('Robin', 'robin@exemple.fr', '$2y$10$t/7D9oDcFmoPAKyhFfCyE.gJWZ/hINmHHw/n67ZvEZbxPiFJBOiku', 'Administrateur secondaire',
 '2017-12-28');


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
