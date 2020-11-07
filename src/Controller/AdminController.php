<?php

namespace App\Controller;

use App\Entity\AdminBookings;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Classes\Calendar;

/**
 * @Route("/admin", name="admin.")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function adminMain(): Response {
        if($this->isGranted('ROLE_ADMIN')) {
            return $this->render('admin/admin-main.html.twig', []);
        }
    }

    /**
     * @Route("/calendar", name="calendar")
     */
    public function adminCalendar(): Response {
        if($this->isGranted('ROLE_ADMIN')) {
            $calendar = new Calendar();
            $calendar->setIsAdmin(true);
            return $this->render('admin/admin-calendar.html.twig', [
                'calendar' => $calendar->buildCalendar($this->getDoctrine()->getManager())
            ]);
        }
    }

    /**
     * @Route("/calendar/booking", name="booking")
     */
    public function adminBooking(): Response {
        if($this->isGranted('ROLE_ADMIN')) {

            $date = new DateTime($_GET['date']);
            $month = $date->format("m");
            $year = $date->format('Y');

            return $this->render('admin/admin-booking.html.twig', [
                'timeslots' => Calendar::buildTimeslots("08:00", "20:00", 60, 0,
                    $this->getDoctrine()->getManager(), $_GET['date']),
                'date' => $_GET['date'],
                'month' => $month,
                'year' => $year
            ]);
        }
    }

    /**
     * @Route("/calendar/booking/ajax", name="booking-ajax")
     * @param Request $request
     */
    public function ajaxAction(Request $request) {

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $date = $request->request->get('date');
        $timeslot = $request->request->get('timeslot');

        $alreadyBooked = $em->getRepository(AdminBookings::Class)->findOneBy([
            'date' => $date,
            'timeslot' => $timeslot,
        ]);

        if($alreadyBooked) {
            $em->remove($alreadyBooked);
        } else {
            $booking = new AdminBookings();
            $booking->setAdminId($user->getId());
            $booking->setDate($date);
            $booking->setTimeslot($timeslot);
            $booking->setIsBooked(false);

            $em->persist($booking);
        }

        $em->flush();

        return new Response();

    }
}
