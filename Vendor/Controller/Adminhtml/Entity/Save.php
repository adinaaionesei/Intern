<?php
namespace Intern\Vendor\Controller\Adminhtml\Entity;
use Magento\Backend\App\Action;
use Intern\Vendor\Model\VendorFactory as VendorFactory;
use Intern\Vendor\Model\AddressFactory as AddressFactory;
use Magento\Backend\App\Action\Context;

class Save extends Action
{
    /**
     * @var VendorFactory
     */
    protected $vendorFactory;

    /**
     * @var VendorFactory
     */
    protected $addressFactory;

    public function __construct(
        Context $context,
        VendorFactory $vendorFactory,
        AddressFactory $addressFactory
    )
    {
        $this->vendorFactory = $vendorFactory;
        $this->addressFactory = $addressFactory;
        parent::__construct($context);
    }
    /**
     * Edit A Vendor Page
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $vendor = $this->getRequest()->getParam('vendor');
            $settings = $this->getRequest()->getParam('settings');
            $addresses = $this->getRequest()->getParam('addresses');

            if(is_array($vendor)) {
                $vendorModel = $this->vendorFactory->create();
                if(isset($vendor['vendor_id'])) {
                    $vendorModel->load($vendor['vendor_id']);
                }
                $vendorModel
                    ->setName($vendor['name'])
                    ->setEmail($vendor['email'])
                    ->setTelephone($vendor['telephone'])
                    ->setStatus($vendor['status'])
                    ->setCurrency($settings['currency'])
                    ->setNotifyOrders($settings['notify_orders'])
                    ->setCcEmails($settings['cc_emails'])
                    ->save();
            }
            if(is_array($addresses)) {
                $shipping = $addresses['shipping_address'];
                $billing = $addresses['billing_address'];
                $billingAddress = $this->addressFactory->create();
                if(isset($billing['address_id'])) {
                    $billingAddress->load($billing['address_id']);
                }
                $billingAddress
                    ->setContactName($billing['contact_name'])
                    ->setAddressType('billing')
                    ->setVendorId($vendorModel->getId())
                    ->setStreet($billing['street'])
                    ->setCity($billing['city'])
                    ->setPostalCode($billing['postal_code'])
                    ->setCountry($billing['country'])
                    ->setStateRegion($billing['state_region'])
                    ->setSameAsBilling(0);
                if($shipping['same_as_billing'] == 1) {
                    $billingAddress->setSameAsBilling(1);
                } else {
                    $shippingAddress = $this->addressFactory->create();
                    if(isset($shipping['shipping_address_id'])) {
                        $shippingAddress->load($shipping['shipping_address_id']);
                    }
                    $shippingAddress
                        ->setContactName($shipping['shipping_contact_name'])
                        ->setAddressType('shipping')
                        ->setVendorId($vendorModel->getId())
                        ->setStreet($shipping['shipping_street'])
                        ->setCity($shipping['shipping_city'])
                        ->setPostalCode($shipping['shipping_postal_code'])
                        ->setCountry($shipping['shipping_country'])
                        ->setStateRegion($shipping['shipping_state_region'])
                        ->save();
                }
                $billingAddress->save();
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $resultRedirect->setPath('*/*/edit');
        }

        $this->messageManager->addSuccessMessage(__('The Vendor has been saved.'));
        if ($this->getRequest()->getParam('back')) {
            return $resultRedirect->setPath('*/*/edit', ['vendor_id' => $vendorModel->getId(), '_current' => true]);
        }

        return $resultRedirect->setPath('*/menu/index');
    }
}
