<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Task;
use App\Entity\Timer;
use App\Form\TaskType;
use App\Form\TimerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class TasksController extends AbstractController
{
    /**
    * @Route("/tasks/{project}", name="tasks")
    * @Template("tasks/index.html.twig")
    */
    public function index(Project $project)
    {
        return [
            'project' => $project
        ];
    }

    /**
     * @Route("/task/save/{project}/", name="task_save")
     * @Template("home/formTask.html.twig")
     */   
    public function saveTask(Request $request, Project $project)
    {
        $task = new Task();
        $formTask = $this->createForm(TaskType::class, $task);
        $formTask->handleRequest($request);

        if($formTask->isSubmitted() && $formTask->isValid()){
            $em = $this->getDoctrine()->getManager();
            $task->setProject($project);
            $em->persist($task);
            $em->flush();
            $this->addFlash('success', 'Task saved!');
            return $this->redirectToRoute('tasks', ['project' => $project->getId()]);
        }

        return [
            'task' => $task,
            'formTask' => $formTask->createView()
        ];
    }
    /**
     * @Route("/task/update/{project}/{task}", name="task_update")
     * @Template("home/formTask.html.twig")
     */
    public function updateTask(Request $request, Project $project, Task $task = null)
    {
        $formTask = $this->createForm(TaskType::class, $task);

        $formTask->handleRequest($request);
        if($formTask->isSubmitted() && $formTask->isValid()){
            $em = $this->getDoctrine()->getManager();
            $task->setProject($project);
            $em->persist($task);
            $em->flush();
            $this->addFlash('success', 'Task saved!');
            return $this->redirectToRoute('tasks', ['project' => $project->getId()]);
        }

        return [
            'task' => $task,
            'formTask' => $formTask->createView()
        ];
    }

    /**
     * @Route("/task/remove/{task}", name="task_remove")
     */
    public function removeTask(Request $request, Task $task)
    {
        $projectId = $task->getProject()->getId();

        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();
        
        $this->addFlash('success', 'Task removed!');
        return $this->redirectToRoute('tasks', ['project' => $projectId]);
    }
}
