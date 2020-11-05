<?php

namespace App\Entity;

use App\Repository\AdminBookingsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminBookingsRepository::class)
 */
class AdminBookings
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $admin_name;

    /**
     * @ORM\Column(type="string")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $timeslot;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_booked;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdminName(): ?string
    {
        return $this->admin_name;
    }

    public function setAdminName(string $admin_name): self
    {
        $this->admin_name = $admin_name;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTimeslot(): ?string
    {
        return $this->timeslot;
    }

    public function setTimeslot(string $timeslot): self
    {
        $this->timeslot = $timeslot;

        return $this;
    }

    public function getIsBooked(): ?bool
    {
        return $this->is_booked;
    }

    public function setIsBooked(bool $is_booked): self
    {
        $this->is_booked = $is_booked;

        return $this;
    }
}
