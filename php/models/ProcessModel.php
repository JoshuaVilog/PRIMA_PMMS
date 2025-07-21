<?php
require_once __DIR__ . '/../../config/db.php';

class ProcessModel {
    
    public static function DisplayRecords() {
        $db = DB::connectionPMMS();
        $sql = "SELECT * FROM `process_list`";
        $result = $db->query($sql);

        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
        }

        return $records;
    }

}