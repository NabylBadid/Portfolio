<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home() 
    {
        return $this->render('page/home.html.twig');
    }

    /**
     * @Route("/{page}",
     *      name="display_page",
     *      requirements={"page": "about|contact"},
     *      methods={"HEAD", "GET"}
     * )
     */
    public function display($page) 
    {
        return $this->render('page/' . $page . '.html.twig');
    }
}
