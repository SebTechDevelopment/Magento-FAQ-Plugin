<?php

namespace SebTech\FAQTwo\Model;

use Magento\Framework\Model\AbstractModel;
use SebTech\FAQTwo\Api\Data\CategoryInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Category extends AbstractModel
{
    const CACHE_TAG = 'category_d';
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;


    protected function _construct()
    {
        $this->_init(\SebTech\FAQTwo\Model\ResourceModel\Category::class);
    }

    /**
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return (string)$this->getData('title');
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->setData('title', $title);
    }

    /**
     * @param bool $enabled
     * @return void
     */
    public function setEnabled(bool $enabled): void
    {
        $this->setData('enabled', $enabled);
    }

    /**
     * @return bool
     */
    public function getEnabled(): bool
    {
        return $this->getData('enabled');
    }

    /**
     * @return array
     */
    public function getAvailableStatuses(): array
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}
