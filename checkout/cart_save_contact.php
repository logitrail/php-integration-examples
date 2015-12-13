<?php
session_start();

$_SESSION['contact'] = array_filter($_POST);

// Checking that all contact details are given
$requiredFields = array('firstname','lastname','address','postalcode','city','email','phone');
$missingFields = array_diff($requiredFields, array_keys($_SESSION['contact']));

Header("Content-Type: text/json");
if ($missingFields) {
    echo json_encode(array('ready' => 0, 'info_for_user' => 'Some fields are still missing: ' . join(', ', $missingFields)));
    exit;
}

echo json_encode(array('ready' => 1, 'info_for_user' => 'Ready for Logitrail Call'));
exit;