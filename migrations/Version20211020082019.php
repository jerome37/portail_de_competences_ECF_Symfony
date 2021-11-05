<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211020082019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experience ADD type_id INT NOT NULL');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C103C54C8C93 FOREIGN KEY (type_id) REFERENCES type_experience (id)');
        $this->addSql('CREATE INDEX IDX_590C103C54C8C93 ON experience (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C103C54C8C93');
        $this->addSql('DROP INDEX IDX_590C103C54C8C93 ON experience');
        $this->addSql('ALTER TABLE experience DROP type_id');
    }
}
