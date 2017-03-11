<?php
namespace StoreApp\Application\CommandLine;

use Doctrine\ORM\EntityManager;
use StoreApp\Infrastructure\Product\ProductRepositoryDB;
use StoreApp\UseCase\CreateProduct\CreateProduct;
use StoreApp\UseCase\CreateProduct\CreateProductRequest;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateProductCommand
 * @package StoreApp\Application\CommandLine
 */
class CreateProductCommand extends Command
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * CreateProductCommand constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    /**
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this->setName('app:create-product')
            ->setDescription('Create new product with given name and price')
            ->addArgument('name', InputArgument::REQUIRED, 'Product name')
            ->addArgument('price', InputArgument::REQUIRED, 'Product price');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Generating new product');

        $createProductRequest = new CreateProductRequest(
            $input->getArgument('name'),
            $input->getArgument('price')
        );

        $createProductUseCase = new CreateProduct(new ProductRepositoryDB($this->entityManager));

        $createProductResponse = $createProductUseCase->execute($createProductRequest);

        $output->writeln('Product create with id: ' . $createProductResponse->getId());
    }
}