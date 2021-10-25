<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Messaging
 *
 * @ORM\Table(name="messaging")
 * @ORM\Entity
 */
class Messaging
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="me_author", type="string", length=32, nullable=false)
     */
    private $meAuthor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="me_date", type="datetime", nullable=false)
     */
    private $meDate;

    /**
     * @var string
     *
     * @ORM\Column(name="me_text", type="string", length=128, nullable=false)
     */
    private $meText;

    /**
     * @var binary
     *
     * @ORM\Column(name="view", type="binary", nullable=false)
     */
    private $view;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Users", mappedBy="messaging")
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeAuthor(): ?string
    {
        return $this->meAuthor;
    }

    public function setMeAuthor(string $meAuthor): self
    {
        $this->meAuthor = $meAuthor;

        return $this;
    }

    public function getMeDate(): ?\DateTimeInterface
    {
        return $this->meDate;
    }

    public function setMeDate(\DateTimeInterface $meDate): self
    {
        $this->meDate = $meDate;

        return $this;
    }

    public function getMeText(): ?string
    {
        return $this->meText;
    }

    public function setMeText(string $meText): self
    {
        $this->meText = $meText;

        return $this;
    }

    public function getView()
    {
        return $this->view;
    }

    public function setView($view): self
    {
        $this->view = $view;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addMessaging($this);
        }

        return $this;
    }

    public function removeUser(Users $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeMessaging($this);
        }

        return $this;
    }

}
