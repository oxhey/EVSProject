<?php
session_start();

if (isset($_SESSION['User_Role_ID']))
	{
	if ($_SESSION['User_Role_ID'] == 1)
		{
		include '../../templates/header.php';

		include '../../config/functions.php';

		include "../../config/connect.php";

		include '../../templates/nav.php';

		echo '
    <div class="container center">';
		echo '<div class="row">
            <div class="col-lg-12">
                <div id="testtitle" class="page-header">
                    <h2>Room code: <strong>';
		getRoomCode();
		echo '</strong></h2>
                </div>
            </div>
        </div>';
		echo '<div id="testform" class=""> <form method="POST" name="closetest" action="">
 <div class="row">
<div class="col s6">
         <input type="submit" class="waves-effect waves-light btn blue darken-3 close" name="closetest" value="Close Test">
</div>

<div class="col s6">
         <input type="checkbox" id="reloadCB" onclick="toggleAutoRefresh(this);" />
      <label for="reloadCB">Auto Refresh</label>
</div>
</div>
    </form></div>';
		if (isset($_POST['closetest']))
			{
			$ts = $_GET["tid"];
			$stmt = mysqli_prepare($conn, "UPDATE test_set 
                                          SET isOpen = 0 WHERE id= ?");
			$stmt->bind_param("i", $ts);
			$result = $stmt->execute();
			if ($result === FALSE)
				{
				echo 'Test Not closed, in fact the query failed ' . $stmt->error;
				}
			  else
				{
				echo ' <script>
        Materialize.toast("Test Closed!", 3000)
        
        $("#testtitle").css( "display", "none" );
        $("#testform").css( "display", "none" );
        window.location.replace("#");
        clearTimeout(reloading);
        </script>
        
        ';
				}

			$stmt->close();
			$conn->close();
			}

		echo '<div class="row">';
		getQuestionsForSet();
		echo '</div>
</div>';
		include "../../templates/footer.php";

		}
	  else
		{
		echo "No";
		}
	}
  else
	{
	echo "Please Login First";
	}

?>

<script>
var reloading;

function checkReloading() {
    if (window.location.hash=="#autoreload") {
        reloading=setTimeout("window.location.reload();", 2000);
        document.getElementById("reloadCB").checked=true;
    }
}

function toggleAutoRefresh(cb) {
    if (cb.checked) {
        window.location.replace("#autoreload");
        reloading=setTimeout("window.location.reload();", 2000);
    } else {
        window.location.replace("#");
        clearTimeout(reloading);
    }
}

window.onload=checkReloading;
</script>