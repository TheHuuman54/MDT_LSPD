<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230629183804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ethnie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gender (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE civil ADD type_id INT DEFAULT NULL, ADD gender_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE civil ADD CONSTRAINT FK_FED9AB76C54C8C93 FOREIGN KEY (type_id) REFERENCES ethnie (id)');
        $this->addSql('ALTER TABLE civil ADD CONSTRAINT FK_FED9AB76708A0E0 FOREIGN KEY (gender_id) REFERENCES gender (id)');
        $this->addSql('CREATE INDEX IDX_FED9AB76C54C8C93 ON civil (type_id)');
        $this->addSql('CREATE INDEX IDX_FED9AB76708A0E0 ON civil (gender_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE civil DROP FOREIGN KEY FK_FED9AB76C54C8C93');
        $this->addSql('ALTER TABLE civil DROP FOREIGN KEY FK_FED9AB76708A0E0');
        $this->addSql('DROP TABLE ethnie');
        $this->addSql('DROP TABLE gender');
        $this->addSql('DROP INDEX IDX_FED9AB76C54C8C93 ON civil');
        $this->addSql('DROP INDEX IDX_FED9AB76708A0E0 ON civil');
        $this->addSql('ALTER TABLE civil DROP type_id, DROP gender_id');
    }
}
