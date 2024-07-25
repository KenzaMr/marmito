<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240725140905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'modif ';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe CHANGE name name VARCHAR(50) NOT NULL, CHANGE text text LONGTEXT NOT NULL, CHANGE prix prix NUMERIC(5, 2) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe CHANGE name name VARCHAR(255) NOT NULL, CHANGE text text VARCHAR(255) NOT NULL, CHANGE prix prix VARCHAR(255) NOT NULL');
    }
}
