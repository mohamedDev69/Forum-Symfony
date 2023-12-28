<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219161929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE forum_sponsor (forum_id INT NOT NULL, sponsor_id INT NOT NULL, INDEX IDX_704084A529CCBAD0 (forum_id), INDEX IDX_704084A512F7FB51 (sponsor_id), PRIMARY KEY(forum_id, sponsor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE forum_sponsor ADD CONSTRAINT FK_704084A529CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE forum_sponsor ADD CONSTRAINT FK_704084A512F7FB51 FOREIGN KEY (sponsor_id) REFERENCES sponsor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sponsor_forum DROP FOREIGN KEY FK_25C1FEF612F7FB51');
        $this->addSql('ALTER TABLE sponsor_forum DROP FOREIGN KEY FK_25C1FEF629CCBAD0');
        $this->addSql('DROP TABLE sponsor_forum');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sponsor_forum (sponsor_id INT NOT NULL, forum_id INT NOT NULL, INDEX IDX_25C1FEF612F7FB51 (sponsor_id), INDEX IDX_25C1FEF629CCBAD0 (forum_id), PRIMARY KEY(sponsor_id, forum_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sponsor_forum ADD CONSTRAINT FK_25C1FEF612F7FB51 FOREIGN KEY (sponsor_id) REFERENCES sponsor (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sponsor_forum ADD CONSTRAINT FK_25C1FEF629CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE forum_sponsor DROP FOREIGN KEY FK_704084A529CCBAD0');
        $this->addSql('ALTER TABLE forum_sponsor DROP FOREIGN KEY FK_704084A512F7FB51');
        $this->addSql('DROP TABLE forum_sponsor');
    }
}
