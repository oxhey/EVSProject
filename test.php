<?php

if (isset($_POST['login']))
	{
	require "connect.php";

	session_start();
	if (count($_POST) > 0)
		{
		if ($stmt = mysqli_prepare($conn, "SELECT id, Login_ID, Name, User_Role_ID FROM user WHERE Login_ID = ?"));
        
        $lid = $_POST["id"];
        
        $lid = "14083313";
            
        mysqli_stmt_bind_param($stmt, "s", $lid);
        
        mysqli_stmt_execute($stmt);
            
        mysqli_stmt_bind_result($stmt, $id, $Login_ID, $Name, $User_Role_ID);
            
        mysqli_stmt_fetch($stmt);

    printf("%s is in district %s\n", $city, $district);
            
            if (is_array($stmt))
			{
            $_SESSION["Student_DB_ID"] = $id;
			$_SESSION["Login_ID"] = $Login_ID;
			$_SESSION["Name"] = $Name;
			$_SESSION["User_Role_ID"] = $User_Role_ID;
			switch ($row["User_Role_ID"])
				{
			case "2":
				header("Location: ../views/student/");
				break; //Student
			case "1":
				header("Location: ../views/admin/");
				break; //Admin
				}
            }
		  else
			{
			echo "Invalid ID!";
			}
            

    /* close statement */
    mysqli_stmt_close($stmt);
        
		}
	}

?>


// Setup Query
02
$query = "SELECT `id` FROM employees WHERE `name`=?";
03
 
04
// Setup parameter to be bound into query
05
$name = "Joey";
06
 
07
// Get instance of statement
08
$stmt = mysqli_stmt_init($link);
09
 
10
// Prepare Query
11
if (mysqli_stmt_prepare($stmt, $query)) {
12
 
13
    // Bind Parameters [s for string]
14
    mysqli_stmt_bind_param($stmt, "s", $name);
15
 
16
   // Execute Statement
17
   mysqli_stmt_execute($stmt);
18
 
19
   // Bind results to variable
20
   mysqli_stmt_bind_result($stmt, $employee_id);
21
 
22
   // Fetch Value
23
   mysqli_stmt_fetch($stmt);
24
 
25
   // Echo Result
26
   echo "$name has an ID of $employee_id";
27
 
28
   // Close Statement
29
   mysqli_stmt_close($stmt);
30
 
31
 
32
}
