<?php
namespace Intern\Vendor\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Intern\Vendor\Model\Api\Data\AddressInterface;

class Address extends AbstractModel implements IdentityInterface, AddressInterface
{
    const CACHE_TAG = 'intern_vendor_address';

    protected function _construct()
    {
        $this->_init('Intern\Vendor\Model\ResourceModel\Address');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
    public function getId()
    {
        return $this->_getData('address_id');
    }

    public function setId($value)
    {
        return $this->setData('address_id', $value);
    }

    public function getContactName()
    {
        return $this->_getData('contact_name');
    }

    public function setContactName($value)
    {
        return $this->setData('contact_name', $value);
    }
    public function getStreet()
    {
        return $this->_getData('street');
    }

    public function setStreet($value)
    {
        return $this->setData('street', $value);
    }
    public function getCity()
    {
        return $this->_getData('city');
    }

    public function setCity($value)
    {
        return $this->setData('city', $value);
    }
    public function getPostalCode()
    {
        return $this->_getData('postal_code');
    }

    public function setPostalCode($value)
    {
        return $this->setData('postal_code', $value);
    }
    public function getStateRegion()
    {
        return $this->_getData('state_region');
    }

    public function setStateRegion($value)
    {
        return $this->setData('state_region', $value);
    }
    public function getSameAsBilling()
    {
        return $this->_getData('same_as_billing');
    }

    public function setSameAsBilling($sameAsBilling)
    {
        return $this->setData('same_as_billing', $sameAsBilling);
    }

    public function getVendorId()
    {
        return $this->_getData('vendor_id');
    }

    public function setVendorId($vendorId)
    {
        return $this->setData('vendor_id', $vendorId);
    }
    public function getAddressType()
    {
        return $this->_getData('address_type');
    }

    public function setAddressType($addressType)
    {
        return $this->setData('address_type', $addressType);
    }
}
