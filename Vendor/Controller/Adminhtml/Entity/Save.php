<?php
namespace Intern\Vendor\Controller\Adminhtml\Entity;
use Magento\Backend\App\Action;
use Intern\Vendor\Model\VendorFactory as VendorFactory;
use Magento\Backend\App\Action\Context;

class Save extends Action
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
            if(is_array($vendor)) {
                $vendorModel = $this->vendorFactory->create();
                $vendorModel
                    ->setName($vendor['name'])
                    ->setEmail($vendor['email'])
                    ->setTelephone($vendor['telephone'])
                    ->setStatus($vendor['status'])
                    ->save();
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
