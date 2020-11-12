<?php

namespace App\Controller;

use App\Entity\AdminAvailability;
use App\Entity\Bookings;
use App\Entity\User;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            return $this->redirectToRoute('admin-main');
        }
        if ($this->getUser()) {
            $em = $this->getDoctrine()->getManager();
            $admins = $em->getRepository(User::class)->findByRole('ADMIN');
            $adminUsernames = [];
            foreach($admins as $admin) {
                $adminUsernames[] = $admin->getUsername();
            }
            return $this->render('user/main.html.twig', ['admins' => $adminUsernames]);
        } else {
            return $this->redirectToRoute('main');
        }
    }

    /**
     * @Route("/calendar/{email}", name="calendar")
     * @param User $admin
     * @return Response
     */
    public function userCalendar(User $admin): Response {
        if($this->isGranted('ROLE_USER')) {
            $calendar = new Calendar();
            $calendar->setIsAdmin(false);
            return $this->render('user/calendar.html.twig', [
                'calendar' => $calendar->buildCalendar($this->getDoctrine()->getManager())]);
        }
    }

    /**
     * @Route("/calendar/{email}/booking", name="booking")
     *  @param User $admin
     */
    public function userBooking(User $admin): Response {
        if($this->isGranted('ROLE_USER')) {

            $date = new DateTime($_GET['date']);
            $month = $date->format("m");
            $year = $date->format('Y');

            $em = $this->getDoctrine()->getManager();
            $availableBookings = $em->getRepository(AdminAvailability::class)->findBy([
                'date' => $_GET['date'],
                'admin_id' => $admin->getId(),
            ]);

            $timeslots = [];
            foreach($availableBookings as $booking) {
                if($booking->getIsBooked()) {
                    $userBooking = $em->getRepository(Bookings::Class)->findOneBy([
                        'timeslot_id' => $booking->getId(),
                    ]);
                    if($userBooking->getUserId() == $this->getUser()->getId()) {
                        $timeslots[] = [$booking->getTimeslot(), true];
                    }
                } else {
                    $timeslots[] = [$booking->getTimeslot(), false];
                }

            }
            sort($timeslots);


            return $this->render('user/booking.html.twig', [
                'date' => $_GET['date'],
                'month' => $month,
                'year' => $year,
                'timeslots' => $timeslots,
                'email' => $admin->getEmail()]);
        }
    }
    /**
     * @Route("/calendar/{email}/booking/create", name="booking-create")
     * @param Request $request
     */
    public function createBooking(Request $request) {

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $date = $request->request->get('date');
        $timeslot = $request->request->get('timeslot');

        $adminBooking = $em->getRepository(AdminAvailability::Class)->findOneBy([
            'date' => $date,
            'timeslot' => $timeslot,
        ]);

        $admin = $adminBooking->getAdminId();
        $admin = $em->getRepository(User::class)->findOneBy([
            'id' => $admin
        ]);
        $adminId = $admin->getId();


        $booking = new Bookings();
        $booking->setAdminId($adminId);
        $booking->setTimeslotId($adminBooking->getId());
        $booking->setUserId($user->getId());
        $adminBooking->setIsBooked(true);

        $em->persist($booking);
        $em->persist($adminBooking);

        $em->flush();

        return new Response();

    }

    /**
     * @Route("/appointments", name="appointments")
     */
    public function userAppointments() {

        $em = $this->getDoctrine()->getManager();

        $bookings = $em->getRepository(Bookings::class)->findBy([
            'user_id' => $this->getUser()->getId()
        ]);

        $adminBookings = [];

        foreach($bookings as $booking) {
            $adminBookings[] = $em->getRepository(AdminAvailability::class)->findOneBy([
                'id' => $booking->getTimeslotId(),
            ]);
        }

        $appointments = [];

        foreach($adminBookings as $booking) {
            $appointments[] = [$booking, $em->getRepository(User::class)->findOneBy([
                'id' => $booking->getAdminId(),
            ])->getEmail()];
        }

        return $this->render('user/appointments.html.twig', [
            'appointments' => $appointments]);
    }

    /**
     * @Route("/appointments/delete", name="booking-delete")
     * @param Request $request
     */
    public function deleteBooking(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $timeslot_id = $request->request->get('timeslot_id');

        $em->remove($em->getRepository(Bookings::class)->findOneBy([
            'timeslot_id' => $timeslot_id,
        ]));

        $em->getRepository(AdminAvailability::class)->findOneBy([
            'id' => $timeslot_id,
        ])->setIsBooked(false);

        $em->flush();

        return new Response;

    }
}
