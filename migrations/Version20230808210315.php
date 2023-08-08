<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230808210315 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE player (id INT NOT NULL, wid VARCHAR(255) NOT NULL, nickname VARCHAR(64) NOT NULL, server VARCHAR(4) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98197A65501FD268 ON player (wid)');
        $this->addSql('CREATE TABLE player_vehicles_played (id INT NOT NULL, player_id INT DEFAULT NULL, wiki_vehicle_id INT DEFAULT NULL, battles VARCHAR(64) NOT NULL, damage VARCHAR(64) NOT NULL, xp VARCHAR(64) NOT NULL, wins VARCHAR(64) NOT NULL, frags VARCHAR(64) NOT NULL, personal_rating VARCHAR(64) NOT NULL, wn8 VARCHAR(64) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FD4E818A99E6F5DF ON player_vehicles_played (player_id)');
        $this->addSql('CREATE INDEX IDX_FD4E818A685BC319 ON player_vehicles_played (wiki_vehicle_id)');
        $this->addSql('CREATE TABLE wiki_vehicle (id INT NOT NULL, wid VARCHAR(255) NOT NULL, name VARCHAR(64) NOT NULL, tier INT NOT NULL, type VARCHAR(64) NOT NULL, nation VARCHAR(64) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D3B31443501FD268 ON wiki_vehicle (wid)');
        $this->addSql('ALTER TABLE player_vehicles_played ADD CONSTRAINT FK_FD4E818A99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player_vehicles_played ADD CONSTRAINT FK_FD4E818A685BC319 FOREIGN KEY (wiki_vehicle_id) REFERENCES wiki_vehicle (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE player_vehicles_played DROP CONSTRAINT FK_FD4E818A99E6F5DF');
        $this->addSql('ALTER TABLE player_vehicles_played DROP CONSTRAINT FK_FD4E818A685BC319');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE player_vehicles_played');
        $this->addSql('DROP TABLE wiki_vehicle');
    }
}
