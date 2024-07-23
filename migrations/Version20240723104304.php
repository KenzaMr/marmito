<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240723104304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'update dates';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe ADD date_ofcreation DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD date_ofmaj DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP date_creation, DROP date_maj');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe ADD date_creation DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD date_maj DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP date_ofcreation, DROP date_ofmaj');
    }
}
