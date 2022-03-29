<?php

namespace SebTech\FAQTwo\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use SebTech\FAQTwo\Api\Data\QuestionCategoryRelationInterface;


class QuestionCategoryRelation extends AbstractDb
{
    const TABLE_NAME = 'faq_category_faq_question_relation';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, QuestionCategoryRelationInterface::RELATION_ID);
    }
}
