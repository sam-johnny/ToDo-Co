<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }
}
