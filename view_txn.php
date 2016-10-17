<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="hulk.css" type="text/css" />

    <title>Reporting Page</title>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
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
                    <li class="active"><a href="view_txn.php">Home<span class="sr-only">(current)</span></a></li>
                    <li><a href="txn.php">Add A Bill</a></li>
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
     <?php
     
     $sqlr = mysql_query("SELECT * FROM Txn ORDER BY TxnID DESC LIMIT 1");
         if(!$sqlr){
            echo "failed into getting last id";

         }
         else{
            // echo nl2br("\r\n");
            $last = mysql_fetch_array($sqlr);
            $lastid = $last['TxnID'];
            // echo "last id =>" . $lastid;
            // echo nl2br("\r\n");
         }
                    $i=0;
                    // echo "came to bakrid";
                    // echo nl2br("\r\n");
                    while($i<=$lastid){
                        $i++;
                        // echo "inside while";
                        // echo nl2br("\r\n");
                        $new = mysql_query("SELECT * from EDGE where EDGE.TxnID = $i") or die('failed to fetch table');
                        $cnt = mysql_num_rows($new);
                        if(!$new){
                            echo "failed $new query";
                            echo nl2br("\r\n");
                            // echo $cnt . " count is";
                            // echo nl2br("\r\n");
                        }
                        if($cnt > 0){
                            $da = mysql_query("SELECT * from Txn where TxnID = $i");
                            $ans = mysql_fetch_array($da);
                            $date = $ans['date'];
                            $desc = $ans['Descr'];
                             $str =    '<div class="row">
        <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
            <div class="row">
                 <div class="col-xs-6 col-sm-6 col-md-6">
                    <address>
                        <strong>Inspiring Excellence </strong>
                        <br>
                        B-414 Bhabha Bhavan
                        <br>
                        Svnit, Surat 
                        <br>
                    </address>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                    <p>
                        <em>Date: '.$date. '</em>
                    </p>
                    <p>
                        <em>TxnID #: '.$i.'</em>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="text-center">
                    <h1>'.$desc .'</h1>
                </div>
                </span> 
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Who gave </th>
                            <th style="text-align: center">Who Took</th>
                            <th class="text-center">What</th>
                            <!-- <th class="text-center">Total</th> -->
                        </tr>
                    </thead>' ;
                        echo $str;
                            while ($row = mysql_fetch_array($new)) {
                                // echo "fetched row new";
                                // echo nl2br("\r\n");
                                $from = $row['from'] ; 
                                // echo "from =>" . $from;
                                // echo nl2br("\r\n");
                                $to = $row['to'];
                                // echo "to =>" . $to;
                                // echo nl2br("\r\n");
                                $val = $row['weight'];
                                // echo "val =>" . $val;
                                // echo nl2br("\r\n");
                                $f1 = mysql_query("SELECT * from Users where UserID = '$from' ");
                                $f2 = mysql_fetch_array($f1);
                                $fname  = $f2['username'];
                                // echo "fname =>" . $fname;
                                // echo nl2br("\r\n");
                                $t1 = mysql_query("SELECT * from Users where UserID = '$to' ");
                                $t2 = mysql_fetch_array($t1);
                                $tname = $t2['username'];
                                // echo "tname =>" . $tname;
                                // echo nl2br("\r\n");
                                if($f1 and $t1){
                                   echo '
                                    <tbody>
                        <tr>
                            <td class="col-md-4"><em>'. $fname .'</em></h4></td>
                            <td class="col-md-4" style="text-align: center">'.$tname .' </td>
                            <td class="col-md-4 text-center">₹' . $val .'</td>
                            <!-- <td class="col-md-1 text-center">$26</td> -->
                        </tr>
                    </tbody> 

                                   ';
                                }
                                else{
                                    echo "failed tp get edge";
                                    echo nl2br("\r\n");
                                }
                                
                            }
                        }
                        echo '</table>
            </div>
        </div>
    </div>';
                    }
                ?>

</body>