<?php

namespace SebTech\FAQTwo\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use SebTech\FAQTwo\Api\Data\QuestionCategoryRelationInterface;
use SebTech\FAQTwo\Api\Data\QuestionCategoryRelationRepositoryInterface;
use SebTech\FAQTwo\Model\QuestionCategoryRelation as QuestionCategoryModel;
use SebTech\FAQTwo\Model\ResourceModel\Question\Collection as QuestionCollection;
use SebTech\FAQTwo\Model\ResourceModel\QuestionCategoryRelation\Collection as QuestionCategoryRelationCollection;

use SebTech\FAQTwo\Model\ResourceModel\QuestionCategoryRelation as QuestionCategoryRelationResource;
use SebTech\FAQTwo\Model\QuestionCategoryRelationFactory as QuestionCategoryRelationModelFactory;
use SebTech\FAQTwo\Model\ResourceModel\QuestionCategoryRelation\CollectionFactory as QuestionCategoryRelationCollectionFactory;
use SebTech\FAQTwo\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;

class QuestionCategoryRepository implements QuestionCategoryRelationRepositoryInterface
{

    private QuestionCategoryRelationResource $resource;
    private QuestionCategoryRelationFactory $productBlogRelationModelFactory;
    private QuestionCategoryRelationCollectionFactory $productBlogRelationCollectionFactory;
    private QuestionCollectionFactory $blogCollectionFactory;

    public function __construct(
        QuestionCategoryRelationResource $resource,
        QuestionCategoryRelationModelFactory $productBlogRelationModelFactory,
        QuestionCategoryRelationCollectionFactory $productBlogRelationCollectionFactory,
        QuestionCollectionFactory $blogCollectionFactory
    ) {
        $this->resource = $resource;
        $this->productBlogRelationModelFactory = $productBlogRelationModelFactory;
        $this->productBlogRelationCollectionFactory = $productBlogRelationCollectionFactory;
        $this->blogCollectionFactory = $blogCollectionFactory;
    }

    public function newModel(): QuestionCategoryModel
    {
        return $this->productBlogRelationModelFactory->create();
    }

    public function newCollection(): QuestionCategoryRelationCollection
    {
        return $this->productBlogRelationCollectionFactory->create();
    }

    public function create(int $categoryId, int $questionId): QuestionCategoryModel
    {
        $productBlogRelationModel = $this->newModel()
            ->setCategoryId($categoryId)
            ->setQuestionId($questionId);

        $this->save($productBlogRelationModel);

        return $productBlogRelationModel;
    }

    public function save(\SebTech\FAQTwo\Api\Data\QuestionCategoryRelationInterface $relation): QuestionCategoryRelationInterface
    {
        try {
            $this->resource->save($relation);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $relation;
    }

    public function getByQuestionId(int $questionId): QuestionCategoryRelationCollection
    {
        return $this->newCollection()
            ->addFieldToFilter(
                QuestionCategoryRelationInterface::QUESTION_ID,
                $questionId
            );
    }

    public function getByCategoryId(int $categoryId): QuestionCategoryRelationCollection
    {
        return $this->newCollection()
            ->addFieldToFilter(
                QuestionCategoryRelationInterface::CATEGORY_ID,
                $categoryId
            );
    }

    public function delete(\SebTech\FAQTwo\Api\Data\QuestionCategoryRelationInterface $relation): bool
    {
        try {
            $this->resource->delete($relation);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    public function deleteByQuestionId(int $questionId): bool
    {
        try {
            $this->newCollection()
                ->addFieldToFilter(QuestionCategoryRelationInterface::QUESTION_ID, $questionId)
                ->walk('delete');

            return true;
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
    }

    public function deleteById(int $categoryId, int $questionId): bool
    {
        try {
            $this->newCollection()
                ->addFieldToFilter(QuestionCategoryRelationInterface::CATEGORY_ID, $categoryId)
                ->addFieldToFilter(QuestionCategoryRelationInterface::QUESTION_ID, $questionId)
                ->walk('delete');

            return true;
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
    }

    public function deleteByCategoryIds(array $categoryIds, ?int $questionId = null): bool
    {
        try {
            $collection = $this->newCollection()
                ->addFieldToFilter(QuestionCategoryRelationInterface::CATEGORY_ID, $categoryIds);

            if ($questionId) {
                $collection->addFieldToFilter(QuestionCategoryRelationInterface::QUESTION_ID, $questionId);
            }

            $collection->walk('delete');

            return true;
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
    }

    public function getRelatedCategorysByQuestionId(int $questionId): QuestionCollection
    {
        $collection = $this->blogCollectionFactory->create();
        $tableName = $collection->getTable(QuestionCategoryRelationResource::TABLE_NAME);
        $collection
            ->addFieldToFilter(
                'product_blog_relation.product_id',
                $questionId
            )
            ->getSelect()
            ->joinLeft(
                ['product_blog_relation' => $tableName],
                'main_table.blog_id = product_blog_relation.blog_id'
            );

        return $collection;
    }

    public function getRelatedCategoryIdsByQuestionId(int $questionId): array
    {
        $collection = $this->getRelatedCategorysByQuestionId($questionId);

        $blogIds = [];
        foreach ($collection->getItems() as $blog) {
            /** @var Question $blog */
            $blogIds[] = $blog->getId();
        }

        return $blogIds;
    }
}
