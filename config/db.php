<!-- connect to mysql -->
<?php
// Create Connection
// pass in the host, the user, password, database name
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check Connection
if(mysqli_connect_errno()){
    // Connection Failed if true, concatenate error
    echo 'Failed to connect to MySQL'. mysqli_connect_errno();
}