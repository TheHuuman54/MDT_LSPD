<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230601180615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arrestation DROP FOREIGN KEY FK_4C6ACFF294513350');
        $this->addSql('DROP INDEX UNIQ_4C6ACFF294513350 ON arrestation');
        $this->addSql('ALTER TABLE arrestation DROP id_card_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arrestation ADD id_card_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE arrestation ADD CONSTRAINT FK_4C6ACFF294513350 FOREIGN KEY (id_card_id) REFERENCES pictures (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C6ACFF294513350 ON arrestation (id_card_id)');
    }
}
