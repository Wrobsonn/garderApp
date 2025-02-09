<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250209123737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assigned_work (id INT AUTO_INCREMENT NOT NULL, job_id INT NOT NULL, company_id INT NOT NULL, hour INT NOT NULL, minute INT NOT NULL, INDEX IDX_BA369279BE04EA9 (job_id), INDEX IDX_BA369279979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assigned_work ADD CONSTRAINT FK_BA369279BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
        $this->addSql('ALTER TABLE assigned_work ADD CONSTRAINT FK_BA369279979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assigned_work DROP FOREIGN KEY FK_BA369279BE04EA9');
        $this->addSql('ALTER TABLE assigned_work DROP FOREIGN KEY FK_BA369279979B1AD6');
        $this->addSql('DROP TABLE assigned_work');
    }
}
