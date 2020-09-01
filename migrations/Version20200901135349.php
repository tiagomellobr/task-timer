<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200901135349 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__task AS SELECT id, title, description FROM task');
        $this->addSql('DROP TABLE task');
        $this->addSql('CREATE TABLE task (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, project_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_527EDB25166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO task (id, title, description) SELECT id, title, description FROM __temp__task');
        $this->addSql('DROP TABLE __temp__task');
        $this->addSql('CREATE INDEX IDX_527EDB25166D1F9C ON task (project_id)');
        $this->addSql('DROP INDEX IDX_6AD0DE1A8DB60186');
        $this->addSql('CREATE TEMPORARY TABLE __temp__timer AS SELECT id, task_id, start_record, end_record FROM timer');
        $this->addSql('DROP TABLE timer');
        $this->addSql('CREATE TABLE timer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, task_id INTEGER NOT NULL, start_record DATETIME NOT NULL, end_record DATETIME DEFAULT NULL, CONSTRAINT FK_6AD0DE1A8DB60186 FOREIGN KEY (task_id) REFERENCES task (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO timer (id, task_id, start_record, end_record) SELECT id, task_id, start_record, end_record FROM __temp__timer');
        $this->addSql('DROP TABLE __temp__timer');
        $this->addSql('CREATE INDEX IDX_6AD0DE1A8DB60186 ON timer (task_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP INDEX IDX_527EDB25166D1F9C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__task AS SELECT id, title, description FROM task');
        $this->addSql('DROP TABLE task');
        $this->addSql('CREATE TABLE task (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO task (id, title, description) SELECT id, title, description FROM __temp__task');
        $this->addSql('DROP TABLE __temp__task');
        $this->addSql('DROP INDEX IDX_6AD0DE1A8DB60186');
        $this->addSql('CREATE TEMPORARY TABLE __temp__timer AS SELECT id, task_id, start_record, end_record FROM timer');
        $this->addSql('DROP TABLE timer');
        $this->addSql('CREATE TABLE timer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, task_id INTEGER NOT NULL, start_record DATETIME NOT NULL, end_record DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO timer (id, task_id, start_record, end_record) SELECT id, task_id, start_record, end_record FROM __temp__timer');
        $this->addSql('DROP TABLE __temp__timer');
        $this->addSql('CREATE INDEX IDX_6AD0DE1A8DB60186 ON timer (task_id)');
    }
}
