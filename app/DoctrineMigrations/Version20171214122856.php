<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171214122856 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pid CHANGE budgetrequested budgetrequested NUMERIC(10, 2) NOT NULL, CHANGE budgetspent budgetspent NUMERIC(10, 2) NOT NULL, CHANGE budgetallocated budgetallocated NUMERIC(10, 2) NOT NULL, CHANGE remainingamount remainingamount NUMERIC(10, 2) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pid CHANGE budgetrequested budgetrequested VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE budgetspent budgetspent VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE budgetallocated budgetallocated VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE remainingamount remainingamount VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
