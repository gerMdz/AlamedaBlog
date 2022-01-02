<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220102200530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_alameda_comment (id INT AUTO_INCREMENT NOT NULL, post_id INT NOT NULL, author_id INT NOT NULL, content LONGTEXT NOT NULL, published_at DATETIME NOT NULL, INDEX IDX_6AD6F6B94B89032C (post_id), INDEX IDX_6AD6F6B9F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_alameda_post (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, summary VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, published_at DATETIME NOT NULL, INDEX IDX_BEEEF590F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_alameda_post_tag (post_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_AC89BE0F4B89032C (post_id), INDEX IDX_AC89BE0FBAD26311 (tag_id), PRIMARY KEY(post_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_alameda_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_69DFA10F5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_alameda_user (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_69F74F54F85E0677 (username), UNIQUE INDEX UNIQ_69F74F54E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_alameda_comment ADD CONSTRAINT FK_6AD6F6B94B89032C FOREIGN KEY (post_id) REFERENCES blog_alameda_post (id)');
        $this->addSql('ALTER TABLE blog_alameda_comment ADD CONSTRAINT FK_6AD6F6B9F675F31B FOREIGN KEY (author_id) REFERENCES blog_alameda_user (id)');
        $this->addSql('ALTER TABLE blog_alameda_post ADD CONSTRAINT FK_BEEEF590F675F31B FOREIGN KEY (author_id) REFERENCES blog_alameda_user (id)');
        $this->addSql('ALTER TABLE blog_alameda_post_tag ADD CONSTRAINT FK_AC89BE0F4B89032C FOREIGN KEY (post_id) REFERENCES blog_alameda_post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_alameda_post_tag ADD CONSTRAINT FK_AC89BE0FBAD26311 FOREIGN KEY (tag_id) REFERENCES blog_alameda_tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_alameda_comment DROP FOREIGN KEY FK_6AD6F6B94B89032C');
        $this->addSql('ALTER TABLE blog_alameda_post_tag DROP FOREIGN KEY FK_AC89BE0F4B89032C');
        $this->addSql('ALTER TABLE blog_alameda_post_tag DROP FOREIGN KEY FK_AC89BE0FBAD26311');
        $this->addSql('ALTER TABLE blog_alameda_comment DROP FOREIGN KEY FK_6AD6F6B9F675F31B');
        $this->addSql('ALTER TABLE blog_alameda_post DROP FOREIGN KEY FK_BEEEF590F675F31B');
        $this->addSql('DROP TABLE blog_alameda_comment');
        $this->addSql('DROP TABLE blog_alameda_post');
        $this->addSql('DROP TABLE blog_alameda_post_tag');
        $this->addSql('DROP TABLE blog_alameda_tag');
        $this->addSql('DROP TABLE blog_alameda_user');
    }
}
