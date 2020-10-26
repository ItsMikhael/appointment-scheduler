<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Classes\Calendar;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin-main", name="admin-main")
     */
    public function adminMain(): Response {
        if($this->isGranted('ROLE_ADMIN')) {
            return $this->render('admin/admin-main.html.twig', []);
        }
    }

    /**
     * @Route("/admin-calendar", name="admin-calendar")
     */
    public function adminCalendar(): Response {
        if($this->isGranted('ROLE_ADMIN')) {
            return $this->render('admin/admin-calendar.html.twig', ['calendar' => Calendar::build_calendar()]);
        }
    }

    /**
     * @Route("/admin-calendar/booking", name="admin-booking")
     */
    public function adminBooking(): Response {
        if($this->isGranted('ROLE_ADMIN')) {
            return $this->render('admin/admin-calendar.html.twig', ['calendar' => Calendar::build_calendar()]);
        }
    }
}
