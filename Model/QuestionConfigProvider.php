<?php

namespace SebTech\FAQTwo\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class QuestionConfigProvider
{
    protected $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function getConfig(): array
    {
        return [
            'store_address' => [
                'name' => $this->scopeConfig->getValue('general/store_information/name'),
                'city' => $this->scopeConfig->getValue('shipping/origin/city'),
            ]
        ];
    }
}
