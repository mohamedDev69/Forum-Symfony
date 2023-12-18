<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218115052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE atelier ADD intervenant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB1823AB9A1716 FOREIGN KEY (intervenant_id) REFERENCES intervenant (id)');
        $this->addSql('CREATE INDEX IDX_E1BB1823AB9A1716 ON atelier (intervenant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB1823AB9A1716');
        $this->addSql('DROP INDEX IDX_E1BB1823AB9A1716 ON atelier');
        $this->addSql('ALTER TABLE atelier DROP intervenant_id');
    }
}
