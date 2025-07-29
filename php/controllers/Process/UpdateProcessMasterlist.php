<?php
require_once __DIR__ . '/../../models/ProcessModel.php';

// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $rid = $_POST['rid'];
    $user = $_POST['user'];
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];

    try {
        $record = new ProcessModel();

        $record->rid = $rid;
        $record->user = $user;
        $record->status = $status;
        $record->remarks = $remarks;

        $record::UpdateProcessMasterlist($record);
        $record::UpdateStatusRegisterMasterlist($record);

    } catch (Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

}