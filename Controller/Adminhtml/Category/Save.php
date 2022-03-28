<?php

declare(strict_types=1);

namespace SebTech\FAQTwo\Controller\Adminhtml\Category;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use SebTech\FAQTwo\Model\CategoryRepository;
use Magento\Framework\Controller\ResultInterface;
use SebTech\FAQTwo\Model\Category;
use SebTech\FAQTwo\Model\CategoryFactory;

class Save extends \Magento\Backend\App\Action
{

    protected DataPersistorInterface $dataPersistor;
    private CategoryRepository $categoryRepository;
    private CategoryFactory $categoryFactory;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param CategoryRepository $categoryRepository
     * @param CategoryFactory $categoryFactory
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        CategoryRepository $categoryRepository,
        CategoryFactory $categoryFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
        $this->categoryRepository = $categoryRepository;
        $this->categoryFactory = $categoryFactory;
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $model = $this->categoryFactory->create();
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                try {
                    $model = $this->categoryRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This Category post no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            $model->setData($data);
            try {
                $this->categoryRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the category post.'));
                $this->dataPersistor->clear('sebtech_faq');
                return $this->processCategoryReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the category.'));
            }
            $this->dataPersistor->set('sebtech_category', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }


    private function processCategoryReturn(Category $model, array $data, ResultInterface $resultRedirect): ResultInterface
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect ==='continue') {
            $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        }
        return $resultRedirect;
    }
}

