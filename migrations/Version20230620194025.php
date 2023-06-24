<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230620194025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pictures ADD civil_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pictures ADD CONSTRAINT FK_8F7C2FC084C1DE7E FOREIGN KEY (civil_id) REFERENCES civil (id)');
        $this->addSql('CREATE INDEX IDX_8F7C2FC084C1DE7E ON pictures (civil_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pictures DROP FOREIGN KEY FK_8F7C2FC084C1DE7E');
        $this->addSql('DROP INDEX IDX_8F7C2FC084C1DE7E ON pictures');
        $this->addSql('ALTER TABLE pictures DROP civil_id');
    }
}
