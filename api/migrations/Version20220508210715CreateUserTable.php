<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220508221245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create User table with the basic column for the login_link authentication feature';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE `user` (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', lastname VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, api_token VARCHAR(255) DEFAULT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `user`');
    }
}
