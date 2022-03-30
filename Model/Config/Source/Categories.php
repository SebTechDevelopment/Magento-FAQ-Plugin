<?php

namespace SebTech\FAQTwo\Model\Config\Source;

use SebTech\FAQTwo\Model\Category;
use SebTech\FAQTwo\Model\ResourceModel\Category\Collection;

class Categories implements \Magento\Framework\Data\OptionSourceInterface
{

    private Collection $collection;

    public function __construct(
        Collection $collection
    ) {
        $this->collection = $collection;
    }

    public function toOptionArray()
    {
        $categories = $this->collection->getItems();
        $options = array();

        /** @var Category $category */
        foreach ($categories as $category) {
            $options[] = ["label" =>  "{$category->getId()} - {$category->getTitle()}", "value" => "{$category->getId()}"];
        }
        return $options;
    }
}
