<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230306082055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personality ADD page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personality ADD CONSTRAINT FK_E1CF90AEC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('CREATE INDEX IDX_E1CF90AEC4663E4 ON personality (page_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personality DROP FOREIGN KEY FK_E1CF90AEC4663E4');
        $this->addSql('DROP INDEX IDX_E1CF90AEC4663E4 ON personality');
        $this->addSql('ALTER TABLE personality DROP page_id');
    }
}
