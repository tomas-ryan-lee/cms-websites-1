<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210916085640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nav_links DROP FOREIGN KEY FK_B29E78BDD842E46');
        $this->addSql('DROP INDEX UNIQ_B29E78BDD842E46 ON nav_links');
        $this->addSql('ALTER TABLE nav_links ADD link_id INT DEFAULT NULL, DROP position_id');
        $this->addSql('ALTER TABLE nav_links ADD CONSTRAINT FK_B29E78BADA40271 FOREIGN KEY (link_id) REFERENCES pages (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B29E78BADA40271 ON nav_links (link_id)');
        $this->addSql('ALTER TABLE navigation ADD nav_position_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE navigation ADD CONSTRAINT FK_493AC53F8BB1C9A0 FOREIGN KEY (nav_position_id) REFERENCES nav_links (id)');
        $this->addSql('CREATE INDEX IDX_493AC53F8BB1C9A0 ON navigation (nav_position_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nav_links DROP FOREIGN KEY FK_B29E78BADA40271');
        $this->addSql('DROP INDEX UNIQ_B29E78BADA40271 ON nav_links');
        $this->addSql('ALTER TABLE nav_links ADD position_id INT NOT NULL, DROP link_id');
        $this->addSql('ALTER TABLE nav_links ADD CONSTRAINT FK_B29E78BDD842E46 FOREIGN KEY (position_id) REFERENCES navigation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B29E78BDD842E46 ON nav_links (position_id)');
        $this->addSql('ALTER TABLE navigation DROP FOREIGN KEY FK_493AC53F8BB1C9A0');
        $this->addSql('DROP INDEX IDX_493AC53F8BB1C9A0 ON navigation');
        $this->addSql('ALTER TABLE navigation DROP nav_position_id');
    }
}
