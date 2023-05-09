<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230508131349 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE obtention (id INT AUTO_INCREMENT NOT NULL, un_user_id INT DEFAULT NULL, une_recompense_id INT NOT NULL, quantite INT NOT NULL, INDEX IDX_7A35A2B3D14F911D (un_user_id), INDEX IDX_7A35A2B32152A79 (une_recompense_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE obtention ADD CONSTRAINT FK_7A35A2B3D14F911D FOREIGN KEY (un_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE obtention ADD CONSTRAINT FK_7A35A2B32152A79 FOREIGN KEY (une_recompense_id) REFERENCES recompense (id)');
        $this->addSql('ALTER TABLE user_recompense DROP FOREIGN KEY FK_B9FC06324D714096');
        $this->addSql('ALTER TABLE user_recompense DROP FOREIGN KEY FK_B9FC0632A76ED395');
        $this->addSql('DROP TABLE user_recompense');
        $this->addSql('ALTER TABLE recompense ADD image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_recompense (user_id INT NOT NULL, recompense_id INT NOT NULL, INDEX IDX_B9FC06324D714096 (recompense_id), INDEX IDX_B9FC0632A76ED395 (user_id), PRIMARY KEY(user_id, recompense_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_recompense ADD CONSTRAINT FK_B9FC06324D714096 FOREIGN KEY (recompense_id) REFERENCES recompense (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_recompense ADD CONSTRAINT FK_B9FC0632A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE obtention DROP FOREIGN KEY FK_7A35A2B3D14F911D');
        $this->addSql('ALTER TABLE obtention DROP FOREIGN KEY FK_7A35A2B32152A79');
        $this->addSql('DROP TABLE obtention');
        $this->addSql('ALTER TABLE recompense DROP image');
    }
}
