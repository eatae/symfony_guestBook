<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Bridge\Doctrine\Logger\DbalLogger;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201124154705 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {

        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('CREATE SEQUENCE test_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE test (id SERIAL, foo VARCHAR(255) DEFAULT NULL, bar VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        /*
        $table = $schema->createTable('test');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('foo', 'string');
        $table->addColumn('bar', 'string');
        $table->addIndex(['id']);
        $table->setPrimaryKey(['id']);
        */

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE test_id_seq CASCADE');
        $this->addSql('DROP TABLE test');
    }
}
