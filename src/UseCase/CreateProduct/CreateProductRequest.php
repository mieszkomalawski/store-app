<?php
namespace StoreApp\UseCase\CreateProduct;

/**
 * Class CreateProductRequest
 * @package StoreApp\UseCase\CreateProduct
 */
class CreateProductRequest
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $price;

    /**
     * CreateProductRequest constructor.
     * @param string $name
     * @param float $price
     */
    public function __construct(string $name, float $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

}