<?php

namespace SebTech\FAQTwo\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface QuestionSearchResultsInterface extends SearchResultsInterface
{
    public function getItems(): array;

    public function setItems(array $items);
}
