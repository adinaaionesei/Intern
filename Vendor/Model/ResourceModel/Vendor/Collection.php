<?php
namespace Intern\Vendor\Model\ResourceModel\Vendor;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Intern\Vendor\Model\Vendor', 'Intern\Vendor\Model\ResourceModel\Vendor');
    }
}
