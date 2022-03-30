<?php
namespace Intern\Vendor\Model\ResourceModel\Address;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Intern\Vendor\Model\Address', 'Intern\Vendor\Model\ResourceModel\Address');
    }
}
