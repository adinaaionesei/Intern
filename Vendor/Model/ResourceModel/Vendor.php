<?php
namespace Intern\Vendor\Model\ResourceModel;
class Vendor extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('intern_vendor_entity', 'vendor_id');
    }
}
