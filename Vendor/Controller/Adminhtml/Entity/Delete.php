<?php
namespace Intern\Vendor\Controller\Adminhtml\Entity;
use Intern\Vendor\Model\VendorFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Delete extends Action
{
    /**
     * @var VendorFactory
     */
    protected $vendorFactory;

    public function __construct(
        Context $context,
        VendorFactory $vendorFactory
    )
    {
        $this->vendorFactory = $vendorFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('vendor_id');
        try {
            $vendor = $this->vendorFactory->create()->load($id);
            $vendor->delete();
            $this->messageManager->addSuccessMessage(__('Vendor has been deleted!'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error while trying to delete Vendor'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/menu/index', array('_current' => true));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/menu/index', array('_current' => true));
    }
}
