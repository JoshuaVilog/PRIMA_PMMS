<?php
require_once __DIR__ . '/../../config/db.php';

class RegisterModel {
    
    public static function DisplayRecords() {
        $db = DB::connectionPMMS();
        $sql = "SELECT `RID`, `JOB_ORDER`, `MOLD_CODE`, `CONTROL_NO`, `TYPE`, `ISSUED_DATE`, `ISSUED_TIME`, `REMARKS`, `CREATED_AT`, `CREATED_BY` FROM `register_masterlist` WHERE COALESCE(DELETED_AT, '') = '' ORDER BY RID DESC";
        $result = $db->query($sql);

        $records = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
        }

        return $records;
    }

    public static function GetRecord($id){
        $db = DB::connectionPMMS();

        $sql = "SELECT `RID`, `JOB_ORDER`, `MOLD_CODE`, `CONTROL_NO`, `TYPE`, `ISSUED_DATE`, `ISSUED_TIME`, `REMARKS`, `CREATED_AT`, `CREATED_BY` FROM `register_masterlist` WHERE RID = $id";
        $result = mysqli_query($db,$sql);

        if(mysqli_num_rows($result) == 0){
            return null;
        } else {
            $row = mysqli_fetch_assoc($result);

            return $row;
        }
    }
    public static function CheckDuplicate($desc){
        $db = DB::connectionPMMS();

        $sql = "SELECT RID FROM `register_masterlist` WHERE CONCAT(CONTROL_NO, COALESCE(DELETED_AT, '')) = '$desc' ";
        $result = mysqli_query($db,$sql);

        if(mysqli_num_rows($result) == 0){
            return false;
        } else {
            return true;
        }
    }

    public static function InsertRecord($records){
        $db = DB::connectionPMMS();
        $userCode = $_SESSION['USER_CODE'];

        $jobOrder = $db->real_escape_string($records->jobOrder);
        $moldCode = $db->real_escape_string($records->moldCode);
        $controlNo = $db->real_escape_string($records->controlNo);
        $type = $db->real_escape_string($records->type);
        $issuedDate = $db->real_escape_string($records->issuedDate);
        $issuedTime = $db->real_escape_string($records->issuedTime);
        $remarks = $db->real_escape_string($records->remarks);

        $sql = "INSERT INTO `register_masterlist`(
            `RID`,
            `JOB_ORDER`,
            `MOLD_CODE`,
            `CONTROL_NO`,
            `TYPE`,
            `ISSUED_DATE`,
            `ISSUED_TIME`,
            `REMARKS`,
            `CREATED_BY`
        )
        VALUES(
            DEFAULT,
            '$jobOrder',
            '$moldCode',
            '$controlNo',
            '$type',
            '$issuedDate',
            '$issuedTime',
            '$remarks',
            '$userCode'
        )";
        return $db->query($sql);
    }

    public static function UpdateRecord($records){
        $db = DB::connectionPMMS();
        $userCode = $_SESSION['USER_CODE'];

        $moldCode = $db->real_escape_string($records->moldCode);
        $controlNo = $db->real_escape_string($records->controlNo);
        $type = $db->real_escape_string($records->type);
        $issuedDate = $db->real_escape_string($records->issuedDate);
        $issuedTime = $db->real_escape_string($records->issuedTime);
        $remarks = $db->real_escape_string($records->remarks);
        $id = $records->id;

        $sql = "UPDATE
            `register_masterlist`
        SET
            `MOLD_CODE` = '$moldCode',
            `CONTROL_NO` = '$controlNo',
            `TYPE` = '$type',
            `ISSUED_DATE` = '$issuedDate',
            `ISSUED_TIME` = '$issuedTime',
            `REMARKS` = '$remarks',
            `UPDATED_BY` = '$userCode'
        WHERE
            `RID` = $id";
        return $db->query($sql);
    }
    
    public static function RemoveRecord($id){
        $db = DB::connectionPMMS();
        $userCode = $_SESSION['USER_CODE'];

        date_default_timezone_set('Asia/Manila');
        $createdAt = date("Y-m-d H:i:s");

        $sql = "UPDATE
            `register_masterlist`
        SET
            `DELETED_AT` = '$createdAt',
            `DELETED_BY` = '$userCode'
        WHERE
            `RID` = $id";
        
        return $db->query($sql);


    }


}

?>