<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190714152130 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE chat_message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, distenation_id INTEGER NOT NULL, message CLOB NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_FAB3FC16F675F31B ON chat_message (author_id)');
        $this->addSql('CREATE INDEX IDX_FAB3FC161EA3835 ON chat_message (distenation_id)');
        $this->addSql('DROP INDEX IDX_CBE5A331F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__book AS SELECT id, author_id, title, pages_count, price, is_delete FROM book');
        $this->addSql('DROP TABLE book');
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, pages_count INTEGER NOT NULL, price DOUBLE PRECISION DEFAULT NULL, is_delete BOOLEAN DEFAULT NULL, CONSTRAINT FK_CBE5A331F675F31B FOREIGN KEY (author_id) REFERENCES shop_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO book (id, author_id, title, pages_count, price, is_delete) SELECT id, author_id, title, pages_count, price, is_delete FROM __temp__book');
        $this->addSql('DROP TABLE __temp__book');
        $this->addSql('CREATE INDEX IDX_CBE5A331F675F31B ON book (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE chat_message');
        $this->addSql('DROP INDEX IDX_CBE5A331F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__book AS SELECT id, author_id, title, pages_count, price, is_delete FROM book');
        $this->addSql('DROP TABLE book');
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, pages_count INTEGER NOT NULL, price DOUBLE PRECISION DEFAULT NULL, is_delete BOOLEAN DEFAULT NULL)');
        $this->addSql('INSERT INTO book (id, author_id, title, pages_count, price, is_delete) SELECT id, author_id, title, pages_count, price, is_delete FROM __temp__book');
        $this->addSql('DROP TABLE __temp__book');
        $this->addSql('CREATE INDEX IDX_CBE5A331F675F31B ON book (author_id)');
    }
}
