<?php
namespace StoreApp\Domain\Product;

/**
 * Class Product
 * @package StoreApp\Domain\Product
 */
final class Product
{

    /*
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $price;

    /**
     * Product constructor.
     * @param string $name
     * @param float $price
     */
    public function __construct(string $name, float $price)
    {
        $this->name = $name;
        $this->price = $price;
    }
}