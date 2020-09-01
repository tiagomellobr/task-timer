<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Task;
use App\Entity\Timer;
use App\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @Template("home/index.html.twig")
     */
    public function index()
    {
        
        $em = $this->getDoctrine()->getManager();

        $projects = $em->getRepository(Project::class)->findAll();
        
        $tasks = $em->getRepository(Task::class)->findAll();

        $timer = new Timer();
        
        return [
            'tasks' => $tasks,
            'projects' => $projects
        ];
    }

    /**
     * @Route("/project/save", name="project_save")
     * @Route("/project/update/{project}", name="project_update")
     * @Template("home/formProject.html.twig")
     */   
    public function saveProject(Request $request, Project $project = null)
    {
        if ($project == null) {
            $project = new Project();
        }
        $formProject = $this->createForm(ProjectType::class, $project);

        $formProject->handleRequest($request);
        if($formProject->isSubmitted() && $formProject->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();
            $this->addFlash('success', 'Project saved!');
            return $this->redirectToRoute('home');
        }

        return [
            'project' => $project,
            'formProject' => $formProject->createView()
        ];
    }

    /**
     * @Route("/project/remove/{project}", name="project_remove")
     */
    public function removeProject(Request $request, Project $project = null)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($project);
        $em->flush();
        
        $this->addFlash('success', 'Project removed!');
        return $this->redirectToRoute('home');
    }
}
