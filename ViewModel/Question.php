<?php

namespace SebTech\FAQTwo\ViewModel;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use SebTech\FAQTwo\Api\Data\QuestionSearchResultsInterface;
use SebTech\FAQTwo\Model\QuestionRepository;
use SebTech\FAQTwo\Model\ResourceModel\Question\Collection as QuestionCollection;

class Question implements ArgumentInterface
{
    private QuestionRepository $questionRepository;
    private QuestionCollection $collectionQuestion;

    /**
     * @param QuestionRepository $questionRepository
     * @param QuestionCollection $collectionQuestion
     */
    public function __construct(
        QuestionRepository $questionRepository,
        QuestionCollection $collectionQuestion

    ) {
        $this->questionRepository = $questionRepository;
        $this->collectionQuestion = $collectionQuestion;
    }

    /**
     * @return \Magento\Framework\DataObject[]
     */
    public function getQuestions()
    {
        return $this->collectionQuestion->getItems();
    }

    public function getQuestionsAsJson()
    {
        return json_encode($this->getQuestions());
    }
}
