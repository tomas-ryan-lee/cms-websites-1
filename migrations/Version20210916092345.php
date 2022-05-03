<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210916092345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nav_links ADD nav_position_id INT NOT NULL');
        $this->addSql('ALTER TABLE nav_links ADD CONSTRAINT FK_B29E78B8BB1C9A0 FOREIGN KEY (nav_position_id) REFERENCES navigation (id)');
        $this->addSql('CREATE INDEX IDX_B29E78B8BB1C9A0 ON nav_links (nav_position_id)');
        $this->addSql('ALTER TABLE navigation ADD nav_links_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE navigation ADD CONSTRAINT FK_493AC53FD8ACCC1D FOREIGN KEY (nav_links_id) REFERENCES nav_links (id)');
        $this->addSql('CREATE INDEX IDX_493AC53FD8ACCC1D ON navigation (nav_links_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nav_links DROP FOREIGN KEY FK_B29E78B8BB1C9A0');
        $this->addSql('DROP INDEX IDX_B29E78B8BB1C9A0 ON nav_links');
        $this->addSql('ALTER TABLE nav_links DROP nav_position_id');
        $this->addSql('ALTER TABLE navigation DROP FOREIGN KEY FK_493AC53FD8ACCC1D');
        $this->addSql('DROP INDEX IDX_493AC53FD8ACCC1D ON navigation');
        $this->addSql('ALTER TABLE navigation DROP nav_links_id');
    }
}
