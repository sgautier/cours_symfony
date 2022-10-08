<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221008150629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__voiture AS SELECT id, plate, mileage, price, description, manu_date FROM voiture');
        $this->addSql('DROP TABLE voiture');
        $this->addSql('CREATE TABLE voiture (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, vehicle_security_id INTEGER DEFAULT NULL, plate VARCHAR(10) NOT NULL, mileage INTEGER NOT NULL, price DOUBLE PRECISION DEFAULT NULL, description CLOB DEFAULT NULL, manu_date DATETIME NOT NULL, CONSTRAINT FK_E9E2810FE3853F62 FOREIGN KEY (vehicle_security_id) REFERENCES vehicle_security (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO voiture (id, plate, mileage, price, description, manu_date) SELECT id, plate, mileage, price, description, manu_date FROM __temp__voiture');
        $this->addSql('DROP TABLE __temp__voiture');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E9E2810FE3853F62 ON voiture (vehicle_security_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__voiture AS SELECT id, plate, mileage, price, description, manu_date FROM voiture');
        $this->addSql('DROP TABLE voiture');
        $this->addSql('CREATE TABLE voiture (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, plate VARCHAR(10) NOT NULL, mileage INTEGER NOT NULL, price DOUBLE PRECISION DEFAULT NULL, description CLOB DEFAULT NULL, manu_date DATETIME NOT NULL)');
        $this->addSql('INSERT INTO voiture (id, plate, mileage, price, description, manu_date) SELECT id, plate, mileage, price, description, manu_date FROM __temp__voiture');
        $this->addSql('DROP TABLE __temp__voiture');
    }
}
