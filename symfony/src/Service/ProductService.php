<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    private $productRepository;
    private $entityManager;

    public function __construct(ProductRepository $productRepository, EntityManagerInterface $entityManager)
    {
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
    }

    public function getAllProducts(): array
    {
        return $this->productRepository->findAll();
    }

    public function createProduct(array $data): Product
    {
        $product = new Product();
        $product->setName($data['name'] ?? null);
        $product->setQuantity($data['quantity'] ?? null);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }

    public function updateProduct(Product $product, array $data): Product
    {
        $product->setName($data['name'] ?? $product->getName());
        $product->setQuantity($data['quantity'] ?? $product->getQuantity());

        $this->entityManager->flush();

        return $product;
    }

    public function deleteProduct(Product $product): void
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }
}
