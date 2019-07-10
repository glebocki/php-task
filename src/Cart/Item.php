<?php

namespace Recruitment\Cart;

use InvalidArgumentException;
use Recruitment\Cart\Exception\QuantityTooLowException;
use Recruitment\Entity\Product;

/**
 * Class Item - Product with specified quantity in a Cart
 * @package Recruitment\Cart
 */
class Item
{
    /** @var Product */
    private $product;
    /** @var int */
    private $quantity;

    /**
     * Item constructor.
     * @param Product $product
     * @param int $quantity
     */
    public function __construct(Product $product, int $quantity)
    {
        if ($quantity < $product->getMinimumQuantity()) {
            throw new InvalidArgumentException();
        }

        $this->product = $product;
        $this->quantity = $quantity;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        return $this->quantity * $this->product->getUnitPrice();
    }

    /**
     * @return int
     */
    public function getTotalPriceGross(): int
    {
        $taxPercentage = $this->product->getTaxRate() / 100;
        $totalPrice = $this->getTotalPrice();
        $tax = $totalPrice * $taxPercentage;
        $totalPriceGross = $totalPrice + $tax;
        return $totalPriceGross;
    }

    /**
     * @param int $quantity
     * @throws
     */
    public function setQuantity(int $quantity): void
    {
        if ($quantity < $this->product->getMinimumQuantity()) {
            throw new QuantityTooLowException;
        }

        $this->quantity = $quantity;
    }
}
