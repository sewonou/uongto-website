<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230326014151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE historic (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, year VARCHAR(30) DEFAULT NULL, description LONGTEXT DEFAULT NULL, update_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_published TINYINT(1) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, INDEX IDX_AD52EF56F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historic ADD CONSTRAINT FK_AD52EF56F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historic DROP FOREIGN KEY FK_AD52EF56F675F31B');
        $this->addSql('DROP TABLE historic');
    }
}
