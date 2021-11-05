<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211018213607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE profile ADD profession_id INT NOT NULL');
        // $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FFDEF8996 FOREIGN KEY (profession_id) REFERENCES profession (id)');
        // $this->addSql('CREATE UNIQUE INDEX UNIQ_8157AA0FFDEF8996 ON profile (profession_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FFDEF8996');
        $this->addSql('DROP INDEX UNIQ_8157AA0FFDEF8996 ON profile');
        $this->addSql('ALTER TABLE profile DROP profession_id');
    }
}
