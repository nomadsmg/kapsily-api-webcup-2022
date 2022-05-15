<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220515005011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_capsule (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', user_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', type VARCHAR(50) NOT NULL, lifetime INT NOT NULL, location LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', note LONGTEXT DEFAULT NULL, auto_destroy_after INT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_9A65BF89ABFE1C6F (user_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_capsule ADD CONSTRAINT FK_9A65BF89ABFE1C6F FOREIGN KEY (user_uuid) REFERENCES `user` (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_capsule');
    }
}
