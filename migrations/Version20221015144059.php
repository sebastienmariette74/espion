<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221015144059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hiding_place (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, type_id INT NOT NULL, code VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, zipcode VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, INDEX IDX_924939C1F92F3E70 (country_id), INDEX IDX_924939C1C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, type_id INT NOT NULL, status_id INT NOT NULL, speciality_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, code_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', finished_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9067F23CF92F3E70 (country_id), INDEX IDX_9067F23CC54C8C93 (type_id), INDEX IDX_9067F23C6BF700BD (status_id), INDEX IDX_9067F23C3B5A08D7 (speciality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission_hiding_place (mission_id INT NOT NULL, hiding_place_id INT NOT NULL, INDEX IDX_45237465BE6CAE90 (mission_id), INDEX IDX_45237465F7A84D5B (hiding_place_id), PRIMARY KEY(mission_id, hiding_place_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission_agent (mission_id INT NOT NULL, agent_id INT NOT NULL, INDEX IDX_B61DC3A0BE6CAE90 (mission_id), INDEX IDX_B61DC3A03414710B (agent_id), PRIMARY KEY(mission_id, agent_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission_target (mission_id INT NOT NULL, target_id INT NOT NULL, INDEX IDX_1E97F5B2BE6CAE90 (mission_id), INDEX IDX_1E97F5B2158E0B66 (target_id), PRIMARY KEY(mission_id, target_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission_contact (mission_id INT NOT NULL, contact_id INT NOT NULL, INDEX IDX_DD5E7275BE6CAE90 (mission_id), INDEX IDX_DD5E7275E7A1254A (contact_id), PRIMARY KEY(mission_id, contact_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status_mission (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_hiding_place (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_mission (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hiding_place ADD CONSTRAINT FK_924939C1F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE hiding_place ADD CONSTRAINT FK_924939C1C54C8C93 FOREIGN KEY (type_id) REFERENCES type_hiding_place (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CC54C8C93 FOREIGN KEY (type_id) REFERENCES type_mission (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C6BF700BD FOREIGN KEY (status_id) REFERENCES status_mission (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id)');
        $this->addSql('ALTER TABLE mission_hiding_place ADD CONSTRAINT FK_45237465BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_hiding_place ADD CONSTRAINT FK_45237465F7A84D5B FOREIGN KEY (hiding_place_id) REFERENCES hiding_place (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_agent ADD CONSTRAINT FK_B61DC3A0BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_agent ADD CONSTRAINT FK_B61DC3A03414710B FOREIGN KEY (agent_id) REFERENCES agent (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_target ADD CONSTRAINT FK_1E97F5B2BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_target ADD CONSTRAINT FK_1E97F5B2158E0B66 FOREIGN KEY (target_id) REFERENCES target (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_contact ADD CONSTRAINT FK_DD5E7275BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_contact ADD CONSTRAINT FK_DD5E7275E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hiding_place DROP FOREIGN KEY FK_924939C1F92F3E70');
        $this->addSql('ALTER TABLE hiding_place DROP FOREIGN KEY FK_924939C1C54C8C93');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CF92F3E70');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CC54C8C93');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C6BF700BD');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C3B5A08D7');
        $this->addSql('ALTER TABLE mission_hiding_place DROP FOREIGN KEY FK_45237465BE6CAE90');
        $this->addSql('ALTER TABLE mission_hiding_place DROP FOREIGN KEY FK_45237465F7A84D5B');
        $this->addSql('ALTER TABLE mission_agent DROP FOREIGN KEY FK_B61DC3A0BE6CAE90');
        $this->addSql('ALTER TABLE mission_agent DROP FOREIGN KEY FK_B61DC3A03414710B');
        $this->addSql('ALTER TABLE mission_target DROP FOREIGN KEY FK_1E97F5B2BE6CAE90');
        $this->addSql('ALTER TABLE mission_target DROP FOREIGN KEY FK_1E97F5B2158E0B66');
        $this->addSql('ALTER TABLE mission_contact DROP FOREIGN KEY FK_DD5E7275BE6CAE90');
        $this->addSql('ALTER TABLE mission_contact DROP FOREIGN KEY FK_DD5E7275E7A1254A');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE hiding_place');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE mission_hiding_place');
        $this->addSql('DROP TABLE mission_agent');
        $this->addSql('DROP TABLE mission_target');
        $this->addSql('DROP TABLE mission_contact');
        $this->addSql('DROP TABLE status_mission');
        $this->addSql('DROP TABLE type_hiding_place');
        $this->addSql('DROP TABLE type_mission');
    }
}
