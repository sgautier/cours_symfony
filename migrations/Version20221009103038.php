<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221009103038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__vehicle_to_vehicle_repair AS SELECT id, date FROM vehicle_to_vehicle_repair');
        $this->addSql('DROP TABLE vehicle_to_vehicle_repair');
        $this->addSql('CREATE TABLE vehicle_to_vehicle_repair (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, vehicle_id INTEGER NOT NULL, vehicle_repair_id INTEGER NOT NULL, date DATETIME NOT NULL, CONSTRAINT FK_55D01AAE545317D1 FOREIGN KEY (vehicle_id) REFERENCES voiture (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_55D01AAEB43C79AD FOREIGN KEY (vehicle_repair_id) REFERENCES vehicle_repair (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO vehicle_to_vehicle_repair (id, date) SELECT id, date FROM __temp__vehicle_to_vehicle_repair');
        $this->addSql('DROP TABLE __temp__vehicle_to_vehicle_repair');
        $this->addSql('CREATE INDEX IDX_55D01AAE545317D1 ON vehicle_to_vehicle_repair (vehicle_id)');
        $this->addSql('CREATE INDEX IDX_55D01AAEB43C79AD ON vehicle_to_vehicle_repair (vehicle_repair_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__vehicle_to_vehicle_repair AS SELECT id, date FROM vehicle_to_vehicle_repair');
        $this->addSql('DROP TABLE vehicle_to_vehicle_repair');
        $this->addSql('CREATE TABLE vehicle_to_vehicle_repair (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATETIME NOT NULL)');
        $this->addSql('INSERT INTO vehicle_to_vehicle_repair (id, date) SELECT id, date FROM __temp__vehicle_to_vehicle_repair');
        $this->addSql('DROP TABLE __temp__vehicle_to_vehicle_repair');
    }
}
