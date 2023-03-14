<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307160736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_course ADD niveau_course VARCHAR(255) NOT NULL, ADD type_course VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE course ADD nom_course VARCHAR(255) NOT NULL, ADD distance DOUBLE PRECISION NOT NULL, ADD pix DOUBLE PRECISION NOT NULL, ADD date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE point ADD nombre INT NOT NULL');
        $this->addSql('ALTER TABLE recompense ADD label VARCHAR(255) NOT NULL, ADD valeur DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE resultat_course ADD temps TIME NOT NULL, ADD vitesse_moyenne DOUBLE PRECISION NOT NULL, ADD position VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD pseudo VARCHAR(255) NOT NULL, ADD adresse VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_course DROP niveau_course, DROP type_course');
        $this->addSql('ALTER TABLE course DROP nom_course, DROP distance, DROP pix, DROP date');
        $this->addSql('ALTER TABLE point DROP nombre');
        $this->addSql('ALTER TABLE recompense DROP label, DROP valeur');
        $this->addSql('ALTER TABLE resultat_course DROP temps, DROP vitesse_moyenne, DROP position');
        $this->addSql('ALTER TABLE `user` DROP nom, DROP prenom, DROP email, DROP pseudo, DROP adresse');
    }
}
