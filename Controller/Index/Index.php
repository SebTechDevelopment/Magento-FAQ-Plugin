<?php

namespace SebTech\FAQTwo\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\ForwardFactory;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;


class Index extends Action implements HttpGetActionInterface, HttpPostActionInterface
{
    /**
     * @var PageFactory
     */
    protected PageFactory $_pageFactory;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        ResultFactory $resultFactory
    ) {
        parent::__construct($context);
        $this->_pageFactory = $pageFactory;
        $this->resultFactory = $resultFactory;
    }


    /**
     * @return ResultInterface
     */
    public function execute()
    {
        return $this->_pageFactory->create();
    }
}
