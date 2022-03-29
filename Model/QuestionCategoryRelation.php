<?php

namespace SebTech\FAQTwo\Model;

use SebTech\FAQTwo\Api\Data\QuestionCategoryRelationInterface;
use SebTech\FAQTwo\Model\ResourceModel\QuestionCategoryRelation as Resource;

use Magento\Framework\Model\AbstractModel;

class QuestionCategoryRelation extends AbstractModel implements QuestionCategoryRelationInterface
{
    const CACHE_TAG = 'faq_category_question_blog_rel';

    protected $_cacheTag = self::CACHE_TAG;

    protected $_eventPrefix = 'faq_question_faq_category_relation';

    protected function _construct()
    {
        $this->_init(Resource::class);
    }

    public function getId()
    {
        return $this->getData(self::RELATION_ID);
    }

    public function setId($value): QuestionCategoryRelationInterface
    {
        return $this->setData(self::RELATION_ID, $value);
    }

    public function getCategoryId(): int
    {
        return $this->getData(self::CATEGORY_ID);
    }

    public function setCategoryId(int $categoryId): QuestionCategoryRelationInterface
    {
        return $this->setData(self::CATEGORY_ID, $categoryId);
    }

    public function getQuestionId(): int
    {
        return $this->getData(self::QUESTION_ID);
    }

    public function setQuestionId(int $categoryId): QuestionCategoryRelationInterface
    {
        return $this->setData(self::QUESTION_ID, $categoryId);
    }
}
