<?php
namespace Intern\Vendor\Block\Adminhtml\Vendor\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\App\RequestInterface;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * Url Builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * Registry
     *
     * @var RequestInterface
     */
    protected $request;

    /**
     * @param Context $context
     * @param RequestInterface $request
     */
    public function __construct(
        Context $context,
        RequestInterface $request
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->request = $request;
    }

    /**
     * Return the vendor id
     *
     * @return int|null
     */
    public function getId()
    {
        $vendorId = $this->request->getParam('vendor_id');
        return $vendorId;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
