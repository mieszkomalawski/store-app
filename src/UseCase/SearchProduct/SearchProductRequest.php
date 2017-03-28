<?php
namespace StoreApp\UseCase\SearchProduct;

/**
 * Class SearchProductRequest
 * @package StoreApp\UseCase\SearchProduct
 */
class SearchProductRequest
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $priceMin;

    /**
     * @var float
     */
    private $priceMax;

    /**
     * @todo enum
     * @var string
     */
    private $sortBy;

    /**
     * @todo enum - może jakiś interface
     * @var string
     */
    private $sortOrder;

    /**
     * SearchProductRequest constructor.
     * @param string $name
     * @param float $priceMin
     * @param float $priceMax
     * @param string $sortBy
     * @param string $sortOrder
     */
    public function __construct(
        string $name = null,
        float $priceMin = null,
        float $priceMax = null,
        string $sortBy = null,
        string $sortOrder = null)
    {
        $this->name = $name;
        $this->priceMin = $priceMin;
        $this->priceMax = $priceMax;
        $this->sortBy = $sortBy;
        $this->sortOrder = $sortOrder;
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
    public function getPriceMin(): float
    {
        return $this->priceMin;
    }

    /**
     * @return float
     */
    public function getPriceMax(): float
    {
        return $this->priceMax;
    }

    /**
     * @return string
     */
    public function getSortBy(): string
    {
        return $this->sortBy;
    }

    /**
     * @return string
     */
    public function getSortOrder(): string
    {
        return $this->sortOrder;
    }


}