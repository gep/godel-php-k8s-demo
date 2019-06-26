<?php

namespace App\Controller;

use App\Entity\Good;
use App\Repository\GoodRepository;
use App\Services\Goods\GoodsService;
use ProbablyRational\RandomNameGenerator\All;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class GoodsController extends AbstractController
{

    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index(): Response
    {
        return new Response('Goods store! Seems to be working. :)');
    }

    /**
     * @Route("/goods", name="goods")
     */
    public function getGoods(): JsonResponse
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
     * @param GoodsService $goodsService
     * @return JsonResponse
     */
    public function createGoods(int $amount, GoodsService $goodsService): JsonResponse
    {
        $goodsService->createGoods($amount);
        return $this->json(['message' => sprintf("%d goods created", $amount)]);
    }




}
