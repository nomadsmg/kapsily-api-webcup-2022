<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220514192549PricingOfferPlan extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Pricing offer plan';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE offer (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', identifier VARCHAR(25) NOT NULL, name VARCHAR(150) NOT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pricing_plan (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', identifier VARCHAR(25) NOT NULL, label VARCHAR(100) NOT NULL, level INT NOT NULL, description LONGTEXT DEFAULT NULL, minds INT NOT NULL, years INT NOT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pricing_plan_offer (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', offer_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', pricing_plan_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_516A09242F877EB1 (offer_uuid), INDEX IDX_516A09246A38E8EE (pricing_plan_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pricing_plan_offer ADD CONSTRAINT FK_516A09242F877EB1 FOREIGN KEY (offer_uuid) REFERENCES offer (uuid)');
        $this->addSql('ALTER TABLE pricing_plan_offer ADD CONSTRAINT FK_516A09246A38E8EE FOREIGN KEY (pricing_plan_uuid) REFERENCES pricing_plan (uuid)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE pricing_plan_offer DROP FOREIGN KEY FK_516A09242F877EB1');
        $this->addSql('ALTER TABLE pricing_plan_offer DROP FOREIGN KEY FK_516A09246A38E8EE');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE pricing_plan');
        $this->addSql('DROP TABLE pricing_plan_offer');
    }
}
