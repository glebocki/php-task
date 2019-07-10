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
                'tax_rate' => $item->getProduct()->getTaxRate() . '%',
                'quantity' => $item->getQuantity(),
                'total_price' => $item->getTotalPrice(),
                'total_price_gross' => $item->getTotalPriceGross(),
            ];
        }

        return [
            'id' => $this->id,
            'items' => $items,
            'total_price' => $this->getTotalPrice(),
            'total_price_gross' => $this->getTotalPriceGross(),
        ];
    }

    private function getTotalPriceGross()
    {
        $totalPriceGross = 0;
        foreach ($this->items as $item) {
            $totalPriceGross += $item->getTotalPriceGross();
        }
        return $totalPriceGross;
    }
}
