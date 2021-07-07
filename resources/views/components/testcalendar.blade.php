<?php

use App\ControlEquipment;

$setdate = (isset($setdate)) ? $setdate : date('Y-m-d');
//		return "$month, $year, $monat, $jahr";
$month = (int)date('n', strtotime($setdate));
$year = (int)date('Y', strtotime($setdate));
$prevMonth = ($month - 1 < 1) ? 12 : $month - 1;
$prevYear = ($month - 1 < 1) ? $year-- : $year;
$nextMonth = ($month + 1 > 12) ? 1 : $month + 1;
$nextYear = ($month + 1 > 12) ? $year++ : $year;


/* draw table */
$calendar = '
<div class="d-flex justify-content-between align-items-center">
<button class="btn btn-sm btn-outline-primary setTestingCalenderDate" data-nextmonth="' . $prevMonth . '" data-nextyear="' . $prevYear . '">
    <span class="fas fa-angle-left"></span>
</button>
<span>
    ' . date('F Y', strtotime($setdate)) . '
</span>
<button class="btn btn-sm btn-outline-primary setTestingCalenderDate" data-nextmonth="' . $nextMonth . '" data-nextyear="' . $nextYear . '">
    <span class="fas fa-angle-right"></span>
</button>
</div>
';

$calendar .= '<table class="table">';

/* table headings */
//	$headings = array('Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag');
$calendar .= '<tr class="table-secondary">
    <td class="text-center  border" style="width: 14.2857% !important;">Mo</td>
    <td class="text-center  border" style="width: 14.2857% !important;">Di</td>
    <td class="text-center  border" style="width: 14.2857% !important;">Mi</td>
    <td class="text-center  border" style="width: 14.2857% !important;">Do</td>
    <td class="text-center  border" style="width: 14.2857% !important;">Fr</td>
    <td class="text-center  border" style="width: 14.2857% !important;">Sa</td>
    <td class="text-center  border" style="width: 14.2857% !important;">So</td>
</tr>';

//reorder labels, starting with monday
$running_day = date('N', mktime(0, 0, 0, $month, 1, $year)) - 1;


/* days and weeks vars now ...
$running_day = date('w',mktime(0,0,0,$month,1,$year))-1;*/
$days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));

$days_in_this_week = 1;
$day_counter = 5;
$dates_array = array();

/* row for week one */
$calendar .= '<tr class="">';

/* print "blank" days until the first of the current week */
for ($x = 0; $x < $running_day; $x++):
    $setWE = ($days_in_this_week == '0' || $days_in_this_week == '6') ? 'bg-secondary ' : 'bg-light ';
    $calendar .= '<td class="border ' . $setWE . '" style="width: 14.2857% !important;"></td>';

    $days_in_this_week++;
endfor;

/* keep going with days.... */
for ($list_day = 1; $list_day <= $days_in_month; $list_day++):

    $daytoday = (int)date('j', time());
    $montoday = (int)date('n', time());
    $datum = date('Y-m-d', mktime(0, 0, 0, $month, $list_day, $year));
    $wochenende = date('w', mktime(0, 0, 0, $month, $list_day, $year));
    $setWE = ($wochenende == '0' || $wochenende == '6') ? 'table-secondary ' : '';


    $calendar .= ($list_day == $daytoday && $month == $montoday) ? '<td style="background-color:#' . env('APP_Color') . '; width: 14.2857% !important;" class="border ' . $setWE . '" data-datum="' . $datum . '">' : '<td  style="width: 14.2857% !important;" class="border ' . $setWE . '" data-datum="' . $datum . '">';


    //		$calendar.='<td class="calendar-day">';
    /* add in the day number */
    $calendar .= '<span class="small mr-3">' . $list_day . '</span>';
    //$calendar.=t;

    //		$calendar.= ($daytoday == $list_day ) ? '<p>heute</p>' : '<p></p>';
    //		$calendar.= '<div data-datum="'.$datum.'" class="TagDiv">';
    $n = ControlEquipment::where('qe_control_date_due', date('Y-m-' . $list_day))->count();
    if ($n > 0) {
        $calendar .= '
<button class="btn btn-sm btn-primary btnOpenTestListeOfDate" data-testingdate="' . date('Y-m-' . $list_day) . ' ">
<span class="fas fa-stethoscope mr-2 d-none d-lg-inline"></span>
<span class="badge badge-info">' . $n . '</span>
</button>
';
    }
    $calendar .= '</td>';
    if ($running_day == 6):
        $calendar .= '</tr>';
        if (($day_counter - 1) != $days_in_month):
            $calendar .= '<tr class="">';
        endif;
        $running_day = -1;
        $days_in_this_week = 0;
    endif;
    $days_in_this_week++;
    $running_day++;
    $day_counter++;
endfor;

/* finish the rest of the days in the week */
if ($days_in_this_week < 8):
    for ($x = 1; $x <= (8 - $days_in_this_week); $x++):
        $wochenende = date('w', mktime(0, 0, 0, $month + 1, $x, $year));
        $setWE = ($wochenende == '0' || $wochenende == '6') ? 'table-secondary ' : '';
        $calendar .= '<td  style="width: 14.2857% !important;" class="border ' . $setWE . '"> </td>';
    endfor;
endif;

/* final row */
$calendar .= '</tr>';

/* end the table */
$calendar .= '</table>';
echo $calendar
?>
<script>

</script>
