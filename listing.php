<?php

// Fetch required records joined together, sorted by Category Title, then by Listing Title
$records = mysql_query("SELECT pmd_listings.title AS TitleL, pmd_listings.location_text3 AS Location3, pmd_listings.location_text2 AS Location2,".
							"pmd_listings.phone AS Phone, pmd_categories.title AS TitleC ".
							"FROM pmd_listings_categories ".
							"INNER JOIN pmd_listings ".
								"ON pmd_listings_categories.list_id = pmd_listings.id ".
							"INNER JOIN pmd_categories ".
								"ON pmd_listings_categories.cat_id = pmd_categories.id ".
							"ORDER BY TitleC ASC, TitleL ASC");

// Fetch a list of all categories in alphabetical order
$categories = mysql_query("SELECT * FROM pmd_categories ORDER BY title ASC");

// Add all categories to an array
$categoryArray = array();
while($catinfo = mysql_fetch_array( $categories )) {
	$categoryArray[] = $catinfo['title'];
}

// Print out the data
$echoCategory = 1; // 1= Print the Category title
$i=0; //this is incremented and iterates through the categoryArray
while($info = mysql_fetch_array($records)) {
	if ($echoCategory == 1) { // This statement is to print the first Category Title only
		echo "<b>" . $categoryArray[$i] . "</b><br /><br />"; // Print the Category Title
		$echoCategory = 0; // 0 = Never again print the Category Title
	}
	if ($info['TitleC'] == $categoryArray[$i]) {
		echo $info['TitleL'] . "<br />";
		echo $info['Location3'] . ", " . $info['Location2'] . ", " . $info['Phone'] . "<br /><br />";
	} else {
		$i++;
		echo "<br /><b>" . $categoryArray[$i] . "</b><br /><br />";
		echo $info['TitleL'] . "<br />";
		echo $info['Location3'] . ", " . $info['Location2'] . ", " . $info['Phone'] . "<br />";
		$echoCategory = 0;
		echo "<br />";
	}
}
	
?>