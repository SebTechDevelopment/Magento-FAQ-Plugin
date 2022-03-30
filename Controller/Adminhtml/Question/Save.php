<?php

declare(strict_types=1);

namespace SebTech\FAQTwo\Controller\Adminhtml\Question;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use SebTech\FAQTwo\Model\QuestionCategoryRelation;
use SebTech\FAQTwo\Model\QuestionCategoryRepository;
use SebTech\FAQTwo\Model\QuestionRepository;
use Magento\Framework\Controller\ResultInterface;
use SebTech\FAQTwo\Model\Question;
use SebTech\FAQTwo\Model\QuestionFactory;
use SebTech\FAQTwo\Model\QuestionCategoryRelationFactory;

class Save extends \Magento\Backend\App\Action
{
    protected DataPersistorInterface $dataPersistor;
    private QuestionRepository $questionRepository;
    private QuestionFactory $questionFactory;
    private QuestionCategoryRelationFactory $questionCategoryRelationFactory;
    private QuestionCategoryRepository $questionCategoryRepository;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param QuestionRepository $questionRepository
     * @param QuestionFactory $questionFactory
     * @param QuestionCategoryRelationFactory $questionCategoryRelationFactory
     * @param QuestionCategoryRepository $questionCategoryRepository
     */
    public function __construct(
        Context                         $context,
        DataPersistorInterface          $dataPersistor,
        QuestionRepository              $questionRepository,
        QuestionFactory                 $questionFactory,
        QuestionCategoryRelationFactory $questionCategoryRelationFactory,
        QuestionCategoryRepository      $questionCategoryRepository
    ) {
        parent::__construct($context);
        $this->dataPersistor = $dataPersistor;
        $this->questionRepository = $questionRepository;
        $this->questionFactory = $questionFactory;
        $this->questionCategoryRelationFactory = $questionCategoryRelationFactory;
        $this->questionCategoryRepository = $questionCategoryRepository;
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
            $model = $this->questionFactory->create();
            $questionCategoryRelationModel = $this->questionCategoryRelationFactory->create();
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                try {
                    $model = $this->questionRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This Question post no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            $model->setData($data);


            try {
                /** Save Model */
                $this->questionRepository->save($model);

                /** Save relation */
                $questionCategoryRelationModel->setCategoryId((int)$this->getRequest()->getParam('category_id'));
                $questionCategoryRelationModel->setQuestionId((int)$model->getId());
                $this->questionCategoryRepository->save($questionCategoryRelationModel);

                $this->messageManager->addSuccessMessage(__('You saved the question post.'));
                $this->dataPersistor->clear('sebtech_faq');
                return $this->processQuestionReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the question.'));
            }
            $this->dataPersistor->set('sebtech_question', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }


    private function processQuestionReturn(Question $model, array $data, ResultInterface $resultRedirect): ResultInterface
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

