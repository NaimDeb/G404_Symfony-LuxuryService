<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250210133121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidate (id INT AUTO_INCREMENT NOT NULL, gender_id INT DEFAULT NULL, job_category_id INT DEFAULT NULL, user_id INT NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, nationality VARCHAR(255) DEFAULT NULL, current_location VARCHAR(255) DEFAULT NULL, place_of_birth VARCHAR(255) DEFAULT NULL, short_description VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', availibility TINYINT(1) DEFAULT NULL, notes LONGTEXT DEFAULT NULL, birth_date DATE DEFAULT NULL, experience VARCHAR(255) DEFAULT NULL, profile_picture VARCHAR(255) DEFAULT NULL, curriculum_vitae VARCHAR(255) DEFAULT NULL, passport VARCHAR(255) DEFAULT NULL, INDEX IDX_C8B28E44708A0E0 (gender_id), INDEX IDX_C8B28E44712A86AB (job_category_id), UNIQUE INDEX UNIQ_C8B28E44A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gender (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidate ADD CONSTRAINT FK_C8B28E44708A0E0 FOREIGN KEY (gender_id) REFERENCES gender (id)');
        $this->addSql('ALTER TABLE candidate ADD CONSTRAINT FK_C8B28E44712A86AB FOREIGN KEY (job_category_id) REFERENCES job_category (id)');
        $this->addSql('ALTER TABLE candidate ADD CONSTRAINT FK_C8B28E44A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidate DROP FOREIGN KEY FK_C8B28E44708A0E0');
        $this->addSql('ALTER TABLE candidate DROP FOREIGN KEY FK_C8B28E44712A86AB');
        $this->addSql('ALTER TABLE candidate DROP FOREIGN KEY FK_C8B28E44A76ED395');
        $this->addSql('DROP TABLE candidate');
        $this->addSql('DROP TABLE gender');
        $this->addSql('DROP TABLE job_category');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
