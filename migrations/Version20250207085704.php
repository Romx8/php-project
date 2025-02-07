<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250207085704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE encounter_team DROP FOREIGN KEY FK_DD68F77A296CD8AE');
        $this->addSql('ALTER TABLE encounter_team DROP FOREIGN KEY FK_DD68F77AD6E2FADC');
        $this->addSql('DROP TABLE encounter_team');
        $this->addSql('ALTER TABLE encounter ADD team1_id INT DEFAULT NULL, ADD team2_id INT DEFAULT NULL, ADD winner_id INT DEFAULT NULL, ADD tournament_id INT DEFAULT NULL, ADD next_encounter_id INT DEFAULT NULL, DROP result');
        $this->addSql('ALTER TABLE encounter ADD CONSTRAINT FK_69D229CAE72BCFA4 FOREIGN KEY (team1_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE encounter ADD CONSTRAINT FK_69D229CAF59E604A FOREIGN KEY (team2_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE encounter ADD CONSTRAINT FK_69D229CA5DFCD4B8 FOREIGN KEY (winner_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE encounter ADD CONSTRAINT FK_69D229CA33D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id)');
        $this->addSql('ALTER TABLE encounter ADD CONSTRAINT FK_69D229CA1EDFA36 FOREIGN KEY (next_encounter_id) REFERENCES encounter (id)');
        $this->addSql('CREATE INDEX IDX_69D229CAE72BCFA4 ON encounter (team1_id)');
        $this->addSql('CREATE INDEX IDX_69D229CAF59E604A ON encounter (team2_id)');
        $this->addSql('CREATE INDEX IDX_69D229CA5DFCD4B8 ON encounter (winner_id)');
        $this->addSql('CREATE INDEX IDX_69D229CA33D1A3E7 ON encounter (tournament_id)');
        $this->addSql('CREATE INDEX IDX_69D229CA1EDFA36 ON encounter (next_encounter_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE encounter_team (encounter_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_DD68F77A296CD8AE (team_id), INDEX IDX_DD68F77AD6E2FADC (encounter_id), PRIMARY KEY(encounter_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE encounter_team ADD CONSTRAINT FK_DD68F77A296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE encounter_team ADD CONSTRAINT FK_DD68F77AD6E2FADC FOREIGN KEY (encounter_id) REFERENCES encounter (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE encounter DROP FOREIGN KEY FK_69D229CAE72BCFA4');
        $this->addSql('ALTER TABLE encounter DROP FOREIGN KEY FK_69D229CAF59E604A');
        $this->addSql('ALTER TABLE encounter DROP FOREIGN KEY FK_69D229CA5DFCD4B8');
        $this->addSql('ALTER TABLE encounter DROP FOREIGN KEY FK_69D229CA33D1A3E7');
        $this->addSql('ALTER TABLE encounter DROP FOREIGN KEY FK_69D229CA1EDFA36');
        $this->addSql('DROP INDEX IDX_69D229CAE72BCFA4 ON encounter');
        $this->addSql('DROP INDEX IDX_69D229CAF59E604A ON encounter');
        $this->addSql('DROP INDEX IDX_69D229CA5DFCD4B8 ON encounter');
        $this->addSql('DROP INDEX IDX_69D229CA33D1A3E7 ON encounter');
        $this->addSql('DROP INDEX IDX_69D229CA1EDFA36 ON encounter');
        $this->addSql('ALTER TABLE encounter ADD result TINYINT(1) NOT NULL, DROP team1_id, DROP team2_id, DROP winner_id, DROP tournament_id, DROP next_encounter_id');
    }
}
