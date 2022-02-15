<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220215073906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE llibre MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE llibre DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE llibre DROP id');
        $this->addSql('ALTER TABLE llibre ADD PRIMARY KEY (isbn)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE llibre ADD id INT AUTO_INCREMENT NOT NULL, CHANGE isbn isbn VARCHAR(20) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE titol titol VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE autor autor VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE imatge imatge VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }
}
