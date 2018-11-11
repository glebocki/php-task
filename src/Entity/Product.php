<?php

namespace Recruitment\Entity;

use Recruitment\Entity\Exception\InvalidUnitPriceException;

/**
 * Product in shop.
 * @package Recruitment\Entity
 */
class Product
{
    const DEFAULT_MIN_QUANTITY = 1;

    const TAX_RATES = [0, 5, 8, 23];

    /** @var int */
    private $id;

    /**@var string */
    private $name;

    /** @var int Product unit price in Grosze */
    private $unitPrice;

    /** @var int */
    private $minimumQuantity;

    /** @var int */
    private $taxRate;

    public function __construct()
    {
        $this->minimumQuantity = self::DEFAULT_MIN_QUANTITY;
    }

//    /**
//     * @param string $name
//     */
//    public function setName(string $name)
//    {
//        $this->name = $name;
//    }
//
//    /**
//     * @return string
//     */
//    public function getName(): string
//    {
//        return $this->name;
//    }

    /**
     * @param int $unitPrice
     * @return Product
     * @throws InvalidUnitPriceException
     */
    public function setUnitPrice(int $unitPrice): Product
    {
        if ($unitPrice <= 0) {
            throw new InvalidUnitPriceException();
        }

        $this->unitPrice = $unitPrice;
        return $this;
    }

    /**
     * @return int
     */
    public function getMinimumQuantity(): int
    {
        return $this->minimumQuantity;
    }

    /**
     * @param int $minimumQuantity
     * @return Product
     */
    public function setMinimumQuantity(int $minimumQuantity): Product
    {
        if ($minimumQuantity < self::DEFAULT_MIN_QUANTITY) {
            throw new \InvalidArgumentException();
        }

        $this->minimumQuantity = $minimumQuantity;
        return $this;
    }

    /**
     * @return int
     */
    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Product
     */
    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param $taxRate
     * @return Product
     */
    public function setTaxRate($taxRate): Product
    {
        if (!in_array($taxRate, self::TAX_RATES)) {
            throw new \InvalidArgumentException;
        }

        $this->taxRate = $taxRate;
        return $this;
    }

    /**
     * @return int
     */
    public function getTaxRate(): int
    {
        return $this->taxRate;
    }
}
