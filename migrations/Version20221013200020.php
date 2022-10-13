<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221013200020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__vehicle_model AS SELECT id, name, make FROM vehicle_model');
        $this->addSql('DROP TABLE vehicle_model');
        $this->addSql('CREATE TABLE vehicle_model (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, make VARCHAR(255) NOT NULL, slug VARCHAR(128) DEFAULT NULL)');
        $this->addSql('INSERT INTO vehicle_model (id, name, make) SELECT id, name, make FROM __temp__vehicle_model');
        $this->addSql('DROP TABLE __temp__vehicle_model');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B53AF235989D9B62 ON vehicle_model (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__vehicle_model AS SELECT id, name, make FROM vehicle_model');
        $this->addSql('DROP TABLE vehicle_model');
        $this->addSql('CREATE TABLE vehicle_model (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, make VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO vehicle_model (id, name, make) SELECT id, name, make FROM __temp__vehicle_model');
        $this->addSql('DROP TABLE __temp__vehicle_model');
    }
}
