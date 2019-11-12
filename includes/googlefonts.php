<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 * @since 	  5.1.0
 * @lastfetch 02.04.2019
 */
 
if(!defined('ABSPATH')) exit();

/**
*** CREATED WITH SCRIPT SNIPPET AND DATA TAKEN FROM https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&fields=items(family%2Csubsets%2Cvariants%2Ccategory)&key={YOUR_API_KEY}

$list_raw = file_get_contents('https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&fields=items(family%2Csubsets%2Cvariants%2Ccategory)&key={YOUR_API_KEY}');

$list = json_decode($list_raw, true);
$list = $list['items'];

echo '<pre>';
foreach($list as $l){
	echo "'".$l['family'] ."' => array("."\n";
	echo "'variants' => array(";
	foreach($l['variants'] as $k => $v){
		if($k > 0) echo ", ";
		if($v == 'regular') $v = '400';
		echo "'".$v."'";
	}
	echo "),\n";
	echo "'subsets' => array(";
	foreach($l['subsets'] as $k => $v){
		if($k > 0) echo ", ";
		echo "'".$v."'";
	}
	echo "),\n";
	echo "'category' => '". $l['category'] ."'";
	echo "\n),\n";
}
echo '</pre>';
**/

$googlefonts = array(
'Roboto' => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Open Sans' => array(
'variants' => array('300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic', '800', '800italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Lato' => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Montserrat' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Roboto Condensed' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Source Sans Pro' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Oswald' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Raleway' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Merriweather' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Roboto Slab' => array(
'variants' => array('100', '300', '400', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'PT Sans' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Slabo 27px' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Poppins' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'devanagari', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Ubuntu' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Heebo' => array(
'variants' => array('100', '300', '400', '500', '700', '800', '900'),
'subsets' => array('hebrew', 'latin'),
'category' => 'sans-serif'
),
'Open Sans Condensed' => array(
'variants' => array('300', '300italic', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Playfair Display' => array(
'variants' => array('400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('cyrillic', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'PT Serif' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Lora' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Muli' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Titillium Web' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Nunito' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Roboto Mono' => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'monospace'
),
'PT Sans Narrow' => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Rubik' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic', '900', '900italic'),
'subsets' => array('cyrillic', 'hebrew', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Fira Sans' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Mukta' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Arimo' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'hebrew', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Serif' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Inconsolata' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'monospace'
),
'Work Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Nanum Gothic' => array(
'variants' => array('400', '700', '800'),
'subsets' => array('latin', 'korean'),
'category' => 'sans-serif'
),
'Dosis' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Quicksand' => array(
'variants' => array('300', '400', '500', '700'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans KR' => array(
'variants' => array('100', '300', '400', '500', '700', '900'),
'subsets' => array('latin', 'korean'),
'category' => 'sans-serif'
),
'Oxygen' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Hind' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Crimson Text' => array(
'variants' => array('400', 'italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Bitter' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Indie Flower' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Libre Baskerville' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Josefin Sans' => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Cabin' => array(
'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Nunito Sans' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Anton' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Arvo' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Libre Franklin' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Fjalla One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Karla' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Lobster' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Noto Sans JP' => array(
'variants' => array('100', '300', '400', '500', '700', '900'),
'subsets' => array('latin', 'japanese'),
'category' => 'sans-serif'
),
'Exo 2' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Source Code Pro' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'Pacifico' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'handwriting'
),
'Varela Round' => array(
'variants' => array('400'),
'subsets' => array('hebrew', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Abel' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Merriweather Sans' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic', '800', '800italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Dancing Script' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'handwriting'
),
'Shadows Into Light' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Source Serif Pro' => array(
'variants' => array('400', '600', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Yanone Kaffeesatz' => array(
'variants' => array('200', '300', '400', '700'),
'subsets' => array('cyrillic', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Abril Fatface' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Acme' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Asap' => array(
'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Bree Serif' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Kanit' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Questrial' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Archivo Narrow' => array(
'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Hind Siliguri' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'bengali'),
'category' => 'sans-serif'
),
'Exo' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'EB Garamond' => array(
'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Righteous' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Noto Sans TC' => array(
'variants' => array('100', '300', '400', '500', '700', '900'),
'subsets' => array('latin', 'japanese', 'chinese-traditional'),
'category' => 'sans-serif'
),
'Amatic SC' => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'hebrew', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'handwriting'
),
'Ubuntu Condensed' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Catamaran' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'tamil'),
'category' => 'sans-serif'
),
'Signika' => array(
'variants' => array('300', '400', '600', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Comfortaa' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Cairo' => array(
'variants' => array('200', '300', '400', '600', '700', '900'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Teko' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Fira Sans Condensed' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Maven Pro' => array(
'variants' => array('400', '500', '700', '900'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Play' => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Gloria Hallelujah' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Cinzel' => array(
'variants' => array('400', '700', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Overpass' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Rajdhani' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Barlow' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Francois One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Assistant' => array(
'variants' => array('200', '300', '400', '600', '700', '800'),
'subsets' => array('hebrew', 'latin'),
'category' => 'sans-serif'
),
'Crete Round' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Vollkorn' => array(
'variants' => array('400', 'italic', '600', '600italic', '700', '700italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Domine' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Permanent Marker' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Alegreya' => array(
'variants' => array('400', 'italic', '500', '500italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Satisfy' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Rokkitt' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Cuprum' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'PT Sans Caption' => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Cantarell' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'ABeeZee' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Amiri' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'News Cycle' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Hind Madurai' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'tamil'),
'category' => 'sans-serif'
),
'Courgette' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Cormorant Garamond' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Prompt' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Noticia Text' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Alegreya Sans' => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Patua One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Cardo' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Ropa Sans' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Kaushan Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Caveat' => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Fira Sans Extra Condensed' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Pathway Gothic One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Old Standard TT' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Tinos' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'hebrew', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Great Vibes' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Fredoka One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Patrick Hand' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'handwriting'
),
'Orbitron' => array(
'variants' => array('400', '500', '700', '900'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Alfa Slab One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Quattrocento Sans' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Lobster Two' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'display'
),
'Kalam' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Barlow Condensed' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Luckiest Guy' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Volkhov' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'IBM Plex Sans' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Archivo Black' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Nanum Myeongjo' => array(
'variants' => array('400', '700', '800'),
'subsets' => array('latin', 'korean'),
'category' => 'serif'
),
'Istok Web' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Russo One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Arapey' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Didact Gothic' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Quattrocento' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Passion One' => array(
'variants' => array('400', '700', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Martel' => array(
'variants' => array('200', '300', '400', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Concert One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Cookie' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Poiret One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Special Elite' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Lalezar' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Chivo' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Economica' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Merienda' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Monda' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Sacramento' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'BenchNine' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Tangerine' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Josefin Slab' => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Playball' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Noto Sans SC' => array(
'variants' => array('100', '300', '400', '500', '700', '900'),
'subsets' => array('chinese-simplified', 'cyrillic', 'latin', 'vietnamese', 'japanese'),
'category' => 'sans-serif'
),
'Pragati Narrow' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Vidaloka' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Sigmar One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Barlow Semi Condensed' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Gudea' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Viga' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Handlee' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Khand' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Zilla Slab' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Cabin Condensed' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Playfair Display SC' => array(
'variants' => array('400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('cyrillic', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Neuton' => array(
'variants' => array('200', '300', '400', 'italic', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'VT323' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'monospace'
),
'Armata' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Monoton' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Hind Guntur' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('telugu', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Frank Ruhl Libre' => array(
'variants' => array('300', '400', '500', '700', '900'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Signika Negative' => array(
'variants' => array('300', '400', '600', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Gochi Hand' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Pontano Sans' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Paytone One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Philosopher' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese'),
'category' => 'sans-serif'
),
'IBM Plex Serif' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Yrsa' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Marck Script' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Bangers' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Montserrat Alternates' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Hind Vadodara' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Caveat Brush' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Sawarabi Mincho' => array(
'variants' => array('400'),
'subsets' => array('latin', 'japanese', 'latin-ext'),
'category' => 'sans-serif'
),
'M PLUS 1p' => array(
'variants' => array('100', '300', '400', '500', '700', '800', '900'),
'subsets' => array('cyrillic', 'hebrew', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'japanese', 'latin-ext'),
'category' => 'sans-serif'
),
'Hammersmith One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Neucha' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin'),
'category' => 'handwriting'
),
'Khula' => array(
'variants' => array('300', '400', '600', '700', '800'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Architects Daughter' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Sanchez' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Prata' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese'),
'category' => 'serif'
),
'Audiowide' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Gothic A1' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'korean'),
'category' => 'sans-serif'
),
'Gentium Basic' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Ultra' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Yantramanav' => array(
'variants' => array('100', '300', '400', '500', '700', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Ruda' => array(
'variants' => array('400', '700', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Advent Pro' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('greek', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Boogaloo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Tajawal' => array(
'variants' => array('200', '300', '400', '500', '700', '800', '900'),
'subsets' => array('arabic', 'latin'),
'category' => 'sans-serif'
),
'Parisienne' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'PT Mono' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'monospace'
),
'Unica One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Alice' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin'),
'category' => 'serif'
),
'Changa' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Sorts Mill Goudy' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Varela' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Glegoo' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Bad Script' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin'),
'category' => 'handwriting'
),
'Kreon' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Amaranth' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Shadows Into Light Two' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Allerta Stencil' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Yellowtail' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Enriqueta' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Homemade Apple' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Molengo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Gentium Book Basic' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Adamina' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Sintony' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Antic Slab' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Actor' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Press Start 2P' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext'),
'category' => 'display'
),
'Ubuntu Mono' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'monospace'
),
'Covered By Your Grace' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Rock Salt' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Julius Sans One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Pridi' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Taviraj' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'El Messiri' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('cyrillic', 'arabic', 'latin'),
'category' => 'sans-serif'
),
'Chewy' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Carter One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Cormorant' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Cousine' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'hebrew', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'monospace'
),
'Allura' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Noto Serif JP' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '900'),
'subsets' => array('latin', 'japanese'),
'category' => 'serif'
),
'Jura' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Sarala' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Fugaz One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Cantata One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Damion' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Lusitana' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Scada' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Arbutus Slab' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Nothing You Could Do' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Rambla' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Lustria' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Karma' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Alegreya Sans SC' => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Oleo Script' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Archivo' => array(
'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'PT Serif Caption' => array(
'variants' => array('400', 'italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Bevan' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Knewave' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Reenie Beanie' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Mr Dafoe' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Marcellus' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Rancho' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Palanquin' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Saira' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Prosto One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Encode Sans Condensed' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Spinnaker' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Alex Brush' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Fredericka the Great' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Nanum Gothic Coding' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'korean'),
'category' => 'monospace'
),
'Marmelad' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Nanum Pen Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'korean'),
'category' => 'handwriting'
),
'Nobile' => array(
'variants' => array('400', 'italic', '500', '500italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Unna' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Michroma' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Baloo' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Basic' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Average' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Scheherazade' => array(
'variants' => array('400', '700'),
'subsets' => array('arabic', 'latin'),
'category' => 'serif'
),
'Saira Semi Condensed' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Bowlby One SC' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Allerta' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Overlock' => array(
'variants' => array('400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Sawarabi Gothic' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'vietnamese', 'japanese', 'latin-ext'),
'category' => 'sans-serif'
),
'Coda Caption' => array(
'variants' => array('800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Italianno' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Black Ops One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Do Hyeon' => array(
'variants' => array('400'),
'subsets' => array('latin', 'korean'),
'category' => 'sans-serif'
),
'Kameron' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Coda' => array(
'variants' => array('400', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Niconne' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Rasa' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Pinyon Script' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Saira Extra Condensed' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Electrolize' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Just Another Hand' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Antic' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Biryani' => array(
'variants' => array('200', '300', '400', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Coming Soon' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Pangolin' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'handwriting'
),
'Syncopate' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Mitr' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Abhaya Libre' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('sinhala', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Alef' => array(
'variants' => array('400', '700'),
'subsets' => array('hebrew', 'latin'),
'category' => 'sans-serif'
),
'Spectral' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
'subsets' => array('cyrillic', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Quantico' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Leckerli One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Space Mono' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'monospace'
),
'Forum' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'display'
),
'Grand Hotel' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Radley' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Love Ya Like A Sister' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Tenor Sans' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Belleza' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Cabin Sketch' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Hanuman' => array(
'variants' => array('400', '700'),
'subsets' => array('khmer'),
'category' => 'serif'
),
'Fauna One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Days One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Candal' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Oranienbaum' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Aldrich' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Reem Kufi' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin'),
'category' => 'sans-serif'
),
'Telex' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Itim' => array(
'variants' => array('400'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'handwriting'
),
'Copse' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Cinzel Decorative' => array(
'variants' => array('400', '700', '900'),
'subsets' => array('latin'),
'category' => 'display'
),
'Berkshire Swash' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Magra' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Gruppo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Share' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Fira Mono' => array(
'variants' => array('400', '500', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'monospace'
),
'Share Tech Mono' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'monospace'
),
'Titan One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Rochester' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Shojumaru' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Squada One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Rufina' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Saira Condensed' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Miriam Libre' => array(
'variants' => array('400', '700'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Lilita One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Lateef' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin'),
'category' => 'handwriting'
),
'Arsenal' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Yesteryear' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Jaldi' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Marcellus SC' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Norican' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Carrois Gothic' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Asap Condensed' => array(
'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Jockey One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Marvel' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'M PLUS Rounded 1c' => array(
'variants' => array('100', '300', '400', '500', '700', '800', '900'),
'subsets' => array('cyrillic', 'hebrew', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'japanese', 'latin-ext'),
'category' => 'sans-serif'
),
'Encode Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Anonymous Pro' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'greek', 'latin', 'latin-ext'),
'category' => 'monospace'
),
'Nanum Brush Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'korean'),
'category' => 'handwriting'
),
'Nixie One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Carme' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Staatliches' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'IBM Plex Mono' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'monospace'
),
'Petit Formal Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Cutive Mono' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'Slabo 13px' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Sniglet' => array(
'variants' => array('400', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Changa One' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'display'
),
'Shrikhand' => array(
'variants' => array('400'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'display'
),
'Coustard' => array(
'variants' => array('400', '900'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Annie Use Your Telescope' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Halant' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Delius' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Aclonica' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Martel Sans' => array(
'variants' => array('200', '300', '400', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Racing Sans One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Alegreya SC' => array(
'variants' => array('400', 'italic', '500', '500italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Buenard' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Lekton' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Ceviche One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Caudex' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Rosario' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Tauri' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Ovo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Bungee' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Metrophobic' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Voltaire' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Londrina Solid' => array(
'variants' => array('100', '300', '400', '900'),
'subsets' => array('latin'),
'category' => 'display'
),
'Calligraffitti' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Balthazar' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Yeseva One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Bungee Inline' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Spicy Rice' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Freckle Face' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Cambo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Markazi Text' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('arabic', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Goudy Bookletter 1911' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Graduate' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Gilda Display' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Judson' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Kelly Slab' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Limelight' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Contrail One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Amethysta' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Gabriela' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin'),
'category' => 'serif'
),
'GFS Didot' => array(
'variants' => array('400'),
'subsets' => array('greek'),
'category' => 'serif'
),
'Six Caps' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Pattaya' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Aladin' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Bubblegum Sans' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Herr Von Muellerhoff' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Capriola' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Puritan' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Doppio One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Mada' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '900'),
'subsets' => array('arabic', 'latin'),
'category' => 'sans-serif'
),
'Cutive' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Inder' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Mukta Malar' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'tamil'),
'category' => 'sans-serif'
),
'Homenaje' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Average Sans' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Pompiere' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Arima Madurai' => array(
'variants' => array('100', '200', '300', '400', '500', '700', '800', '900'),
'subsets' => array('latin', 'vietnamese', 'latin-ext', 'tamil'),
'category' => 'display'
),
'Hanalei Fill' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Duru Sans' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Raleway Dots' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Oxygen Mono' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'Trocchi' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Laila' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Amiko' => array(
'variants' => array('400', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Eczar' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Mr De Haviland' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Arizonia' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Sriracha' => array(
'variants' => array('400'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'handwriting'
),
'Skranji' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Schoolbell' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Allan' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Give You Glory' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Suranna' => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin'),
'category' => 'serif'
),
'Merienda One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Wendy One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Trirong' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Noto Serif SC' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '900'),
'subsets' => array('chinese-simplified', 'cyrillic', 'latin', 'vietnamese', 'japanese'),
'category' => 'serif'
),
'Lemonada' => array(
'variants' => array('300', '400', '600', '700'),
'subsets' => array('arabic', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Chelsea Market' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Baloo Bhaina' => array(
'variants' => array('400'),
'subsets' => array('latin', 'oriya', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Sunflower' => array(
'variants' => array('300', '500', '700'),
'subsets' => array('latin', 'korean'),
'category' => 'sans-serif'
),
'Sue Ellen Francisco' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Kristi' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Short Stack' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Happy Monkey' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Mate' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Noto Serif TC' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '900'),
'subsets' => array('cyrillic', 'latin', 'vietnamese', 'japanese', 'chinese-traditional'),
'category' => 'serif'
),
'Secular One' => array(
'variants' => array('400'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Maitree' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Rye' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Montez' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Sarabun' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Mukta Vaani' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Poly' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Gravitas One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Palanquin Dark' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Artifika' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Bowlby One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Averia Serif Libre' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'display'
),
'Dawning of a New Day' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Andada' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Noto Serif KR' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '900'),
'subsets' => array('latin', 'korean'),
'category' => 'serif'
),
'Emilys Candy' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Faster One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Bentham' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Kosugi Maru' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'japanese'),
'category' => 'sans-serif'
),
'Cedarville Cursive' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Alike' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'IM Fell Double Pica' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Lemon' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Qwigley' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'IM Fell English' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Federo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Convergence' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Megrim' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Andika' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Faustina' => array(
'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Mouse Memoirs' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Corben' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Cambay' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Fanwood Text' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Athiti' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Black Han Sans' => array(
'variants' => array('400'),
'subsets' => array('latin', 'korean'),
'category' => 'sans-serif'
),
'Baloo Chettan' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext', 'malayalam'),
'category' => 'display'
),
'Bai Jamjuree' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Suez One' => array(
'variants' => array('400'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Gurajada' => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin'),
'category' => 'serif'
),
'Cormorant Infant' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'La Belle Aurore' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Carrois Gothic SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Crafty Girls' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Oregano' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Overpass Mono' => array(
'variants' => array('300', '400', '600', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'Kurale' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'devanagari', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Seaweed Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Patrick Hand SC' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'handwriting'
),
'Vesper Libre' => array(
'variants' => array('400', '500', '700', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Rozha One' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'UnifrakturMaguntia' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Anaheim' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'IM Fell DW Pica' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Bilbo Swash Caps' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Baloo Bhaijaan' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Lily Script One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Brawler' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Quando' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'The Girl Next Door' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Baumans' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Wallpoet' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Clicker Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Proza Libre' => array(
'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Niramit' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Meddon' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Podkova' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Expletus Sans' => array(
'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'display'
),
'Loved by the King' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Rammetto One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Strait' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Fondamento' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Vibur' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Kadwa' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin'),
'category' => 'serif'
),
'Mako' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Euphoria Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'McLaren' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Encode Sans Semi Expanded' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Walter Turncoat' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Stardos Stencil' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Salsa' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Averia Libre' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'display'
),
'Wire One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Delius Swash Caps' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Waiting for the Sunrise' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Zeyada' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Mirza' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Orienta' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Mallanna' => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin'),
'category' => 'sans-serif'
),
'Krona One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Gafata' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Vast Shadow' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Unkempt' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Cormorant SC' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Shanti' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Rouge Script' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Belgrano' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Fjord One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Tulpen One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Just Me Again Down Here' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Harmattan' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin'),
'category' => 'sans-serif'
),
'IBM Plex Sans Condensed' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Denk One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Quintessential' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Oleo Script Swash Caps' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Voces' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Iceland' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Londrina Outline' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Sofia' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Aguafina Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Encode Sans Expanded' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Cherry Swash' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Bungee Shade' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Cantora One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Imprima' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Galada' => array(
'variants' => array('400'),
'subsets' => array('latin', 'bengali'),
'category' => 'display'
),
'Amita' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Timmana' => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin'),
'category' => 'sans-serif'
),
'Mrs Saint Delafield' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Nova Mono' => array(
'variants' => array('400'),
'subsets' => array('greek', 'latin'),
'category' => 'monospace'
),
'K2D' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Prociono' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Crushed' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Chonburi' => array(
'variants' => array('400'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Medula One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Battambang' => array(
'variants' => array('400', '700'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Scope One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Over the Rainbow' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'IM Fell English SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'David Libre' => array(
'variants' => array('400', '500', '700'),
'subsets' => array('hebrew', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Ramabhadra' => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin'),
'category' => 'sans-serif'
),
'Bellefair' => array(
'variants' => array('400'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Vampiro One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Ledger' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Rationale' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Sansita' => array(
'variants' => array('400', 'italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Metamorphous' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Fontdiner Swanky' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Headland One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Germania One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Finger Paint' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Uncial Antiqua' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Eater' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Rubik Mono One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Habibi' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Sarpanch' => array(
'variants' => array('400', '500', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Share Tech' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Port Lligat Sans' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Nova Round' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Tienne' => array(
'variants' => array('400', '700', '900'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Italiana' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Atma' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'bengali'),
'category' => 'display'
),
'Baloo Paaji' => array(
'variants' => array('400'),
'subsets' => array('gurmukhi', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Sree Krushnadevaraya' => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin'),
'category' => 'serif'
),
'Sumana' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Holtwood One SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Geo' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Life Savers' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Codystar' => array(
'variants' => array('300', '400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Aref Ruqaa' => array(
'variants' => array('400', '700'),
'subsets' => array('arabic', 'latin'),
'category' => 'serif'
),
'Averia Sans Libre' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'display'
),
'Katibeh' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Nova Square' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Mogra' => array(
'variants' => array('400'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'display'
),
'Jua' => array(
'variants' => array('400'),
'subsets' => array('latin', 'korean'),
'category' => 'sans-serif'
),
'Creepster' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Port Lligat Slab' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Spirax' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Milonga' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Koulen' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Dekko' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Sedgwick Ave' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'handwriting'
),
'Fascinate Inline' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Bilbo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Rakkas' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Dynalight' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Ranchers' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Fenix' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Bubbler One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Frijole' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Kranky' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Amarante' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Poller One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'BioRhyme' => array(
'variants' => array('200', '300', '400', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Mali' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'handwriting'
),
'Spectral SC' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
'subsets' => array('cyrillic', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Charm' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'handwriting'
),
'Mandali' => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin'),
'category' => 'sans-serif'
),
'Mountains of Christmas' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'NTR' => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin'),
'category' => 'sans-serif'
),
'Cherry Cream Soda' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Ruslan Display' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Montserrat Subrayada' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Coiny' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext', 'tamil'),
'category' => 'display'
),
'Chicle' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Kotta One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Slackey' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Condiment' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Mate SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Engagement' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Alike Angular' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Englebert' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Elsie' => array(
'variants' => array('400', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Krub' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Aleo' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Kite One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Encode Sans Semi Condensed' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Princess Sofia' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Esteban' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Stint Ultra Expanded' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Nova Slim' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Sail' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Simonetta' => array(
'variants' => array('400', 'italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Numans' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Antic Didone' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Baloo Bhai' => array(
'variants' => array('400'),
'subsets' => array('gujarati', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Baloo Thambi' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext', 'tamil'),
'category' => 'display'
),
'Chau Philomene One' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Nosifer' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Kosugi' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'japanese'),
'category' => 'sans-serif'
),
'Stalemate' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Averia Gruesa Libre' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Sarina' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'League Script' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Paprika' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Dorsa' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Almendra' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Meera Inimai' => array(
'variants' => array('400'),
'subsets' => array('latin', 'tamil'),
'category' => 'sans-serif'
),
'Rosarivo' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Bokor' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Baloo Tamma' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext', 'kannada'),
'category' => 'display'
),
'Ramaraja' => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin'),
'category' => 'serif'
),
'Peralta' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Fresca' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Arya' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Nova Flat' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Farsan' => array(
'variants' => array('400'),
'subsets' => array('gujarati', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Cagliostro' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Asul' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Moul' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Cormorant Upright' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Junge' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Stint Ultra Condensed' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Manuale' => array(
'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Mukta Mahee' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('gurmukhi', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Pirata One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Stoke' => array(
'variants' => array('300', '400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Taprom' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Iceberg' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Linden Hill' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Joti One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'ZCOOL XiaoWei' => array(
'variants' => array('400'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'serif'
),
'Lovers Quarrel' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Ruluko' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Donegal One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Delius Unicase' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Trade Winds' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Khmer' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Mystery Quest' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Pavanam' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'tamil'),
'category' => 'sans-serif'
),
'Sancreek' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Padauk' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'myanmar'),
'category' => 'sans-serif'
),
'Flamenco' => array(
'variants' => array('300', '400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Jim Nightshade' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Ribeye' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Overlock SC' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Yatra One' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'display'
),
'Mrs Sheppards' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Galindo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Angkor' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Inknut Antiqua' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'IM Fell French Canon' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Wellfleet' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Miniver' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Chakra Petch' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Kavoon' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Gugi' => array(
'variants' => array('400'),
'subsets' => array('latin', 'korean'),
'category' => 'display'
),
'Buda' => array(
'variants' => array('300'),
'subsets' => array('latin'),
'category' => 'display'
),
'Maiden Orange' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Chela One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Swanky and Moo Moo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'IM Fell DW Pica SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Redressed' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Sura' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'IM Fell Great Primer' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Text Me One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Gaegu' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin', 'korean'),
'category' => 'handwriting'
),
'Croissant One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Petrona' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Sonsie One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Offside' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Julee' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Margarine' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Eagle Lake' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Flavors' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Glass Antiqua' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Rhodium Libre' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Autour One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Plaster' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Diplomata SC' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Poor Story' => array(
'variants' => array('400'),
'subsets' => array('latin', 'korean'),
'category' => 'display'
),
'Smythe' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Revalia' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'UnifrakturCook' => array(
'variants' => array('700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Kumar One' => array(
'variants' => array('400'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'display'
),
'Nokora' => array(
'variants' => array('400', '700'),
'subsets' => array('khmer'),
'category' => 'serif'
),
'Mina' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'bengali'),
'category' => 'sans-serif'
),
'Monsieur La Doulaise' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'MedievalSharp' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Henny Penny' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Inika' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Barrio' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Marko One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Della Respira' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Elsie Swash Caps' => array(
'variants' => array('400', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Montaga' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Song Myung' => array(
'variants' => array('400'),
'subsets' => array('latin', 'korean'),
'category' => 'serif'
),
'Galdeano' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Thasadith' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Griffy' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Akronim' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Miltonian Tattoo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Purple Purse' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Cormorant Unicase' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Irish Grover' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Tillana' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Chathura' => array(
'variants' => array('100', '300', '400', '700', '800'),
'subsets' => array('telugu', 'latin'),
'category' => 'sans-serif'
),
'Monofett' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Libre Barcode 39' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Trykker' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Dokdo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'korean'),
'category' => 'handwriting'
),
'New Rocker' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Chango' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Modern Antiqua' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Siemreap' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Smokum' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Ruthie' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Astloch' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Underdog' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Rum Raisin' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Asar' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Ranga' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'display'
),
'Bahiana' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'IM Fell Great Primer SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Felipa' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Oldenburg' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Ravi Prakash' => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin'),
'category' => 'display'
),
'Asset' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Bigshot One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'IM Fell French Canon SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Content' => array(
'variants' => array('400', '700'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Snippet' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Ruge Boogie' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Baloo Tammudu' => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Caesar Dressing' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Dr Sugiyama' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'ZCOOL QingKe HuangYou' => array(
'variants' => array('400'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'display'
),
'Sahitya' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin'),
'category' => 'serif'
),
'Lancelot' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Molle' => array(
'variants' => array('italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Devonshire' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Snowburst One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Diplomata' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Original Surfer' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Metal Mania' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Zilla Slab Highlight' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Sirin Stencil' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Jacques Francois Shadow' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Ewert' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Meie Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Arbutus' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Charmonman' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'handwriting'
),
'Kavivanar' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'tamil'),
'category' => 'handwriting'
),
'Jolly Lodger' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Miss Fajardose' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Keania One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Sunshiney' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Atomic Age' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Ribeye Marrow' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Odor Mean Chey' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Goblin One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Lakki Reddy' => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin'),
'category' => 'handwriting'
),
'Suwannaphum' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'IM Fell Double Pica SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Major Mono Display' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'monospace'
),
'Baloo Da' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext', 'bengali'),
'category' => 'display'
),
'Dangrek' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Kirang Haerang' => array(
'variants' => array('400'),
'subsets' => array('latin', 'korean'),
'category' => 'display'
),
'Macondo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Kdam Thmor' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Freehand' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Almendra SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'KoHo' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Almendra Display' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Piedra' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Seymour One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Jacques Francois' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Kenia' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'GFS Neohellenic' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('greek'),
'category' => 'sans-serif'
),
'Jomhuria' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Modak' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'display'
),
'Londrina Shadow' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Nova Script' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Kantumruy' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('khmer'),
'category' => 'sans-serif'
),
'Trochut' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Bayon' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Bungee Outline' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Srisakdi' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Fahkwang' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Metal' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Romanesco' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'East Sea Dokdo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'korean'),
'category' => 'handwriting'
),
'Vollkorn SC' => array(
'variants' => array('400', '600', '700', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese', 'latin-ext'),
'category' => 'serif'
),
'Libre Barcode 128' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Libre Barcode 39 Extended Text' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Libre Barcode 39 Text' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Passero One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Miltonian' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Risque' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Combo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Geostar Fill' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Kodchasan' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'thai', 'vietnamese', 'latin-ext'),
'category' => 'sans-serif'
),
'Butterfly Kids' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Nova Cut' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Erica One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Nova Oval' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Libre Barcode 39 Extended' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Unlock' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Gorditas' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Sedgwick Ave Display' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'handwriting'
),
'Preahvihear' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Bungee Hairline' => array(
'variants' => array('400'),
'subsets' => array('latin', 'vietnamese', 'latin-ext'),
'category' => 'display'
),
'Bigelow Rules' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Fascinate' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Fruktur' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Supermercado One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Aubrey' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Tenali Ramakrishna' => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin'),
'category' => 'sans-serif'
),
'Sofadi One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Londrina Sketch' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Macondo Swash Caps' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Bonbon' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Mr Bedfort' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Geostar' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Butcherman' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Emblema One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Sevillana' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Gamja Flower' => array(
'variants' => array('400'),
'subsets' => array('latin', 'korean'),
'category' => 'handwriting'
),
'B612' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Gidugu' => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin'),
'category' => 'sans-serif'
),
'Federant' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Stalinist One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Peddana' => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin'),
'category' => 'serif'
),
'Chenla' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Suravaram' => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin'),
'category' => 'serif'
),
'Fasthand' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'serif'
),
'ZCOOL KuaiLe' => array(
'variants' => array('400'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'display'
),
'Black And White Picture' => array(
'variants' => array('400'),
'subsets' => array('latin', 'korean'),
'category' => 'sans-serif'
),
'Stylish' => array(
'variants' => array('400'),
'subsets' => array('latin', 'korean'),
'category' => 'sans-serif'
),
'Kumar One Outline' => array(
'variants' => array('400'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'display'
),
'Hanalei' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Dhurjati' => array(
'variants' => array('400'),
'subsets' => array('telugu', 'latin'),
'category' => 'sans-serif'
),
'Libre Barcode 128 Text' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Cute Font' => array(
'variants' => array('400'),
'subsets' => array('latin', 'korean'),
'category' => 'display'
),
'Moulpali' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'B612 Mono' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'monospace'
),
'BioRhyme Expanded' => array(
'variants' => array('200', '300', '400', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Yeon Sung' => array(
'variants' => array('400'),
'subsets' => array('latin', 'korean'),
'category' => 'display'
),
'Hi Melody' => array(
'variants' => array('400'),
'subsets' => array('latin', 'korean'),
'category' => 'handwriting'
),
'Warnes' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Notable' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
)
);

?>