<?php
include_once 'dbconnect.php';
$result = mysql_query("SELECT * FROM edges") or die('Unable to run query:');
//print_r($result);
$counter = mysql_num_rows($result);
$graph = array();
if($counter > 0){
	while($row = mysql_fetch_array($result)){
		echo $row['from'] . $row['to'] . $row['weight']."\n";
		$graph[$row['from']][$row['to']]= $row['weight'];

	}
}
//print_r($graph);

$visited = array();
$i = 1000;
while($i>=0){
	$visited[$i] = false;
	$i = $i-1;
}
//print_r($visited);

$cost = array();
$i=1000;
while($i>=0){
	$cost[$i] = 0;
	$i = $i-1;
}
$q = new SplQueue();
function bfs($x){
	//echo "Applying bfs\n";
	global $q;
	global $visited;
	$q -> enqueue ($x );
	while(!$q->isEmpty()){
		$top =$q[0];
		$q->dequeue();
		print($top);
		if($visited[$top]!=false)
			continue;
		$visited[$top] = true;
		$cnt = count($graph[$row['from']]);
		for($j=0;$j<$cnt;$j++){
			$cost[$row['from']] -= $graph[$row['from']][$row['to']];
			$cost[$row['to']] += $graph[$row['from']][$row['to']];
			$q->enqueue($graph[$row['from']][$j]);
		}
	}

}
print_r($cost);

$cnt = count($graph);
	for($i=0;$i<$cnt;$i++){
		if($visited[$i]==false){
			bfs($graph[$i]);
		}
	}
?>
