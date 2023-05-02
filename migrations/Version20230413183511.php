<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230413183511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE INDEX IDX_169E6FB9301E8B39 ON course (un_organisateur_id)');
        $this->addSql('ALTER TABLE user ADD est_organisateur TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9301E8B39');
        $this->addSql('DROP INDEX IDX_169E6FB9301E8B39 ON course');
        $this->addSql('ALTER TABLE course DROP un_organisateur_id');
        $this->addSql('ALTER TABLE user DROP est_organisateur');
    }
}
