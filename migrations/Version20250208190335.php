<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250208190335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tool (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, client_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, is_reserved TINYINT(1) DEFAULT NULL, INDEX IDX_20F33ED1979B1AD6 (company_id), INDEX IDX_20F33ED119EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
       $this->addSql('ALTER TABLE tool ADD CONSTRAINT FK_20F33ED1979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE tool ADD CONSTRAINT FK_20F33ED119EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tool DROP FOREIGN KEY FK_20F33ED1979B1AD6');
        $this->addSql('ALTER TABLE tool DROP FOREIGN KEY FK_20F33ED119EB6921');
        $this->addSql('DROP TABLE tool');
    }
}
