<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201126141407_CommentAndConferenceAutoincrement extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('alter table conference alter column id set default nextval(\'public.conference_id_seq\')');
        $this->addSql('alter sequence conference_id_seq owned by conference.id');

        $this->addSql('alter table comment alter column id set default nextval(\'public.comment_id_seq\')');
        $this->addSql('alter sequence comment_id_seq owned by comment.id');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('alter table comment alter column id set not null');
        $this->addSql('alter table conference alter column id set not null');
    }
}
