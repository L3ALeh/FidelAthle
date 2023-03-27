<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321135901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9F51AA87');
        $this->addSql('CREATE TABLE niveau_course (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_course (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE categorie_course');
        $this->addSql('DROP INDEX IDX_169E6FB9F51AA87 ON course');
        $this->addSql('ALTER TABLE course ADD un_type_course_id INT NOT NULL, CHANGE une_categorie_course_id un_niveau_course_id INT NOT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB99499657 FOREIGN KEY (un_niveau_course_id) REFERENCES niveau_course (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9A6467E84 FOREIGN KEY (un_type_course_id) REFERENCES type_course (id)');
        $this->addSql('CREATE INDEX IDX_169E6FB99499657 ON course (un_niveau_course_id)');
        $this->addSql('CREATE INDEX IDX_169E6FB9A6467E84 ON course (un_type_course_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB99499657');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9A6467E84');
        $this->addSql('CREATE TABLE categorie_course (id INT AUTO_INCREMENT NOT NULL, niveau_course VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type_course VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE niveau_course');
        $this->addSql('DROP TABLE type_course');
        $this->addSql('DROP INDEX IDX_169E6FB99499657 ON course');
        $this->addSql('DROP INDEX IDX_169E6FB9A6467E84 ON course');
        $this->addSql('ALTER TABLE course ADD une_categorie_course_id INT NOT NULL, DROP un_niveau_course_id, DROP un_type_course_id');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9F51AA87 FOREIGN KEY (une_categorie_course_id) REFERENCES categorie_course (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_169E6FB9F51AA87 ON course (une_categorie_course_id)');
    }
}
