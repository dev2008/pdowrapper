<?php
// don't delete this line, this must be the first line of your code
if(!defined('custom_page_from_inclusion')) { die(); }
$time_start = microtime(true);
require_once 'g_functions.php';

$str="<br /><div class='w3-card-4'>";
$str.="<header class='w3-container w3-blue-gray'>";
$str.="<h1>Headline</h1>";
$str.="</header>";
output($str);

$str="<div class='w3-container w3-pale-blue'>";
output($str);
//Text for middle box
$str="<h2>About to process some records</h3>";
output($str);
try {
		$_cp_sql = "SELECT DISTINCT(`gametype`) FROM `f_gametypes` WHERE 1 ";
		$result = $conn->prepare($_cp_sql); 
		$result->execute(); 
		$number_of_rows = number_format($result->rowCount() ); 
		$str="<div class='w3-container w3-teal'>\n";
		$str.="<h4>Found $number_of_rows records</h4>";
		output($str);
	} catch (PDOException $e) {
				echo "DataBase Error:<br>".$e->getMessage();
				exit ("<h1>****Warning - processing stopped on database error****</h1>");
	} catch (Exception $e) {
					echo "General Error:<br>".$e->getMessage();
					exit ("<h1>****Warning - processing stopped on general error****</h1>");
	}
$mycount=0;	
while($row = fetch_row_db($result)){
	$mycount++;	
	if ($mycount % 5 == 0) {
		$str='<p>Processed ';
		$str.=$mycount;
		$str.=' records.</p>';
		output($str);
	}
}

$string="GAMEPLAN BASEBALL  MLB8   Team Report   Season 1   Preseason   4/12/03";
preg_match_all('#\b(Team|Report|Season)\b#', $string, $matches);
print_r ($matches);

echo "<br />";
$myline="<T>Tom Tom bongo<T>";
$mylineprocessed=str_replace("<T>"," - ",$myline);
echo $mylineprocessed;
echo "<br /";

require_once 'g_footer.php';
?>
