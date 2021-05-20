<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210429170526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F7B39D312');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F7B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F7B39D312');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F7B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id)');
    }
}
