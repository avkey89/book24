<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201030160351 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE balance (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, balance INT NOT NULL, UNIQUE INDEX UNIQ_ACF41FFEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, debit_balance_id INT DEFAULT NULL, credit_balance_id INT DEFAULT NULL, date DATETIME NOT NULL, amount INT NOT NULL, INDEX IDX_723705D115B6B2CD (debit_balance_id), INDEX IDX_723705D15DE91863 (credit_balance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE balance ADD CONSTRAINT FK_ACF41FFEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D115B6B2CD FOREIGN KEY (debit_balance_id) REFERENCES balance (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D15DE91863 FOREIGN KEY (credit_balance_id) REFERENCES balance (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D115B6B2CD');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D15DE91863');
        $this->addSql('ALTER TABLE balance DROP FOREIGN KEY FK_ACF41FFEA76ED395');
        $this->addSql('DROP TABLE balance');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE user');
    }
}
