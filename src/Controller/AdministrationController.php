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
 * @Route("/administration")
 */
class AdministrationController extends AbstractController
{
    /**
     * @Route("/", name="administration")
     */
    public function administration(ProjectRepository $projectRepository)
    {
        return $this->render('administration/index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

    
    /**
     * @Route("/new", name="administration_create")
     * @Route("/{id}/edit",
     * name="administration_edit",
     * requirements={"id": "^([0-9]+)$"},
     * methods={"HEAD", "GET", "POST"}
     * )
     */
    public function createModify(Project $project = null, Request $request, EntityManagerInterface $manager) 
    {
        if (!$project) {
            $project = new Project();
        }
        // 
        // $this->denyAccessUnlessGranted();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$project->getId()) {
                $project->setCreatedAt(new DateTime());
                $this->addFlash('new project', 'Le nouveau projet a bien été ajouté !');
            } else {
                $this->addFlash('edit project', 'Le projet a bien été mis à jour !');
            }

            $manager->persist($project);
            $manager->flush();

            return $this->redirectToRoute('administration');
        }

        return $this->render('administration/createEdit.html.twig', [
            'formProject' => $form->createView(),
            'editMode' => $project->getId() !== null,
        ]);
    }

    /**
     * @Route("/{id}/delete",
     * name="administration_delete",
     * requirements={"id": "^([0-9]+)$"},
     * methods={"HEAD", "GET"}
     * )     */
    public function delete(Project $project, EntityManagerInterface $manager) 
    {
        $manager->remove($project);
        $manager->flush();

        $this->addFlash('delete project', 'Le projet a bien été supprimé');
        
        return $this->redirectToRoute('administration');
    }
}
