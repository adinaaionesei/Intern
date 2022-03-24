<?php
namespace Intern\Vendor\Model;
use Magento\Catalog\Model\Product;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Intern\Vendor\Model\Api\Data\VendorInterface;

class Vendor extends AbstractModel implements IdentityInterface, VendorInterface
{
    const CACHE_TAG = 'intern_vendor';

    protected function _construct()
    {
        $this->_init('Intern\Vendor\Model\ResourceModel\Vendor');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getId()
    {
        return $this->_getData('id');
    }

    public function setId($value)
    {
        return $this->setData('id', $value);
    }
    public function getName()
    {
        return $this->_getData('name');
    }

    public function setName($value)
    {
        return $this->setData('name', $value);
    }
    public function getStatus()
    {
        return $this->_getData('status');
    }

    public function setStatus($value)
    {
        return $this->setData('status', $value);
    }
    public function getEmail()
    {
        return $this->_getData('email');
    }

    public function setEmail($value)
    {
        return $this->setData('email', $value);
    }
}
