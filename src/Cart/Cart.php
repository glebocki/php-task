<?php

namespace Recruitment\Cart;

use OutOfBoundsException;
use Recruitment\Entity\Order;
use Recruitment\Entity\Product;

/**
 * Shopping cart with a list of products and their quantities.
 * @package Recruitment\Cart
 */
class Cart
{
    /** @var $items Item[] Items in Cart */
    private $items = [];

    /**
     * Adds a product to Cart. If product was already in Cart increases its
     * quantity.
     *
     * @param Product $product
     * @param int $quantity
     * @return Cart
     * @throws Exception\QuantityTooLowException
     */
    public function addProduct(Product $product, int $quantity = 1): Cart
    {
        // Look for Product on list. If found increase quantity.
        if ($item = $this->findItemByProduct($product)) {
            $item->setQuantity($item->getQuantity() + $quantity);
        } else {
            // Add new Item to list
            $this->items[] = new Item($product, $quantity);
        }

        return $this;
    }

    private function findItemByProduct($product): ?Item
    {
        foreach ($this->items as $item) {
            if ($item->getProduct() === $product) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Returns a list of items in cart with their quantities.
     *
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
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
     * @return int
     */
    public function getTotalPriceGross(): int
    {
        $totalPrice = 0;
        foreach ($this->items as $item) {
            $totalPrice += $item->getTotalPriceGross();
        }
        return $totalPrice;
    }

    /**
     * @param int $index
     * @return Item
     */
    public function getItem(int $index): Item
    {
        if (array_key_exists($index, $this->items)) {
            return $this->items[$index];
        } else {
            throw new OutOfBoundsException();
        }
    }

    /**
     * @param Product $product
     */
    public function removeProduct(Product $product): void
    {
        foreach ($this->items as $key => $item) {
            if ($item->getProduct() === $product) {
                unset($this->items[$key]);
                break;
            }
        }
        $this->items = array_values($this->items);
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return Cart
     * @throws Exception\QuantityTooLowException
     */
    public function setQuantity(Product $product, int $quantity): Cart
    {
        // Look for Product on list. If found update quantity and exit.
        foreach ($this->items as $item) {
            if ($item->getProduct() === $product) {
                $item->setQuantity($quantity);
                return $this;
            }
        }

        return $this->addProduct($product, $quantity);
    }

    /**
     * @param int $orderId
     * @return Order
     */
    public function checkout(int $orderId): Order
    {
        $order = new Order($orderId, $this->items);
        $this->clearCart();
        return $order;
    }

    /**
     * Clears carts items list.
     */
    private function clearCart(): void
    {
        $this->items = [];
    }
}
