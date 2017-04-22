<?php
namespace StoreApp\UseCase\UpdateProduct;

/**
 * Class UpdateProductRequest
 * @package StoreApp\UseCase\UpdateProduct
 */
class UpdateProductRequest
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var float
     */
    private $price;

    /**
     * @var string
     */
    private $name;

    /**
     * UpdateProductRequest constructor.
     * @param int $id
     * @param float $price
     * @param string $name
     */
    public function __construct($id = null, $price = null, $name = null)
    {
        $this->id = $id;
        $this->price = $price;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

}