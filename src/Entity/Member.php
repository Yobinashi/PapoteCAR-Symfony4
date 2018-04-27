<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @UniqueEntity(fields={"email"}, message="You already have an account !")
 * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
 *
 */
class Member implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="integer")
     */
    private $tel;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vehicle;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="writer")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="target")
     */
    private $commentsaboutme;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Run", mappedBy="driver")
     */
    private $runsWhereIAmDriver;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Run", mappedBy="pasengers")
     */
    private $reservedRuns;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Run", mappedBy="driver", orphanRemoval=true)
     */
    private $myRuns;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Run", mappedBy="pasengers")
     */
    private $runsAttended;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->commentsaboutme = new ArrayCollection();
        $this->runsWhereIAmDriver = new ArrayCollection();
        $this->reservedRuns = new ArrayCollection();
        $this->myRuns = new ArrayCollection();
        $this->runsAttended = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getVehicle(): ?string
    {
        return $this->vehicle;
    }

    public function setVehicle(?string $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setWriter($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getWriter() === $this) {
                $comment->setWriter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getCommentsaboutme(): Collection
    {
        return $this->commentsaboutme;
    }

    public function addCommentsaboutme(Comment $commentsaboutme): self
    {
        if (!$this->commentsaboutme->contains($commentsaboutme)) {
            $this->commentsaboutme[] = $commentsaboutme;
            $commentsaboutme->setTarget($this);
        }

        return $this;
    }

    public function removeCommentsaboutme(Comment $commentsaboutme): self
    {
        if ($this->commentsaboutme->contains($commentsaboutme)) {
            $this->commentsaboutme->removeElement($commentsaboutme);
            // set the owning side to null (unless already changed)
            if ($commentsaboutme->getTarget() === $this) {
                $commentsaboutme->setTarget(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Run[]
     */
    public function getRunsWhereIAmDriver(): Collection
    {
        return $this->runsWhereIAmDriver;
    }

    public function addRunsWhereIAmDriver(Run $runsWhereIAmDriver): self
    {
        if (!$this->runsWhereIAmDriver->contains($runsWhereIAmDriver)) {
            $this->runsWhereIAmDriver[] = $runsWhereIAmDriver;
            $runsWhereIAmDriver->setDriver($this);
        }

        return $this;
    }

    public function removeRunsWhereIAmDriver(Run $runsWhereIAmDriver): self
    {
        if ($this->runsWhereIAmDriver->contains($runsWhereIAmDriver)) {
            $this->runsWhereIAmDriver->removeElement($runsWhereIAmDriver);
            // set the owning side to null (unless already changed)
            if ($runsWhereIAmDriver->getDriver() === $this) {
                $runsWhereIAmDriver->setDriver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Run[]
     */
    public function getReservedRuns(): Collection
    {
        return $this->reservedRuns;
    }

    public function addReservedRun(Run $reservedRun): self
    {
        if (!$this->reservedRuns->contains($reservedRun)) {
            $this->reservedRuns[] = $reservedRun;
            $reservedRun->addPasenger($this);
        }

        return $this;
    }

    public function removeReservedRun(Run $reservedRun): self
    {
        if ($this->reservedRuns->contains($reservedRun)) {
            $this->reservedRuns->removeElement($reservedRun);
            $reservedRun->removePasenger($this);
        }

        return $this;
    }

    /**
     * @return Collection|Run[]
     */
    public function getMyRuns(): Collection
    {
        return $this->myRuns;
    }

    public function addMyRun(Run $myRun): self
    {
        if (!$this->myRuns->contains($myRun)) {
            $this->myRuns[] = $myRun;
            $myRun->setDriver($this);
        }

        return $this;
    }

    public function removeMyRun(Run $myRun): self
    {
        if ($this->myRuns->contains($myRun)) {
            $this->myRuns->removeElement($myRun);
            // set the owning side to null (unless already changed)
            if ($myRun->getDriver() === $this) {
                $myRun->setDriver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Run[]
     */
    public function getRunsAttended(): Collection
    {
        return $this->runsAttended;
    }

    public function addRunsAttended(Run $runsAttended): self
    {
        if (!$this->runsAttended->contains($runsAttended)) {
            $this->runsAttended[] = $runsAttended;
            $runsAttended->addPasenger($this);
        }

        return $this;
    }

    public function removeRunsAttended(Run $runsAttended): self
    {
        if ($this->runsAttended->contains($runsAttended)) {
            $this->runsAttended->removeElement($runsAttended);
            $runsAttended->removePasenger($this);
        }

        return $this;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {

    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {

    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {

    }
}
