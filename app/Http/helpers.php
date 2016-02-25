<?php
function rad( $x ){
	return $x * pi() / 180;
}

function getDistance($p1, $p2){
	$radius = 6378137;
	$dLat = rad($p2->latitude - $p1->latitude);
	$dLong = rad($p2->longitude - $p1->longitude);
	$a = sin($dLat/2) * sin($dLat/2) + 
			cos(rad($p1->latitude)) * cos(rad($p2->latitude)) *
			sin($dLong / 2) * sin($dLong / 2);
	$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
	$d = $radius * $c;
	return $d;
}
?>