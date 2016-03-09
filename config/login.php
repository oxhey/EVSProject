<?php

if (isset($_POST['login'])) {
    session_start();

    require "connect.php";
    
    if (count($_POST) > 0) {
        if ($stmt = mysqli_prepare($conn, "SELECT id, Login_ID, Name, User_Role_ID FROM user WHERE Login_ID = ?")) {
            
            $lid = $_POST["id"];
            echo $lid;
            echo "test";

            $stmt->bind_param("i", $lid);
            $stmt->execute();
            $stmt->bind_result($id, $Login_ID, $Name, $User_Role_ID);
            $stmt->fetch();

            $_SESSION["Student_DB_ID"] = $id;
            $_SESSION["Login_ID"] = $Login_ID;
            $_SESSION["Name"] = $Name;
            $_SESSION["User_Role_ID"] = $User_Role_ID;

            switch ($User_Role_ID) {
                case "2":
                    header("Location: ../views/student/");
                    break; //Student
                case "1":
                    header("Location: ../views/admin/");
                    break; //Admin
                default:
                    echo "Invalid ID!"; 
            }

            /* close statement */
            $stmt->close();
            $conn->close();
        }
    }
    else
    {
        echo "Nope!"; 
        
    }
}

?>