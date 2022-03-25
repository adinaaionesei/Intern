<?php
namespace Intern\Vendor\Controller\Adminhtml\Entity;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Intern\Vendor\Model\VendorFactory as VendorFactory;

class Edit extends Action
{
    protected $_coreRegistry = null;
    /**
     * @var VendorFactory
     */
    protected $vendorFactory;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        VendorFactory $vendorFactory
    )
    {
        $this->_coreRegistry = $coreRegistry;
        $this->vendorFactory = $vendorFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $vendorModel = $this->vendorFactory->create();
        $vendorId = $this->getRequest()->getParam('vendor_id');

        if($vendorId)
            $vendorModel->load($vendorId);

        $this->_getSession()->setData('current_vendor', $vendorModel->getData());
        $this->_view->loadLayout();

        if($vendorModel->getId()) {
            $breadcrumbTitle = __('Edit Vendor');
            $breadcrumbLabel = __('Edit Vendor');
        } else {
            $breadcrumbTitle = __('New Vendor');
            $breadcrumbLabel = __('New Vendor');
        }
        $this->_view->getPage()->getConfig()->getTitle()->prepend($vendorModel->getId() ? __('Edit Vendor') : __('New Vendor'));
        $this->_addBreadcrumb($breadcrumbLabel, $breadcrumbTitle);

        // restore data
        $values = $this->_getSession()->getData('current_vendor', true);
//var_dump($values);die;
        if ($values) {
            $vendorModel->addData($values);
        }

        $this->_view->renderLayout();
    }
}
