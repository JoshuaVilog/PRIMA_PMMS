<?php
require_once __DIR__ . '/../../models/RegisterModel.php';

// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // $jobOrder = $_POST['jobOrder'];
    $jobOrder = "";
    $moldCode = $_POST['moldCode'];
    $controlNo = $_POST['controlNo'];
    $type = $_POST['type'];
    $issuedDate = $_POST['issuedDate'];
    $issuedTime = $_POST['issuedTime'];
    $remarks = $_POST['remarks'];

    try {
        $record = new RegisterModel();

        $record->jobOrder = $jobOrder;
        $record->moldCode = $moldCode;
        $record->controlNo = $controlNo;
        $record->type = $type;
        $record->issuedDate = $issuedDate;
        $record->issuedTime = $issuedTime;
        $record->remarks = $remarks;
        
       /*  $isDuplicate = $record::CheckDuplicate($desc);

        if($isDuplicate == true){

            echo json_encode(['status' => 'duplicate', 'message' => '']);
        } else if($isDuplicate == false){

            $record::InsertRecord($record);
            echo json_encode(['status' => 'success', 'message' => '']);
        } */

        $record::InsertRecord($record);
        echo json_encode(['status' => 'success', 'message' => '']);

    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}