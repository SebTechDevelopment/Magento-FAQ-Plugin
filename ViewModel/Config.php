<?php

namespace SebTech\FAQTwo\ViewModel;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use SebTech\FAQTwo\Api\Data\QuestionSearchResultsInterface;
use SebTech\FAQTwo\Model\QuestionRepository;
use SebTech\FAQTwo\Model\ResourceModel\Question\Collection as QuestionCollection;
use SebTech\FAQTwo\Model\ResourceModel\Category\Collection as CategoryCollection;

class Config implements ArgumentInterface
{
    private QuestionRepository $questionRepository;
    private QuestionCollection $collectionQuestion;
    private CategoryCollection $collectionCategory;

    /**
     * @param QuestionRepository $questionRepository
     * @param QuestionCollection $collectionQuestion
     * @param CategoryCollection $collectionCategory
     */
    public function __construct(
        QuestionRepository $questionRepository,
        QuestionCollection $collectionQuestion,
        CategoryCollection $collectionCategory
    ) {
        $this->questionRepository = $questionRepository;
        $this->collectionQuestion = $collectionQuestion;
        $this->collectionCategory = $collectionCategory;
    }

    /**
     * @return \Magento\Framework\DataObject[]
     */
    public function getQuestions(): array
    {
        return $this->collectionQuestion->getItems();
    }

    /**
     * @return \Magento\Framework\DataObject[]
     */
    public function getCategories(): array
    {
        return $this->collectionCategory->getItems();
    }

    public function getQuestionsAsArray(): array
    {
        $questions = $this->getQuestions();
        $result = [];
        foreach($questions as $question) {
            $result[] = $question->toArray();
        }

        return $result;
    }

    public function getCategoriesAsArray(): array
    {
        $categories = $this->getCategories();
        $result = [];
        foreach ($categories as $category) {
            $result[] = $category->toArray();
        }

        return $result;
    }

}
