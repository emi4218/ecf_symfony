<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211026124036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reaction (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reaction_commentaire (reaction_id INT NOT NULL, commentaire_id INT NOT NULL, INDEX IDX_24E68F8A813C7171 (reaction_id), INDEX IDX_24E68F8ABA9CD190 (commentaire_id), PRIMARY KEY(reaction_id, commentaire_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reaction_commentaire ADD CONSTRAINT FK_24E68F8A813C7171 FOREIGN KEY (reaction_id) REFERENCES reaction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reaction_commentaire ADD CONSTRAINT FK_24E68F8ABA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reaction_commentaire DROP FOREIGN KEY FK_24E68F8A813C7171');
        $this->addSql('DROP TABLE reaction');
        $this->addSql('DROP TABLE reaction_commentaire');
    }
}
