-- Script SQL pour créer la base de données du restaurant en français
-- Création des bases de données et des tables

-- Création de la base de données restaurant
CREATE DATABASE IF NOT EXISTS restaurant CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Utilisation de la base de données restaurant
USE restaurant;

-- Création de la table menus (plats du menu)
CREATE TABLE IF NOT EXISTS menus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL COMMENT 'Nom du plat',
    description TEXT COMMENT 'Description du plat',
    prix DECIMAL(10,2) NOT NULL COMMENT 'Prix en euros',
    categorie ENUM('entree', 'plat', 'dessert', 'boisson') NOT NULL COMMENT 'Catégorie du plat',
    image VARCHAR(500) COMMENT 'Chemin vers l\'image du plat',
    date_menu DATE NOT NULL COMMENT 'Date du menu',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création de l\'entrée'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Création de la base de données user_authentication
CREATE DATABASE IF NOT EXISTS user_authentication CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Utilisation de la base de données user_authentication
USE user_authentication;

-- Création de la table utilisateurs (administrateurs)
CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_utilisateur VARCHAR(50) NOT NULL UNIQUE COMMENT 'Nom d\'utilisateur unique',
    email VARCHAR(255) NOT NULL UNIQUE COMMENT 'Adresse email',
    mot_de_passe VARCHAR(255) NOT NULL COMMENT 'Mot de passe hashé',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création du compte',
    derniere_connexion TIMESTAMP NULL COMMENT 'Dernière connexion'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Création de la table messages_contact (messages des utilisateurs)
CREATE TABLE IF NOT EXISTS messages_contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL COMMENT 'Email de l\'expéditeur',
    message TEXT NOT NULL COMMENT 'Contenu du message',
    lu BOOLEAN DEFAULT FALSE COMMENT 'Statut de lecture (vrai = lu, faux = non lu)',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date d\'envoi du message'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertion de données d'exemple pour la base restaurant
USE restaurant;

-- Insertion de quelques plats d'exemple
INSERT INTO menus (titre, description, prix, categorie, date_menu) VALUES
('Salade César', 'Salade fraîche avec poulet grillé, parmesan et sauce César', 12.50, 'entree', CURDATE()),
('Steak Frites', 'Steak de bœuf tendre avec frites maison et sauce au poivre', 18.90, 'plat', CURDATE()),
('Tarte Tatin', 'Tarte aux pommes caramélisées avec crème fraîche', 8.50, 'dessert', CURDATE()),
('Café Expresso', 'Café italien traditionnel', 2.50, 'boisson', CURDATE());

-- Insertion de données d'exemple pour la base user_authentication
USE user_authentication;

-- Insertion d'un administrateur d'exemple (mot de passe: admin123)
INSERT INTO utilisateurs (nom_utilisateur, email, mot_de_passe) VALUES
('elias', 'sena@restaurant.com', 'ada@2003'); -- Note: Utilisez un mot de passe hashé en production

-- Insertion de quelques messages d'exemple
INSERT INTO messages_contact (email, message, lu) VALUES
('client1@email.com', 'Bonjour, j\'aimerais réserver une table pour 4 personnes ce soir. Merci de me contacter.', FALSE),
('client2@email.com', 'Excellent restaurant ! Le service était impeccable et la nourriture délicieuse.', TRUE),
('client3@email.com', 'Question concernant les horaires d\'ouverture. Êtes-vous ouverts le dimanche ?', FALSE);

-- Création d'index pour optimiser les performances
USE restaurant;
CREATE INDEX idx_menus_categorie ON menus(categorie);
CREATE INDEX idx_menus_date ON menus(date_menu);

USE user_authentication;
CREATE INDEX idx_utilisateurs_email ON utilisateurs(email);
CREATE INDEX idx_messages_contact_lu ON messages_contact(lu);
CREATE INDEX idx_messages_contact_date ON messages_contact(date_creation);

-- Commentaires finaux
/*
Instructions d'utilisation :
1. Exécutez ce script dans votre serveur MySQL
2. Les bases de données seront créées automatiquement
3. Des données d'exemple sont incluses pour tester l'application
4. Pensez à modifier les mots de passe des administrateurs en production

Tables créées :
- restaurant.menus : Contient les plats du menu du jour
- user_authentication.utilisateurs : Contient les comptes administrateur
- user_authentication.messages_contact : Contient les messages de contact des utilisateurs
*/
