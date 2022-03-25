<?php
namespace Intern\Vendor\Controller\Adminhtml\Entity;
use Intern\Vendor\Model\ResourceModel\Vendor;
use Magento\Backend\App\Action;
use Intern\Vendor\Model\VendorFactory as VendorFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class NewVendor extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Context     $context,
        PageFactory $resultPageFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
    /**
     * Edit A Vendor Page
     *
     * @return \Magento\Framework\View\Result\Page
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute() {
        $this->_view->getPage()->getConfig()->getTitle()->prepend( __('New Vendor'));
        $resultPage = $this->resultPageFactory->create();

        return $resultPage;
    }
}
