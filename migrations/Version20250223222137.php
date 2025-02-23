<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250223222137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE support (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, company_id INT NOT NULL, name VARCHAR(50) NOT NULL, contents VARCHAR(255) NOT NULL, INDEX IDX_8004EBA5A76ED395 (user_id), INDEX IDX_8004EBA5979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE support_message (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, support_id INT NOT NULL, contents VARCHAR(255) NOT NULL, INDEX IDX_B883883A76ED395 (user_id), INDEX IDX_B883883315B405 (support_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE support ADD CONSTRAINT FK_8004EBA5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE support ADD CONSTRAINT FK_8004EBA5979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE support_message ADD CONSTRAINT FK_B883883A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE support_message ADD CONSTRAINT FK_B883883315B405 FOREIGN KEY (support_id) REFERENCES support (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE support DROP FOREIGN KEY FK_8004EBA5A76ED395');
        $this->addSql('ALTER TABLE support DROP FOREIGN KEY FK_8004EBA5979B1AD6');
        $this->addSql('ALTER TABLE support_message DROP FOREIGN KEY FK_B883883A76ED395');
        $this->addSql('ALTER TABLE support_message DROP FOREIGN KEY FK_B883883315B405');
        $this->addSql('DROP TABLE support');
        $this->addSql('DROP TABLE support_message');
    }
}
