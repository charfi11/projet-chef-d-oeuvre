<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190918091152 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message ADD mess_groupe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F190774E9 FOREIGN KEY (mess_groupe_id) REFERENCES groupe (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F190774E9 ON message (mess_groupe_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F190774E9');
        $this->addSql('DROP INDEX IDX_B6BD307F190774E9 ON message');
        $this->addSql('ALTER TABLE message DROP mess_groupe_id');
    }
}
