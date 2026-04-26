<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260416212552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Utiliser le type JSON pour le champ status de ToyRequest pour les enums';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE toy_request ALTER status TYPE JSON USING status::json');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE toy_request ALTER status TYPE TEXT USING status::text');
    }
}
