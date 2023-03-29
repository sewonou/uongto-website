<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230327061006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD second_image VARCHAR(255) DEFAULT NULL, ADD third_image VARCHAR(255) DEFAULT NULL, ADD fourth_image VARCHAR(255) DEFAULT NULL, ADD firth_image VARCHAR(255) DEFAULT NULL, ADD first_document VARCHAR(255) DEFAULT NULL, ADD second_document VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP second_image, DROP third_image, DROP fourth_image, DROP firth_image, DROP first_document, DROP second_document');
    }
}
