<?php
if (isset($_SESSION['User_Role_ID']))
	{
	if ($_SESSION['User_Role_ID'] == 1)
		{

        echo '<div class="navbar-fixed">
<nav>
    <div class="nav-wrapper grey darken-4">
        <a class="brand-logo">EVS</a>
        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            <li><a href="index.php">Home</a></li>
            <li><a href="addSet.php">New Test Set</a></li>
            <li><a href="add.php">New Question</a></li>
            <li><a href="#!">Edit</a></li>
            <li><a href="#!">Report</a></li>
            <li><a href="../../logout.php">Logout</a></li>
        </ul>
        <ul class="side-nav" id="mobile-demo">
            <li><a href="index.php">Home</a></li>
            <li><a href="addSet.php">New Test Set</a></li>
            <li><a href="add.php">New Question</a></li>
            <li><a href="#!">Edit</a></li>
            <li><a href="#!">Report</a></li>
            <li><a href="../../logout.php">Logout</a></li>
        </ul>
    </div>
</nav>
</div>';

		}
	  else if ($_SESSION['User_Role_ID'] == 2)
		{
		
            
             echo '<div class="navbar-fixed">
<nav>
    <div class="nav-wrapper grey darken-4">
        <a class="brand-logo">EVS</a>
        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            <li><a href="index.php">Home</a></li>
            <li><a href="room.php">Take Test</a></li>
            <li><a href="results.php">View Results</a></li>
            <li><a href="../../logout.php">Logout</a></li>
        </ul>
        <ul class="side-nav" id="mobile-demo">
            <li><a href="index.php">Home</a></li>
            <li><a href="room.php">Take Test</a></li>
            <li><a href="results.php">View Results</a></li>
            <li><a href="../../logout.php">Logout</a></li>
        </ul>
    </div>
</nav>
</div>';
            
            
		}
	}
  else
	{
	      echo '<div class="navbar-fixed">
  <nav>
        <div class="nav-wrapper grey darken-4">
            <a class="brand-logo">EVS</a>
        </div>
    </nav>
</div>';
      
	} 
?>