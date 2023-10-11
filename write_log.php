#!/usr/bin/php
<?php

function writeLog($conn, $logEntry) {
    echo "\n" . $logEntry;
    $sqlStatement = mysqli_prepare($conn, "insert into log (timestamp, action) values (now(), ?);");
    mysqli_stmt_bind_param($sqlStatement, "s", $logEntry);

    $check_result = mysqli_stmt_execute($sqlStatement);
    if (!$check_result) {
        echo "Error writing log entry - " . $logEntry . "\n";
    }     
}