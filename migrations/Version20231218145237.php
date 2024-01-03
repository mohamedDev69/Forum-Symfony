<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218145237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ecole ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ecole ADD CONSTRAINT FK_9786AACA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_9786AACA76ED395 ON ecole (user_id)');
        $this->addSql('ALTER TABLE eleve ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_ECA105F7A76ED395 ON eleve (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ecole DROP FOREIGN KEY FK_9786AACA76ED395');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F7A76ED395');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP INDEX IDX_ECA105F7A76ED395 ON eleve');
        $this->addSql('ALTER TABLE eleve DROP user_id');
        $this->addSql('DROP INDEX IDX_9786AACA76ED395 ON ecole');
        $this->addSql('ALTER TABLE ecole DROP user_id');
    }
}
