<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240129115112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ruta_visita (ruta_id INT NOT NULL, visita_id INT NOT NULL, INDEX IDX_BF0956A1ABBC4845 (ruta_id), INDEX IDX_BF0956A14EA74B0E (visita_id), PRIMARY KEY(ruta_id, visita_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ruta_visita ADD CONSTRAINT FK_BF0956A1ABBC4845 FOREIGN KEY (ruta_id) REFERENCES ruta (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ruta_visita ADD CONSTRAINT FK_BF0956A14EA74B0E FOREIGN KEY (visita_id) REFERENCES visita (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ruta_visita DROP FOREIGN KEY FK_BF0956A1ABBC4845');
        $this->addSql('ALTER TABLE ruta_visita DROP FOREIGN KEY FK_BF0956A14EA74B0E');
        $this->addSql('DROP TABLE ruta_visita');
    }
}
