<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200901025334 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE task (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('CREATE TABLE timer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, task_id INTEGER NOT NULL, start_record DATETIME NOT NULL, end_record DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_6AD0DE1A8DB60186 ON timer (task_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE timer');
    }
}
