<?php

namespace SebTech\FAQTwo\Model\ResourceModel\QuestionCategoryRelation;

use Magento\Cms\Model\ResourceModel\AbstractCollection;
use SebTech\FAQTwo\Model\QuestionCategoryRelation as QuestionCategoryRelationModel;
use SebTech\FAQTwo\Model\ResourceModel\QuestionCategoryRelation as QuestionCategoryRelationResource;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(
            QuestionCategoryRelationModel::class,
            QuestionCategoryRelationResource::class
        );
    }

    public function addStoreFilter($store, $withAdmin = true): self
    {
        if (!$this->getFlag('store_filter_added')) {
            $this->performAddStoreFilter($store, $withAdmin);
            $this->setFlag('store_filter_added', true);
        }

        return $this;
    }
}
