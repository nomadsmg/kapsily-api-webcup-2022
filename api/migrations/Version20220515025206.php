<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220515025206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `media` (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', user_capsule_uuid BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_6A2CA10CB00FC7C9 (user_capsule_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `media` ADD CONSTRAINT FK_6A2CA10CB00FC7C9 FOREIGN KEY (user_capsule_uuid) REFERENCES user_capsule (uuid)');
        $this->addSql('ALTER TABLE user_capsule CHANGE type type VARCHAR(50) DEFAULT NULL, CHANGE lifetime lifetime INT DEFAULT NULL, CHANGE location location VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `media`');
        $this->addSql('ALTER TABLE user_capsule CHANGE type type VARCHAR(50) NOT NULL, CHANGE lifetime lifetime INT NOT NULL, CHANGE location location LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
    }
}
