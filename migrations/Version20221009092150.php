<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221009092150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE asso_vehicle_equipment (vehicle_id INTEGER NOT NULL, vehicle_equipment_id INTEGER NOT NULL, PRIMARY KEY(vehicle_id, vehicle_equipment_id), CONSTRAINT FK_69426F7E545317D1 FOREIGN KEY (vehicle_id) REFERENCES voiture (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_69426F7EE897068A FOREIGN KEY (vehicle_equipment_id) REFERENCES vehicle_equipment (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_69426F7E545317D1 ON asso_vehicle_equipment (vehicle_id)');
        $this->addSql('CREATE INDEX IDX_69426F7EE897068A ON asso_vehicle_equipment (vehicle_equipment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE asso_vehicle_equipment');
    }
}
