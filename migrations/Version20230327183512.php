<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230327183512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, short_name VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, year INT DEFAULT NULL, facebook_url VARCHAR(255) DEFAULT NULL, twitter_url VARCHAR(255) DEFAULT NULL, linked_in_url VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, update_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_published TINYINT(1) DEFAULT NULL, INDEX IDX_70E4FA7898260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member_thematic (member_id INT NOT NULL, thematic_id INT NOT NULL, INDEX IDX_8BC17C987597D3FE (member_id), INDEX IDX_8BC17C982395FCED (thematic_id), PRIMARY KEY(member_id, thematic_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA7898260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE member_thematic ADD CONSTRAINT FK_8BC17C987597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_thematic ADD CONSTRAINT FK_8BC17C982395FCED FOREIGN KEY (thematic_id) REFERENCES thematic (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA7898260155');
        $this->addSql('ALTER TABLE member_thematic DROP FOREIGN KEY FK_8BC17C987597D3FE');
        $this->addSql('ALTER TABLE member_thematic DROP FOREIGN KEY FK_8BC17C982395FCED');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE member_thematic');
    }
}
