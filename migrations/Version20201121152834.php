<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201121152834 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Remove foo column and change ';
    }


    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE comment ALTER COLUMN created_at SET DEFAULT NOW()');
        $this->addSql('ALTER TABLE comment DROP COLUMN foo');
    }


    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE comment ALTER COLUMN created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE comment ADD foo INT DEFAULT NULL');

    }
}
