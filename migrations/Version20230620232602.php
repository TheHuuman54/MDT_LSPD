<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230620232602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arrestation ADD suspect_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE arrestation ADD CONSTRAINT FK_4C6ACFF271812EB2 FOREIGN KEY (suspect_id) REFERENCES civil (id)');
        $this->addSql('CREATE INDEX IDX_4C6ACFF271812EB2 ON arrestation (suspect_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arrestation DROP FOREIGN KEY FK_4C6ACFF271812EB2');
        $this->addSql('DROP INDEX IDX_4C6ACFF271812EB2 ON arrestation');
        $this->addSql('ALTER TABLE arrestation DROP suspect_id');
    }
}
