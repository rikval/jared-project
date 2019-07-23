<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190721095016 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact ADD location_id INT DEFAULT NULL, DROP reach, DROP area');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E63864D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('CREATE INDEX IDX_4C62E63864D218E ON contact (location_id)');
        $this->addSql('ALTER TABLE location DROP longitude, DROP latitude, DROP zip');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E63864D218E');
        $this->addSql('DROP INDEX IDX_4C62E63864D218E ON contact');
        $this->addSql('ALTER TABLE contact ADD reach VARCHAR(40) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD area VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP location_id');
        $this->addSql('ALTER TABLE location ADD longitude DOUBLE PRECISION DEFAULT NULL, ADD latitude DOUBLE PRECISION DEFAULT NULL, ADD zip VARCHAR(50) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
