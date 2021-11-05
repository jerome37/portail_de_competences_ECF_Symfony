<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211019195731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile_skill ADD level_id INT NOT NULL');
        $this->addSql('ALTER TABLE profile_skill ADD CONSTRAINT FK_A9E97BA55FB14BA7 FOREIGN KEY (level_id) REFERENCES skill_level (id)');
        $this->addSql('CREATE INDEX IDX_A9E97BA55FB14BA7 ON profile_skill (level_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile_skill DROP FOREIGN KEY FK_A9E97BA55FB14BA7');
        $this->addSql('DROP INDEX IDX_A9E97BA55FB14BA7 ON profile_skill');
        $this->addSql('ALTER TABLE profile_skill DROP level_id');
    }
}
