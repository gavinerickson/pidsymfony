<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171123072640 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pid ADD owner_id INT NOT NULL, DROP owner');
        $this->addSql('ALTER TABLE pid ADD CONSTRAINT FK_5550C4ED7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5550C4ED7E3C61F9 ON pid (owner_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pid DROP FOREIGN KEY FK_5550C4ED7E3C61F9');
        $this->addSql('DROP INDEX IDX_5550C4ED7E3C61F9 ON pid');
        $this->addSql('ALTER TABLE pid ADD owner VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP owner_id');
    }
}
