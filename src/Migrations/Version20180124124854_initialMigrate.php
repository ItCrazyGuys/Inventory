<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180124124854_initialMigrate extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA IF NOT EXISTS storage_1c');

        // regions1C
        $this->addSql('CREATE TABLE "storage_1c"."regions1C" (__id SERIAL NOT NULL, title VARCHAR(255) UNIQUE NOT NULL, PRIMARY KEY(__id))');


        // cities1C
        $this->addSql('CREATE TABLE "storage_1c"."cities1C" (__id SERIAL NOT NULL, __region_1c_id BIGINT NOT NULL, title VARCHAR(255), PRIMARY KEY(__id))');

        $this->addSql('CREATE INDEX "idx_cities1C__region1c_id" ON "storage_1c"."cities1C" (__region_1c_id)');
        $this->addSql('ALTER TABLE "storage_1c"."cities1C" ADD CONSTRAINT "fk_cities1C__region1c_id" FOREIGN KEY (__region_1c_id) REFERENCES "storage_1c"."regions1C" (__id) ON UPDATE CASCADE ON DELETE RESTRICT');

        // roomsTypes
        $this->addSql('CREATE TABLE "storage_1c"."roomsTypes" (__id SERIAL NOT NULL, type VARCHAR(255) UNIQUE NOT NULL, PRIMARY KEY(__id))');


        // rooms1C
        $this->addSql('CREATE TABLE "storage_1c"."rooms1C" (__id SERIAL NOT NULL, __type_id BIGINT NOT NULL, __voice_office_id BIGINT, __city_1c_id BIGINT NOT NULL, "roomsCode" VARCHAR(255) UNIQUE NOT NULL, address TEXT, PRIMARY KEY(__id))');

        $this->addSql('CREATE INDEX "idx_rooms1C__type_id" ON "storage_1c"."rooms1C" (__type_id)');
        $this->addSql('ALTER TABLE "storage_1c"."rooms1C" ADD CONSTRAINT "fk_rooms1C__type_id" FOREIGN KEY (__type_id) REFERENCES "storage_1c"."roomsTypes" (__id) ON UPDATE CASCADE ON DELETE RESTRICT');

        $this->addSql('CREATE INDEX "idx_rooms1C__city_1c_id" ON "storage_1c"."rooms1C" (__city_1c_id)');
        $this->addSql('ALTER TABLE "storage_1c"."rooms1C" ADD CONSTRAINT "fk_rooms1C__city_1c_id" FOREIGN KEY (__city_1c_id) REFERENCES "storage_1c"."cities1C" (__id) ON UPDATE CASCADE ON DELETE RESTRICT');

        $this->addSql('CREATE INDEX "idx_rooms1C__voice_office_id" ON "storage_1c"."rooms1C" (__voice_office_id)');
        $this->addSql('ALTER TABLE "storage_1c"."rooms1C" ADD CONSTRAINT "fk_rooms1C__voice_office_id" FOREIGN KEY (__voice_office_id) REFERENCES "company"."offices" (__id) ON UPDATE CASCADE ON DELETE RESTRICT');

        $this->addSql('CREATE INDEX "idx_rooms1C__rooms_code" ON "storage_1c"."rooms1C" ("roomsCode")');


        // category
        $this->addSql('CREATE TABLE "storage_1c"."categories" (__id SERIAL NOT NULL, title VARCHAR(255) UNIQUE NOT NULL, PRIMARY KEY(__id))');


        // nomenclatureTypes
        $this->addSql('CREATE TABLE "storage_1c"."nomenclatureTypes" (__id SERIAL NOT NULL, type VARCHAR(255) UNIQUE NOT NULL, PRIMARY KEY(__id))');


        // nomenclature1C
        $this->addSql('CREATE TABLE "storage_1c"."nomenclature1C" (__id SERIAL NOT NULL, __type_id BIGINT NOT NULL, title TEXT, PRIMARY KEY(__id))');

        $this->addSql('CREATE INDEX "idx_nomenclature1C__type_id" ON "storage_1c"."nomenclature1C" (__type_id)');
        $this->addSql('ALTER TABLE "storage_1c"."nomenclature1C" ADD CONSTRAINT "fk_nomenclature1C__type_id" FOREIGN KEY (__type_id) REFERENCES "storage_1c"."nomenclatureTypes" (__id) ON UPDATE CASCADE ON DELETE RESTRICT');


        // mols
        $this->addSql('CREATE TABLE "storage_1c".mols (__id SERIAL NOT NULL, fio VARCHAR(255), "molTabNumber" INTEGER UNIQUE NOT NULL, PRIMARY KEY(__id))');
        $this->addSql('CREATE INDEX "idx_mols__mol_tabnumber" ON "storage_1c".mols ("molTabNumber")');


        // inventoryItem1C
        $this->addSql('CREATE TABLE "storage_1c"."inventoryItem1C" (__id SERIAL NOT NULL, "__rooms_1c_id" BIGINT NOT NULL, "__category_id" BIGINT NOT NULL, __nomenclature_id BIGINT NOT NULL, __mol_id BIGINT NOT NULL, "inventoryNumber" VARCHAR(255) UNIQUE NOT NULL, "serialNumber" VARCHAR(255), "dateOfRegistration" TIMESTAMP, "lastUpdate" TIMESTAMP, PRIMARY KEY(__id))');

        $this->addSql('CREATE INDEX "idx_inventoryItem1C__category_id" ON "storage_1c"."inventoryItem1C" ("__category_id")');
        $this->addSql('ALTER TABLE "storage_1c"."inventoryItem1C" ADD CONSTRAINT "fk_inventoryItem1C__category_id" FOREIGN KEY ("__category_id") REFERENCES "storage_1c"."categories" (__id) ON UPDATE CASCADE ON DELETE RESTRICT');

        $this->addSql('CREATE INDEX "idx_inventoryItem1C__nomenclature_id" ON "storage_1c"."inventoryItem1C" (__nomenclature_id)');
        $this->addSql('ALTER TABLE "storage_1c"."inventoryItem1C" ADD CONSTRAINT "fk_inventoryItem1C__nomenclature_id" FOREIGN KEY (__nomenclature_id) REFERENCES "storage_1c"."nomenclature1C" (__id) ON UPDATE CASCADE ON DELETE RESTRICT');

        $this->addSql('CREATE INDEX "idx_inventoryItem1C__mol_id" ON "storage_1c"."inventoryItem1C" (__mol_id)');
        $this->addSql('ALTER TABLE "storage_1c"."inventoryItem1C" ADD CONSTRAINT "fk_inventoryItem1C__mol_id" FOREIGN KEY (__mol_id) REFERENCES "storage_1c".mols (__id) ON UPDATE CASCADE ON DELETE RESTRICT');

        $this->addSql('CREATE INDEX "idx_inventoryItem1C__rooms_1c_id" ON "storage_1c"."inventoryItem1C" (__rooms_1c_id)');
        $this->addSql('ALTER TABLE "storage_1c"."inventoryItem1C" ADD CONSTRAINT "fk_inventoryItem1C__rooms_1c_id" FOREIGN KEY (__rooms_1c_id) REFERENCES "storage_1c"."rooms1C" (__id) ON UPDATE CASCADE ON DELETE RESTRICT');

        $this->addSql('CREATE INDEX "idx_inventoryItem1C__inventory_number" ON "storage_1c"."inventoryItem1C" ("inventoryNumber")');
        $this->addSql('CREATE INDEX "idx_inventoryItem1C__serial_number" ON "storage_1c"."inventoryItem1C" ("serialNumber")');


        // mol-rooms1C
        $this->addSql('CREATE TABLE "storage_1c"."mol_rooms1C" (__mol_id BIGINT NOT NULL, __rooms_1c_id BIGINT NOT NULL, PRIMARY KEY(__mol_id, __rooms_1c_id))');
        $this->addSql('CREATE INDEX "idx_mol_rooms1C___mol_id" ON "storage_1c"."mol_rooms1C" (__mol_id)');
        $this->addSql('CREATE INDEX "idx_mol_rooms1C___rooms_1c_id" ON "storage_1c"."mol_rooms1C" (__rooms_1c_id)');
        $this->addSql('ALTER TABLE "storage_1c"."mol_rooms1C" ADD CONSTRAINT "fk_mol_rooms1C___mol_id" FOREIGN KEY (__mol_id) REFERENCES "storage_1c".mols (__id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE "storage_1c"."mol_rooms1C" ADD CONSTRAINT "fk_mol_rooms1C___rooms_1c" FOREIGN KEY (__rooms_1c_id) REFERENCES "storage_1c"."rooms1C" (__id) ON DELETE CASCADE');


        // appliance1C
        $this->addSql('CREATE TABLE "storage_1c"."appliances1C" (__id SERIAL NOT NULL, __inventory_item_id BIGINT UNIQUE NOT NULL, __voice_appliance_id BIGINT UNIQUE, PRIMARY KEY(__id))');

        $this->addSql('CREATE INDEX "idx_appliances1C__inventory_item_id" ON "storage_1c"."appliances1C" (__inventory_item_id)');
        $this->addSql('ALTER TABLE "storage_1c"."appliances1C" ADD CONSTRAINT "fk_appliances1C__inventory_item_id" FOREIGN KEY (__inventory_item_id) REFERENCES "storage_1c"."inventoryItem1C" (__id) ON UPDATE CASCADE ON DELETE RESTRICT');

        $this->addSql('CREATE INDEX "idx_appliances1C__voice_appliance_id" ON "storage_1c"."appliances1C" (__voice_appliance_id)');
        $this->addSql('ALTER TABLE "storage_1c"."appliances1C" ADD CONSTRAINT "fk_appliances1C__voice_appliance_id" FOREIGN KEY (__voice_appliance_id) REFERENCES "equipment"."appliances" (__id) ON UPDATE CASCADE ON DELETE RESTRICT');



        // module1C
        $this->addSql('CREATE TABLE "storage_1c"."modules1C" (__id SERIAL NOT NULL, __inventory_item_id BIGINT UNIQUE, __voice_module_id BIGINT UNIQUE, PRIMARY KEY(__id))');

        $this->addSql('CREATE INDEX "idx_modules1C__inventory_item_id" ON "storage_1c"."modules1C" (__inventory_item_id)');
        $this->addSql('ALTER TABLE "storage_1c"."modules1C" ADD CONSTRAINT "fk_modules1C__inventory_item_id" FOREIGN KEY (__inventory_item_id) REFERENCES "storage_1c"."inventoryItem1C" (__id) ON UPDATE CASCADE ON DELETE RESTRICT');

        $this->addSql('CREATE INDEX "idx_modules1C__voice_module_id" ON "storage_1c"."modules1C" (__voice_module_id)');
        $this->addSql('ALTER TABLE "storage_1c"."modules1C" ADD CONSTRAINT "fk_modules1C__voice_module_id" FOREIGN KEY (__voice_module_id) REFERENCES "equipment"."moduleItems" (__id) ON UPDATE CASCADE ON DELETE RESTRICT');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        // module1C
        $this->addSql('ALTER TABLE "storage_1c"."modules1C" DROP CONSTRAINT "fk_modules1C__voice_module_id"');
        $this->addSql('ALTER TABLE "storage_1c"."modules1C" DROP CONSTRAINT "fk_modules1C__inventory_item_id"');
        $this->addSql('DROP TABLE "storage_1c"."modules1C"');

        // appliance1C
        $this->addSql('ALTER TABLE "storage_1c"."appliances1C" DROP CONSTRAINT "fk_appliances1C__voice_appliance_id"');
        $this->addSql('ALTER TABLE "storage_1c"."appliances1C" DROP CONSTRAINT "fk_appliances1C__inventory_item_id"');
        $this->addSql('DROP TABLE "storage_1c"."appliances1C"');

        // mol-rooms1C
        $this->addSql('ALTER TABLE "storage_1c"."mol_rooms1C" DROP CONSTRAINT "fk_mol_rooms1C___rooms_1c"');
        $this->addSql('ALTER TABLE "storage_1c"."mol_rooms1C" DROP CONSTRAINT "fk_mol_rooms1C___mol_id"');
        $this->addSql('DROP TABLE "storage_1c"."mol_rooms1C"');

        // inventoryItem1C
        $this->addSql('ALTER TABLE "storage_1c"."inventoryItem1C" DROP CONSTRAINT "fk_inventoryItem1C__rooms_1c_id"');
        $this->addSql('ALTER TABLE "storage_1c"."inventoryItem1C" DROP CONSTRAINT "fk_inventoryItem1C__mol_id"');
        $this->addSql('ALTER TABLE "storage_1c"."inventoryItem1C" DROP CONSTRAINT "fk_inventoryItem1C__nomenclature_id"');
        $this->addSql('ALTER TABLE "storage_1c"."inventoryItem1C" DROP CONSTRAINT "fk_inventoryItem1C__category_id"');
        $this->addSql('DROP TABLE "storage_1c"."inventoryItem1C"');

        // mols
        $this->addSql('DROP TABLE "storage_1c".mols');

        // nomenclature1C
        $this->addSql('ALTER TABLE "storage_1c"."nomenclature1C" DROP CONSTRAINT "fk_nomenclature1C__type_id"');
        $this->addSql('DROP TABLE "storage_1c"."nomenclature1C"');

        // nomenclatureTypes
        $this->addSql('DROP TABLE "storage_1c"."nomenclatureTypes"');

        // category
        $this->addSql('DROP TABLE "storage_1c"."categories"');

        // rooms1C
        $this->addSql('ALTER TABLE "storage_1c"."rooms1C" DROP CONSTRAINT "fk_rooms1C__voice_office_id"');
        $this->addSql('ALTER TABLE "storage_1c"."rooms1C" DROP CONSTRAINT "fk_rooms1C__city_1c_id"');
        $this->addSql('ALTER TABLE "storage_1c"."rooms1C" DROP CONSTRAINT "fk_rooms1C__type_id"');
        $this->addSql('DROP TABLE "storage_1c"."rooms1C"');

        // roomsTypes
        $this->addSql('DROP TABLE "storage_1c"."roomsTypes"');

        // cities1C
        $this->addSql('ALTER TABLE "storage_1c"."cities1C" DROP CONSTRAINT "fk_cities1C__region1c_id"');
        $this->addSql('DROP TABLE "storage_1c"."cities1C"');

        // regions1C
        $this->addSql('DROP TABLE "storage_1c"."regions1C"');

        // schema
        $this->addSql('DROP SCHEMA IF EXISTS storage_1c');
    }
}
