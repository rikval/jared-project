<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190708100648 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE venue DROP FOREIGN KEY FK_91911B0D64D218E');
        $this->addSql('ALTER TABLE venue ADD CONSTRAINT FK_91911B0D64D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB40A73EBA');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB40A73EBA FOREIGN KEY (venue_id) REFERENCES venue (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB40A73EBA');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB40A73EBA FOREIGN KEY (venue_id) REFERENCES venue (id)');
        $this->addSql('ALTER TABLE venue DROP FOREIGN KEY FK_91911B0D64D218E');
        $this->addSql('ALTER TABLE venue ADD CONSTRAINT FK_91911B0D64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
    }
}
