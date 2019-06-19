<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GoodsController extends AbstractController
{
    /**
    * @Route("/goods")
    */
    public function getGoods()
    {
        return $this->json();
    }

    /**
     * @Route("/goods/{id}")
     * @param int $id
     */
    public function getGoodsById(int $id)
    {

    }
}