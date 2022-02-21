<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221071925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE editorial (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE llibre (isbn VARCHAR(20) NOT NULL, editorial_id INT DEFAULT NULL, titol VARCHAR(255) NOT NULL, autor VARCHAR(100) NOT NULL, pagines INT NOT NULL, imatge VARCHAR(255) NOT NULL, INDEX IDX_BF9ADDAABAF1A24D (editorial_id), PRIMARY KEY(isbn)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuari (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_68CC94FFF85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE llibre ADD CONSTRAINT FK_BF9ADDAABAF1A24D FOREIGN KEY (editorial_id) REFERENCES editorial (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE llibre DROP FOREIGN KEY FK_BF9ADDAABAF1A24D');
        $this->addSql('DROP TABLE editorial');
        $this->addSql('DROP TABLE llibre');
        $this->addSql('DROP TABLE usuari');
    }
}
