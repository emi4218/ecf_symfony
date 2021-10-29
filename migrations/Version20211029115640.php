<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211029115640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire ADD com_article_id INT NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCC42176B0 FOREIGN KEY (com_article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_67F068BCC42176B0 ON commentaire (com_article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCC42176B0');
        $this->addSql('DROP INDEX IDX_67F068BCC42176B0 ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP com_article_id');
    }
}
