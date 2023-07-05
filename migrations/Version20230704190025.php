<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230704190025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE judiciary_case (id INT AUTO_INCREMENT NOT NULL, suspect_id INT DEFAULT NULL, date DATETIME NOT NULL, decision LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_4AC3B78871812EB2 (suspect_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE judiciary_case_user (judiciary_case_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_48FAA4B4208E2437 (judiciary_case_id), INDEX IDX_48FAA4B4A76ED395 (user_id), PRIMARY KEY(judiciary_case_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE judiciary_case ADD CONSTRAINT FK_4AC3B78871812EB2 FOREIGN KEY (suspect_id) REFERENCES civil (id)');
        $this->addSql('ALTER TABLE judiciary_case_user ADD CONSTRAINT FK_48FAA4B4208E2437 FOREIGN KEY (judiciary_case_id) REFERENCES judiciary_case (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE judiciary_case_user ADD CONSTRAINT FK_48FAA4B4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE arrestation ADD judiciary_case_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE arrestation ADD CONSTRAINT FK_4C6ACFF2208E2437 FOREIGN KEY (judiciary_case_id) REFERENCES judiciary_case (id)');
        $this->addSql('CREATE INDEX IDX_4C6ACFF2208E2437 ON arrestation (judiciary_case_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arrestation DROP FOREIGN KEY FK_4C6ACFF2208E2437');
        $this->addSql('ALTER TABLE judiciary_case DROP FOREIGN KEY FK_4AC3B78871812EB2');
        $this->addSql('ALTER TABLE judiciary_case_user DROP FOREIGN KEY FK_48FAA4B4208E2437');
        $this->addSql('ALTER TABLE judiciary_case_user DROP FOREIGN KEY FK_48FAA4B4A76ED395');
        $this->addSql('DROP TABLE judiciary_case');
        $this->addSql('DROP TABLE judiciary_case_user');
        $this->addSql('DROP INDEX IDX_4C6ACFF2208E2437 ON arrestation');
        $this->addSql('ALTER TABLE arrestation DROP judiciary_case_id');
    }
}
