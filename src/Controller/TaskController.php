<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/task")
 */
class TaskController extends AbstractController
{
  private $serializer;

  public function __construct(SerializerInterface $serializer)
  {
    $this->serializer = $serializer;
  }
  /**
   * @Route("/", name="task_index", methods={"GET"})
   */
  public function index(TaskRepository $taskRepository): Response
  {
    $tasks = $taskRepository->findAll();

    $data = $this->serializer->serialize($tasks, JsonEncoder::FORMAT);
    return new JsonResponse($data);
  }

  /**
   * @Route("/new", name="task_new", methods={"GET","POST"})
   */
  public function new(Request $request): Response
  {
    $data = $this->serializer->deserialize($request->getContent(), Task::class, "json");
    $task = new Task($data->getTitle(), $data->getDescription());
    $task->setCompleted($data->getCompleted());

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($task);
    $entityManager->flush();

    $taskSerialized = $this->serializer->serialize($task, JsonEncoder::FORMAT);
    return new JsonResponse($taskSerialized);
  }

  /**
   * @Route("/{id}", name="task_show", methods={"GET"})
   */
  public function show(Task $task): Response
  {
    $task = $this->serializer->serialize($task, JsonEncoder::FORMAT);

    return new JsonResponse($task);
  }

  /**
   * @Route("/{id}/edit", name="task_edit", methods={"GET","POST"})
   */
  public function edit(Request $request, Task $task): Response
  {
    $data = $this->serializer->deserialize($request->getContent(), Task::class, "json");
    $task->setTitle($data->getTitle());
    $task->setDescription($data->getDescription());

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($task);
    $entityManager->flush();

    $taskSerialized = $this->serializer->serialize($task, JsonEncoder::FORMAT);

    return new JsonResponse($taskSerialized);
  }


  /**
   * @Route("/{id}", name="task_delete", methods={"DELETE"})
   */
  public function delete(Task $task): Response
  {
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($task);
    $entityManager->flush();


    return new JsonResponse();
  }
}
