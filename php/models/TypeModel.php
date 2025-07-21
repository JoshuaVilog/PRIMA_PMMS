<?php
require_once __DIR__ . '/../../config/db.php';

class TypeModel {
    
    public static function DisplayRecords() {
        $db = DB::connectionPMMS();
        $sql = "SELECT * FROM `type_list`";
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