<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230324074101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE testimonial (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, author_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, update_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_published TINYINT(1) DEFAULT NULL, INDEX IDX_E6BDCDF7C4663E4 (page_id), INDEX IDX_E6BDCDF7F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE testimonial ADD CONSTRAINT FK_E6BDCDF7C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE testimonial ADD CONSTRAINT FK_E6BDCDF7F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE testimonial DROP FOREIGN KEY FK_E6BDCDF7C4663E4');
        $this->addSql('ALTER TABLE testimonial DROP FOREIGN KEY FK_E6BDCDF7F675F31B');
        $this->addSql('DROP TABLE testimonial');
    }
}
