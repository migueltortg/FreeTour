<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240131070904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tour ADD guia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tour ADD CONSTRAINT FK_6AD1F96962AA81F FOREIGN KEY (guia_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6AD1F96962AA81F ON tour (guia_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tour DROP FOREIGN KEY FK_6AD1F96962AA81F');
        $this->addSql('DROP INDEX IDX_6AD1F96962AA81F ON tour');
        $this->addSql('ALTER TABLE tour DROP guia_id');
    }
}
