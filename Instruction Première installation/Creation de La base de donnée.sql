
create database lequaiantique ;

use lequaiantique;

#Fichiers migration de base : 

#Création des Tables  Initiales:
#( Ce schéma de table initial a pu être modifié au cours du développement. Mieux vaut donc utiliser les fichiers migrations.) 
    

    CREATE TABLE administrateur (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id), username VARCHAR(64) DEFAULT NULL, password VARCHAR(256) DEFAULT NULL, nom VARCHAR(64) DEFAULT NULL, prenom VARCHAR(64) DEFAULT NULL,auth_entity VARCHAR(255) NOT NULL, email VARCHAR(128) NOT NULL) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    CREATE TABLE boisson (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(64) NOT NULL, description VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    CREATE TABLE carte (id INT AUTO_INCREMENT NOT NULL, entree LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', plat LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', dessert LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(64) NOT NULL, prenom VARCHAR(64) NOT NULL, email VARCHAR(128) NOT NULL, nb_convive INT NOT NULL, commande VARCHAR(255) NOT NULL, intolerance_alimentaire LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, entree LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', plat_principal LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', dessert LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', boisson LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', menu LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    CREATE TABLE dessert (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(64) NOT NULL, description VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    CREATE TABLE entree (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(64) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    CREATE TABLE formule (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(64) NOT NULL, description VARCHAR(255) NOT NULL, plats LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', prix DOUBLE PRECISION NOT NULL, date_application VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    CREATE TABLE horaires (id INT AUTO_INCREMENT NOT NULL, dejeuner_debut DATETIME NOT NULL, dejeuner_fin DATETIME NOT NULL, diner_debut DATETIME NOT NULL, diner_fin DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(64) NOT NULL, formule LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(64) NOT NULL, binary_file LONGBLOB NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    CREATE TABLE plat_principal (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(64) NOT NULL, description VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, arrivee DATETIME NOT NULL, nb_convive INT NOT NULL, intolerance_alimentaire LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    CREATE TABLE auth_entity (id INT AUTO_INCREMENT NOT NULL, roles JSON NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
    CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(64) NOT NULL, prenom VARCHAR(64) NOT NULL, email VARCHAR(128) NOT NULL, message LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
    INSERT Into administrateur (username,password,nom,prenom,auth_entity,email) values ('admin','lequaiantique','root','lequai','1','administrateur@lequaiantique.xyz');
    INSERT INTO auth_entity(roles,email,password) VALUES ('[ROLE_ADMIN]','administrateur@lequaiantique.xyz','lequaiantique);
