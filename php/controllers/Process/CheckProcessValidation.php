<?php
require_once __DIR__ . '/../../models/ProcessModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $processs = $_POST['process'];
    $user = $_POST['user'];
    $registerID = $_POST['registerID'];

    try {
        $process = new ProcessModel();

        $process->user = $user;
        $process->process = $processs;
        $process->registerID = $registerID;

        $checkLogs = ProcessModel::CheckProcessValidation($process);
        $rid = 0;

        if($checkLogs == 0){
            $response = "IN";
        } else {
            $rid = $checkLogs['RID'];
            $response = "OUT";
        }
        
        echo json_encode(['status' => 'success', 'status' => $response, 'rid' => $rid, 'message' => '']);
    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}