<?php

namespace SebTech\FAQTwo\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface QuestionCategoryRelationInterface extends ExtensibleDataInterface
{
    const RELATION_ID = 'relation_id';
    const QUESTION_ID  = 'question_id';
    const CATEGORY_ID = 'category_id';

    public function getId();

    public function setId($value): self;

    public function getCategoryId(): int;

    public function setCategoryId(int $categoryId): self;

    public function getQuestionId(): int;

    public function setQuestionId(int $categoryId): self;
}
