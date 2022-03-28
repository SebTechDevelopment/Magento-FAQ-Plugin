<?php

namespace SebTech\FAQTwo\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface CategorySearchResultsInterface extends SearchResultsInterface
{
    public function getItems(): array;

    public function setItems(array $items);
}
