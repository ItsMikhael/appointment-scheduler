<?php

namespace App\Controller;

use App\Entity\AdminBookings;
use App\Entity\User;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Classes\Calendar;

/**
 * @Route("/user", name="user-")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function userMain(): Response {
        if($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin.main');
        }
        if ($this->getUser()) {
            $em = $this->getDoctrine()->getManager();
            $admins = $em->getRepository(User::class)->findByRole('ADMIN');
            $adminUsernames = [];
            foreach($admins as $admin) {
                $adminUsernames[] = $admin->getUsername();
            }
            return $this->render('user/user-main.html.twig', ['admins' => $adminUsernames]);
        } else {
            return $this->redirectToRoute('main');
        }
    }

    /**
     * @Route("/calendar", name="calendar")
     */
    public function userCalendar(): Response {
        if($this->isGranted('ROLE_USER')) {
            $calendar = new Calendar();
            $calendar->setIsAdmin(false);
            return $this->render('user/user-calendar.html.twig', ['calendar' => $calendar->buildCalendar($this->getDoctrine()->getManager())]);
        }
    }

    /**
     * @Route("/calendar/booking", name="booking")
     */
    public function userBooking(): Response {
        if($this->isGranted('ROLE_USER')) {

            $date = new DateTime($_GET['date']);
            $month = $date->format("m");
            $year = $date->format('Y');

            $em = $this->getDoctrine()->getManager();
            $availableBookings = $em->getRepository(AdminBookings::class)->findBy([
                'date' => $_GET['date']]);

            $timeslots = [];
            foreach($availableBookings as $booking) {
                $timeslots[] = $booking->getTimeslot();
            }

            return $this->render('user/user-booking.html.twig', [
                'date' => $_GET['date'],
                'month' => $month,
                'year' => $year,
                'timeslots' => $timeslots]);
        }
    }
}
