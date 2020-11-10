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
     * @ORM\Column(type="integer", length=50)
     */
    private $admin_id;

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

    public function getAdminId(): ?int
    {
        return $this->admin_id;
    }

    public function setAdminId(string $admin_id): self
    {
        $this->admin_id = $admin_id;

        return $this;
    }

    public function getDate(): ?string
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
