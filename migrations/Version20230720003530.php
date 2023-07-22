<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230720003530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coffee_shop ADD nb_place_salle_prive_max_dispo INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD forfait_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955906D5F2C FOREIGN KEY (forfait_id) REFERENCES forfait (id)');
        $this->addSql('CREATE INDEX IDX_42C84955906D5F2C ON reservation (forfait_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coffee_shop DROP nb_place_salle_prive_max_dispo');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955906D5F2C');
        $this->addSql('DROP INDEX IDX_42C84955906D5F2C ON reservation');
        $this->addSql('ALTER TABLE reservation DROP forfait_id');
    }
}
