<?php
    namespace App\Controllers;
    class DashboardController {
        public function index()
        {
            require dirname(__DIR__) . '/views/dashboard/index.php';
        }
    }
?>