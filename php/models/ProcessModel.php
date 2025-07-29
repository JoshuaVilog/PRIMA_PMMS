<?php
require_once __DIR__ . '/../../config/db.php';

class ProcessModel {
    
    public static function DisplayProcessRecords() {
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

    public static function CheckProcessValidation($records){
        $db = DB::connectionPMMS();

        $registerID = $db->real_escape_string($records->registerID);
        $user = $db->real_escape_string($records->user);
        $process = $db->real_escape_string($records->process);

        $find = $registerID."-".$process."-".$user;
        $sql = "SELECT `RID` FROM `process_masterlist` WHERE CONCAT(REGISTER_ID,'-',PROCESS, '-', IN_BY, COALESCE(OUT_BY, ''))  = '$find'";
        $result = mysqli_query($db,$sql);

        if(mysqli_num_rows($result) == 0){
            return null;
        } else {
            $row = mysqli_fetch_assoc($result);

            return $row;
        }
    }

    public static function CheckDuplicateProcessMasterlist($records){
        $db = DB::connectionPMMS();

        $registerID = $db->real_escape_string($records->registerID);
        $process = $db->real_escape_string($records->process);
        $user = $db->real_escape_string($records->user);

        $find = $registerID."-".$process."-".$user;
        $sql = "SELECT `RID` FROM `process_masterlist` WHERE CONCAT(REGISTER_ID,'-',PROCESS, '-', IN_BY, COALESCE(OUT_BY, ''))  = '$find'";
        $result = mysqli_query($db,$sql);

        if(mysqli_num_rows($result) == 0){
            return false;
        } else {

            return true;
        }
    }

    public static function InsertProcessMasterlist($records){
        $db = DB::connectionPMMS();
        // $userCode = $_SESSION['USER_CODE'];

        $registerID = $db->real_escape_string($records->registerID);
        $process = $db->real_escape_string($records->process);
        $user = $db->real_escape_string($records->user);

        date_default_timezone_set('Asia/Manila');
        $createdAt = date("Y-m-d H:i:s");

        $sql = "INSERT INTO `process_masterlist`(
            `RID`,
            `REGISTER_ID`,
            `PROCESS`,
            `IN_DATETIME`,
            `IN_BY`
        )
        VALUES(
            DEFAULT,
            '$registerID',
            '$process',
            '$createdAt',
            '$user'
        )";

        return $db->query($sql);
    }
    public static function UpdateProcessMasterlist($records){
        $db = DB::connectionPMMS();
        // $userCode = $_SESSION['USER_CODE'];

        $rid = $db->real_escape_string($records->rid);
        $status = $db->real_escape_string($records->status);
        $remarks = $db->real_escape_string($records->remarks);
        $user = $db->real_escape_string($records->user);

        date_default_timezone_set('Asia/Manila');
        $createdAt = date("Y-m-d H:i:s");

        $sql = "UPDATE
            `process_masterlist`
        SET
            `OUT_DATETIME` = '$createdAt',
            `OUT_BY` = '$user',
            `REMARKS` = '$remarks',
            `STATUS` = '$status'
        WHERE
            `RID` = $rid";

        return $db->query($sql);
    }
    public static function UpdateStatusRegisterMasterlist($records){
        $db = DB::connectionPMMS();

        $rid = $db->real_escape_string($records->rid);
        $status = $db->real_escape_string($records->status);

        $sql = "UPDATE
            `register_masterlist`
        SET
            `STATUS` = '$status'
        WHERE
            `RID` = $rid";

        return $db->query($sql);
    }

}