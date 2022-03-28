<?php

namespace SebTech\FAQTwo\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Category extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('sebtech_category_two', 'id');
    }
}
