<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230327123814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP quote, DROP content_intro');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD quote LONGTEXT DEFAULT NULL, ADD content_intro LONGTEXT DEFAULT NULL, DROP created_at');
    }
}
