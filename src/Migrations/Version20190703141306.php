<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190703141306 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE permission (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, tour_id INT NOT NULL, permission VARCHAR(30) NOT NULL, INDEX IDX_E04992AAA76ED395 (user_id), INDEX IDX_E04992AA15ED8D43 (tour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE relation (id INT AUTO_INCREMENT NOT NULL, artist_id INT NOT NULL, contact_id INT NOT NULL, affinity VARCHAR(50) NOT NULL, note LONGTEXT DEFAULT NULL, INDEX IDX_62894749B7970CF8 (artist_id), INDEX IDX_62894749E7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE permission ADD CONSTRAINT FK_E04992AAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE permission ADD CONSTRAINT FK_E04992AA15ED8D43 FOREIGN KEY (tour_id) REFERENCES tour (id)');
        $this->addSql('ALTER TABLE relation ADD CONSTRAINT FK_62894749B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE relation ADD CONSTRAINT FK_62894749E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE permission');
        $this->addSql('DROP TABLE relation');
    }
}
