<?php

namespace App\Entity\View;


interface IInventoryItem1C
{
    public function getInvItemId();
    public function getInvItemInventoryNumber();
    public function getInvItemSerialNumber();
    public function getInvItemDateOfRegistration();
    public function getInvItemLastUpdate();
    public function getMolId();
    public function getMolFio();
    public function getMolTabNumber();
    public function getNomenclature1CId();
    public function getNomenclature1CTitle();
    public function getNomenclatureTypeId();
    public function getNomenclatureTypeType();
    public function getInvItemCategoryId();
    public function getInvItemCategoryTitle();
    public function getRooms1CId();
    public function getRooms1CRoomsCode();
    public function getRooms1CAddress();
    public function getOfficeId();
    public function getOfficeLotusId();
    public function getRoomsTypesId();
    public function getRoomsTypesType();
    public function getCity1CId();
    public function getCity1CTitle();
    public function getRegion1CId();
    public function getRegion1CTitle();
}
