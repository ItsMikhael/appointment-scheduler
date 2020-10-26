<?php


namespace App\Classes;


class Calendar
{

    public static function build_calendar() {
        $dateInfo = getdate();
        if(isset($_GET['month']) && isset($_GET['year'])) {
            $dateMonth = $_GET['month'];
            $dateYear = $_GET['year'];
        } else {
            $dateMonth = $dateInfo['mon'];
            $dateYear = $dateInfo['year'];
        }

        $daysOfWeek = array('Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela');

        $firstDayOfMonth = mktime(0, 0, 0, $dateMonth, 1, $dateYear);

        $numberDays = date('t', $firstDayOfMonth);

        $dateComponents = getdate($firstDayOfMonth);

        $monthName = $dateComponents['month'];

        $dayOfWeek = $dateComponents['wday'];
        if($dayOfWeek==0) {
            $dayOfWeek = 6;
        } else {
            $dayOfWeek = $dayOfWeek-1;
        }

        $dateToday = date('Y-m-d');

        $prevMonth = date('m', mktime(0, 0, 0, $dateMonth-1, 1, $dateYear));
        $prevYear = date('Y', mktime(0, 0, 0, $dateMonth-1, 1, $dateYear));

        $nextMonth = date('m', mktime(0, 0, 0, $dateMonth+1, 1, $dateYear));
        $nextYear = date('Y', mktime(0, 0, 0, $dateMonth+1, 1, $dateYear));

        switch($monthName) {
            case 'January':
                $monthName = 'Styczeń';
                break;
            case 'February':
                $monthName = 'Luty';
                break;
            case 'March':
                $monthName = 'Marzec';
                break;
            case 'April':
                $monthName = 'Kwiecień';
                break;
            case 'May':
                $monthName = 'Maj';
                break;
            case 'June':
                $monthName = 'Czerwiec';
                break;
            case 'July':
                $monthName = 'Lipiec';
                break;
            case 'August':
                $monthName = 'Sierpień';
                break;
            case 'September':
                $monthName = 'Wrzesień';
                break;
            case 'October':
                $monthName = 'Październik';
                break;
            case 'November':
                $monthName = 'Listopad';
                break;
            case 'December':
                $monthName = 'Grudzień';
                break;
            default:
                break;
        }

        $calendar = "<center> <h2> $monthName $dateYear</h2></center>";
        $calendar .= "<div class='calendar-nav'>";
        if($dateInfo['mon'] < $dateMonth || $dateInfo['year'] < $dateYear) {
            $calendar .= "<a class='btn btn-primary btn-xs' href='?month=" . $prevMonth . "&year=" . $prevYear . "'>
        Poprzedni Miesiąc </a>";
        }
        $calendar .= "<a class='btn btn-primary btn-xs' href='?month=" . date('m') . "&year=" . date('Y') ."'>
        Obecny Miesiąc </a>";
        $calendar .= "<a class='btn btn-primary btn-xs' href='?month=" . $nextMonth . "&year=" . $nextYear . "'>
        Następny Miesiąc </a> </center>";
        $calendar .= "</div>";
        $calendar .= "<table class='table table-bordered'>";
        $calendar .= "<tr>";

        foreach($daysOfWeek as $day) {
            $calendar .= "<th class='header'> $day </th>";
        }

        $calendar .= "</tr><tr>";
        $currentDay = 1;

        if($dayOfWeek > 0) {
            for($k = 0; $k < $dayOfWeek; $k++) {
                $calendar .= "<td class='empty'></td>";
            }
        }

        $month = str_pad($dateMonth, 2, "0", STR_PAD_LEFT);

        while($currentDay <= $numberDays) {

            if($dayOfWeek == 7) {
                $dayOfWeek = 0;
                $calendar .= "</tr><tr>";
            }

            $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
            $date = "$dateYear-$month-$currentDayRel";
            $dayName = strtolower(date('I', strtotime($date)));
            $today = $date == date('Y-m-d') ? 'today' : '';

            if($date < date('Y-m-d')) {
                $calendar .= "<td> <h4>$currentDayRel</h4> <button class='btn btn-danger btn-xs'>N/A</button>";
            } else {
                $calendar .= "<td class='$today'><h4>$currentDayRel</h4><a href='admin-booking?date=$date' class='btn btn-success btn-xs'>Zarezerwuj</a></td>";
            }

            $currentDay++;
            $dayOfWeek++;

        }

        if($dayOfWeek < 7) {
            $remainingDays = 7-$dayOfWeek;
            for($i = 0; $i < $remainingDays; $i++) {
                $calendar .= "<td class='empty'></td>";
            }
        }

        $calendar .= "</tr></table>";

        return $calendar;
    }

}