<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200401124440 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE post_photo (post_id INT NOT NULL, photo_id INT NOT NULL, INDEX IDX_83AC08F74B89032C (post_id), INDEX IDX_83AC08F77E9E4C8C (photo_id), PRIMARY KEY(post_id, photo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post_photo ADD CONSTRAINT FK_83AC08F74B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_photo ADD CONSTRAINT FK_83AC08F77E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE photo_post');
        $this->addSql('ALTER TABLE user CHANGE photo photo VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE photo_post (photo_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_DBBBDE797E9E4C8C (photo_id), INDEX IDX_DBBBDE794B89032C (post_id), PRIMARY KEY(photo_id, post_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE photo_post ADD CONSTRAINT FK_DBBBDE794B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo_post ADD CONSTRAINT FK_DBBBDE797E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE post_photo');
        $this->addSql('ALTER TABLE user CHANGE photo photo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
