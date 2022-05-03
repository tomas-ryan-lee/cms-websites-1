<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210916085013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE nav_links (id INT AUTO_INCREMENT NOT NULL, position_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B29E78BDD842E46 (position_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nav_links_pages (nav_links_id INT NOT NULL, pages_id INT NOT NULL, INDEX IDX_95A0F968D8ACCC1D (nav_links_id), INDEX IDX_95A0F968401ADD27 (pages_id), PRIMARY KEY(nav_links_id, pages_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nav_links ADD CONSTRAINT FK_B29E78BDD842E46 FOREIGN KEY (position_id) REFERENCES navigation (id)');
        $this->addSql('ALTER TABLE nav_links_pages ADD CONSTRAINT FK_95A0F968D8ACCC1D FOREIGN KEY (nav_links_id) REFERENCES nav_links (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nav_links_pages ADD CONSTRAINT FK_95A0F968401ADD27 FOREIGN KEY (pages_id) REFERENCES pages (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nav_links_pages DROP FOREIGN KEY FK_95A0F968D8ACCC1D');
        $this->addSql('DROP TABLE nav_links');
        $this->addSql('DROP TABLE nav_links_pages');
    }
}
