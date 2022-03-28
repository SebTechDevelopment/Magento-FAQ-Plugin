<?php

namespace SebTech\FAQTwo\Model\ResourceModel\Category;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection  extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(\SebTech\FAQTwo\Model\Category::class, \SebTech\FAQTwo\Model\ResourceModel\Category::class);
    }
}
