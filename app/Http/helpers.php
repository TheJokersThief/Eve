<?php
// Returns the argument in radians
function rad( $x ){
	return $x * pi() / 180;
}

// Gets the distance as the crow flies between two points
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

/**
 * Calculates the distance to travel from origin to destination using thier respective co-ordinates.
 * This function makes use of the Google Maps Distance Matrix API and requires a valid Server API key.
 *
 * @param  App\Location $origin			The origin, for this project it should be the co-ordinates of the event
 * @param  App\Location $destination	The destination, as above
 * @return int              			The distance returned by the Google Maps Distance Matrix API
 */
function getMapsMatrixDistance($origin, $destination){

	//Try to get Distance from Google Distance Matrix API
	$response = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?origins='
				. $origin->longitude . ',' . $origin->latitude
				. '&destinations='
				. $destination->longitude . ',' . $destination->latitude
				. '&key=AIzaSyB17PgysQ3erA1N2uSJ-xaj7bS9dxyOW9o');
				//TODO: Update key to be fetched dynamically from the .env
	$response = json_decode($response, true, 512);

	//WOO Debug code! Documenting my approach tbh
	//If we're all cool with the functional code, I'll get rid of these comments
	//
	//	var_dump($response);
	//	var_dump($response["rows"][0]["elements"][0]["distance"]["value"]);
	//echo ($response["rows"][0]["elements"][0]["distance"]["value"] == '' ? 'empty' : 'not empty');
	//if( isset($response["rows"][0]["elements"][0]["distance"]["value"]) ){echo 'not empty';} else {echo 'empty';}

	//If response contains zero results call getDistance instead
	//This will only happen (I think) when Google can't find a route between the two points
	//Or on an invalid request
	if( isset($response["rows"][0]["elements"][0]["distance"]["value"]) ){
		return $response["rows"][0]["elements"][0]["distance"]["value"];
	} else {
		return getDistance($origin, $destination);
	}

}

/**
 * Translates all available languages into the language
 * they're describing (i.e. Irish is Gaeilge)
 * @return array [language_code => language_description]
 */
function getTranslationLocales( ){
	$locales = config('translation.locales');
	foreach ($locales as $key => $language) {
		$locales[$key] = _t( $language, [], $key );
	}

	return $locales;
}
?>
