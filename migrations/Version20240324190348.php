<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240324190348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE training_reimbursement ADD COLUMN amount INTEGER NOT NULL');
        $this->addSql('ALTER TABLE training_reimbursement ADD COLUMN paid_amount INTEGER NOT NULL');
        $this->addSql('ALTER TABLE training_reimbursement ADD COLUMN activity VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__training_reimbursement AS SELECT id, trainee, trainee_email, token, training_completion_certificate, training_expenses, mileage_expenses, payment_details, created_at, updated_at, license_number, status FROM training_reimbursement');
        $this->addSql('DROP TABLE training_reimbursement');
        $this->addSql('CREATE TABLE training_reimbursement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, trainee VARCHAR(255) NOT NULL, trainee_email VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, training_completion_certificate VARCHAR(255) DEFAULT NULL, training_expenses VARCHAR(255) DEFAULT NULL, mileage_expenses VARCHAR(255) DEFAULT NULL, payment_details VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , license_number VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO training_reimbursement (id, trainee, trainee_email, token, training_completion_certificate, training_expenses, mileage_expenses, payment_details, created_at, updated_at, license_number, status) SELECT id, trainee, trainee_email, token, training_completion_certificate, training_expenses, mileage_expenses, payment_details, created_at, updated_at, license_number, status FROM __temp__training_reimbursement');
        $this->addSql('DROP TABLE __temp__training_reimbursement');
    }
}
