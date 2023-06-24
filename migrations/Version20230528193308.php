<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230528193308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pictures (id INT AUTO_INCREMENT NOT NULL, arrestation_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_8F7C2FC031042105 (arrestation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pictures ADD CONSTRAINT FK_8F7C2FC031042105 FOREIGN KEY (arrestation_id) REFERENCES arrestation (id)');
        $this->addSql('ALTER TABLE sentences ADD arrestation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sentences ADD CONSTRAINT FK_ED2A8F1E31042105 FOREIGN KEY (arrestation_id) REFERENCES arrestation (id)');
        $this->addSql('CREATE INDEX IDX_ED2A8F1E31042105 ON sentences (arrestation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pictures DROP FOREIGN KEY FK_8F7C2FC031042105');
        $this->addSql('DROP TABLE pictures');
        $this->addSql('ALTER TABLE sentences DROP FOREIGN KEY FK_ED2A8F1E31042105');
        $this->addSql('DROP INDEX IDX_ED2A8F1E31042105 ON sentences');
        $this->addSql('ALTER TABLE sentences DROP arrestation_id');
    }
}
