<?php
include ('security.php');
//assume contains a security function
secure_my_page();
// wright the function that would do the checking of sessions and log in


/**
 *		CPS 276 Winter 2016-- Assignment 01
 *              Aquarium Cost Estimator
 *              Jeff Pollack
 *              Time loged on assignment: 1.5 Hours.
 */

// first, some notes...

// <-- Comments in PHP can be added with two forward slashes -- the comment continues until the next line
#  <-- Or with an octothorp (hash sign)
/* <-- Or for mutiple lines,
		 sandwiched between these characters -->  */

		 
// Variables are identified with a dollar sign:
$a = 5;

// -------------------------------------------------------

// Your assignment is to calculate the following values...

$materials_cost = 0;		// cost of materials: glass, fish, water, etc
$labor_cost = 0;			// cost of putting it together
$total_cost = 0;			// the grand total
$time_required = 0;		// the total number of hours required
$total_fish = 0;			// total fish in a fully-stocked tank
$regular_fish = 0;
$fancy_fish = 0;

// here is the input... (no changes needed here)

$width = intval(@$_REQUEST['width']);
$height = intval(@$_REQUEST['height']);
$depth = intval(@$_REQUEST['depth']);


// you can set the following variable to a string, to report any errors at the end.
$error='';
// Example: $error='Width cannot be a negative number.';


// START WORKING HERE...

// Part 1: Materials Cost

		
//		A. Start by finding the total surface area of the aquarium. Assume that the aquarium is glass on all six sides. Store this as $glass_surface. Hint: (W*H)*2 + (W*D)*2 + (H*D)*2

$glass_surface = ($width*$height)*2 + ($width*$depth)*2 + ($height*$depth)*2;

//		B. Also find the total volume of the aquarium, and store as $total_volume. Assume the tank will be filled completely to the top.

$total_volume = $width*$height*$depth;

//		C. Raw materials cost: glass costs $0.03 per cm/sq.

$raw_glass = $glass_surface*.03;

//		D. Raw materials cost: purified water costs $0.001 per cm3 (cubic centimeter).

$raw_water = $total_volume*.001;

//		E. Each fish requires 275 cm3 of space. Find the maximum number of fish that can fit in the tank. ** Hint: use the floor() function to round down.

$total_fish = floor($total_volume/275);

//		F. NOT more than 7% of the fish will be fancy fish ($1.98 each). There must be an even number of fancy fish. Add as many fancy fish as possible. The rest will be regular fish ($0.61 each).

$fancy_fish = floor($total_fish*.07);//*1.98;

if($fancy_fish % 2 !=0){
    $fancy_fish = $fancy_fish-1;
}

$regular_fish = ($total_fish-$fancy_fish);//*.61;
$all_fish = ($fancy_fish*1.98)+($regular_fish*.61);

//		G. Add a small castle and lighting: $7.95

$ambiance = 7.95;

//		H. The sum of C,D,F,and G and the total materials cost. 

$materials_cost = number_format($raw_glass+$raw_water+$all_fish+$ambiance, 2);






// Part 2: Time Required

/*
		The time required will be used to calculate the labor costs
		A. There are two times to keep track of: time to construct the tank ($tank_time) and time to stock the fish ($stock_time), both measured in seconds.
		B. For the tank time, use the FOR loop below.
		   Start with x= the total volume of the tank (cm3)
		   The first side takes x seconds to construct
			Each successive side takes 10% less time than the previous
		C. Stock time is 3 seconds per fish.
		D. the total time is the sum of the tank time and the stock time, measured in minutes.
*/

$tank_time=0;
$stock_time=0;

//$total_volume = x;
$x = $total_volume;

// tank time

for ($i = 0; $i < 6; $i++){
	// {add code here}
$tank_time += $x;
$x = $x- ($x*.1);
}    
$stock_time = $total_fish*3;

$time_required = ceil(($tank_time+$stock_time) / 60);

// Part 3: Labor Costs and Grand Total

// 	A. The staff are aquarium professionals, paid $33.71 per hour or portion thereof. ** Hint: round up to the nearest hour with the ceil() function

$labor_cost = ceil((($tank_time + $stock_time)/60)/60)*33.71;
//		B. Add $12 handling fee.
$handling_fee = 12;
//		C. Calculate the grand total (materials and labor and fees)
$total_cost = $labor_cost+$handling_fee+$materials_cost;
//		D. There's a sale going on! If the total is greater than $250, give a 30% discount. If between $100-$249, give a 10% discount.
if ($total_cost > 250){
$total_cost = $total_cost-($total_cost*.3);
}
elseif ($total_cost > 100 && $total_cost < 249){
$total_cost = $total_cost-($total_cost*.1);
}

//		E. Use the number_format function to alter the math precision for currency.
//			Example: $amount = number_format($amount, 2);   -->  would turn 24.022278 into 24.02
$total_cost = number_format($total_cost, 2);









/*		What follows is the HTML form used to present the application.
 		No changes are needed beyond this point, but it's a good idea to look this over.
 		You will be making your own forms in future assignments. */

echo $error;
if($width==0) $width='';
if($height==0) $height='';
if($depth==0) $depth='';
?>
<form method='get' action='index.php'>
	<table border='1'>
		<tr>
			<th colspan='2'>Aquarium Cost Estimator</th>
		</tr>
		<tr>
			<td>Width</td>
			<td><input type='text' name='width' value='<?=$width?>' size='5'/> cm</td>
		</tr>
		<tr>
			<td>Height</td>
			<td><input type='text' name='height' value='<?=$height?>' size='5'/> cm</td>
		</tr>
		<tr>
			<td>Depth</td>
			<td><input type='text' name='depth' value='<?=$depth?>' size='5'/> cm</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type='submit' value='Calculate'/></td>
		</tr>
		<tr>
			<th colspan='2'>Results</th>
		</tr>
		<tr>
			<td>Total Fish</td>
			<td><?php if($total_fish) echo $total_fish.' ('.$fancy_fish.' fancy)'; else echo '&nbsp;'?></td>
		</tr>
		<tr>
			<td>Materials Cost</td>
			<td>$<?=($materials_cost) ? $materials_cost: '&nbsp;'?></td>
		</tr>
		<tr>
			<td>Labor Cost</td>
			<td>$<?=($labor_cost) ? $labor_cost : '&nbsp;'?></td>
		</tr>
		<tr>
			<td>Total Cost</td>
			<td>$<?=($total_cost) ? $total_cost : '&nbsp;'?></td>
		</tr>
		<tr>
			<td>Time Required</td>
			<td><?=($time_required)?$time_required.' minutes':'&nbsp;'?></td>
		</tr>
	</table>
</form>






