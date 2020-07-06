<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PortfolioController extends AbstractController
{
    /**
     * @Route("/portfolio", name="portfolio")
     */
    public function portfolio()
    {
        return $this->render('portfolio/portfolio.html.twig', [
            'controller_name' => 'PortfolioController',
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home() 
    {
        return $this->render('portfolio/home.html.twig');
    }

    /**
     * @Route("/about", name="about")
     */
    public function about() 
    {
        return $this->render('portfolio/about.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact() 
    {
        return $this->render('portfolio/contact.html.twig');
    }
}
