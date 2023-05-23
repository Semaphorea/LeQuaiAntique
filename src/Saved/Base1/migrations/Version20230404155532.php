<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230404155532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(64) NOT NULL, prenom VARCHAR(64) NOT NULL, email VARCHAR(128) NOT NULL, message LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE authentity');
        $this->addSql('ALTER TABLE auth_entity CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE roles roles JSON NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE client ADD reservation VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE horaires CHANGE dejeuner_debut dejeuner_debut DATETIME NOT NULL, CHANGE dejeuner_fin dejeuner_fin DATETIME NOT NULL, CHANGE diner_debut diner_debut DATETIME NOT NULL, CHANGE diner_fin diner_fin DATETIME NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD client VARCHAR(255) NOT NULL, ADD intolerances_alimentaires LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD remarque VARCHAR(255) NOT NULL, DROP IntolerancesAlimentaires, CHANGE nombre_adultes nombre_adultes INT NOT NULL, CHANGE horaire_midi horaire_midi DATETIME NOT NULL, CHANGE horaire_soir horaire_soir DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE authentity (id INT DEFAULT NULL, email VARCHAR(128) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, password VARCHAR(256) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE contact');
        $this->addSql('ALTER TABLE auth_entity MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON auth_entity');
        $this->addSql('ALTER TABLE auth_entity CHANGE id id INT DEFAULT NULL, CHANGE roles roles VARCHAR(64) DEFAULT NULL, CHANGE email email VARCHAR(128) DEFAULT NULL, CHANGE password password VARCHAR(256) DEFAULT NULL');
        $this->addSql('ALTER TABLE client DROP reservation');
        $this->addSql('ALTER TABLE horaires CHANGE dejeuner_debut dejeuner_debut TIME DEFAULT NULL, CHANGE dejeuner_fin dejeuner_fin TIME DEFAULT NULL, CHANGE diner_debut diner_debut TIME DEFAULT NULL, CHANGE diner_fin diner_fin TIME DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD IntolerancesAlimentaires LONGTEXT DEFAULT NULL, DROP client, DROP intolerances_alimentaires, DROP remarque, CHANGE nombre_adultes nombre_adultes INT DEFAULT NULL, CHANGE horaire_midi horaire_midi DATETIME DEFAULT NULL, CHANGE horaire_soir horaire_soir DATETIME DEFAULT NULL');
    }
}
