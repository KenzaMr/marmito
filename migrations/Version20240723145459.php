<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240723145459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add ingredients';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recipe_recette (recipe_id INT NOT NULL, recette_id INT NOT NULL, INDEX IDX_55F6DD059D8A214 (recipe_id), INDEX IDX_55F6DD089312FE9 (recette_id), PRIMARY KEY(recipe_id, recette_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipe_recette ADD CONSTRAINT FK_55F6DD059D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_recette ADD CONSTRAINT FK_55F6DD089312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe_recette DROP FOREIGN KEY FK_55F6DD059D8A214');
        $this->addSql('ALTER TABLE recipe_recette DROP FOREIGN KEY FK_55F6DD089312FE9');
        $this->addSql('DROP TABLE recipe_recette');
    }
}
