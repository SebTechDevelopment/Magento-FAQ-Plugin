<?php

namespace SebTech\FAQTwo\Model\ResourceModel\Question;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SebTech\FAQTwo\Model\Question;

class Collection extends AbstractCollection
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Question::class, \SebTech\FAQTwo\Model\ResourceModel\Question::class);
    }
}
