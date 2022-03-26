<?php

namespace SebTech\FAQTwo\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Content extends Column
{
    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ){
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item['content'] = $this->cleanContent($item['content'], "#", "}", "");
            }
        }
        return $dataSource;
    }

    /**
     * @param string $str
     * @param string $start
     * @param string $end
     * @param string $replacement
     * @return array|string|string[]|null
     */
    function cleanContent(string $str, string $start, string $end, string $replacement): string
    {
        $replacement = $start . $replacement . $end;
        $start = preg_quote($start, '/');
        $end = preg_quote($end, '/');
        $regex = "/({$start})(.*?)({$end})/";
        $result = preg_replace($regex,$replacement,$str);
        $secondResult = strip_tags(substr($result,0,450));
        return str_replace("#}", "",$secondResult . "...." );
    }
}
