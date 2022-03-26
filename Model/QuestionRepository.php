<?php

namespace SebTech\FAQTwo\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;


use SebTech\FAQTwo\Api\Data\QuestionSearchResultsInterface;
use SebTech\FAQTwo\Model\ResourceModel\Question as QuestionResource;
use SebTech\FAQTwo\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;


class QuestionRepository
{
    private QuestionResource $questionResource;
    private QuestionFactory $questionFactory;
    private QuestionCollectionFactory $questionCollectionFactory;
    private CollectionProcessorInterface $collectionProcessor;

    public function __construct(
        QuestionResource $questionResource,
        QuestionFactory $questionFactory,
        QuestionCollectionFactory $questionCollectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->questionResource = $questionResource;
        $this->questionFactory = $questionFactory;
        $this->questionCollectionFactory = $questionCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @throws CouldNotSaveException
     */
    public function save(Question $question): Question
    {
        try {
            $this->questionResource->save($question);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $question;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getById($questionId): Question
    {
        $details = $this->questionFactory->create();
        $this->questionResource->load($details, $questionId);

        if (!$details->getId()) {
            throw new NoSuchEntityException(__('The question ID "%1" doesn\'t exist.', $questionId));
        }
        return $details;
    }

    public function getList(SearchCriteriaInterface $criteria): QuestionSearchResultsInterface
    {
        $collection = $this->questionCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @throws CouldNotDeleteException
     */
    public function delete(Question $question): bool
    {
        try {
            $this->questionResource->delete($question);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    public function deleteById(int $questionId): bool
    {
        return $this->delete($this->getById($questionId));
    }

}
