<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200328143503 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appartements DROP FOREIGN KEY appartements_ibfk_1');
        $this->addSql('ALTER TABLE appartements DROP FOREIGN KEY appartements_ibfk_2');
        $this->addSql('ALTER TABLE appartements DROP FOREIGN KEY fk_arrondissement');
        $this->addSql('DROP INDEX fk_arrondissement ON appartements');
        $this->addSql('ALTER TABLE appartements CHANGE NUMAPPART NUMAPPART INT AUTO_INCREMENT NOT NULL, CHANGE PREAVIS PREAVIS TINYINT(1) DEFAULT NULL, CHANGE NUMEROPROP NUMEROPROP VARCHAR(255) NOT NULL, CHANGE NUMEROLOC NUMEROLOC VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE arrondissement CHANGE ARRONDISS_DEM ARRONDISS_DEM INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE clients CHANGE NUM_CLI NUM_CLI INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE visiter DROP DATE_VISITE');
        $this->addSql('ALTER TABLE visiter RENAME INDEX i_fk_visiter_clients TO IDX_300A0915C70601B6');
        $this->addSql('ALTER TABLE visiter RENAME INDEX i_fk_visiter_appartements TO IDX_300A09156A8A714C');
        $this->addSql('ALTER TABLE demandes DROP INDEX INDEX_NUM_CLI, ADD INDEX I_FK_DEMANDES_CLIENTS (NUM_CLI)');
        $this->addSql('ALTER TABLE demandes CHANGE NUM_DEM NUM_DEM INT AUTO_INCREMENT NOT NULL, CHANGE NUM_CLI NUM_CLI INT DEFAULT NULL');
        $this->addSql('ALTER TABLE concerner RENAME INDEX fk_concerner_arrondissement TO IDX_ABE9A866E6FA518');
        $this->addSql('ALTER TABLE locataires CHANGE NUMEROLOC NUMEROLOC INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE proprietaires CHANGE NUMEROPROP NUMEROPROP INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(65535) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appartements CHANGE NUMAPPART NUMAPPART INT NOT NULL, CHANGE PREAVIS PREAVIS TINYINT(1) DEFAULT \'0\', CHANGE NUMEROPROP NUMEROPROP INT NOT NULL, CHANGE NUMEROLOC NUMEROLOC INT NOT NULL');
        $this->addSql('ALTER TABLE appartements ADD CONSTRAINT appartements_ibfk_1 FOREIGN KEY (NUMEROPROP) REFERENCES proprietaires (NUMEROPROP)');
        $this->addSql('ALTER TABLE appartements ADD CONSTRAINT appartements_ibfk_2 FOREIGN KEY (NUMEROLOC) REFERENCES locataires (NUMEROLOC)');
        $this->addSql('ALTER TABLE appartements ADD CONSTRAINT fk_arrondissement FOREIGN KEY (ARRONDISSEMENT) REFERENCES arrondissement (ARRONDISS_DEM)');
        $this->addSql('CREATE INDEX fk_arrondissement ON appartements (ARRONDISSEMENT)');
        $this->addSql('ALTER TABLE arrondissement CHANGE ARRONDISS_DEM ARRONDISS_DEM INT NOT NULL');
        $this->addSql('ALTER TABLE clients CHANGE NUM_CLI NUM_CLI INT NOT NULL');
        $this->addSql('ALTER TABLE concerner RENAME INDEX idx_abe9a866e6fa518 TO FK_CONCERNER_ARRONDISSEMENT');
        $this->addSql('ALTER TABLE demandes DROP INDEX I_FK_DEMANDES_CLIENTS, ADD UNIQUE INDEX INDEX_NUM_CLI (NUM_CLI)');
        $this->addSql('ALTER TABLE demandes CHANGE NUM_DEM NUM_DEM INT NOT NULL, CHANGE NUM_CLI NUM_CLI INT NOT NULL');
        $this->addSql('ALTER TABLE locataires CHANGE NUMEROLOC NUMEROLOC INT NOT NULL');
        $this->addSql('ALTER TABLE proprietaires CHANGE NUMEROPROP NUMEROPROP INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE visiter ADD DATE_VISITE DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE visiter RENAME INDEX idx_300a09156a8a714c TO I_FK_VISITER_APPARTEMENTS');
        $this->addSql('ALTER TABLE visiter RENAME INDEX idx_300a0915c70601b6 TO I_FK_VISITER_CLIENTS');
    }
}
