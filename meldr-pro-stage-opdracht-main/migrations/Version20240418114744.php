<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240418114744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) DEFAULT NULL, given_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, naam VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE foto (id INT AUTO_INCREMENT NOT NULL, foto_id INT NOT NULL, user_id INT NOT NULL, filename VARCHAR(255) NOT NULL, datum_tijd DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE melding (melding_id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, categorie_id INT DEFAULT NULL, inhoud LONGTEXT NOT NULL, datum_tijd DATETIME NOT NULL, afbeelding_url VARCHAR(255) DEFAULT NULL, INDEX IDX_A81CD4D7A76ED395 (user_id), INDEX IDX_A81CD4D7BCF5E72D (categorie_id), PRIMARY KEY(melding_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE melding ADD CONSTRAINT FK_A81CD4D7A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id)');
        $this->addSql('ALTER TABLE melding ADD CONSTRAINT FK_A81CD4D7BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE melding DROP FOREIGN KEY FK_A81CD4D7A76ED395');
        $this->addSql('ALTER TABLE melding DROP FOREIGN KEY FK_A81CD4D7BCF5E72D');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE foto');
        $this->addSql('DROP TABLE melding');
    }
}
