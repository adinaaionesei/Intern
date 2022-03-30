<?php
namespace Intern\Vendor\Model\ResourceModel;

class Address extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('intern_vendor_address', 'address_id');
    }
}
