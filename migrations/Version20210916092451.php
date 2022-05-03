<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210916092451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nav_links ADD CONSTRAINT FK_B29E78B8BB1C9A0 FOREIGN KEY (nav_position_id) REFERENCES navigation (id)');
        $this->addSql('CREATE INDEX IDX_B29E78B8BB1C9A0 ON nav_links (nav_position_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nav_links DROP FOREIGN KEY FK_B29E78B8BB1C9A0');
        $this->addSql('DROP INDEX IDX_B29E78B8BB1C9A0 ON nav_links');
    }
}
