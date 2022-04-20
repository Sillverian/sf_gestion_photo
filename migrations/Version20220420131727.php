<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220420131727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE photo_tag (photo_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_8C2D8E577E9E4C8C (photo_id), INDEX IDX_8C2D8E57BAD26311 (tag_id), PRIMARY KEY(photo_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo_color_code (photo_id INT NOT NULL, color_code_id INT NOT NULL, INDEX IDX_46A6E5D47E9E4C8C (photo_id), INDEX IDX_46A6E5D4744C7339 (color_code_id), PRIMARY KEY(photo_id, color_code_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo_meta_value (photo_id INT NOT NULL, meta_value_id INT NOT NULL, INDEX IDX_BE5500657E9E4C8C (photo_id), INDEX IDX_BE550065B76D43E9 (meta_value_id), PRIMARY KEY(photo_id, meta_value_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE validation (id INT AUTO_INCREMENT NOT NULL, photo_id INT NOT NULL, user_id INT NOT NULL, is_validated TINYINT(1) NOT NULL, INDEX IDX_16AC5B6E7E9E4C8C (photo_id), INDEX IDX_16AC5B6EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photo_tag ADD CONSTRAINT FK_8C2D8E577E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo_tag ADD CONSTRAINT FK_8C2D8E57BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo_color_code ADD CONSTRAINT FK_46A6E5D47E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo_color_code ADD CONSTRAINT FK_46A6E5D4744C7339 FOREIGN KEY (color_code_id) REFERENCES color_code (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo_meta_value ADD CONSTRAINT FK_BE5500657E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo_meta_value ADD CONSTRAINT FK_BE550065B76D43E9 FOREIGN KEY (meta_value_id) REFERENCES meta_value (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE validation ADD CONSTRAINT FK_16AC5B6E7E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id)');
        $this->addSql('ALTER TABLE validation ADD CONSTRAINT FK_16AC5B6EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE photo_tag');
        $this->addSql('DROP TABLE photo_color_code');
        $this->addSql('DROP TABLE photo_meta_value');
        $this->addSql('DROP TABLE validation');
    }
}
