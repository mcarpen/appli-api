<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180112132914 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE restaurant CHANGE address address VARCHAR(150) NOT NULL, CHANGE city city VARCHAR(50) NOT NULL, CHANGE zip zip INT NOT NULL, CHANGE lat lat NUMERIC(10, 8) NOT NULL, CHANGE lng lng NUMERIC(11, 8) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_88BDF3E9F85E0677 ON app_user');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9F85E0677 ON app_user (username)');
        $this->addSql('ALTER TABLE restaurant CHANGE address address VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE city city VARCHAR(30) NOT NULL COLLATE utf8_unicode_ci, CHANGE zip zip VARCHAR(6) NOT NULL COLLATE utf8_unicode_ci, CHANGE lat lat VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE lng lng VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
