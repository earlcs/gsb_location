<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200328145536 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE demandes (NUM_DEM INT AUTO_INCREMENT NOT NULL, TYPE_DEM VARCHAR(128) NOT NULL, DATE_LIMITE DATE DEFAULT \'NULL\', NUM_CLI INT DEFAULT NULL, INDEX I_FK_DEMANDES_CLIENTS (NUM_CLI), PRIMARY KEY(NUM_DEM)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concerner (NUM_DEM INT NOT NULL, ARRONDISS_DEM INT NOT NULL, INDEX IDX_ABE9A86614E66863 (NUM_DEM), INDEX IDX_ABE9A866E6FA518 (ARRONDISS_DEM), PRIMARY KEY(NUM_DEM, ARRONDISS_DEM)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locataires (NUMEROLOC INT AUTO_INCREMENT NOT NULL, NOM_LOC VARCHAR(128) NOT NULL, PRENOM_LOC VARCHAR(128) NOT NULL, DATENAISS DATE NOT NULL, TEL_LOC CHAR(255) DEFAULT \'NULL\', R_I_B INT NOT NULL, BANQUE VARCHAR(128) NOT NULL, RUE_BANQUE VARCHAR(128) NOT NULL, CODEVILLE_BANQUE VARCHAR(128) NOT NULL, TEL_BANQUE CHAR(255) DEFAULT \'NULL\', PRIMARY KEY(NUMEROLOC)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proprietaires (NUMEROPROP INT AUTO_INCREMENT NOT NULL, NOM VARCHAR(255) NOT NULL, PRENOM VARCHAR(255) NOT NULL, ADRESSE VARCHAR(255) NOT NULL, CODE_VILLE VARCHAR(128) NOT NULL, TEL VARCHAR(128) DEFAULT \'NULL\', PRIMARY KEY(NUMEROPROP)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(30) NOT NULL, mdp VARCHAR(50) NOT NULL, email VARCHAR(65535) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demandes ADD CONSTRAINT FK_BD940CBBC70601B6 FOREIGN KEY (NUM_CLI) REFERENCES clients (NUM_CLI)');
        $this->addSql('ALTER TABLE concerner ADD CONSTRAINT FK_ABE9A86614E66863 FOREIGN KEY (NUM_DEM) REFERENCES demandes (NUM_DEM)');
        $this->addSql('ALTER TABLE concerner ADD CONSTRAINT FK_ABE9A866E6FA518 FOREIGN KEY (ARRONDISS_DEM) REFERENCES arrondissement (ARRONDISS_DEM)');
        $this->addSql('ALTER TABLE appartements CHANGE PREAVIS PREAVIS TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE clients CHANGE TEL_CLI TEL_CLI VARCHAR(128) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE visiter ADD CONSTRAINT FK_300A0915C70601B6 FOREIGN KEY (NUM_CLI) REFERENCES clients (NUM_CLI)');
        $this->addSql('ALTER TABLE visiter ADD CONSTRAINT FK_300A09156A8A714C FOREIGN KEY (NUMAPPART) REFERENCES appartements (NUMAPPART)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE concerner DROP FOREIGN KEY FK_ABE9A86614E66863');
        $this->addSql('DROP TABLE demandes');
        $this->addSql('DROP TABLE concerner');
        $this->addSql('DROP TABLE locataires');
        $this->addSql('DROP TABLE proprietaires');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE appartements CHANGE PREAVIS PREAVIS TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE clients CHANGE TEL_CLI TEL_CLI VARCHAR(128) CHARACTER SET utf8mb4 DEFAULT \'\'\'NULL\'\'\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE visiter DROP FOREIGN KEY FK_300A0915C70601B6');
        $this->addSql('ALTER TABLE visiter DROP FOREIGN KEY FK_300A09156A8A714C');
    }
}
