<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180327131753_createInventoryItem1CView extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        // view.inventory_item1c
        $this->addSql('CREATE OR REPLACE VIEW view.inventory_item1c AS
            SELECT
              i."__id" AS "invItem_id",
              i."inventoryNumber" AS "invItem_inventoryNumber",
              i."serialNumber" AS "invItem_serialNumber",
              i."dateOfRegistration" AS "invItem_dateOfRegistration",
              i."lastUpdate" AS "invItem_lastUpdate",
              m."__id" AS "mol_id",
              m."fio" AS "mol_fio",
              m."molTabNumber" AS "mol_tabNumber",
              n."__id" AS "nomenclature1C_id",
              n."title" AS "nomenclature1C_title",
              nt."__id" AS "nomenclatureType_id",
              nt."type" AS "nomenclatureType_type",
              c."__id" AS "invItemCategory_id",
              c."title" AS "invItemCategory_title",
              r."__id" AS "rooms1C_id",
              r."roomsCode" AS "rooms1C_roomsCode",
              r."address" AS "rooms1C_address",
              o."__id" AS "office_id",
              o."lotusId" AS "office_lotusId",
              rt."__id" AS "roomsTypes_id",
              rt."type" AS "roomsTypes_type",
              ct."__id" AS "city1C_id",
              ct."title" AS "city1C_title",
              rg."__id" AS "region1C_id",
              rg."title" AS "region1C_title"
            FROM "storage_1c"."inventoryItem1C" AS i
              JOIN "storage_1c"."mols" AS m ON m.__id = i.__mol_id
              JOIN "storage_1c"."nomenclature1C" AS n ON n.__id = i.__nomenclature_id
              JOIN "storage_1c"."nomenclatureTypes" AS nt ON nt.__id = n.__type_id
              JOIN "storage_1c"."categories" AS c ON c.__id = i.__category_id
              JOIN "storage_1c"."rooms1C" AS r ON r.__id = i.__rooms_1c_id
              LEFT JOIN company."offices" AS o ON o.__id = r.__voice_office_id
              JOIN "storage_1c"."roomsTypes" AS rt ON rt.__id = r.__type_id
              JOIN "storage_1c"."cities1C" AS ct ON ct.__id = r.__city_1c_id
              JOIN "storage_1c"."regions1C" AS rg ON rg.__id = ct.__region_1c_id');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        // view.inventory_item1c
        $this->addSql('DROP VIEW view.inventory_item1c');
    }
}
