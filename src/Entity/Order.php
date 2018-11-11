<?php

namespace Recruitment\Entity;

use Recruitment\Cart\Item;

class Order
{
    /** @var int */
    private $id;

    /** @var $items Item[] Items in Order*/
    private $items = [];

    /**
     * Order constructor.
     * @param int $id
     * @param array $items
     */
    public function __construct(int $id, array $items)
    {
        $this->id = $id;
        $this->items = $items;
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        $totalPrice = 0;
        foreach ($this->items as $item) {
            $totalPrice += $item->getTotalPrice();
        }
        return $totalPrice;
    }

    /**
     * @return array
     */
    public function getDataForView(): array
    {
        $items = [];
        foreach ($this->items as $item) {
            $items[] = [
                'id' => $item->getProduct()->getId(),
                'quantity' => $item->getQuantity(),
                'total_price' => $item->getTotalPrice(),
            ];
        }

        return [
            'id' => $this->id,
            'items' => $items,
            'total_price' => $this->getTotalPrice(),
            'total_gross_price' => $this->getTotalGrossPrice(),
        ];
    }

    private function getTotalGrossPrice()
    {
        $totalGrossPrice = 0;
        foreach ($this->items as $item) {
            $totalGrossPrice += $item->getTotalPriceGross();
        }
        return $totalGrossPrice;
    }
}
