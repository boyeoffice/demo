<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240621063750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable('book');
        $table->addColumn('is_promoted', 'boolean', ['default' => false]);
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('book');
        $table->dropColumn('is_promoted');
    }
}
