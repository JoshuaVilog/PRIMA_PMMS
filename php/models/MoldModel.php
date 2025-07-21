<?php
require_once __DIR__ . '/../../config/db.php';

class MoldModel {
    
    public static function DisplayRecords() {
        $db = DB::connectionTMS();
        $sql = "SELECT
            `RID`,
            `MOLD_CTRL`,
            `ITEM_CODE`,
            `ITEM_NAME`,
            `CUSTOMER`,
            `MODEL`,
            `MAKER`,
            `CATEGORY`,
            `MOLD_LOCATION`,
            `MARK`,
            `MOLD_STATUS`,
            `COLOR_CODE`,
            `GUARANTEE`,
            `CAVITY`,
            `TRANSFER_DATE`,
            `APPROVAL_DATE`,
            `MOLD_CONDITION`
        FROM
            `mold_masterlist`
        WHERE
            COALESCE(DELETED_AT, '') = ''";
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