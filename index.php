<?php
    function build_calendar($month, $year) {
        //Tableau contenant les noms de tous les jours de la semaine
        $daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

        //Premier jour du mois qui est l'argument de cette fonction
        $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

        //Obtention du nombre de jours de ce mois 
        $numberDays = date("t", $firstDayOfMonth);

        //Information sur le premier jour de ce mois
        $dateComponents = getdate($firstDayOfMonth);

        //Obtenir le nom de ce mois
        $monthName = $dateComponents['month'];

        //Getting the index value 0-6 of the first day of this month
        $dayOfWeek = $dateComponents['wday'];

        //Getting the current date
        $dateToday = date('Y-m-d');

        //Now creating the HTML Table
        $calendar = "<table class='table table-bordered'>";
        $calendar.= "<center><h2>$monthName $year</h2>";
        
        $calendar.= "<a class='btn btn-xs btn-primary' href='?month=".date('m', mktime(0, 0, 0, $month-1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month-1, 1, $year))."'>Previous Month</a> ";
        $calendar.= "<a class='btn btn-xs btn-primary' href='?month=".date('m', mktime(0, 0, 0, $month+1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month+1, 1, $year))."'>Next Month</a></center><br>";


        $calendar.= "<tr>";

        //Creating the calendar headers 
        foreach($daysOfWeek as $day) {
            $calendar.="<th class='header'>$day</th>";
        }

        $calendar.="</tr><tr>";

        //the variable $dayOfWeek will make sure that there must be only 7 columns on our table
        if($dayOfWeek > 0){
            for($k=0; $k<$dayOfWeek; $k++) {
                $calendar.="<td></td>";
            }
        }
        $currentDay = 1;

        $month = str_pad($month, 2, "0", STR_PAD_LEFT);

        while($currentDay <= $numberDays) {

            if($dayOfWeek == 7) {
                $dayOfWeek = 0;
                $calendar.="</tr><tr>";
            }

            $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
            $date = "$year-$month-$currentDayRel";

            if($dateToday==$date){
                $calendar.="<td class='today'><h4>$currentDay</h4>";
            } else {
                $calendar.="<td><h4>$currentDay</h4>";
            }

            $calendar.="</td>";

            $currentDay++;
            $dayOfWeek++;
        }
        if($dayOfWeek != 7) {
            $remainingDays = 7-$dayOfWeek;
            for($i=0; $i<$remainingDays; $i++) {
                $calendar.= "<td></td>";
            }
        }

        $calendar.="</tr>";
        $calendar.="</table>";

        echo $calendar;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <style>
        table {
            table-layout: fixed;
        }

        td {
            width: 33%;
        }

        .today {
            background: yellow;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                    $dateComponents = getdate();
                    $month = $dateComponents['mon'];
                    $year = $dateComponents['year'];
                    echo build_calendar($month, $year);
                ?>
            </div>
        </div>
    </div>
</body>
</html>