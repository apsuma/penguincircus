<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200129132148 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE keywords (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, articles_id INT DEFAULT NULL, nb_place_child INT DEFAULT NULL, nb_place_adult INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_42C849551EBAF6CC (articles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, subject VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, picture VARCHAR(255) DEFAULT NULL, resa_open TINYINT(1) NOT NULL, in_front TINYINT(1) NOT NULL, show_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_keywords (article_id INT NOT NULL, keywords_id INT NOT NULL, INDEX IDX_FFB741357294869C (article_id), INDEX IDX_FFB741356205D0B8 (keywords_id), PRIMARY KEY(article_id, keywords_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_theme (article_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_E0C295197294869C (article_id), INDEX IDX_E0C2951959027487 (theme_id), PRIMARY KEY(article_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849551EBAF6CC FOREIGN KEY (articles_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE article_keywords ADD CONSTRAINT FK_FFB741357294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_keywords ADD CONSTRAINT FK_FFB741356205D0B8 FOREIGN KEY (keywords_id) REFERENCES keywords (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_theme ADD CONSTRAINT FK_E0C295197294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_theme ADD CONSTRAINT FK_E0C2951959027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article_keywords DROP FOREIGN KEY FK_FFB741356205D0B8');
        $this->addSql('ALTER TABLE article_theme DROP FOREIGN KEY FK_E0C2951959027487');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849551EBAF6CC');
        $this->addSql('ALTER TABLE article_keywords DROP FOREIGN KEY FK_FFB741357294869C');
        $this->addSql('ALTER TABLE article_theme DROP FOREIGN KEY FK_E0C295197294869C');
        $this->addSql('DROP TABLE keywords');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_keywords');
        $this->addSql('DROP TABLE article_theme');
    }
}
