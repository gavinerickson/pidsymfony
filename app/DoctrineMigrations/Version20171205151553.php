<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171205151553 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pid CHANGE approval approval VARCHAR(255) DEFAULT NULL, CHANGE budgetrequested budgetrequested VARCHAR(255) DEFAULT NULL, CHANGE budgetspent budgetspent VARCHAR(255) DEFAULT NULL, CHANGE budgetallocated budgetallocated VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE task CHANGE description description VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pid CHANGE approval approval VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE budgetrequested budgetrequested VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE budgetspent budgetspent VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE budgetallocated budgetallocated VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE task CHANGE description description VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
