<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913074700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP thumbnail_id');
        $this->addSql('ALTER TABLE thumbnail DROP FOREIGN KEY FK_C35726E67294869C');
        $this->addSql('DROP INDEX UNIQ_C35726E67294869C ON thumbnail');
        $this->addSql('ALTER TABLE thumbnail DROP article_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD thumbnail_id INT NOT NULL');
        $this->addSql('ALTER TABLE thumbnail ADD article_id INT NOT NULL');
        $this->addSql('ALTER TABLE thumbnail ADD CONSTRAINT FK_C35726E67294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C35726E67294869C ON thumbnail (article_id)');
    }
}
