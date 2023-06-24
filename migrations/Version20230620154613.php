<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230620154613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arrestation DROP suspect_name, DROP height, DROP tel_number, DROP id_unique, DROP birthday, DROP job');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arrestation ADD suspect_name VARCHAR(255) NOT NULL, ADD height VARCHAR(255) DEFAULT NULL, ADD tel_number VARCHAR(255) DEFAULT NULL, ADD id_unique INT NOT NULL, ADD birthday DATE DEFAULT NULL, ADD job VARCHAR(255) NOT NULL');
    }
}
