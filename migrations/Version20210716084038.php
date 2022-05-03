<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210716084038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE navigation ADD position_id INT NOT NULL');
        $this->addSql('ALTER TABLE navigation ADD CONSTRAINT FK_493AC53FDD842E46 FOREIGN KEY (position_id) REFERENCES nav_position (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_493AC53FDD842E46 ON navigation (position_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE navigation DROP FOREIGN KEY FK_493AC53FDD842E46');
        $this->addSql('DROP INDEX UNIQ_493AC53FDD842E46 ON navigation');
        $this->addSql('ALTER TABLE navigation DROP position_id');
    }
}
