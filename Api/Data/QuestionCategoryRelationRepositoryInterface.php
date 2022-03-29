<?php

namespace SebTech\FAQTwo\Api\Data;

use SebTech\FAQTwo\Model\QuestionCategoryRelation as QuestionCategoryModel;
use SebTech\FAQTwo\Model\ResourceModel\QuestionCategoryRelation\Collection as QuestionCategoryRelationCollection;
use SebTech\FAQTwo\Api\Data\QuestionCategoryRelationInterface;
use SebTech\FAQTwo\Model\ResourceModel\Question\Collection as QuestionCollection;

interface QuestionCategoryRelationRepositoryInterface
{
    public function newModel(): QuestionCategoryModel;

    public function newCollection(): QuestionCategoryRelationCollection;

    public function create(int $categoryId, int $questionId): QuestionCategoryModel;

    public function save(QuestionCategoryRelationInterface $relation): QuestionCategoryRelationInterface;

    public function getByQuestionId(int $questionId): QuestionCategoryRelationCollection;

    public function getByCategoryId(int $categoryId): QuestionCategoryRelationCollection;

    public function delete(QuestionCategoryRelationInterface $relation): bool;

    public function deleteByQuestionId(int $questionId): bool;

    public function deleteById(int $categoryId, int $questionId): bool;

    public function deleteByCategoryIds(array $categoryIds, ?int $questionId = null): bool;

    public function getRelatedCategorysByQuestionId(int $questionId): QuestionCollection;

    public function getRelatedCategoryIdsByQuestionId(int $questionId): array;
}
