<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 */
class City
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $zipcode;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Run", mappedBy="departure", orphanRemoval=true)
     */
    private $departureRuns;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Run", mappedBy="arrival", orphanRemoval=true)
     */
    private $arrivalRuns;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cityName;

    public function __construct()
    {
        $this->departureRuns = new ArrayCollection();
        $this->arrivalRuns = new ArrayCollection();

    }

    public function getId()
    {
        return $this->id;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * @return Collection|Run[]
     */
    public function getDepartureRuns(): Collection
    {
        return $this->departureRuns;
    }

    public function addDepartureRun(Run $departureRun): self
    {
        if (!$this->departureRuns->contains($departureRun)) {
            $this->departureRuns[] = $departureRun;
            $departureRun->setDeparture($this);
        }

        return $this;
    }

    public function removeDepartureRun(Run $departureRun): self
    {
        if ($this->departureRuns->contains($departureRun)) {
            $this->departureRuns->removeElement($departureRun);
            // set the owning side to null (unless already changed)
            if ($departureRun->getDeparture() === $this) {
                $departureRun->setDeparture(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Run[]
     */
    public function getArrivalRuns(): Collection
    {
        return $this->arrivalRuns;
    }

    public function addArrivalRun(Run $arrivalRun): self
    {
        if (!$this->arrivalRuns->contains($arrivalRun)) {
            $this->arrivalRuns[] = $arrivalRun;
            $arrivalRun->setArrival($this);
        }

        return $this;
    }

    public function removeArrivalRun(Run $arrivalRun): self
    {
        if ($this->arrivalRuns->contains($arrivalRun)) {
            $this->arrivalRuns->removeElement($arrivalRun);
            // set the owning side to null (unless already changed)
            if ($arrivalRun->getArrival() === $this) {
                $arrivalRun->setArrival(null);
            }
        }

        return $this;
    }

    public function getCityName(): ?string
    {
        return $this->cityName;
    }

    public function setCityName(string $cityName): self
    {
        $this->cityName = $cityName;

        return $this;
    }
}
