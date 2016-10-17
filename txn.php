<?php

session_start();
include_once 'dbconnect.php';
if(!isset($_SESSION['user']))
{
 header("Location: index.php");

}
$res=mysql_query("SELECT * FROM Users WHERE UserID=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);


?>

<!DOCTYPE html>
<html>
<head>
	 <link rel="stylesheet" href="hulk.css" type="text/css" /> 

	<title>Reporting Page</title>
	<!-- Latest compiled and minified CSS -->
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body>
<div class="container">

	<div class="row">
			<nav class="navbar navbar-default ">
			  <div class="container-fluid navi">
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">
			     <a class="navbar-brand" href="#">
			        <img alt="Brand" src="icon.svg">
			      </a>

			      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
			      <a class="navbar-brand" href="#">SplitSense</a>
			      <p class="navbar-text">Signed in as <a href="profile.php"><?php echo $userRow['username']; ?></a></p>
			    </div>

			    <!-- Collect the nav links, forms, and other content for toggling -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			      <ul class="nav navbar-nav">
			      </ul>
			      <ul class="nav navbar-nav navbar-right">
			      	<li ><a href="view_txn.php">Home</a></li>
			      	<li class="active"><a href="txn.php">Add A Bill <span class="sr-only">(current)</span></a></li>
			      	<li><a href="new_view.php">Summary</a></li>
			        <li class="dropdown">
			          <a href="logout.php?logout" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Signout <span class="caret"></span></a>
			          <ul class="dropdown-menu">
			            <li><a href="logout.php?logout">Signout</a></li>
			            <li><a href="#">Settings</a></li>
			            <li><a href="profile.php">Profile</a></li>
			            <li role="separator" class="divider"></li>
			            <li><a href="#">Separated link</a></li>
			          </ul>
			        </li>
			      </ul>
			    </div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>
		</div>


	<div class="row">
        <div class="col-md-3">
        	
        </div>

        <div class="col-md-6">
        	            
        </div>
        <div class="col-md-3">
        	
        </div>
        
	</div>
	<div class="row">
		<div class="col-md-3">
			
		</div>
		<div class="col-md-6">
		<div >
            <legend>SplitSense:</legend>
        </div>
			<form method='post' action=''>
		<div class="form-group">
	    <label for="payer">Select Payer</label>
	    <?php
		// session_start();
		include_once 'dbconnect.php';
		$sql=mysql_query("SELECT * FROM Users");
		if(mysql_num_rows($sql)){	
		$select= '<select class = "form-control" id="payer" name="select">';
		while($rs=mysql_fetch_array($sql)){
		      $select.='<option value="'.$rs['UserID'].'">'.$rs['username'].'</option>';
		  }
		}
		$select.='<option value="0">'."Multple People".'</option>';
		$select.='</select>';
		echo $select;
		?>
	  </div>
	  <input type="submit" name="" required="true" class="btn btn-primary">
	   <!-- <button type="submit" name="choice" class="btn btn-primary">Submit</button> -->
	</form> 
	<?php
       if(isset($_POST['select']))
		{

			$ans = mysql_real_escape_string($_POST['select']);


			if($ans != 0 ){
				$sql = mysql_query("select * from Users where UserID= '$ans'");
				$rs=mysql_fetch_array($sql);
				$name = $rs['username'];
				$id = $rs['UserID'];
				$str =  '<form method="post" action = "mooshtxn.php" class="form-group">
				
        	<!-- panel preview -->
            <h4>Add payment:</h4>
            <div class="panel panel-default">
                <div class="panel-body form-horizontal payment-form">
                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" required="true" id="description" name="description">
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="date" class="col-sm-3 control-label">Date</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" required="true" id="date" name="date">
                        </div>
                    </div>   
                </div>
            </div>
			  <div class="form-group">
			    <label class="sr-only" for="Amount">Amount (in INR)</label>
			    <div class="input-group">
			      <div class="input-group-addon">₹</div> 
			      <input type="number" min="0" step="1" class="form-control" required="true"; name = ' . $id. 'id="Amount" placeholder="Amount paid by ' .$name . ' ">
			      <div class="input-group-addon">.00</div>
			    </div>
				  </div> ' ; 
				  $sql=mysql_query("SELECT * FROM Users");
					if(mysql_num_rows($sql)){	
					while($rs=mysql_fetch_array($sql)){
						 $name = $rs['username'];
						 $id = $rs['UserID'];
				  		$str.= '  <div class="form-group">
				    <label class="sr-only" for="Amount">Amount (in INR)</label>
				    <div class="input-group">
				      <div class="input-group-addon">₹</div>
				      <input type="number" min="0" step="1" class="form-control" required="true"  name = '.$id .   '  id="Amount" placeholder="Amount used by '.$name. ' ">
				      <div class="input-group-addon">.00</div>
				    </div>
				  </div> ';
					  }
					  $str .= ' <button type="submit" class="btn btn-primary" name="cash" value= "cash" >Transfer cash</button> ';
					  $str .= ' </form> ';
					  echo $str;
					}
					


			}
			else{

				  $str = ' <form method="post" action="murga.php" class="form-group">
				  	<!-- panel preview -->
            <h4>Add payment:</h4>
            <div class="panel panel-default">
                <div class="panel-body form-horizontal payment-form">
                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" required="true" id="description" name="description">
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="date" class="col-sm-3 control-label">Date</label>
                        <div class="col-sm-9">
                            <input type="date"  class="form-control" required="true" id="date" name="date">
                        </div>
                    </div>   
                </div>
            </div> ';
				  $sql=mysql_query("SELECT * FROM Users");
					if(mysql_num_rows($sql)){	
					while($rs=mysql_fetch_array($sql)){
						 $name = $rs['username'];
						  $id = $rs['UserID'];
					      $str.= ' <div class="form-group">
				    <label class="sr-only" for="Amount">Amount (in INR)</label>
				    <div class="input-group">
				      <div class="input-group-addon">₹</div>
				      <input type="number" min="0" step="1" class="form-control" required="true" name = ' . $id. 'id="Amount" placeholder="Amount paid by ' .$name . ' ">
				      <div class="input-group-addon">.00</div>
				    </div>
				  </div> ';
				  		$str.= ' <div class="form-group">
				    <label class="sr-only" for="Amount">Amount (in INR)</label>
				    <div class="input-group">
				      <div class="input-group-addon">₹</div>
				      <input style="
    background-color: rgba(245, 245, 245, 0.51);
" type="number" min="0" step="1" class="form-control" required="true" name = '.$id .   '  id="ActAmount" placeholder="Amount used by '.$name. '  ">
				      <div class="input-group-addon">.00</div>
				    </div>
				  </div> ';
					  }
					  $str .= ' <button type="submit" class="btn btn-primary" name="cash" >Transfer cash</button> ';
					  $str .= '</form>';
					  echo $str;
					}

			}
		}
	?>
		</div>
		<div class="col-md-3">
			
		</div>
	</div>
</div>
</body>
