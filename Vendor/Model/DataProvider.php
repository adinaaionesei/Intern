<?php
namespace Intern\Vendor\Model;

use Intern\Vendor\Model\ResourceModel\Vendor\CollectionFactory as VendorCollectionFactory;
use Intern\Vendor\Model\ResourceModel\Address\CollectionFactory as AddressCollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{

    protected $loadedData;

    protected $addressCollection;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $vendorCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        VendorCollectionFactory $vendorCollectionFactory,
        AddressCollectionFactory $addressCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $vendorCollectionFactory->create()->load();
        $this->addressCollection = $addressCollectionFactory;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = array();


        foreach ($items as $vendor) {
            $this->loadedData[$vendor->getId()]['vendor'] = $vendor->getData();
            $this->loadedData[$vendor->getId()]['settings'] = [
                'cc_emails' => $vendor->getCcEmails(),
                'currency' => $vendor->getCurrency(),
                'notify_orders' => $vendor->getNotifyOrders()
            ];

            $addresses = $this->getAddressByVendor($vendor->getId());
            foreach ($addresses as $address) {
                if($address->getAddressType() == 'billing') {
                    $this->loadedData[$vendor->getId()]['addresses']['billing_address'] = $address->getData();
                    $sameAsBilling = $address->getSameAsBilling();
                } else {
                    $this->loadedData[$vendor->getId()]['addresses']['shipping_address'] = $address->getData();
                    $this->loadedData[$vendor->getId()]['addresses']['shipping_address']['same_as_billing'] = $sameAsBilling;
                }
            }
        }

        return $this->loadedData;

    }

    public function getAddressByVendor($vendorId)
    {
        return $this->addressCollection->create()
            ->addFieldToFilter('vendor_id', $vendorId);
    }

}
