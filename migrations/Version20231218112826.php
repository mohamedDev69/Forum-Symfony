<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218112826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE atelier (id INT AUTO_INCREMENT NOT NULL, forum_id INT DEFAULT NULL, sector_id INT DEFAULT NULL, room_id INT DEFAULT NULL, title VARCHAR(30) NOT NULL, duration INT NOT NULL, description VARCHAR(100) NOT NULL, date_atelier DATETIME NOT NULL, INDEX IDX_E1BB182329CCBAD0 (forum_id), INDEX IDX_E1BB1823DE95C867 (sector_id), INDEX IDX_E1BB182354177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, school_info VARCHAR(50) NOT NULL, unique_info VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervenant (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, contact_info VARCHAR(100) NOT NULL, bio VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, capacity INT NOT NULL, location VARCHAR(30) NOT NULL, features LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE secteur (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, description VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sponsor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, contact_info VARCHAR(40) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sponsor_forum (sponsor_id INT NOT NULL, forum_id INT NOT NULL, INDEX IDX_25C1FEF612F7FB51 (sponsor_id), INDEX IDX_25C1FEF629CCBAD0 (forum_id), PRIMARY KEY(sponsor_id, forum_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB182329CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id)');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB1823DE95C867 FOREIGN KEY (sector_id) REFERENCES secteur (id)');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB182354177093 FOREIGN KEY (room_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE sponsor_forum ADD CONSTRAINT FK_25C1FEF612F7FB51 FOREIGN KEY (sponsor_id) REFERENCES sponsor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sponsor_forum ADD CONSTRAINT FK_25C1FEF629CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB182329CCBAD0');
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB1823DE95C867');
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB182354177093');
        $this->addSql('ALTER TABLE sponsor_forum DROP FOREIGN KEY FK_25C1FEF612F7FB51');
        $this->addSql('ALTER TABLE sponsor_forum DROP FOREIGN KEY FK_25C1FEF629CCBAD0');
        $this->addSql('DROP TABLE atelier');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE intervenant');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE secteur');
        $this->addSql('DROP TABLE sponsor');
        $this->addSql('DROP TABLE sponsor_forum');
    }
}
