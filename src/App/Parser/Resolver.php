<?php

namespace App\Parser;

class Resolver
{
    /**
     * @param string $content
     * @return Result[]
     */
    public function findItems(string $content): array
    {
        $productList = $this->strBetween(
            $content,
            $itemTagStart = '<div class="products-list__item product-card js-reveal"',
            '<div class="products-list__pager js-list-progress"'
            );
        $items = explode($itemTagStart, $productList);

        $results = array_map(function (string $item) {
            return new Result(
                $this->strBetween($item, '<a href="', '"'),
                $this->strBetween($item, 'class="link">', '</a'),
                $this->strBetween($item, 'price__current ">', '</span'),
                $this->strBetween($item, 'srcset="', ' 2x"'),
                $this->strBetween($item, 'alt="', '">')
            );
        }, $items);

        return array_filter($results, function (Result $item) {
            return $item->isFilledFully();
        });
    }

    private function strBetween($haystack, $after, $before): string
    {
        if (!is_string($haystack) || empty($haystack)) {
            return '';
        }
        $start = strpos($haystack, $after) + strlen($after);
        $end = strpos($haystack, $before, $start);
        return substr($haystack, $start, $end-$start);
    }
}