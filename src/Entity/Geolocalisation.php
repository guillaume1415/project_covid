<?php

declare(strict_types=1);

// namespace Geolocalisation;
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="geolocalisation")
 */
class Geolocalisation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int 
     */
    protected $id;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $latitude;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $longitude;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }
}
