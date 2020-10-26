<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Classes\Calendar;

class UserController extends AbstractController
{
    /**
     * @Route("/user-main", name="user-main")
     */
    public function userMain(): Response {
        if($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin-main');
        }
        if ($this->getUser()) {
            return $this->render('user/user-main.html.twig', []);
        } else {
            return $this->redirectToRoute('main');
        }
    }

    /**
     * @Route("/user-calendar", name="user-calendar")
     */
    public function userCalendar(): Response {
        if($this->isGranted('ROLE_USER')) {
            return $this->render('user/user-calendar.html.twig', ['calendar' => Calendar::build_calendar()]);
        }
    }

    /**
     * @Route("/user-calendar/booking", name="user-booking")
     */
    public function userBooking(): Response {
        if($this->isGranted('ROLE_USER')) {
            return $this->render('admin/admin-calendar.html.twig', ['calendar' => Calendar::build_calendar()]);
        }
    }
}
