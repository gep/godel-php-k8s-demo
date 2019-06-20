<?php

namespace App\Controller;

use App\Entity\Good;
use App\Repository\GoodRepository;
use ProbablyRational\RandomNameGenerator\All;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class GoodsController extends AbstractController
{
    /**
     * @Route("/goods", name="goods")
     */
    public function index(): JsonResponse
    {
        /** @var GoodRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Good::class);

        return $this->json([
            'goods' => $repository->getGoods(),
            'path' => 'src/Controller/GoodsController.php',
        ]);
    }

    /**
     * @Route("/goods/create/{amount}", name="create_goods", requirements={"amount"="\d+"}, methods={"PUT"})
     * @param int $amount
     * @return JsonResponse
     */
    public function createGoods(int $amount): JsonResponse
    {
        $namesGenerator = All::create();
        $entityManager = $this->getDoctrine()->getManager();

        foreach (range(1, $amount) as $itemNumber) {
            $product = new Good();
            $product->setName($namesGenerator->getName());
            $product->setPrice((float)(rand(0, 200) + (rand(0, 100) / 100)));

            $entityManager->persist($product);
        }

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->json(['message' => sprintf("%d goods created", $amount)]);
    }




}
