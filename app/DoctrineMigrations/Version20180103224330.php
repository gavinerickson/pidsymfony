<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180103224330 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pid CHANGE deadline deadline DATE NOT NULL');
        $this->addSql('ALTER TABLE user ADD linemanager_id INT DEFAULT NULL, DROP linemanager');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64985A16E0C FOREIGN KEY (linemanager_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64985A16E0C ON user (linemanager_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pid CHANGE deadline deadline DATE DEFAULT \'1990-01-01\' NOT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64985A16E0C');
        $this->addSql('DROP INDEX UNIQ_8D93D64985A16E0C ON user');
        $this->addSql('ALTER TABLE user ADD linemanager VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP linemanager_id');
    }
}
