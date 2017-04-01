<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170129152642 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, url_id INT DEFAULT NULL, browsers LONGTEXT NOT NULL, referrers LONGTEXT NOT NULL, ip LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_27BA704B81CFDAE7 (url_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE url (id INT AUTO_INCREMENT NOT NULL, url LONGTEXT NOT NULL, short_url LONGTEXT NOT NULL, created_at DATETIME NOT NULL, clicks INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704B81CFDAE7 FOREIGN KEY (url_id) REFERENCES url (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704B81CFDAE7');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE url');
    }
}
