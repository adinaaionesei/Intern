<?php
namespace Intern\Vendor\Observer;

use Intern\Vendor\Model\VendorFactory as VendorFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Psr\Log\LoggerInterface;
use Magento\Store\Model\StoreManagerInterface;

class EmailNotify implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var VendorFactory
     */
    protected $vendorFactory;
    protected $_inlineTranslation;
    protected $_transportBuilder;
    protected $_scopeConfig;
    protected $_logLoggerInterface;
    protected $storeManager;


    public function __construct(
        VendorFactory $vendorFactory,
        StateInterface $inlineTranslation,
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig,
        LoggerInterface $loggerInterface,
        StoreManagerInterface $storeManager
    )
    {
        $this->vendorFactory = $vendorFactory;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_logLoggerInterface = $loggerInterface;
        $this->storeManager = $storeManager;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /* @var $order \Magento\Sales\Model\Order */
        $order = $observer->getEvent()->getData('order');
        $shipping = $order->getShippingAddress();
        $items = $order->getAllItems();

        foreach ($items as $item) {
            $product = $item->getProduct();
            $productType = $product->getTypeID();

            if (($productType == "virtual") || ($productType == "downloadable")) {
                return $this;
            }
            if ($product->getVendor()) {
                $vendor = $this->vendorFactory->create()->load($product->getVendor());

                if (($vendor->getStatus() == 1) && ($vendor->getNotifyOrders() == 1)) {
                    try {
                        // Send Mail
                        $this->_inlineTranslation->suspend();

                        $sender = [
                            'name' => $this->_scopeConfig->getValue('trans_email/ident_general/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
                            'email' => $this->_scopeConfig->getValue('trans_email/ident_general/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE)
                        ];

                        $transport = $this->_transportBuilder
                            ->setTemplateIdentifier('vendor_email_template')
                            ->setTemplateOptions(
                                [
                                    'area' => 'frontend',
                                    'store' => $this->storeManager->getStore()->getId()
                                ]
                            )
                            ->addCc(explode(',', $vendor->getCcEmails()))
                            ->setTemplateVars([
                                'sku' => $product->getSku(),
                                'product_name' => $product->getName(),
                                'quantity' => $item->getQtyOrdered(),
                                'email_address' => $shipping->getEmail(),
                                'first_name' => $shipping->getFirstname(),
                                'last_name' => $shipping->getLastname(),
                                'company' => $shipping->getCompany(),
                                'street_address' => $shipping->getStreetLine(1),
                                'country' => $shipping->getCountryId(),
                                'state_province' => $shipping->getRegion(),
                                'city' => $shipping->getCity(),
                                'zip_postal_code' => $shipping->getPostcode(),
                                'phone_number' => $shipping->getTelephone()
                            ])
                            ->setFromByScope($sender)
                            ->addTo($vendor->getEmail(), $vendor->getName())
                            ->getTransport();

                        $transport->sendMessage();
                        $this->_inlineTranslation->resume();

                    } catch (\Exception $e) {
                        $this->_logLoggerInterface->debug($e->getMessage());
                        exit;
                    }
                }
            }
        }
        return $this;
    }
}
