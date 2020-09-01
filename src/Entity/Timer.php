<?php

namespace App\Entity;

use App\Repository\TimerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TimerRepository::class)
 */
class Timer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Task::class, inversedBy="timers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $task;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startRecord;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endRecord;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): self
    {
        $this->task = $task;

        return $this;
    }

    public function getStartRecord(): ?\DateTimeInterface
    {
        return $this->startRecord;
    }

    public function setStartRecord(\DateTimeInterface $startRecord): self
    {
        $this->startRecord = $startRecord;

        return $this;
    }

    public function getEndRecord(): ?\DateTimeInterface
    {
        return $this->endRecord;
    }

    public function setEndRecord(?\DateTimeInterface $endRecord): self
    {
        $this->endRecord = $endRecord;

        return $this;
    }
}
