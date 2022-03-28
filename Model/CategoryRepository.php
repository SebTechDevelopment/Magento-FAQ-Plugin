<?php

namespace SebTech\FAQTwo\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;

use SebTech\FAQTwo\Api\Data\CategorySearchResultsInterface;
use SebTech\FAQTwo\Model\ResourceModel\Category as CategoryResource;
use SebTech\FAQTwo\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;

class CategoryRepository
{
    private CategoryResource $categoryResource;
    private CategoryFactory $categoryFactory;
    private CategoryCollectionFactory $categoryCollectionFactory;
    private CollectionProcessorInterface $collectionProcessor;

    public function __construct(
        CategoryResource $categoryResource,
        CategoryFactory $categoryFactory,
        CategoryCollectionFactory $categoryCollectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->categoryResource = $categoryResource;
        $this->categoryFactory = $categoryFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @throws CouldNotSaveException
     */
    public function save(Category $category): Category
    {
        try {
            $this->categoryResource->save($category);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $category;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getById($categoryId): Category
    {
        $details = $this->categoryFactory->create();
        $this->categoryResource->load($details, $categoryId);

        if (!$details->getId()) {
            throw new NoSuchEntityException(__('The category ID "%1" doesn\'t exist.', $categoryId));
        }
        return $details;
    }

    public function getList(SearchCriteriaInterface $criteria): CategorySearchResultsInterface
    {
        $collection = $this->categoryCollectionFactory->create();

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
    public function delete(Category $category): bool
    {
        try {
            $this->categoryResource->delete($category);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    public function deleteById(int $categoryId): bool
    {
        return $this->delete($this->getById($categoryId));
    }

}
