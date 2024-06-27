<?php

    /* Function to format strings that represent an amount of time into 
    a 00:00:00 format */
    function format_into_leading_zeroes($timeString) {
        if ($timeString != "") {
        list($hours, $minutes, $seconds) = explode(':', $timeString);
        $formattedTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        return $formattedTime;
        } else {
            return "00:00:00";
        }
    }

    /* Function to get the statistics for the current month and returns an associative array
     * for each stat */
    function getCurrentMonthStats(){
        /* Get the current month's number using a DateTime object*/
        $date = new DateTime(); // Represents current date and time
        $currentMonthID = $date->format('n'); // n for no leading 0's
        $currentMonthName = $date->format('F'); // F for full name of month
        $currentDay = $date->format('j');
        $daysInMonth = MonthsDB::getDaysInMonth($currentMonthName);
        $startingDayOfMonth = (new DateTime('first day of this month'));
        $nameOfStartingDay = $startingDayOfMonth->format('l');
        // Calculate amount of "grayed" days 
        $calendarDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $grayedDays = 0;
        foreach ($calendarDays as $calendarDay){
            if ($calendarDay != $nameOfStartingDay) {
                $grayedDays++;
            } else {
                break;
            }
        }

        return [
            $currentMonthID,
            $currentMonthName,
            $currentDay,
            $daysInMonth,
            $nameOfStartingDay,
            $grayedDays,
            $calendarDays,
        ];

    }

    /* For number-tracked habits, subtract and add the values and return as a string */
    function subtract_and_add_number($habit_value, $value_to_add, $value_to_subtract) {
        // Add
        $addition_result = (int)$habit_value + (int)$value_to_add;
        // Subtract
        $subtraction_result = (int)$addition_result - (int)$value_to_subtract;
        // Subtraction result is the final result, convert it back to string
        return (string)$subtraction_result;
    }

    /* For time-tracked habits, subtract and add the amounts of time and return the value
     * as a formatted string aswell */
    function subtract_and_add_time($habit_value, $time_to_add, $time_to_subtract){
        // Format everything into leading zeroes
        $habit_value = format_into_leading_zeroes($habit_value);
        $time_to_add = format_into_leading_zeroes($time_to_add);
        $time_to_subtract = format_into_leading_zeroes($time_to_subtract);
        //var_dump($habit_value, $time_to_add, $time_to_subtract);
        
        // Parse the formatted strings for their hours/minutes/seconds and assign them to variables
        list($hours, $minutes, $seconds) = explode(':', $habit_value);
        list($hours_to_add, $minutes_to_add, $seconds_to_add) = explode(':', $time_to_add);
        list($hours_to_subtract, $minutes_to_subtract, $seconds_to_subtract) = explode(':', $time_to_subtract);

        // Convert all of them into their own categories of seconds
        $total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;
        $total_seconds_to_add = ($hours_to_add * 3600) + ($minutes_to_add * 60) + $seconds_to_add;
        $total_seconds_to_subtract = ($hours_to_subtract * 3600) + ($minutes_to_subtract * 60) + $seconds_to_subtract;

        // Do the math
        $total_seconds_result = ($total_seconds + $total_seconds_to_add - $total_seconds_to_subtract);

        // Convert back into HH:MM:SS format
        $result_hours = floor($total_seconds_result / 3600);
        $result_minutes = floor(($total_seconds_result % 3600) / 60);
        $result_seconds = $total_seconds_result % 60;

        $calculated_time_f = sprintf('%02d:%02d:%02d', $result_hours, $result_minutes, $result_seconds);
        return $calculated_time_f;
    }
    


