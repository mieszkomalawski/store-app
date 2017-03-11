<?php
namespace StoreApp\UseCase\CreateProduct;

/**
 * Class CreateProductResponse
 * @package StoreApp\UseCase\CreateProduct
 */
class CreateProductResponse
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


}