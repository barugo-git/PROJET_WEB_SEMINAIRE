<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250513192107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE demandes DROP FOREIGN KEY demandes_ibfk_1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demandes CHANGE statut statut VARCHAR(255) NOT NULL, CHANGE date_validation date_validation DATE DEFAULT NULL, CHANGE date_souhaitee date_souhaitee DATE DEFAULT NULL, CHANGE date_soumission date_soumission DATETIME NOT NULL, CHANGE resume resume LONGTEXT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demandes ADD CONSTRAINT FK_BD940CBBA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demandes RENAME INDEX user_id TO IDX_BD940CBBA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE presentations DROP FOREIGN KEY presentations_ibfk_1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE presentations ADD uploade_at DATETIME NOT NULL, DROP uploaded_at, CHANGE programmation_id programmation_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE presentations ADD CONSTRAINT FK_72936B1D96D6BD09 FOREIGN KEY (programmation_id) REFERENCES programmations (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE presentations RENAME INDEX programmation_id TO IDX_72936B1D96D6BD09
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE programmations DROP FOREIGN KEY programmations_ibfk_1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE programmations CHANGE resume resume LONGTEXT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE programmations ADD CONSTRAINT FK_2253E34980E95E18 FOREIGN KEY (demande_id) REFERENCES demandes (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE programmations RENAME INDEX demande_id TO IDX_2253E34980E95E18
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX email ON users
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users CHANGE role role VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL
        SQL);
        
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE users CHANGE role role ENUM('admin', 'presenter') DEFAULT 'NULL', CHANGE created_at created_at DATETIME DEFAULT 'current_timestamp()' NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX email ON users (email)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE programmations DROP FOREIGN KEY FK_2253E34980E95E18
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE programmations CHANGE resume resume TEXT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE programmations ADD CONSTRAINT programmations_ibfk_1 FOREIGN KEY (demande_id) REFERENCES demandes (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE programmations RENAME INDEX idx_2253e34980e95e18 TO demande_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE presentations DROP FOREIGN KEY FK_72936B1D96D6BD09
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE presentations ADD uploaded_at DATETIME DEFAULT 'current_timestamp()' NOT NULL, DROP uploade_at, CHANGE programmation_id programmation_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE presentations ADD CONSTRAINT presentations_ibfk_1 FOREIGN KEY (programmation_id) REFERENCES programmations (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE presentations RENAME INDEX idx_72936b1d96d6bd09 TO programmation_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demandes DROP FOREIGN KEY FK_BD940CBBA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demandes CHANGE statut statut ENUM('en_attente', 'valide', 'rejete') DEFAULT '''en_attente''', CHANGE date_validation date_validation DATE DEFAULT 'NULL', CHANGE date_souhaitee date_souhaitee DATE DEFAULT 'NULL', CHANGE date_soumission date_soumission DATETIME DEFAULT 'current_timestamp()' NOT NULL, CHANGE resume resume TEXT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT 'current_timestamp()' NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demandes ADD CONSTRAINT demandes_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demandes RENAME INDEX idx_bd940cbba76ed395 TO user_id
        SQL);
    }
}
