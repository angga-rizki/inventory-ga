<?php

function setMessageFlashData($message, $status) {
    $data = [
        'message' => $message,
        'status' => $status
    ];
    return $data;
}
