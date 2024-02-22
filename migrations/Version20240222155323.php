<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222155323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tour_guia (id INT AUTO_INCREMENT NOT NULL, id_guia_id INT NOT NULL, id_tour_id INT NOT NULL, INDEX IDX_7A35DB1DD8B7016F (id_guia_id), UNIQUE INDEX UNIQ_7A35DB1DCB702433 (id_tour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tour_guia ADD CONSTRAINT FK_7A35DB1DD8B7016F FOREIGN KEY (id_guia_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tour_guia ADD CONSTRAINT FK_7A35DB1DCB702433 FOREIGN KEY (id_tour_id) REFERENCES tour (id)');
        $this->addSql('ALTER TABLE ruta CHANGE programacion programacion JSON NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tour_guia DROP FOREIGN KEY FK_7A35DB1DD8B7016F');
        $this->addSql('ALTER TABLE tour_guia DROP FOREIGN KEY FK_7A35DB1DCB702433');
        $this->addSql('DROP TABLE tour_guia');
        $this->addSql('ALTER TABLE ruta CHANGE programacion programacion JSON DEFAULT NULL COMMENT \'(DC2Type:json)\'');
    }
}
