<?php

/* object-oriented monthsDB Class with public static methods for interacting 
 * with the months table */

class MonthsDB {

    public static function getDaysInMonth($month_name) {
        $db = Database::getDB();

        $query = 'SELECT * FROM months
                  WHERE monthName = :monthName';
        $statement = $db->prepare($query);
        $statement->bindValue(':monthName', $month_name);
        $statement->execute();
        $month = $statement->fetch();
        $statement->closeCursor();
        return $month['numDays'];
    }
    
    public static function getMonthNameByID($monthID) {
        $db = Database::getDB();

        $query = 'SELECT * FROM months
                  WHERE monthID = :monthID';
        $statement = $db->prepare($query);
        $statement->bindValue(':monthID', $monthID);
        $statement->execute();
        $month = $statement->fetch();
        $statement->closeCursor();
        return $month['monthName'];
    }

    public static function getStartingDayOfMonth($month_name) {
        $db = Database::getDB();

        $query = 'SELECT * FROM months
                  WHERE monthName = :monthName';
        $statement = $db->prepare($query);
        $statement->bindValue(':monthName', $month_name);
        $statement->execute();
        $month = $statement->fetch();
        $statement->closeCursor();
        return $month['startingDay'];
    }
    
}

?>
