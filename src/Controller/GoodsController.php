<?php

namespace App\Controller;

use App\Entity\Good;
use ProbablyRational\RandomNameGenerator\All;
use ProbablyRational\RandomNameGenerator\Alliteration;
use ProbablyRational\RandomNameGenerator\Sketch;
use ProbablyRational\RandomNameGenerator\Vgng;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class GoodsController extends AbstractController
{
    /**
     * @Route("/goods", name="goods")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/GoodsController.php',
        ]);
    }

    /**
     * @Route("/goods/create/{amount}", name="create_goods")
     * @param int $amount
     * @return Response
     */
    public function createGoods(int $amount): Response
    {
        $namesGenerator = new All(
            [
                new Alliteration(1),
                new Vgng(1),
                new Sketch(1),
            ]
        );


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
