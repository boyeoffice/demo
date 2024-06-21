<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Enum\BookPromotionStatus;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use GraphQL\Type\Definition\EnumType;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240621065429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // $table = $schema->getTable('book');
        // $table->addColumn('promotionStatus', 'enum', [
        //     'class' => BookPromotionStatus::class,
        //     'required' => true
        // ]);

        $this->addSql("CREATE TYPE promotion_status_enum AS ENUM ('None', 'Basic', 'Pro')");
        $this->addSql("ALTER TABLE book ADD COLUMN promotion_status promotion_status_enum");
        $this->addSql("ALTER TABLE book ALTER COLUMN promotion_status SET DEFAULT 'None'");
        $this->addSql("ALTER TABLE book ADD CONSTRAINT check_promotion_status CHECK (promotion_status IN ('None', 'Basic', 'Pro'))");
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('book');
        $table->dropColumn('promotion_status');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT check_promotion_status');
    }
}
