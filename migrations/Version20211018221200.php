<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211018221200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile DROP INDEX UNIQ_8157AA0FFDEF8996, ADD INDEX IDX_8157AA0FFDEF8996 (profession_id)');
        $this->addSql('ALTER TABLE profile ADD status_id INT NOT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_8157AA0F6BF700BD ON profile (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile DROP INDEX IDX_8157AA0FFDEF8996, ADD UNIQUE INDEX UNIQ_8157AA0FFDEF8996 (profession_id)');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F6BF700BD');
        $this->addSql('DROP INDEX IDX_8157AA0F6BF700BD ON profile');
        $this->addSql('ALTER TABLE profile DROP status_id');
    }
}
