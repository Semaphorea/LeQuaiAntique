<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230414135809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {  
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auth_entity CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE roles roles JSON NOT NULL, ADD passwordconfirmation VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE boisson CHANGE description description LONGTEXT NOT NULL, CHANGE photo photo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE client CHANGE reservation reservation VARCHAR(255) NOT NULL, ADD auth_entity VARCHAR(255) DEFAULT NULL, CHANGE commande commande VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE dessert CHANGE description description LONGTEXT NOT NULL, CHANGE photo photo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE entree CHANGE description description LONGTEXT NOT NULL, CHANGE prix prix DOUBLE PRECISION NOT NULL, CHANGE photo photo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE horaires CHANGE dejeuner_debut dejeuner_debut DATETIME NOT NULL, CHANGE dejeuner_fin dejeuner_fin DATETIME NOT NULL, CHANGE diner_debut diner_debut DATETIME NOT NULL, CHANGE diner_fin diner_fin DATETIME NOT NULL');
        $this->addSql('ALTER TABLE plat_principal CHANGE description description LONGTEXT NOT NULL, CHANGE photo photo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD date_heure_reservation DATETIME NOT NULL, CHANGE nombre_adultes nombre_adultes INT NOT NULL, CHANGE horaire_midi horaire_midi DATETIME NOT NULL, CHANGE horaire_soir horaire_soir DATETIME NOT NULL, CHANGE intolerances_alimentaires intolerances_alimentaires LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD remarques VARCHAR(255) NOT NULL, CHANGE Client client VARCHAR(255) NOT NULL');
    }  

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auth_entity CHANGE id id INT DEFAULT NULL, CHANGE email email VARCHAR(128) DEFAULT NULL, CHANGE password password VARCHAR(256) DEFAULT NULL, CHANGE roles roles VARCHAR(64) DEFAULT NULL, DROP passwordconfirmation VARCHAR(256) DEFAULT NULL');
        $this->addSql('ALTER TABLE boisson CHANGE description description VARCHAR(255) NOT NULL, CHANGE photo photo BINARY(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE client CHANGE commande commande VARCHAR(255) DEFAULT NULL, CHANGE reservation reservation BLOB DEFAULT NULL,DROP auth_entity BLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE dessert CHANGE description description VARCHAR(255) NOT NULL, CHANGE photo photo BINARY(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE entree CHANGE description description VARCHAR(255) NOT NULL, CHANGE prix prix DOUBLE PRECISION DEFAULT NULL, CHANGE photo photo BINARY(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE horaires CHANGE dejeuner_debut dejeuner_debut TIME DEFAULT NULL, CHANGE dejeuner_fin dejeuner_fin TIME DEFAULT NULL, CHANGE diner_debut diner_debut TIME DEFAULT NULL, CHANGE diner_fin diner_fin TIME DEFAULT NULL');
        $this->addSql('ALTER TABLE plat_principal CHANGE description description VARCHAR(255) NOT NULL, CHANGE photo photo BINARY(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation DROP date_heure_reservation, CHANGE client Client BLOB DEFAULT NULL, CHANGE nombre_adultes nombre_adultes INT DEFAULT NULL, CHANGE horaire_midi horaire_midi DATETIME DEFAULT NULL, CHANGE horaire_soir horaire_soir DATETIME DEFAULT NULL, CHANGE intolerances_alimentaires intolerances_alimentaires LONGTEXT DEFAULT NULL, DROP remarques');
    }
}
 