<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308164536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_option (category_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_556ECACB12469DE2 (category_id), INDEX IDX_556ECACBA7C41D6F (option_id), PRIMARY KEY(category_id, option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_option ADD CONSTRAINT FK_556ECACB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_option ADD CONSTRAINT FK_556ECACBA7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1C54C8C93');
        $this->addSql('DROP INDEX IDX_64C19C1C54C8C93 ON category');
        $this->addSql('ALTER TABLE category DROP type_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_option DROP FOREIGN KEY FK_556ECACB12469DE2');
        $this->addSql('ALTER TABLE category_option DROP FOREIGN KEY FK_556ECACBA7C41D6F');
        $this->addSql('DROP TABLE category_option');
        $this->addSql('ALTER TABLE category ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1C54C8C93 FOREIGN KEY (type_id) REFERENCES `option` (id)');
        $this->addSql('CREATE INDEX IDX_64C19C1C54C8C93 ON category (type_id)');
    }
}
