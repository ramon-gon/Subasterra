<?php
require_once(__DIR__ . "/session-controller.php");
lazy_session_start();

session_destroy();
header("location: ../index.php");
