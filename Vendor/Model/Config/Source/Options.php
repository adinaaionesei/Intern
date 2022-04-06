<?php

namespace Intern\Vendor\Model\Config\Source;

use Intern\Vendor\Model\ResourceModel\Vendor\CollectionFactory as VendorCollectionFactory;

/**
 * Custom Attribute Renderer
 */

class Options extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @var VendorCollectionFactory
     */
    protected $vendorCollectionFactory;

    public function __construct(
        VendorCollectionFactory $vendorCollectionFactory
    ) {
        $this->vendorCollectionFactory = $vendorCollectionFactory;
    }

    public function getAllOptions()
    {
        $vendorCollection = $this->vendorCollectionFactory->create();
        $this->_options[] = ['label' => '-- Please select --', 'value' => ''];
        foreach($vendorCollection as $vendor)
        {
            $this->_options[] = ['label' => $vendor->getName(), 'value' => $vendor->getId()];
        }
        return $this->_options;
    }
}
