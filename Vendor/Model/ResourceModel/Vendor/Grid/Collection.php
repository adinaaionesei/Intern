<?php
namespace Intern\Vendor\Model\ResourceModel\Vendor\Grid;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'vendor_id';

    protected function _construct()
    {
        $this->_init('Intern\Vendor\Model\Vendor', 'Intern\Vendor\Model\ResourceModel\Vendor');
    }
}
