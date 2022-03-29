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
        return $this->_getData('vendor_id');
    }

    public function setId($value)
    {
        return $this->setData('vendor_id', $value);
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
    public function getTelephone()
    {
        return $this->_getData('telephone');
    }

    public function setTelephone($value)
    {
        return $this->setData('telephone', $value);
    }
    public function getCurrency()
    {
        return $this->_getData('$currency');
    }

    public function setCurrency($currency)
    {
        return $this->setData('currency', $currency);
    }
    public function getNotifyOrders()
    {
        return $this->_getData('$notify_orders');
    }
    public function setNotifyOrders($notifyOrders)
    {
        return $this->setData('notify_orders', $notifyOrders);
    }
    public function getCcEmails()
    {
        return $this->_getData('$cc_emails');
    }
    public function setCcEmails($ccEmails)
    {
        return $this->setData('cc_emails', $ccEmails);
    }
}
