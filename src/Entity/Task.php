<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=100)
   */
  private $title;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $description;

  /**
   * @ORM\Column(type="boolean")
   */
  private $completed;

  public function __construct($title, $description)
  {
    $this->title = $title;
    $this->description = $description;
  }
  public function getId(): ?int
  {
    return $this->id;
  }

  public function getTitle(): ?string
  {
    return $this->title;
  }

  public function setTitle(string $title): self
  {
    $this->title = $title;

    return $this;
  }

  public function getDescription(): ?string
  {
    return $this->description;
  }

  public function setDescription(?string $description): self
  {
    $this->description = $description;

    return $this;
  }

  public function getCompleted(): ?bool
  {
    return $this->completed;
  }

  public function setCompleted(bool $completed): self
  {
    $this->completed = $completed;

    return $this;
  }
}
