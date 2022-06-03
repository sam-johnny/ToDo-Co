<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Task;
use App\Form\SearchType;
use App\Form\TaskType;
use App\Service\DeleteTaskService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class TaskController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/tasks", name="task_list")
     */
    public function list(ManagerRegistry $doctrine, Request $request, DeleteTaskService $deleteTaskAuto): Response
    {
        $data = new SearchData();
        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);
        $tasks = $doctrine->getRepository(Task::class)->findSearch($data);
        return $this->render('task/list.html.twig',
            [
                'tasks' => $tasks,
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/tasks/list/done", name="task_done_list")
     */
    public function listTaskDone(ManagerRegistry $doctrine): Response
    {
        return $this->render('task/listTaskDone.html.twig',
            [
                'tasks' => $doctrine->getRepository(Task::class)->findBy([
                    'isDone' => true
                ])
            ]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function create(Request $request): RedirectResponse|Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($task);
            $this->entityManager->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function edit(Task $task, Request $request): RedirectResponse|Response
    {
        $this->denyAccessUnlessGranted('TASK_EDIT', $task);
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->flush();
            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/flag/done", name="task_flag_done")
     */
    public function flagDoneTask(Task $task): RedirectResponse
    {
        $this->denyAccessUnlessGranted('TASK_EDIT', $task);

        //set IsDone and return message
        $message = $flagTaskService->flagTask($task);

        $this->entityManager->flush();
        $this->addFlash('success', $message);
        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTask(Task $task, Security $security): RedirectResponse
    {
        $this->denyAccessUnlessGranted('TASK_DELETE', $task);

        $this->entityManager->remove($task);
        $this->entityManager->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
