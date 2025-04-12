<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250403144721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE equipment CHANGE id id INT NOT NULL, CHANGE description description LONGTEXT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement DROP FOREIGN KEY fk_event_speaker
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement DROP FOREIGN KEY fk_organisateurId
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement CHANGE id id INT NOT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE status status VARCHAR(250) NOT NULL, CHANGE organisateurId organisateurId INT DEFAULT NULL, CHANGE eventspeakerId eventspeakerId INT DEFAULT NULL, CHANGE dateEvent date_event DATE NOT NULL, CHANGE nbPlace nb_place INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement ADD CONSTRAINT FK_B26681E8DAB9FC1 FOREIGN KEY (organisateurId) REFERENCES user (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement ADD CONSTRAINT FK_B26681E2F76C57D FOREIGN KEY (eventspeakerId) REFERENCES eventspeaker (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement RENAME INDEX fk_organisateurid TO IDX_B26681E8DAB9FC1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement RENAME INDEX fk_event_speaker TO IDX_B26681E2F76C57D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE eventspeaker CHANGE id id INT NOT NULL, CHANGE description description LONGTEXT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE maintenance_record CHANGE id id INT NOT NULL, CHANGE equipmentId equipmentId INT DEFAULT NULL, CHANGE date date DATETIME NOT NULL, CHANGE description description LONGTEXT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE maintenance_record RENAME INDEX equipmentid TO IDX_B1C9A998CCAA7D19
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE payment ADD payment_date DATETIME NOT NULL, ADD payment_type VARCHAR(255) NOT NULL, DROP paymentDate, DROP paymentType, CHANGE id id INT NOT NULL, CHANGE reservationId reservationId INT DEFAULT NULL, CHANGE amount amount DOUBLE PRECISION NOT NULL, CHANGE status status VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE payment RENAME INDEX fk_reservation TO IDX_6D28840DE271511F
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_user ON reclamation
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_event ON reclamation
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamation ADD id_user INT NOT NULL, ADD id_event INT NOT NULL, ADD date_reclamation DATETIME NOT NULL, DROP idUser, DROP idEvent, DROP dateReclamation, CHANGE id id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reponse ADD date_rep DATETIME NOT NULL, DROP dateRep, CHANGE id id INT NOT NULL, CHANGE idRec idRec INT DEFAULT NULL, CHANGE message message LONGTEXT NOT NULL, CHANGE messageRec message_rec VARCHAR(500) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reponse RENAME INDEX fk_reclamation TO IDX_5FB6DEC7454DD7AB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation DROP FOREIGN KEY FK___user
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX id_event ON reservation
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD total_price DOUBLE PRECISION NOT NULL, ADD created_at DATETIME NOT NULL, DROP totalPrice, DROP createdAt, CHANGE id id INT NOT NULL, CHANGE userId userId INT DEFAULT NULL, CHANGE status status VARCHAR(255) NOT NULL, CHANGE eventId event_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD CONSTRAINT FK_42C8495564B64DCC FOREIGN KEY (userId) REFERENCES user (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation RENAME INDEX fk___user TO IDX_42C8495564B64DCC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE session CHANGE user_id user_id INT DEFAULT NULL, CHANGE login_time login_time DATETIME NOT NULL, CHANGE logout_time logout_time DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE session RENAME INDEX foreign_key TO IDX_D044D5D4A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX fk_reservationId ON ticket
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket ADD qr_code VARCHAR(255) NOT NULL, ADD ticket_count INT NOT NULL, DROP qrCode, DROP TicketCount, CHANGE id id INT NOT NULL, CHANGE price price DOUBLE PRECISION NOT NULL, CHANGE reservationId reservation_id INT NOT NULL, CHANGE ticketType ticket_type VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user CHANGE id id INT NOT NULL, CHANGE state state VARCHAR(250) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE equipment CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE description description TEXT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE maintenance_record CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE date date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE description description TEXT NOT NULL, CHANGE equipmentId equipmentId INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE maintenance_record RENAME INDEX idx_b1c9a998ccaa7d19 TO equipmentId
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reclamation ADD idUser INT NOT NULL, ADD idEvent INT NOT NULL, ADD dateReclamation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, DROP id_user, DROP id_event, DROP date_reclamation, CHANGE id id INT AUTO_INCREMENT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_user ON reclamation (idUser)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_event ON reclamation (idEvent)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE session CHANGE user_id user_id INT NOT NULL, CHANGE login_time login_time DATETIME DEFAULT NULL, CHANGE logout_time logout_time DATETIME DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE session RENAME INDEX idx_d044d5d4a76ed395 TO foreign_key
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E8DAB9FC1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E2F76C57D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE description description TEXT NOT NULL, CHANGE status status VARCHAR(250) DEFAULT 'dispo' NOT NULL, CHANGE organisateurId organisateurId INT NOT NULL, CHANGE eventspeakerId eventspeakerId INT NOT NULL, CHANGE date_event dateEvent DATE NOT NULL, CHANGE nb_place nbPlace INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement ADD CONSTRAINT fk_event_speaker FOREIGN KEY (eventspeakerId) REFERENCES eventspeaker (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement ADD CONSTRAINT fk_organisateurId FOREIGN KEY (organisateurId) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement RENAME INDEX idx_b26681e8dab9fc1 TO fk_organisateurId
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenement RENAME INDEX idx_b26681e2f76c57d TO fk_event_speaker
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE payment ADD paymentDate DATETIME DEFAULT CURRENT_TIMESTAMP, ADD paymentType VARCHAR(255) DEFAULT 'CreditCard', DROP payment_date, DROP payment_type, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE amount amount NUMERIC(10, 2) NOT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE reservationId reservationId INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE payment RENAME INDEX idx_6d28840de271511f TO fk_reservation
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495564B64DCC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD totalPrice DOUBLE PRECISION DEFAULT NULL, ADD createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, DROP total_price, DROP created_at, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE userId userId INT NOT NULL, CHANGE event_id eventId INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD CONSTRAINT FK___user FOREIGN KEY (userId) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX id_event ON reservation (eventId)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation RENAME INDEX idx_42c8495564b64dcc TO FK___user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE state state VARCHAR(250) DEFAULT 'active' NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE eventspeaker CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE description description TEXT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reponse ADD dateRep DATETIME DEFAULT NULL, DROP date_rep, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE message message TEXT NOT NULL, CHANGE idRec idRec INT NOT NULL, CHANGE message_rec messageRec VARCHAR(500) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reponse RENAME INDEX idx_5fb6dec7454dd7ab TO fk_reclamation
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket ADD reservationId INT NOT NULL, ADD ticketType VARCHAR(255) NOT NULL, ADD qrCode VARCHAR(255) DEFAULT NULL, ADD TicketCount INT DEFAULT NULL, DROP reservation_id, DROP ticket_type, DROP qr_code, DROP ticket_count, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE price price NUMERIC(10, 2) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX fk_reservationId ON ticket (reservationId)
        SQL);
    }
}
