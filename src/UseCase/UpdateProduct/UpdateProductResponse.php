<?php
namespace StoreApp\UseCase\UpdateProduct;

/**
 * Class UpdateProductResponse
 * @package StoreApp\UseCase\CreateProduct
 */
class UpdateProductResponse
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $price;

    /**
     * CreateProductResponse constructor.
     * @param int $id
     * @param string $name
     * @param float $price
     */
    public function __construct($id, $name, $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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