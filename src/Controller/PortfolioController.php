<?php

namespace App\Controller;

use DateTime;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/portfolio")
 */
class PortfolioController extends AbstractController
{
    /**
     * @Route("/", name="portfolio")
     */
    public function list(ProjectRepository $projectRepository)
    {
        return $this->render('portfolio/portfolio.html.twig', [
            'projects' => $projectRepository->findAll(), 
        ]);
    }

    /**
     * @Route("/{id}",
     *      name="portfolio_display",
     *      requirements={"id": "^([0-9]+)$"},
     *      methods={"HEAD", "GET"}
     * )
     */
    public function display(Project $project)
    {
        return $this->render('portfolio/display.html.twig', [
            'project' => $project, 
        ]);    
    }
}
