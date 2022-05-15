<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220514223939CreateUserBalanceTransaction extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create User Balance transaction';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE balance_transaction (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', user_balance_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', type VARCHAR(50) NOT NULL, initialized_at DATETIME NOT NULL, INDEX IDX_A70FE7334397DDA3 (user_balance_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_balance (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', user_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', current DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_F4F901F4ABFE1C6F (user_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE balance_transaction ADD CONSTRAINT FK_A70FE7334397DDA3 FOREIGN KEY (user_balance_uuid) REFERENCES user_balance (uuid)');
        $this->addSql('ALTER TABLE user_balance ADD CONSTRAINT FK_F4F901F4ABFE1C6F FOREIGN KEY (user_uuid) REFERENCES `user` (uuid)');
        $this->addSql('ALTER TABLE plan_payment ADD balance_transaction_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE plan_payment ADD CONSTRAINT FK_D397CC05CB69F679 FOREIGN KEY (balance_transaction_uuid) REFERENCES balance_transaction (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D397CC05CB69F679 ON plan_payment (balance_transaction_uuid)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE plan_payment DROP FOREIGN KEY FK_D397CC05CB69F679');
        $this->addSql('ALTER TABLE balance_transaction DROP FOREIGN KEY FK_A70FE7334397DDA3');
        $this->addSql('DROP TABLE balance_transaction');
        $this->addSql('DROP TABLE user_balance');
        $this->addSql('DROP INDEX UNIQ_D397CC05CB69F679 ON plan_payment');
        $this->addSql('ALTER TABLE plan_payment DROP balance_transaction_uuid');
    }
}
