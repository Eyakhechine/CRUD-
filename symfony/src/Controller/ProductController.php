<?php
namespace App\Controller;

use App\Entity\Product;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product')]
final class ProductController extends AbstractController
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    #[Route(name: 'app_product_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $products = $this->productService->getAllProducts();
        $productData = array_map(fn($product) => [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'quantity' => $product->getQuantity(),
        ], $products);

        return new JsonResponse($productData);
    }

    #[Route('/new', name: 'app_product_new', methods: ['POST'])]
    public function new (Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $product = $this->productService->createProduct($data);

        return new JsonResponse([
            'id' => $product->getId(),
            'name' => $product->getName(),
            'quantity' => $product->getQuantity(),
        ], JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): JsonResponse
    {
        return new JsonResponse([
            'id' => $product->getId(),
            'name' => $product->getName(),
            'quantity' => $product->getQuantity(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['PUT'])]
    public function edit(Request $request, Product $product): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $updatedProduct = $this->productService->updateProduct($product, $data);

        return new JsonResponse([
            'id' => $updatedProduct->getId(),
            'name' => $updatedProduct->getName(),
            'quantity' => $updatedProduct->getQuantity(),
        ]);
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['DELETE'])]
    public function delete(Product $product): JsonResponse
    {
        $this->productService->deleteProduct($product);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
