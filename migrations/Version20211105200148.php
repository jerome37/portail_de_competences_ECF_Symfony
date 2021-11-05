<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211105200148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE disk');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE natio');
        $this->addSql('DROP TABLE pl');
        $this->addSql('DROP TABLE sortie');
        $this->addSql('DROP TABLE type');
        $this->addSql('ALTER TABLE profile CHANGE phone phone VARCHAR(45) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE disk (Numéro INT AUTO_INCREMENT NOT NULL, num DOUBLE PRECISION DEFAULT NULL, Gro VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, Alb VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, Lab VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, Typ VARCHAR(1) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, Gen VARCHAR(1) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, Local INT DEFAULT 0, Natio VARCHAR(1) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, Datea DATETIME DEFAULT NULL, cpt DOUBLE PRECISION DEFAULT NULL, Sortie VARCHAR(1) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, Snom VARCHAR(20) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, Sdate DATETIME DEFAULT NULL, disk_sem TINYINT(1) DEFAULT NULL, concert TINYINT(1) DEFAULT NULL, Aucard TINYINT(1) DEFAULT NULL, INDEX num (num), PRIMARY KEY(Numéro)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE genre (cod_genre INT AUTO_INCREMENT NOT NULL, genre VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, lib VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(cod_genre)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE natio (cod_natio INT AUTO_INCREMENT NOT NULL, natio VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, lib VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, INDEX natio (natio), INDEX cod_natio (cod_natio)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pl (num INT AUTO_INCREMENT NOT NULL, DATSAIS DATETIME DEFAULT NULL, GUS VARCHAR(10) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, D1 DOUBLE PRECISION DEFAULT NULL, D2 DOUBLE PRECISION DEFAULT NULL, D3 DOUBLE PRECISION DEFAULT NULL, D4 DOUBLE PRECISION DEFAULT NULL, D5 DOUBLE PRECISION DEFAULT NULL, D6 DOUBLE PRECISION DEFAULT NULL, D7 DOUBLE PRECISION DEFAULT NULL, D8 DOUBLE PRECISION DEFAULT NULL, D9 DOUBLE PRECISION DEFAULT NULL, D10 DOUBLE PRECISION DEFAULT NULL, D11 DOUBLE PRECISION DEFAULT NULL, D12 DOUBLE PRECISION DEFAULT NULL, D13 DOUBLE PRECISION DEFAULT NULL, D14 DOUBLE PRECISION DEFAULT NULL, D15 DOUBLE PRECISION DEFAULT NULL, D16 DOUBLE PRECISION DEFAULT NULL, D17 DOUBLE PRECISION DEFAULT NULL, D18 DOUBLE PRECISION DEFAULT NULL, D19 DOUBLE PRECISION DEFAULT NULL, D20 DOUBLE PRECISION DEFAULT NULL, D21 DOUBLE PRECISION DEFAULT NULL, D22 DOUBLE PRECISION DEFAULT NULL, D23 DOUBLE PRECISION DEFAULT NULL, D24 DOUBLE PRECISION DEFAULT NULL, D25 DOUBLE PRECISION DEFAULT NULL, D26 DOUBLE PRECISION DEFAULT NULL, D27 DOUBLE PRECISION DEFAULT NULL, D28 DOUBLE PRECISION DEFAULT NULL, D29 DOUBLE PRECISION DEFAULT NULL, D30 DOUBLE PRECISION DEFAULT NULL, D31 DOUBLE PRECISION DEFAULT NULL, D32 DOUBLE PRECISION DEFAULT NULL, D33 DOUBLE PRECISION DEFAULT NULL, D34 DOUBLE PRECISION DEFAULT NULL, D35 DOUBLE PRECISION DEFAULT NULL, D36 DOUBLE PRECISION DEFAULT NULL, D37 DOUBLE PRECISION DEFAULT NULL, D38 DOUBLE PRECISION DEFAULT NULL, D39 DOUBLE PRECISION DEFAULT NULL, D40 DOUBLE PRECISION DEFAULT NULL, D41 DOUBLE PRECISION DEFAULT NULL, D42 DOUBLE PRECISION DEFAULT NULL, D43 DOUBLE PRECISION DEFAULT NULL, D44 DOUBLE PRECISION DEFAULT NULL, D45 DOUBLE PRECISION DEFAULT NULL, D46 DOUBLE PRECISION DEFAULT NULL, D47 DOUBLE PRECISION DEFAULT NULL, D48 DOUBLE PRECISION DEFAULT NULL, D49 DOUBLE PRECISION DEFAULT NULL, D50 DOUBLE PRECISION DEFAULT NULL, D51 DOUBLE PRECISION DEFAULT NULL, D52 DOUBLE PRECISION DEFAULT NULL, INDEX DATSAIS (DATSAIS, GUS), PRIMARY KEY(num)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sortie (cod_sortie INT AUTO_INCREMENT NOT NULL, sortie VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, lib VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, INDEX sortie (sortie), INDEX cod_sortie (cod_sortie)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE type (cod_type INT AUTO_INCREMENT NOT NULL, type VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, lib VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(cod_type)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('ALTER TABLE profile CHANGE phone phone INT NOT NULL');
    }
}