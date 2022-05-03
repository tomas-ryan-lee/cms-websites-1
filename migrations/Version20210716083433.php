<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210716083433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE navigation ADD name_id INT NOT NULL');
        $this->addSql('ALTER TABLE navigation ADD CONSTRAINT FK_493AC53F71179CD6 FOREIGN KEY (name_id) REFERENCES pages (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_493AC53F71179CD6 ON navigation (name_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE navigation DROP FOREIGN KEY FK_493AC53F71179CD6');
        $this->addSql('DROP INDEX UNIQ_493AC53F71179CD6 ON navigation');
        $this->addSql('ALTER TABLE navigation DROP name_id');
    }
}
