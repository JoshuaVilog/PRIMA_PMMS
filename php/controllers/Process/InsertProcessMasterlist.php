<?php
require_once __DIR__ . '/../../models/ProcessModel.php';

// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $registerID = $_POST['registerID'];
    $process = $_POST['process'];
    $user = $_POST['user'];

    try {
        $record = new ProcessModel();

        $record->registerID = $registerID;
        $record->process = $process;
        $record->user = $user;
        
        $isDuplicate = $record::CheckDuplicateProcessMasterlist($record);

        if($isDuplicate == true){

            echo json_encode(['status' => 'duplicate', 'message' => '']);
        } else if($isDuplicate == false){

            $record::InsertProcessMasterlist($record);
            echo json_encode(['status' => 'success', 'message' => '']);
        }

    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}