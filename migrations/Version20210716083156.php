<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210716083156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE navigation (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nav_position ADD position_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nav_position ADD CONSTRAINT FK_5E5E7065DD842E46 FOREIGN KEY (position_id) REFERENCES navigation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E5E7065DD842E46 ON nav_position (position_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nav_position DROP FOREIGN KEY FK_5E5E7065DD842E46');
        $this->addSql('DROP TABLE navigation');
        $this->addSql('DROP INDEX UNIQ_5E5E7065DD842E46 ON nav_position');
        $this->addSql('ALTER TABLE nav_position DROP position_id');
    }
}
