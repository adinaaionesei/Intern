<?php

namespace Intern\Vendor\Model\Api\Data;
interface AddressInterface
{
    public function getId();

    public function setId($id);

    public function getContactName();

    public function setContactName($contactName);

    public function getStreet();

    public function setStreet($street);

    public function getCity();

    public function setCity($city);

    public function getPostalCode();

    public function setPostalCode($postalCode);

    public function getStateRegion();

    public function setStateRegion($stateRegion);

    public function getSameAsBilling();

    public function setSameAsBilling($sameAsBilling);

    public function getAddressType();

    public function setAddressType($addressType);

    public function getVendorId();

    public function setVendorId($vendorId);
}
