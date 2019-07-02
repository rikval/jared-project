<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190702114811 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event ADD venue_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA740A73EBA FOREIGN KEY (venue_id) REFERENCES venue (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA740A73EBA ON event (venue_id)');
        $this->addSql('ALTER TABLE location ADD venue_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB40A73EBA FOREIGN KEY (venue_id) REFERENCES venue (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E9E89CB40A73EBA ON location (venue_id)');
        $this->addSql('ALTER TABLE venue ADD location_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE venue ADD CONSTRAINT FK_91911B0D64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_91911B0D64D218E ON venue (location_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA740A73EBA');
        $this->addSql('DROP INDEX IDX_3BAE0AA740A73EBA ON event');
        $this->addSql('ALTER TABLE event DROP venue_id');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB40A73EBA');
        $this->addSql('DROP INDEX UNIQ_5E9E89CB40A73EBA ON location');
        $this->addSql('ALTER TABLE location DROP venue_id');
        $this->addSql('ALTER TABLE venue DROP FOREIGN KEY FK_91911B0D64D218E');
        $this->addSql('DROP INDEX UNIQ_91911B0D64D218E ON venue');
        $this->addSql('ALTER TABLE venue DROP location_id');
    }
}
