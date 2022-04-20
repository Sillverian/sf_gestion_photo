<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220420094215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE color_code (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, label VARCHAR(30) NOT NULL, color VARCHAR(30) NOT NULL, description VARCHAR(100) NOT NULL, INDEX IDX_AC20BDCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meta_data (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, label VARCHAR(30) NOT NULL, INDEX IDX_3E558020A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE color_code ADD CONSTRAINT FK_AC20BDCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE meta_data ADD CONSTRAINT FK_3E558020A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE color_code');
        $this->addSql('DROP TABLE meta_data');
    }
}
