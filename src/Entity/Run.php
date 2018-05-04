<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RunRepository")
 */
class Run
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="myRuns")
     * @ORM\JoinColumn(nullable=false)
     */
    private $driver;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Member", inversedBy="runsAttended")
     */
    private $pasengers;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $departure;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $arrival;

    /**
     * @ORM\Column(type="datetime")
     */
    private $departureSchedule;

    /**
     * @ORM\Column(type="integer")
     */
    private $places;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    public function __construct()
    {
        $this->pasengers = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDriver(): ?Member
    {
        return $this->driver;
    }

    public function setDriver(?Member $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @return Collection|Member[]
     */
    public function getPasengers(): Collection
    {
        return $this->pasengers;
    }

    public function addPasenger(Member $pasenger): self
    {
        if (!$this->pasengers->contains($pasenger)) {
            $this->pasengers[] = $pasenger;
        }

        return $this;
    }

    public function removePasenger(Member $pasenger): self
    {
        if ($this->pasengers->contains($pasenger)) {
            $this->pasengers->removeElement($pasenger);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * @param mixed $departure
     */
    public function setDeparture($departure): void
    {
        $this->departure = $departure;
    }

    /**
     * @return mixed
     */
    public function getArrival()
    {
        return $this->arrival;
    }

    /**
     * @param mixed $arrival
     */
    public function setArrival($arrival): void
    {
        $this->arrival = $arrival;
    }
    
    public function getDepartureSchedule(): ?\DateTimeInterface
    {
        return $this->departureSchedule;
    }

    public function setDepartureSchedule(\DateTimeInterface $departureSchedule): self
    {
        $this->departureSchedule = $departureSchedule;

        return $this;
    }

    public function getPlaces(): ?int
    {
        return $this->places;
    }

    public function setPlaces(int $places): self
    {
        $this->places = $places;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
