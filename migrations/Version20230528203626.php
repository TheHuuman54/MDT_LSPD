<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230528203626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE arrestation_sentences (arrestation_id INT NOT NULL, sentences_id INT NOT NULL, INDEX IDX_11F11D4031042105 (arrestation_id), INDEX IDX_11F11D40175906F5 (sentences_id), PRIMARY KEY(arrestation_id, sentences_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE arrestation_sentences ADD CONSTRAINT FK_11F11D4031042105 FOREIGN KEY (arrestation_id) REFERENCES arrestation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE arrestation_sentences ADD CONSTRAINT FK_11F11D40175906F5 FOREIGN KEY (sentences_id) REFERENCES sentences (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arrestation_sentences DROP FOREIGN KEY FK_11F11D4031042105');
        $this->addSql('ALTER TABLE arrestation_sentences DROP FOREIGN KEY FK_11F11D40175906F5');
        $this->addSql('DROP TABLE arrestation_sentences');
    }
}
