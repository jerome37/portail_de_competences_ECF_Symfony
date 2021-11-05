<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211019183346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile_skill ADD skill_id INT NOT NULL, ADD profile_id INT NOT NULL');
        $this->addSql('ALTER TABLE profile_skill ADD CONSTRAINT FK_A9E97BA55585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE profile_skill ADD CONSTRAINT FK_A9E97BA5CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('CREATE INDEX IDX_A9E97BA55585C142 ON profile_skill (skill_id)');
        $this->addSql('CREATE INDEX IDX_A9E97BA5CCFA12B8 ON profile_skill (profile_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile_skill DROP FOREIGN KEY FK_A9E97BA55585C142');
        $this->addSql('ALTER TABLE profile_skill DROP FOREIGN KEY FK_A9E97BA5CCFA12B8');
        $this->addSql('DROP INDEX IDX_A9E97BA55585C142 ON profile_skill');
        $this->addSql('DROP INDEX IDX_A9E97BA5CCFA12B8 ON profile_skill');
        $this->addSql('ALTER TABLE profile_skill DROP skill_id, DROP profile_id');
    }
}
