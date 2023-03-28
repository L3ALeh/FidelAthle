<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321143445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, un_niveau_course_id INT NOT NULL, un_type_course_id INT NOT NULL, nom_course VARCHAR(255) NOT NULL, distance DOUBLE PRECISION NOT NULL, prix DOUBLE PRECISION NOT NULL, date DATETIME NOT NULL, INDEX IDX_169E6FB99499657 (un_niveau_course_id), INDEX IDX_169E6FB9A6467E84 (un_type_course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau_course (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE point (id INT AUTO_INCREMENT NOT NULL, le_user_id INT NOT NULL, la_recompense_id INT DEFAULT NULL, nombre INT NOT NULL, INDEX IDX_B7A5F32488A1A5E2 (le_user_id), INDEX IDX_B7A5F324BA87F26E (la_recompense_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recompense (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, valeur DOUBLE PRECISION NOT NULL, valeur_points INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultat_course (id INT AUTO_INCREMENT NOT NULL, une_course_id INT NOT NULL, le_user_id INT NOT NULL, temps TIME NOT NULL, vitesse_moyenne DOUBLE PRECISION NOT NULL, position VARCHAR(255) NOT NULL, INDEX IDX_7E0F13E4BF450C80 (une_course_id), INDEX IDX_7E0F13E488A1A5E2 (le_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_course (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB99499657 FOREIGN KEY (un_niveau_course_id) REFERENCES niveau_course (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9A6467E84 FOREIGN KEY (un_type_course_id) REFERENCES type_course (id)');
        $this->addSql('ALTER TABLE point ADD CONSTRAINT FK_B7A5F32488A1A5E2 FOREIGN KEY (le_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE point ADD CONSTRAINT FK_B7A5F324BA87F26E FOREIGN KEY (la_recompense_id) REFERENCES recompense (id)');
        $this->addSql('ALTER TABLE resultat_course ADD CONSTRAINT FK_7E0F13E4BF450C80 FOREIGN KEY (une_course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE resultat_course ADD CONSTRAINT FK_7E0F13E488A1A5E2 FOREIGN KEY (le_user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB99499657');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9A6467E84');
        $this->addSql('ALTER TABLE point DROP FOREIGN KEY FK_B7A5F32488A1A5E2');
        $this->addSql('ALTER TABLE point DROP FOREIGN KEY FK_B7A5F324BA87F26E');
        $this->addSql('ALTER TABLE resultat_course DROP FOREIGN KEY FK_7E0F13E4BF450C80');
        $this->addSql('ALTER TABLE resultat_course DROP FOREIGN KEY FK_7E0F13E488A1A5E2');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE niveau_course');
        $this->addSql('DROP TABLE point');
        $this->addSql('DROP TABLE recompense');
        $this->addSql('DROP TABLE resultat_course');
        $this->addSql('DROP TABLE type_course');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
