<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220514204522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plan_payment (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', user_plan_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', initialized_at DATETIME NOT NULL, status VARCHAR(50) NOT NULL, INDEX IDX_D397CC05C44911B0 (user_plan_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_plan (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', user_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', pricing_plan_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', attachment_date DATETIME NOT NULL, canceled_at DATETIME DEFAULT NULL, INDEX IDX_A7DB17B4ABFE1C6F (user_uuid), INDEX IDX_A7DB17B46A38E8EE (pricing_plan_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE plan_payment ADD CONSTRAINT FK_D397CC05C44911B0 FOREIGN KEY (user_plan_uuid) REFERENCES user_plan (uuid)');
        $this->addSql('ALTER TABLE user_plan ADD CONSTRAINT FK_A7DB17B4ABFE1C6F FOREIGN KEY (user_uuid) REFERENCES `user` (uuid)');
        $this->addSql('ALTER TABLE user_plan ADD CONSTRAINT FK_A7DB17B46A38E8EE FOREIGN KEY (pricing_plan_uuid) REFERENCES pricing_plan (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plan_payment DROP FOREIGN KEY FK_D397CC05C44911B0');
        $this->addSql('DROP TABLE plan_payment');
        $this->addSql('DROP TABLE user_plan');
    }
}
