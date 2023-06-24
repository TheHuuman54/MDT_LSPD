<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230601115904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arrestation ADD id_card_id INT DEFAULT NULL, DROP id_card');
        $this->addSql('ALTER TABLE arrestation ADD CONSTRAINT FK_4C6ACFF294513350 FOREIGN KEY (id_card_id) REFERENCES pictures (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C6ACFF294513350 ON arrestation (id_card_id)');
        $this->addSql('ALTER TABLE pictures ADD path VARCHAR(255) NOT NULL, ADD size INT NOT NULL, CHANGE url filename VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arrestation DROP FOREIGN KEY FK_4C6ACFF294513350');
        $this->addSql('DROP INDEX UNIQ_4C6ACFF294513350 ON arrestation');
        $this->addSql('ALTER TABLE arrestation ADD id_card VARCHAR(255) DEFAULT NULL, DROP id_card_id');
        $this->addSql('ALTER TABLE pictures ADD url VARCHAR(255) NOT NULL, DROP filename, DROP path, DROP size');
    }
}
