<?php

namespace SebTech\FAQTwo\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Question extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('sebtech_question_two', 'id');
    }
}
