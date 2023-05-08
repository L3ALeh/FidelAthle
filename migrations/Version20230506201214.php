<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<<< HEAD:migrations/Version20230502090419.php
final class Version20230502090419 extends AbstractMigration
========
final class Version20230506201214 extends AbstractMigration
>>>>>>>> e2f661e81e0c2c3970fb9739001ec0c2c876bb01:migrations/Version20230506201214.php
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9301E8B39 FOREIGN KEY (un_organisateur_id) REFERENCES user (id)');
<<<<<<<< HEAD:migrations/Version20230502090419.php
========
        $this->addSql('ALTER TABLE resultat_course ADD classement_definitif TINYINT(1) NOT NULL');
>>>>>>>> e2f661e81e0c2c3970fb9739001ec0c2c876bb01:migrations/Version20230506201214.php
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9301E8B39');
<<<<<<<< HEAD:migrations/Version20230502090419.php
========
        $this->addSql('ALTER TABLE resultat_course DROP classement_definitif');
>>>>>>>> e2f661e81e0c2c3970fb9739001ec0c2c876bb01:migrations/Version20230506201214.php
    }
}
