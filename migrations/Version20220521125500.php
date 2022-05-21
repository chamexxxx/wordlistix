<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220521125500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comparison (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, dictionary_id INTEGER NOT NULL, image VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_E54AC6D6AF5E5B3C ON comparison (dictionary_id)');
        $this->addSql('CREATE TABLE dictionary (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1FA0E5265E237E06 ON dictionary (name)');
        $this->addSql('CREATE TABLE word (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, comparison_id INTEGER NOT NULL, language_code VARCHAR(255) NOT NULL, text VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_C3F17511E4EC5411 ON word (comparison_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comparison');
        $this->addSql('DROP TABLE dictionary');
        $this->addSql('DROP TABLE word');
    }
}
