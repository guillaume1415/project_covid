<?php

declare(strict_types=1);

// namespace Messaging;
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="messaging")
 */
class Messaging
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $me_author;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $me_date;
    
    /**
     * @ORM\Column(type="string", length=128)
     *
     */
    private $me_text;

    /**
     * @ORM\Column(type="binary")
     *
     */
    private $view;

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, mappedBy="Messaging")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

}
