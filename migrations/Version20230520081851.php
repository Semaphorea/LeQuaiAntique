<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230520081851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auth_entity CHANGE roles roles JSON NOT NULL, CHANGE client client VARCHAR(255) NOT NULL, CHANGE administrateur administrateur VARCHAR(255) NOT NULL, CHANGE username username VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE boisson CHANGE photo photo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE client ADD password VARCHAR(256) NOT NULL');
        $this->addSql('ALTER TABLE dessert CHANGE photo photo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE entree CHANGE photo photo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE formule CHANGE description description VARCHAR(128) NOT NULL, CHANGE plats plats LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', CHANGE menu menu VARCHAR(255) NOT NULL, CHANGE titre titre VARCHAR(64) NOT NULL');
        $this->addSql('ALTER TABLE horaires ADD active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE menu CHANGE formule formule VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE plat_principal CHANGE photo photo VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu CHANGE formule formule LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE boisson CHANGE photo photo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE client CHANGE password password VARCHAR(256) NOT NULL');
        $this->addSql('ALTER TABLE horaires DROP active');
        $this->addSql('ALTER TABLE auth_entity CHANGE roles roles VARCHAR(64) DEFAULT NULL, CHANGE username username VARCHAR(64) NOT NULL, CHANGE email email VARCHAR(128) NOT NULL, CHANGE client client VARCHAR(255) DEFAULT NULL, CHANGE administrateur administrateur TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE plat_principal CHANGE photo photo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE dessert CHANGE photo photo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE formule CHANGE titre titre VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(64) NOT NULL, CHANGE plats plats VARCHAR(255) DEFAULT NULL, CHANGE menu menu VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE entree CHANGE photo photo VARCHAR(255) DEFAULT NULL');
    }
}
