<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Entity\ProjectLike;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProjectLikeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PortfolioController extends AbstractController
{
    /**
     * @Route("/portfolio", name="portfolio")
     */
    public function list(ProjectRepository $projectRepository)
    {
        return $this->render('portfolio/portfolio.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

    /**
     * @Route("portfolio/{id}",
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

    /**
     * Permet de liké ou unlinké un projet
     *
     * @Route("portfolio/{id}/like", name="portfolio_like")
     */
    public function like(Project $project, EntityManagerInterface $manager, ProjectLikeRepository $projectLikeRepository)
    {
        $user = $this->getUser();

        // Si l'utilisateur n'est pas connecté, il n'a pas le droit de liké un projet
        if (!$user) {
            return $this->json([
            'code' => 403,
            'message' => 'Unauthorized'
        ], 403);
        }

        // Se le projet est liké, alors on supprime le like
        if ($project->isLikedByUser($user)) {
            $like = $projectLikeRepository->findOneBy([
                'project' => $project,
                'user' => $user
            ]);

            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Le like a été bien supprimé',
                'likes' => $projectLikeRepository->count(['project' => $project])
            ], 200);
        }

        // Si l'utilisateur est connecté et n'a pas liké ce projet, on ajout un like
        $like = new ProjectLike();
        $like->setProject($project)
             ->setUser($user);
        
        $manager->persist($like);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Le like a bien été ajouté',
            'likes' => $projectLikeRepository->count(['project' => $project]),
        ], 200);
    }
}
