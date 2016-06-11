<?php


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

/**
 * Takes the Google API URL and your secret key and returns the
 * URL with the signature attached
 * @param  URL-String $URL           		The string containing the request you wish
 *                                    		to make. This needs to include the
 *                                     		'googleapis.com/' section of the URL and
 *                                      	ideally, for simplicity, would be the fully
 *                                      	formed URL (i.e. from https:// onwards)
 * @param  URLSafe-String $signingSecret 	The secret key for your app provided by
 *                                        	Google. You can get this from the Dev Console
 * @return URL-String                		The full URL string with the URL Safe
 *                                         	signature attached
 */
function signMapsRequest( $URL, $signingSecret ){
	$needle = "googleapis.com/";
	$needleOffset = strlen($needle);
	$pos = strpos($URL, $needle);
	if( $pos === false ){
		return "";
	}
	$urlArray = array("-","_");
	$b64Array = array("+","/");
	$pathAndQuery = substr($URL, $pos+$needleOffset-1);

	$base64Secret = str_replace($urlArray, $b64Array, $signingSecret);

	$signature = hash_hmac("sha1", $pathAndQuery, $base64Secret);
	$urlSafeSignature = str_replace($b64Array, $urlArray, $signature);

	return $URL . "&signature=" . $urlSafeSignature;
}
?>
