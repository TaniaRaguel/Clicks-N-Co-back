<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211203105654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_tag (product_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_E3A6E39C4584665A (product_id), INDEX IDX_E3A6E39CBAD26311 (tag_id), PRIMARY KEY(product_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_category (shop_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_DDF4E3574D16C4DD (shop_id), INDEX IDX_DDF4E35712469DE2 (category_id), PRIMARY KEY(shop_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_tag ADD CONSTRAINT FK_E3A6E39C4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_tag ADD CONSTRAINT FK_E3A6E39CBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_category ADD CONSTRAINT FK_DDF4E3574D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_category ADD CONSTRAINT FK_DDF4E35712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD shop_id INT NOT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F52993984D16C4DD ON `order` (shop_id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
        $this->addSql('ALTER TABLE orderline ADD product_id INT NOT NULL, ADD order_ref_id INT NOT NULL');
        $this->addSql('ALTER TABLE orderline ADD CONSTRAINT FK_DF24E26C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE orderline ADD CONSTRAINT FK_DF24E26CE238517C FOREIGN KEY (order_ref_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_DF24E26C4584665A ON orderline (product_id)');
        $this->addSql('CREATE INDEX IDX_DF24E26CE238517C ON orderline (order_ref_id)');
        $this->addSql('ALTER TABLE product ADD shop_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD4D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD4D16C4DD ON product (shop_id)');
        $this->addSql('ALTER TABLE shop ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AC6A4CA2A76ED395 ON shop (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product_tag');
        $this->addSql('DROP TABLE shop_category');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984D16C4DD');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F52993984D16C4DD ON `order`');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP shop_id, DROP user_id');
        $this->addSql('ALTER TABLE orderline DROP FOREIGN KEY FK_DF24E26C4584665A');
        $this->addSql('ALTER TABLE orderline DROP FOREIGN KEY FK_DF24E26CE238517C');
        $this->addSql('DROP INDEX IDX_DF24E26C4584665A ON orderline');
        $this->addSql('DROP INDEX IDX_DF24E26CE238517C ON orderline');
        $this->addSql('ALTER TABLE orderline DROP product_id, DROP order_ref_id');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD4D16C4DD');
        $this->addSql('DROP INDEX IDX_D34A04AD4D16C4DD ON product');
        $this->addSql('ALTER TABLE product DROP shop_id');
        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA2A76ED395');
        $this->addSql('DROP INDEX IDX_AC6A4CA2A76ED395 ON shop');
        $this->addSql('ALTER TABLE shop DROP user_id');
    }
}
