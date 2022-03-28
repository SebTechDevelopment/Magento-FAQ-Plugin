<?php

namespace SebTech\FAQTwo\Model\Category;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use SebTech\FAQTwo\Model\Category;
use SebTech\FAQTwo\Model\ResourceModel\Category\CollectionFactory;

class DataProvider  extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{

    protected $collection;

    protected $dataPersistor;

    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $blockCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $blockCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var Category $category */
        foreach ($items as $category) {
            $this->loadedData[$category->getId()] = $category->getData();
        }

        $data = $this->dataPersistor->get('sebtech_faqtwo_category');
        if (!empty($data)) {
            $category = $this->collection->getNewEmptyItem();
            $category->setData($data);
            $this->loadedData[$category->getId()] = $category->getData();
            $this->dataPersistor->clear('sebtech_faqtwo_category');
        }

        return $this->loadedData;
    }
}
