<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230528184333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE arrestation (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, suspect_name VARCHAR(255) NOT NULL, height VARCHAR(255) DEFAULT NULL, tel_number VARCHAR(255) DEFAULT NULL, id_unique INT NOT NULL, id_card VARCHAR(255) DEFAULT NULL, birthday DATE DEFAULT NULL, job VARCHAR(255) NOT NULL, observation LONGTEXT DEFAULT NULL, gav_start DATETIME NOT NULL, gav_end DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE arrestation');
    }
}
