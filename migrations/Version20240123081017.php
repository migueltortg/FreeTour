<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240123081017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE informe ADD cod_tour_id INT NOT NULL');
        $this->addSql('ALTER TABLE informe ADD CONSTRAINT FK_7E75E1D987557DD7 FOREIGN KEY (cod_tour_id) REFERENCES tour (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7E75E1D987557DD7 ON informe (cod_tour_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE informe DROP FOREIGN KEY FK_7E75E1D987557DD7');
        $this->addSql('DROP INDEX UNIQ_7E75E1D987557DD7 ON informe');
        $this->addSql('ALTER TABLE informe DROP cod_tour_id');
    }
}
