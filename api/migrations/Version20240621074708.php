<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\Mercure\Update;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240621074708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $table = $schema->getTable('book');
        $this->addSql(
            <<<EOF
            UPDATE book
            SET promotion_status =
                CASE
                    WHEN is_promoted = false THEN 'None'::promotion_status_enum
                    WHEN is_promoted = true THEN 'Basic'::promotion_status_enum
                END
        EOF
        );
        $this->addSql("ALTER TABLE book DROP COLUMN is_promoted");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $table = $schema->getTable('book');
        $table->addColumn('is_promoted', 'boolean', ['default' => false]);
    }
}
