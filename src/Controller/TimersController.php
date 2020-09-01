<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\Timer;
use App\Form\TimerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TimersController extends AbstractController
{
    /**
     * @Route("/timers/{task}", name="timers")
     * @Template("timers/index.html.twig")
    */
    public function index(Task $task)
    {
        return [
            'task' => $task
        ];
    }

    /**
     * @Route("/timer/save/{task}", name="timer_save")
     * @Template("timers/formTimer.html.twig")
     */   
    public function saveTimer(Request $request, Task $task)
    {
        $timer = new Timer();
        
        $formTimer = $this->createForm(TimerType::class, $timer);
        $formTimer->remove('task');
        $formTimer->handleRequest($request);

        if($formTimer->isSubmitted() && $formTimer->isValid()){
            $em = $this->getDoctrine()->getManager();
            $timer->setTask($task);
            $em->persist($timer);
            $em->flush();
            $this->addFlash('success', 'Timer saved!');
            return $this->redirectToRoute('timers', ['task' => $task->getId()]);
        }
        return [
            'timer' => $timer,
            'formTimer' => $formTimer->createView()
        ];
    }

    /**
     * @Route("/timer/update/{task}/{timer}", name="timer_update")
     * @Template("timers/formTimer.html.twig")
     */   
    public function updateTimer(Request $request, Task $task, Timer $timer = null)
    {
        $formTimer = $this->createForm(TimerType::class, $timer);
        $formTimer->remove('task');
        $formTimer->handleRequest($request);
        
        if($formTimer->isSubmitted() && $formTimer->isValid()){
            $em = $this->getDoctrine()->getManager();
            $timer->setTask($task);
            $em->persist($timer);
            $em->flush();
            $this->addFlash('success', 'Timer saved!');
            return $this->redirectToRoute('timers', ['task' => $task->getId()]);
        }
        return [
            'timer' => $timer,
            'formTimer' => $formTimer->createView()
        ];
    }

    /**
     * @Route("/timer/remove/{timer}", name="timer_remove")
     */
    public function removeTimer(Request $request, Timer $timer)
    {

        $taskId = $timer->getTask()->getId();

        $em = $this->getDoctrine()->getManager();
        $em->remove($timer);
        $em->flush();
        
        $this->addFlash('success', 'Timer removed!');
        return $this->redirectToRoute('timers', ['task' => $taskId]);
    }
}
