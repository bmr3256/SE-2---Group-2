<?php
session_start();
session_destroy();
header('Location: Adminlogin.Se2.html');
exit;