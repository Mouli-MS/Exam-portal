<?php 
    include('database.php');
    
    class Functions extends Database
    {
        function uniqid()
        {
            $uniq = hash('sha256', uniqid(rand(0000,9999), true));
            return $uniq;
        }
        public function sanitize($conn,$data)
        {
            $clean=mysqli_real_escape_string($conn,$data);
            return $clean;
        }
    }
?>