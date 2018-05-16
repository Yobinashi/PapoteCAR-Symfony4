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
    private $passengers;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $departure;

    /**
     * @return mixed
     */

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $arrival;


    /**
     * @ORM\Column(type="date")
     */
    private $departureDate;

    /**
     * @ORM\Column(type="time")
     */
    private $departureTime;

    /**
     * @ORM\Column(type="integer")
     */
    private $places;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    public function __construct()
    {
        $this->passengers = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param mixed $driver
     */
    public function setDriver($driver): void
    {
        $this->driver = $driver;
    }

    /**
     * @return Collection|Member[]
     */
    public function getPassengers(): Collection
    {
        return $this->passengers;
    }
    public function addPassenger(Member $passenger): self
    {
        if (!$this->passengers->contains($passenger)) {
            $this->passengers[] = $passenger;
        }
        return $this;
    }
    public function removePassenger(Member $passenger): self
    {
        if ($this->passengers->contains($passenger)) {
            $this->passengers->removeElement($passenger);
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

    /**
     * @return mixed
     */
    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departureDate;
    }

    /**
     * @param mixed $departureDate
     */
    public function setDepartureDate(\DateTimeInterface $departureDate): self
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDepartureTime(): ?\DateTimeInterface
    {
        return $this->departureTime;
    }

    /**
     * @param mixed $departureTime
     */
    public function setDepartureTime(\DateTimeInterface $departureTime): self
    {
        $this->departureTime = $departureTime;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlaces()
    {
        return $this->places;
    }

    /**
     * @param mixed $places
     */
    public function setPlaces($places): void
    {
        $this->places = $places;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

}
