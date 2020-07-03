<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200702234322 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, document VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, cellphone VARCHAR(255) NOT NULL, tdoc VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transactions (id INT AUTO_INCREMENT NOT NULL, wallet_id INT DEFAULT NULL, value DOUBLE PRECISION NOT NULL, INDEX IDX_EAA81A4C712520F3 (wallet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wallets (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, balance DOUBLE PRECISION NOT NULL, dinamic_token INT DEFAULT NULL, INDEX IDX_967AAA6C19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C712520F3 FOREIGN KEY (wallet_id) REFERENCES wallets (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wallets ADD CONSTRAINT FK_967AAA6C19EB6921 FOREIGN KEY (client_id) REFERENCES clients (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wallets DROP FOREIGN KEY FK_967AAA6C19EB6921');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4C712520F3');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE transactions');
        $this->addSql('DROP TABLE wallets');
    }
}
