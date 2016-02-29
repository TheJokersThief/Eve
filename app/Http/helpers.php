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
?>
