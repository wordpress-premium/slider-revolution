<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2024 ThemePunch
 * @lastfetch 12.03.2024
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
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Open Sans' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'hebrew', 'latin', 'latin-ext', 'math', 'symbols', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Sans JP' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Montserrat' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Lato' => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Poppins' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Inter' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Roboto Condensed' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Material Icons' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'monospace'
),
'Roboto Mono' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Oswald' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'devanagari', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Raleway' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Nunito Sans' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Ubuntu' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Merriweather' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Nunito' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Playfair Display' => array(
'variants' => array('400', '500', '600', '700', '800', '900', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Rubik' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '900', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('arabic', 'cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Roboto Slab' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Noto Sans KR' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'korean', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'PT Sans' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans TC' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('chinese-traditional', 'cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Work Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Kanit' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Lora' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'math', 'symbols', 'vietnamese'),
'category' => 'serif'
),
'Fira Sans' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'DM Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Mulish' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Barlow' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'IBM Plex Sans' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Inconsolata' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Quicksand' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Titillium Web' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Manrope' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'PT Serif' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Heebo' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('hebrew', 'latin', 'latin-ext', 'math', 'symbols'),
'category' => 'sans-serif'
),
'Noto Serif' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Karla' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Nanum Gothic' => array(
'variants' => array('400', '700', '800'),
'subsets' => array('korean', 'latin'),
'category' => 'sans-serif'
),
'Libre Franklin' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Material Icons Outlined' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'monospace'
),
'Noto Sans SC' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('chinese-simplified', 'cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Material Symbols Outlined' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('latin'),
'category' => 'monospace'
),
'Source Code Pro' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Josefin Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Mukta' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Color Emoji' => array(
'variants' => array('400'),
'subsets' => array('emoji'),
'category' => 'sans-serif'
),
'Arimo' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'hebrew', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Dosis' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Libre Baskerville' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Material Symbols Rounded' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('latin'),
'category' => 'monospace'
),
'Hind Siliguri' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('bengali', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Bebas Neue' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Bitter' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'EB Garamond' => array(
'variants' => array('400', '500', '600', '700', '800', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'PT Sans Narrow' => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Cabin' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Cairo' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Dancing Script' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Archivo' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Oxygen' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Space Grotesk' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Anton' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Jost' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Overpass' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Sans HK' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('chinese-hongkong', 'cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Teko' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Barlow Condensed' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Serif JP' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '900'),
'subsets' => array('japanese', 'latin'),
'category' => 'serif'
),
'Outfit' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Hind' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Exo 2' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Material Icons Round' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'monospace'
),
'Pacifico' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Abel' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Comfortaa' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Assistant' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Prompt' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Lobster' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Public Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Signika Negative' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Source Sans 3' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Fjalla One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Sans Arabic' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('arabic'),
'category' => 'sans-serif'
),
'Figtree' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '900', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'M PLUS Rounded 1c' => array(
'variants' => array('100', '300', '400', '500', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'hebrew', 'japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Crimson Text' => array(
'variants' => array('400', 'italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'IBM Plex Mono' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Rajdhani' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Caveat' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Varela Round' => array(
'variants' => array('400'),
'subsets' => array('hebrew', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Red Hat Display' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '900', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Material Icons Sharp' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'monospace'
),
'Zilla Slab' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Arvo' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Cormorant Garamond' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Maven Pro' => array(
'variants' => array('400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Slabo 27px' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Play' => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Shadows Into Light' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Abril Fatface' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Asap' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Lexend' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Barlow Semi Condensed' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Fira Sans Condensed' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'IBM Plex Sans Arabic' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('arabic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Plus Jakarta Sans' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'IBM Plex Serif' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Tajawal' => array(
'variants' => array('200', '300', '400', '500', '700', '800', '900'),
'subsets' => array('arabic', 'latin'),
'category' => 'sans-serif'
),
'Chakra Petch' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Material Icons Two Tone' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'monospace'
),
'Satisfy' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Merriweather Sans' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'DM Serif Display' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Nanum Myeongjo' => array(
'variants' => array('400', '700', '800'),
'subsets' => array('korean', 'latin'),
'category' => 'serif'
),
'Lilita One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Permanent Marker' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Indie Flower' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Archivo Black' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Domine' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Questrial' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Nanum Gothic Coding' => array(
'variants' => array('400', '700'),
'subsets' => array('korean', 'latin'),
'category' => 'handwriting'
),
'Source Serif 4' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Catamaran' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'tamil'),
'category' => 'sans-serif'
),
'Almarai' => array(
'variants' => array('300', '400', '700', '800'),
'subsets' => array('arabic'),
'category' => 'sans-serif'
),
'Sora' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'M PLUS 1p' => array(
'variants' => array('100', '300', '400', '500', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'hebrew', 'japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Signika' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Yanone Kaffeesatz' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'math', 'symbols', 'vietnamese'),
'category' => 'sans-serif'
),
'Hind Madurai' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'tamil'),
'category' => 'sans-serif'
),
'Rowdies' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Urbanist' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Orbitron' => array(
'variants' => array('400', '500', '600', '700', '800', '900'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Archivo Narrow' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Acme' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Bree Serif' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Roboto Flex' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Sarabun' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Vollkorn' => array(
'variants' => array('400', '500', '600', '700', '800', '900', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Cinzel' => array(
'variants' => array('400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Didact Gothic' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Montserrat Alternates' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Exo' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Alfa Slab One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Russo One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Crimson Pro' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Kalam' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Chivo' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Frank Ruhl Libre' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Marcellus' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Amatic SC' => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'hebrew', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Zeyada' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Alegreya' => array(
'variants' => array('400', '500', '600', '700', '800', '900', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Tinos' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'hebrew', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Noto Kufi Arabic' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('arabic', 'latin', 'latin-ext', 'math', 'symbols'),
'category' => 'sans-serif'
),
'ABeeZee' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noticia Text' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Alegreya Sans' => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Spectral' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Cormorant' => array(
'variants' => array('300', '400', '500', '600', '700', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Asap Condensed' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Amiri' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Saira Condensed' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Philosopher' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese'),
'category' => 'sans-serif'
),
'Passion One' => array(
'variants' => array('400', '700', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Great Vibes' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Martel' => array(
'variants' => array('200', '300', '400', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Noto Serif KR' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '900'),
'subsets' => array('korean', 'latin'),
'category' => 'serif'
),
'Prata' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'vietnamese'),
'category' => 'serif'
),
'Encode Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'PT Sans Caption' => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Lexend Deca' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Concert One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Courgette' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Changa' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Cantarell' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Lobster Two' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'display'
),
'Noto Sans Display' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Patua One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Righteous' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Ubuntu Condensed' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Cardo' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Be Vietnam Pro' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Sans Thai' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'thai'),
'category' => 'sans-serif'
),
'Noto Serif TC' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '900'),
'subsets' => array('chinese-traditional', 'latin'),
'category' => 'serif'
),
'Neuton' => array(
'variants' => array('200', '300', '400', 'italic', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Titan One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Sawarabi Mincho' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'IBM Plex Sans Condensed' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Readex Pro' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Yellowtail' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Old Standard TT' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Paytone One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Oleo Script' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Crete Round' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Mate' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Space Mono' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Sacramento' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Yantramanav' => array(
'variants' => array('100', '300', '400', '500', '700', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Kaushan Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Francois One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Alata' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Unbounded' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Bodoni Moda' => array(
'variants' => array('400', '500', '600', '700', '800', '900', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Saira' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Gloria Hallelujah' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'DM Serif Text' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Gruppo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Inter Tight' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Luckiest Guy' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Gothic A1' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('korean', 'latin'),
'category' => 'sans-serif'
),
'Merienda' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Quattrocento' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Khand' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Architects Daughter' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Arsenal' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Alice' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Fraunces' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Eczar' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('devanagari', 'greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Ubuntu Mono' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'monospace'
),
'Sawarabi Gothic' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Alegreya Sans SC' => array(
'variants' => array('100', '100italic', '300', '300italic', '400', 'italic', '500', '500italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Pathway Gothic One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Antic Slab' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Macondo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Cuprum' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Josefin Slab' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Noto Sans Mono' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'League Spartan' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Quattrocento Sans' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Advent Pro' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'El Messiri' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('arabic', 'cyrillic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Zen Kaku Gothic New' => array(
'variants' => array('300', '400', '500', '700', '900'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Commissioner' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Cookie' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Rokkitt' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Roboto Serif' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Unna' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Gelasio' => array(
'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Noto Sans Bengali' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('bengali', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Black Ops One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Staatliches' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Mate SC' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Handlee' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Noto Naskh Arabic' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Tangerine' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Literata' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Special Elite' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Baloo 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('devanagari', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Silkscreen' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Allura' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Encode Sans Condensed' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Creepster' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Poiret One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Sanchez' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'News Cycle' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Fira Sans Extra Condensed' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Patrick Hand' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Sen' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Tenor Sans' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Amaranth' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Taviraj' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'serif'
),
'Courier Prime' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'Playfair Display SC' => array(
'variants' => array('400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Yeseva One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Abhaya Libre' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'sinhala'),
'category' => 'serif'
),
'Mitr' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Libre Barcode 39' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Kosugi Maru' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'PT Mono' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'monospace'
),
'Rubik Bubbles' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Aleo' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Bungee' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Red Hat Text' => array(
'variants' => array('300', '400', '500', '600', '700', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Rubik Mono One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Libre Caslon Text' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Bangers' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Carter One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'JetBrains Mono' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Fugaz One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'DM Mono' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'STIX Two Text' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Comic Neue' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Noto Sans Devanagari' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Albert Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Gudea' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Baskervville' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Antonio' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Vidaloka' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Cousine' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'hebrew', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Homemade Apple' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Ultra' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Parisienne' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Zen Maru Gothic' => array(
'variants' => array('300', '400', '500', '700', '900'),
'subsets' => array('cyrillic', 'greek', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Faustina' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Saira Semi Condensed' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Petrona' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Yatra One' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'display'
),
'Sofia' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Epilogue' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Adamina' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Blinker' => array(
'variants' => array('100', '200', '300', '400', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Hind Vadodara' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Alex Brush' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Unica One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Viga' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Mukta Malar' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'tamil'),
'category' => 'sans-serif'
),
'Secular One' => array(
'variants' => array('400'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Bad Script' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin'),
'category' => 'handwriting'
),
'Voltaire' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Volkhov' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Ropa Sans' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Audiowide' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Mr Dafoe' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Lalezar' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Noto Serif SC' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '900'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'serif'
),
'Sriracha' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'handwriting'
),
'Jaldi' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Varela' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Nanum Pen Script' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'handwriting'
),
'Pangolin' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Press Start 2P' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext'),
'category' => 'display'
),
'Marck Script' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Neucha' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin'),
'category' => 'handwriting'
),
'Syne' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('greek', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Istok Web' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Hammersmith One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Forum' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'display'
),
'Fira Mono' => array(
'variants' => array('400', '500', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'monospace'
),
'Shippori Mincho' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Pridi' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'serif'
),
'Mada' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Cabin Condensed' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Khula' => array(
'variants' => array('300', '400', '600', '700', '800'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Krub' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Monoton' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Monda' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Fredoka' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Kumbh Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'math', 'symbols'),
'category' => 'sans-serif'
),
'Lusitana' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Reenie Beanie' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Playball' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Sorts Mill Goudy' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Rock Salt' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Bai Jamjuree' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Castoro' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Ruda' => array(
'variants' => array('400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Atkinson Hyperlegible' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Pragati Narrow' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Itim' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'handwriting'
),
'Julius Sans One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Six Caps' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Actor' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Anonymous Pro' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'greek', 'latin', 'latin-ext'),
'category' => 'monospace'
),
'Share Tech Mono' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'monospace'
),
'Koulen' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Nothing You Could Do' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'League Gothic' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Cutive Mono' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'Jura' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'kayah-li', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Gochi Hand' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'BenchNine' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Material Symbols Sharp' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('latin'),
'category' => 'monospace'
),
'Short Stack' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Gilda Display' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Martel Sans' => array(
'variants' => array('200', '300', '400', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Andika' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Mandali' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'sans-serif'
),
'Pontano Sans' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Sarala' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Alef' => array(
'variants' => array('400', '700'),
'subsets' => array('hebrew', 'latin'),
'category' => 'sans-serif'
),
'Londrina Solid' => array(
'variants' => array('100', '300', '400', '900'),
'subsets' => array('latin'),
'category' => 'display'
),
'Quantico' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Fira Code' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'monospace'
),
'Sansita' => array(
'variants' => array('400', 'italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Serif Bengali' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('bengali', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Niramit' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Damion' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Reem Kufi' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Pinyon Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Armata' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Electrolize' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Alexandria' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('arabic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Sans Tamil' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'tamil'),
'category' => 'sans-serif'
),
'Rufina' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Italianno' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'VT323' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Nova Square' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Libre Bodoni' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'BIZ UDPGothic' => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'greek-ext', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Newsreader' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Black Han Sans' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'sans-serif'
),
'Quintessential' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Covered By Your Grace' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Sofia Sans Condensed' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Playfair' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '900', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Holtwood One SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Encode Sans Expanded' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Basic' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Economica' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Days One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Alatsi' => array(
'variants' => array('400'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Amita' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Leckerli One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Saira Extra Condensed' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Oxanium' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Calistoga' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Caveat Brush' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Karma' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Kreon' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Big Shoulders Display' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Palanquin' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Hanken Grotesk' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Ramabhadra' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'sans-serif'
),
'Kurale' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Averia Serif Libre' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'display'
),
'Changa One' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'display'
),
'Sintony' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Hebrew' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Charm' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'handwriting'
),
'Racing Sans One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'GFS Didot' => array(
'variants' => array('400'),
'subsets' => array('greek'),
'category' => 'serif'
),
'Shrikhand' => array(
'variants' => array('400'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'display'
),
'Cabin Sketch' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Noto Sans Malayalam' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'malayalam'),
'category' => 'sans-serif'
),
'Nanum Brush Script' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'handwriting'
),
'PT Serif Caption' => array(
'variants' => array('400', 'italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Balsamiq Sans' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'display'
),
'Mrs Saint Delafield' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Cinzel Decorative' => array(
'variants' => array('400', '700', '900'),
'subsets' => array('latin'),
'category' => 'display'
),
'Laila' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Lateef' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Hind Guntur' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'telugu'),
'category' => 'sans-serif'
),
'Rammetto One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Lemonada' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Arbutus Slab' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Rubik Moonrocks' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Pathway Extreme' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Berkshire Swash' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Yrsa' => array(
'variants' => array('300', '400', '500', '600', '700', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Coda' => array(
'variants' => array('400', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Candal' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Lustria' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Glegoo' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Mali' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'handwriting'
),
'Aclonica' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Syncopate' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Cormorant Infant' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Antic' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Geologica' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Chewy' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Michroma' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Trocchi' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Belleza' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Telex' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Arapey' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Darker Grotesque' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Calligraffitti' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Delius' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
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
'Just Another Hand' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Akshar' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'La Belle Aurore' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Zen Old Mincho' => array(
'variants' => array('400', '500', '600', '700', '900'),
'subsets' => array('cyrillic', 'greek', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Fredericka the Great' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Athiti' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Sofia Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Dela Gothic One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'greek', 'japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'K2D' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Vazirmatn' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Golos Text' => array(
'variants' => array('400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Julee' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Georama' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Herr Von Muellerhoff' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Seaweed Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Knewave' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Anuphan' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Rozha One' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Graduate' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Rancho' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Cantata One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Jua' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'sans-serif'
),
'Squada One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Alumni Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Ibarra Real Nova' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Bevan' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Kiwi Maru' => array(
'variants' => array('300', '400', '500'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Boogaloo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Alike' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'math', 'symbols'),
'category' => 'serif'
),
'Aldrich' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Cedarville Cursive' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'BioRhyme' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Arizonia' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Krona One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Grandstander' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Suez One' => array(
'variants' => array('400'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Radio Canada' => array(
'variants' => array('300', '400', '500', '600', '700', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('canadian-aboriginal', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'B612 Mono' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'monospace'
),
'Annie Use Your Telescope' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Nobile' => array(
'variants' => array('400', 'italic', '500', '500italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Scada' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Baloo Bhaijaan 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('arabic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Maitree' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'serif'
),
'Brygada 1918' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Kristi' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Caudex' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('greek', 'greek-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Do Hyeon' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'sans-serif'
),
'Coming Soon' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Marcellus SC' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Pattaya' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Corben' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Limelight' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Wallpoet' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Overpass Mono' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Allerta' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Livvic' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Podkova' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Rye' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Bowlby One SC' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Noto Serif Display' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Palanquin Dark' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Marmelad' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Oranienbaum' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Enriqueta' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Salsa' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Monsieur La Doulaise' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Bowlby One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Klee One' => array(
'variants' => array('400', '600'),
'subsets' => array('cyrillic', 'greek-ext', 'japanese', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Kameron' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Averia Libre' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'display'
),
'Judson' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'IBM Plex Sans KR' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('korean', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'M PLUS 1' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Young Serif' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Bubblegum Sans' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Yesteryear' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'IBM Plex Sans Thai' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'thai'),
'category' => 'sans-serif'
),
'Niconne' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Biryani' => array(
'variants' => array('200', '300', '400', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Overlock' => array(
'variants' => array('400', 'italic', '700', '700italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Contrail One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Grand Hotel' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Nixie One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'David Libre' => array(
'variants' => array('400', '500', '700'),
'subsets' => array('hebrew', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Pirata One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Bellefair' => array(
'variants' => array('400'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Rambla' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Encode Sans Semi Condensed' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Schoolbell' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Irish Grover' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Chonburi' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'display'
),
'Alegreya SC' => array(
'variants' => array('400', 'italic', '500', '500italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Spinnaker' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Kosugi' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'UnifrakturMaguntia' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Ephesis' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Arya' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Henny Penny' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Ovo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'B612' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Average Sans' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Markazi Text' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Petit Formal Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Rochester' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Baloo Da 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('bengali', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Fahkwang' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Trirong' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'serif'
),
'Coustard' => array(
'variants' => array('400', '900'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Halant' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Amiko' => array(
'variants' => array('400', '600', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Andada Pro' => array(
'variants' => array('400', '500', '600', '700', '800', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Mallanna' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'sans-serif'
),
'Miriam Libre' => array(
'variants' => array('400', '700'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Aladin' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'NTR' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'sans-serif'
),
'Dawning of a New Day' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Shippori Mincho B1' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Spectral SC' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Sigmar One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Instrument Sans' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Allison' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Zen Antique' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'greek', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Jockey One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Kelly Slab' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Goudy Bookletter 1911' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Metrophobic' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Proza Libre' => array(
'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Sofia Sans Extra Condensed' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Qwigley' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Gurajada' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'serif'
),
'Rasa' => array(
'variants' => array('300', '400', '500', '600', '700', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('gujarati', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Katibeh' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Kufam' => array(
'variants' => array('400', '500', '600', '700', '800', '900', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('arabic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Magra' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Manjari' => array(
'variants' => array('100', '400', '700'),
'subsets' => array('latin', 'latin-ext', 'malayalam'),
'category' => 'sans-serif'
),
'Love Ya Like A Sister' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Chivo Mono' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Grenze Gotisch' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Noto Nastaliq Urdu' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Average' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Thasadith' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Fjord One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Fanwood Text' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Norican' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Big Shoulders Text' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Sniglet' => array(
'variants' => array('400', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Montserrat Subrayada' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Aboreto' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Italiana' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Rosario' => array(
'variants' => array('300', '400', '500', '600', '700', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Waiting for the Sunrise' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Bungee Inline' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Glory' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Stardos Stencil' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Cormorant Upright' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Croissant One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Fauna One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Chelsea Market' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Trykker' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Carrois Gothic' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Inria Serif' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Copse' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Mina' => array(
'variants' => array('400', '700'),
'subsets' => array('bengali', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Bentham' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Vollkorn SC' => array(
'variants' => array('400', '600', '700', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Cambay' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Tomorrow' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Gabriela' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'IM Fell English SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Anek Malayalam' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'malayalam'),
'category' => 'sans-serif'
),
'Angkor' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Baloo Paaji 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('gurmukhi', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Ma Shan Zheng' => array(
'variants' => array('400'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'handwriting'
),
'Mansalva' => array(
'variants' => array('400'),
'subsets' => array('greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'IM Fell English' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Zen Kaku Gothic Antique' => array(
'variants' => array('300', '400', '500', '700', '900'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Elsie' => array(
'variants' => array('400', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Brawler' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Turret Road' => array(
'variants' => array('200', '300', '400', '500', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Meddon' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'M PLUS 2' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Sans Lao Looped' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('lao', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Style Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Noto Sans Kannada' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('kannada', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Oxygen Mono' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'Schibsted Grotesk' => array(
'variants' => array('400', '500', '600', '700', '800', '900', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Hepta Slab' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Cormorant SC' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Jomhuria' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Radley' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Megrim' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Cambo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Libre Barcode 39 Text' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Amethysta' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Odibee Sans' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Gloock' => array(
'variants' => array('400'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Mouse Memoirs' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Molengo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Coiny' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'tamil', 'vietnamese'),
'category' => 'display'
),
'IM Fell DW Pica' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Gravitas One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Hahmlet' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('korean', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Nova Mono' => array(
'variants' => array('400'),
'subsets' => array('greek', 'latin'),
'category' => 'monospace'
),
'Hanuman' => array(
'variants' => array('100', '300', '400', '700', '900'),
'subsets' => array('khmer', 'latin'),
'category' => 'serif'
),
'McLaren' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Over the Rainbow' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'MuseoModerno' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Rakkas' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Quando' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Baloo Tamma 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('kannada', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Capriola' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Gabarito' => array(
'variants' => array('400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Spline Sans' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Inknut Antiqua' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Share' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'RocknRoll One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Skranji' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Sunflower' => array(
'variants' => array('300', '500', '700'),
'subsets' => array('korean', 'latin'),
'category' => 'sans-serif'
),
'Headland One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Marvel' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'DotGothic16' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'ZCOOL XiaoWei' => array(
'variants' => array('400'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'sans-serif'
),
'Antic Didone' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Della Respira' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Kaisei Decol' => array(
'variants' => array('400', '500', '700'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Lemon' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Sue Ellen Francisco' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Homenaje' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Geo' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Cutive' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Caladea' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Wix Madefor Text' => array(
'variants' => array('400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'KoHo' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Sevillana' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Rouge Script' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Whisper' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Pompiere' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Zen Kurenaido' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'greek', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Mr De Haviland' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Federo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Farro' => array(
'variants' => array('300', '400', '500', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Gluten' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Poller One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Fondamento' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Noto Serif Devanagari' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Encode Sans Semi Expanded' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Happy Monkey' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Bellota Text' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Duru Sans' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Baloo Thambi 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'tamil', 'vietnamese'),
'category' => 'display'
),
'Aref Ruqaa' => array(
'variants' => array('400', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Ms Madi' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Mountains of Christmas' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Noto Sans Gurmukhi' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('gurmukhi', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Inder' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Azeret Mono' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'Anaheim' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Oooh Baby' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Sansita Swashed' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Germania One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Amarante' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Bungee Shade' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Oregano' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Xanh Mono' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Poly' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Supermercado One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Sedgwick Ave' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Give You Glory' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Yusei Magic' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Hurricane' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Euphoria Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'BIZ UDGothic' => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'greek-ext', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Besley' => array(
'variants' => array('400', '500', '600', '700', '800', '900', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Kadwa' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin'),
'category' => 'serif'
),
'Lekton' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans NKo Unjoined' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'nko'),
'category' => 'sans-serif'
),
'Alike Angular' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'math', 'symbols'),
'category' => 'serif'
),
'Flamenco' => array(
'variants' => array('300', '400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Padauk' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'myanmar'),
'category' => 'sans-serif'
),
'Lexend Exa' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Kodchasan' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'sans-serif'
),
'Tenali Ramakrishna' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'sans-serif'
),
'Gafata' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Onest' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Just Me Again Down Here' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Noto Sans Sinhala' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'sinhala'),
'category' => 'sans-serif'
),
'Averia Sans Libre' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'display'
),
'Goblin One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Walter Turncoat' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Aguafina Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Oleo Script Swash Caps' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Mukta Vaani' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Allan' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Ruslan Display' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'math', 'symbols'),
'category' => 'display'
),
'Noto Sans Telugu' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'telugu'),
'category' => 'sans-serif'
),
'Lexend Zetta' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Asul' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Expletus Sans' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Libre Barcode 128' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Solway' => array(
'variants' => array('300', '400', '500', '700', '800'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Modak' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'display'
),
'Fuggles' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Flow Circular' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Montaga' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Montez' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Carme' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'IBM Plex Sans JP' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Familjen Grotesk' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Mako' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Slabo 13px' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Crafty Girls' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Noto Sans Gujarati' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('gujarati', 'latin', 'latin-ext', 'math', 'symbols'),
'category' => 'sans-serif'
),
'Noto Sans Armenian' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('armenian', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Meie Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Mogra' => array(
'variants' => array('400'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'display'
),
'Gotu' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Gugi' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'display'
),
'Hi Melody' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'handwriting'
),
'Goldman' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Noto Sans Meetei Mayek' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'meetei-mayek'),
'category' => 'sans-serif'
),
'Numans' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Sail' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Bayon' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'sans-serif'
),
'Delius Unicase' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Mirza' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Clicker Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Madimi One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'math', 'symbols'),
'category' => 'sans-serif'
),
'Bricolage Grotesque' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Gantari' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Suranna' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'serif'
),
'Noto Serif Thai' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'thai'),
'category' => 'serif'
),
'Dongle' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('korean', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Monomaniac One' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Syne Mono' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'Recursive' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Puritan' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Truculenta' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Bakbak One' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'display'
),
'Baloo Chettan 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'malayalam', 'vietnamese'),
'category' => 'display'
),
'Noto Sans Georgian' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic-ext', 'georgian', 'greek-ext', 'latin', 'latin-ext', 'math', 'symbols'),
'category' => 'sans-serif'
),
'Esteban' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Manuale' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'BIZ UDPMincho' => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'greek-ext', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Sarpanch' => array(
'variants' => array('400', '500', '600', '700', '800', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Harmattan' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Sumana' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Notable' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Rampart One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'display'
),
'Loved by the King' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Patrick Hand SC' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Vibur' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Mochiy Pop One' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin'),
'category' => 'sans-serif'
),
'Saira Stencil One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Original Surfer' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Convergence' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Almendra' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Gaegu' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('korean', 'latin'),
'category' => 'handwriting'
),
'Prosto One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Shojumaru' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Timmana' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'sans-serif'
),
'Zen Antique Soft' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'greek', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Eater' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Mukta Mahee' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('gurmukhi', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Symbols' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'symbols'),
'category' => 'sans-serif'
),
'Vina Sans' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Inria Sans' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Kalnia' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'math'),
'category' => 'serif'
),
'Abyssinica SIL' => array(
'variants' => array('400'),
'subsets' => array('ethiopic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Shalimar' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Charmonman' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'handwriting'
),
'Buenard' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'BhuTuka Expanded One' => array(
'variants' => array('400'),
'subsets' => array('gurmukhi', 'latin', 'latin-ext'),
'category' => 'serif'
),
'League Script' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Overlock SC' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Red Rose' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Spicy Rice' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Shantell Sans' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Libre Caslon Display' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Rubik Dirt' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Kranky' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Dokdo' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'display'
),
'Noto Sans Oriya' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'oriya'),
'category' => 'sans-serif'
),
'Metamorphous' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Wix Madefor Display' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Freehand' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Lily Script One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Bubbler One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Tienne' => array(
'variants' => array('400', '700', '900'),
'subsets' => array('latin'),
'category' => 'serif'
),
'The Girl Next Door' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Kdam Thmor Pro' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Trade Winds' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Fragment Mono' => array(
'variants' => array('400', 'italic'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'monospace'
),
'WindSong' => array(
'variants' => array('400', '500'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Artifika' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'IM Fell Double Pica' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Galada' => array(
'variants' => array('400'),
'subsets' => array('bengali', 'latin'),
'category' => 'display'
),
'Dynalight' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Finger Paint' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Kaisei Opti' => array(
'variants' => array('400', '500', '700'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Cormorant Unicase' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Vast Shadow' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Baloo Bhai 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('gujarati', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Bigshot One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Vesper Libre' => array(
'variants' => array('400', '500', '700', '900'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Slackey' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Codystar' => array(
'variants' => array('300', '400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Birthstone' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Unkempt' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Bilbo Swash Caps' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Barriecito' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Hina Mincho' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Sulphur Point' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Orelega One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'display'
),
'Ceviche One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Tilt Warp' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Instrument Serif' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Atma' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('bengali', 'latin', 'latin-ext'),
'category' => 'display'
),
'Slackside One' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Reggae One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'display'
),
'Cherry Cream Soda' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Orienta' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Wendy One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Sofia Sans Semi Condensed' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Scope One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Kaisei Tokumin' => array(
'variants' => array('400', '500', '700', '800'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Wire One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Scheherazade New' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'ZCOOL QingKe HuangYou' => array(
'variants' => array('400'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'sans-serif'
),
'Libre Barcode 39 Extended Text' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Noto Sans Khojki' => array(
'variants' => array('400'),
'subsets' => array('khojki', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Gamja Flower' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'handwriting'
),
'Stick' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Fontdiner Swanky' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Doppio One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Share Tech' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Nerko One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Chau Philomene One' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Nova Round' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Bellota' => array(
'variants' => array('300', '300italic', '400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Life Savers' => array(
'variants' => array('400', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Balthazar' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Fresca' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Potta One' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Gowun Dodum' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Edu SA Beginner' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Noto Serif Hebrew' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Comforter Brush' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Frijole' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Varta' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Baumans' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Emilys Candy' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Medula One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Zen Dots' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Meera Inimai' => array(
'variants' => array('400'),
'subsets' => array('latin', 'tamil'),
'category' => 'sans-serif'
),
'Montagu Slab' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'MedievalSharp' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Freckle Face' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Noto Serif Malayalam' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'malayalam'),
'category' => 'serif'
),
'Imprima' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Poltawski Nowy' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Viaoda Libre' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Noto Emoji' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('emoji'),
'category' => 'sans-serif'
),
'Shanti' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Phudu' => array(
'variants' => array('300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Hachi Maru Pop' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Gowun Batang' => array(
'variants' => array('400', '700'),
'subsets' => array('korean', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Road Rage' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Voces' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Gayathri' => array(
'variants' => array('100', '400', '700'),
'subsets' => array('latin', 'malayalam'),
'category' => 'sans-serif'
),
'Smooch Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Iceland' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Corinthia' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Belgrano' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Ojuju' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'math', 'symbols', 'vietnamese'),
'category' => 'sans-serif'
),
'Qwitcher Grypen' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Tauri' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Ledger' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Murecho' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Autour One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Akaya Kanadaka' => array(
'variants' => array('400'),
'subsets' => array('kannada', 'latin', 'latin-ext'),
'category' => 'display'
),
'Pavanam' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'tamil'),
'category' => 'sans-serif'
),
'IM Fell French Canon' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Grape Nuts' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Noto Sans Khmer' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('khmer', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Macondo Swash Caps' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Nokora' => array(
'variants' => array('100', '300', '400', '700', '900'),
'subsets' => array('khmer', 'latin'),
'category' => 'sans-serif'
),
'Baloo Bhaina 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'oriya', 'vietnamese'),
'category' => 'display'
),
'Delius Swash Caps' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Tillana' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'display'
),
'Anek Latin' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Miniver' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Redressed' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Battambang' => array(
'variants' => array('100', '300', '400', '700', '900'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Peralta' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Ranchers' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'ZCOOL KuaiLe' => array(
'variants' => array('400'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'sans-serif'
),
'Mochiy Pop P One' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin'),
'category' => 'sans-serif'
),
'Asar' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Agbalumo' => array(
'variants' => array('400'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Habibi' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Raleway Dots' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Major Mono Display' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Noto Serif HK' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('chinese-hongkong', 'cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Modern Antiqua' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Square Peg' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Song Myung' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'serif'
),
'ADLaM Display' => array(
'variants' => array('400'),
'subsets' => array('adlam', 'latin', 'latin-ext'),
'category' => 'display'
),
'Noto Sans Myanmar' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('myanmar'),
'category' => 'sans-serif'
),
'East Sea Dokdo' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'handwriting'
),
'Zilla Slab Highlight' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Rum Raisin' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Faster One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Londrina Outline' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Red Hat Mono' => array(
'variants' => array('300', '400', '500', '600', '700', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'Crushed' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Swanky and Moo Moo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Prociono' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Rhodium Libre' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Cherry Swash' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Lexend Mega' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Chango' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Tiro Kannada' => array(
'variants' => array('400', 'italic'),
'subsets' => array('kannada', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Baloo Tammudu 2' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'telugu', 'vietnamese'),
'category' => 'display'
),
'Port Lligat Sans' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Karantina' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Ribeye' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Ramaraja' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'serif'
),
'Arima' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('greek', 'greek-ext', 'latin', 'latin-ext', 'malayalam', 'tamil', 'vietnamese'),
'category' => 'display'
),
'Strait' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Libre Barcode 128 Text' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'IM Fell DW Pica SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Ranga' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'display'
),
'Alkalami' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Nosifer' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Jomolhari' => array(
'variants' => array('400'),
'subsets' => array('latin', 'tibetan'),
'category' => 'serif'
),
'UnifrakturCook' => array(
'variants' => array('700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Gemunu Libre' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'sinhala'),
'category' => 'sans-serif'
),
'Noto Serif Georgian' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('georgian', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Iceberg' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Bona Nova' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'hebrew', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Monofett' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'Meow Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Gulzar' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Ruthie' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Spline Sans Mono' => array(
'variants' => array('300', '400', '500', '600', '700', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'Suwannaphum' => array(
'variants' => array('100', '300', '400', '700', '900'),
'subsets' => array('khmer', 'latin'),
'category' => 'serif'
),
'Rosarivo' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Galdeano' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Fenix' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'MonteCarlo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Akaya Telivigala' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'telugu'),
'category' => 'display'
),
'Shippori Antique' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Lovers Quarrel' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Stylish' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'sans-serif'
),
'Nova Flat' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Gorditas' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Anek Bangla' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('bengali', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Kulim Park' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Carrois Gothic SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Train One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'display'
),
'Caprasimo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Cantora One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Dekko' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Cute Font' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'display'
),
'Tektur' => array(
'variants' => array('400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Metal Mania' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'IM Fell Great Primer' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Fasthand' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Milonga' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Kite One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Lexend Giga' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Maiden Orange' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Kantumruy Pro' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('khmer', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Sunshiney' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Uncial Antiqua' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Yuji Syuku' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Sonsie One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Denk One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Vujahday Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Stalemate' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Farsan' => array(
'variants' => array('400'),
'subsets' => array('gujarati', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Akronim' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Protest Revolution' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'math', 'symbols', 'vietnamese'),
'category' => 'display'
),
'Moul' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Kaisei HarunoUmi' => array(
'variants' => array('400', '500', '700'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Barrio' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Yomogi' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Stoke' => array(
'variants' => array('300', '400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Pixelify Sans' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Redacted' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'REM' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Piazzolla' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Bruno Ace SC' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Fuzzy Bubbles' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Paprika' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Kotta One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Asset' => array(
'variants' => array('400'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'math', 'symbols'),
'category' => 'display'
),
'Sancreek' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Jolly Lodger' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Alkatra' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('bengali', 'devanagari', 'latin', 'latin-ext', 'oriya'),
'category' => 'display'
),
'IM Fell French Canon SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Sree Krushnadevaraya' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'serif'
),
'IBM Plex Sans Hebrew' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Margarine' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Anta' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'math', 'symbols'),
'category' => 'sans-serif'
),
'Stint Ultra Condensed' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Mystery Quest' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Sura' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Bungee Hairline' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Smythe' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Unlock' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Donegal One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Port Lligat Slab' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Protest Riot' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'math', 'symbols', 'vietnamese'),
'category' => 'display'
),
'Kenia' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Martian Mono' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'monospace'
),
'Tiro Devanagari Hindi' => array(
'variants' => array('400', 'italic'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Stint Ultra Expanded' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Engagement' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Rationale' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Noto Sans Lao' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('lao', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Beth Ellen' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Poor Story' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'display'
),
'Delicious Handrawn' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'IM Fell Great Primer SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Astloch' => array(
'variants' => array('400', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Moon Dance' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Dorsa' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Passions Conflict' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Nova Slim' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'IBM Plex Sans Thai Looped' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'thai'),
'category' => 'sans-serif'
),
'Sarina' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'AR One Sans' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Genos' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cherokee', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Caesar Dressing' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Anek Telugu' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'telugu'),
'category' => 'sans-serif'
),
'Offside' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Noto Serif Telugu' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'telugu'),
'category' => 'serif'
),
'Vampiro One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Eagle Lake' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Girassol' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Stick No Bills' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'sinhala'),
'category' => 'sans-serif'
),
'Marhey' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Underdog' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Yeon Sung' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'display'
),
'Nova Oval' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Imbue' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'IM Fell Double Pica SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Text Me One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Nova Script' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Miltonian Tattoo' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Finlandica' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Junge' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Nova Cut' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Jacques Francois' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Cagliostro' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Waterfall' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Fascinate Inline' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Anybody' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Libre Barcode 39 Extended' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Chicle' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Kumar One' => array(
'variants' => array('400'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'display'
),
'Miltonian' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Molle' => array(
'variants' => array('italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Keania One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Smooch' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Bilbo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Averia Gruesa Libre' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Shippori Antique B1' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Srisakdi' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'thai', 'vietnamese'),
'category' => 'display'
),
'Chilanka' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'malayalam'),
'category' => 'handwriting'
),
'Licorice' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Jim Nightshade' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'The Nautigal' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Anek Devanagari' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Lexend Peta' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Mohave' => array(
'variants' => array('300', '400', '500', '600', '700', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Comforter' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Trispace' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Sedgwick Ave Display' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Birthstone Bounce' => array(
'variants' => array('400', '500'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Kode Mono' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'Felipa' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Simonetta' => array(
'variants' => array('400', 'italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Tulpen One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Tilt Neon' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Noto Sans Adlam' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('adlam', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Spirax' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Zhi Mang Xing' => array(
'variants' => array('400'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'handwriting'
),
'Fascinate' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Khmer' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'sans-serif'
),
'Rethink Sans' => array(
'variants' => array('400', '500', '600', '700', '800', 'italic', '500italic', '600italic', '700italic', '800italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Marko One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Kavoon' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'M PLUS 1 Code' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'New Rocker' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Bahianita' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Carattere' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Beau Rivage' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Tiro Bangla' => array(
'variants' => array('400', 'italic'),
'subsets' => array('bengali', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Alumni Sans Inline One' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Buda' => array(
'variants' => array('300'),
'subsets' => array('latin'),
'category' => 'display'
),
'Anek Tamil' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'tamil'),
'category' => 'sans-serif'
),
'Liu Jian Mao Cao' => array(
'variants' => array('400'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'handwriting'
),
'Kavivanar' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'tamil'),
'category' => 'handwriting'
),
'Arbutus' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Ravi Prakash' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'display'
),
'Seymour One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Texturina' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Englebert' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Tilt Prism' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Kirang Haerang' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'display'
),
'Amiri Quran' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin'),
'category' => 'serif'
),
'Charis SIL' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Condiment' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'New Tegomin' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Big Shoulders Stencil Display' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Black And White Picture' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin'),
'category' => 'display'
),
'Ruluko' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Plaster' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Wellfleet' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Playpen Sans' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('emoji', 'latin', 'latin-ext', 'math', 'vietnamese'),
'category' => 'handwriting'
),
'Noto Sans Math' => array(
'variants' => array('400'),
'subsets' => array('math'),
'category' => 'sans-serif'
),
'Benne' => array(
'variants' => array('400'),
'subsets' => array('kannada', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Noto Sans Symbols 2' => array(
'variants' => array('400'),
'subsets' => array('braille', 'latin', 'latin-ext', 'math', 'mayan-numerals', 'symbols'),
'category' => 'sans-serif'
),
'Long Cang' => array(
'variants' => array('400'),
'subsets' => array('chinese-simplified', 'latin'),
'category' => 'handwriting'
),
'Glass Antiqua' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Galindo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Elsie Swash Caps' => array(
'variants' => array('400', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Praise' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Inika' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Belanosima' => array(
'variants' => array('400', '600', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Mrs Sheppards' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Linden Hill' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Noto Sans Gothic' => array(
'variants' => array('400'),
'subsets' => array('gothic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Aoboshi One' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Bahiana' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Yaldevi' => array(
'variants' => array('200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'sinhala'),
'category' => 'sans-serif'
),
'BIZ UDMincho' => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'greek-ext', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Content' => array(
'variants' => array('400', '700'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Carlito' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Joti One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Braah One' => array(
'variants' => array('400'),
'subsets' => array('gurmukhi', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Sans Anatolian Hieroglyphs' => array(
'variants' => array('400'),
'subsets' => array('anatolian-hieroglyphs', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Protest Strike' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'math', 'symbols', 'vietnamese'),
'category' => 'display'
),
'Ribeye Marrow' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Risque' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Imperial Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Bonheur Royale' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Londrina Shadow' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Noto Sans Thai Looped' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'thai'),
'category' => 'sans-serif'
),
'Romanesco' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Rubik Doodle Shadow' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext', 'math', 'symbols'),
'category' => 'display'
),
'Water Brush' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Akatab' => array(
'variants' => array('400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'tifinagh'),
'category' => 'sans-serif'
),
'Gentium Book Plus' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Sahitya' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin'),
'category' => 'serif'
),
'Grenze' => array(
'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Gupter' => array(
'variants' => array('400', '500', '700'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Smokum' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Lakki Reddy' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'handwriting'
),
'Kumar One Outline' => array(
'variants' => array('400'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'display'
),
'Sirin Stencil' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Afacad' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'math', 'symbols', 'vietnamese'),
'category' => 'sans-serif'
),
'DynaPuff' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext'),
'category' => 'display'
),
'Chela One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Piedra' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Princess Sofia' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Chathura' => array(
'variants' => array('100', '300', '400', '700', '800'),
'subsets' => array('latin', 'telugu'),
'category' => 'sans-serif'
),
'Flavors' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Bungee Spice' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Hedvig Letters Serif' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'math', 'symbols'),
'category' => 'serif'
),
'Rock 3D' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin'),
'category' => 'display'
),
'Jacques Francois Shadow' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Odor Mean Chey' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'serif'
),
'Almendra SC' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'serif'
),
'Big Shoulders Stencil Text' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Lancelot' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Atomic Age' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Ysabeau' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'math', 'symbols', 'vietnamese'),
'category' => 'sans-serif'
),
'Preahvihear' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'sans-serif'
),
'Dr Sugiyama' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Sono' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Ewert' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Anek Gujarati' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('gujarati', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Oldenburg' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Revalia' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Encode Sans SC' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Sans Ethiopic' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('ethiopic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Griffy' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Victor Mono' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'monospace'
),
'Luxurious Script' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Edu TAS Beginner' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Zen Tokyo Zoo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Ysabeau Office' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'math', 'symbols', 'vietnamese'),
'category' => 'sans-serif'
),
'Festive' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Noto Sans Samaritan' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'samaritan'),
'category' => 'sans-serif'
),
'BioRhyme Expanded' => array(
'variants' => array('200', '300', '400', '700', '800'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Gentium Plus' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Libre Barcode EAN13 Text' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Lavishly Yours' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Single Day' => array(
'variants' => array('400'),
'subsets' => array('korean'),
'category' => 'display'
),
'Anek Gurmukhi' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('gurmukhi', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Emblema One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Dhurjati' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'sans-serif'
),
'Snippet' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'sans-serif'
),
'Noto Sans Cham' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cham', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Diplomata SC' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Noto Sans Tangsa' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'tangsa'),
'category' => 'sans-serif'
),
'Dangrek' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Almendra Display' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Bungee Outline' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Stalinist One' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Noto Sans Tai Viet' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'tai-viet'),
'category' => 'sans-serif'
),
'Foldit' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Sometype Mono' => array(
'variants' => array('400', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'monospace'
),
'Noto Serif Sinhala' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'sinhala'),
'category' => 'serif'
),
'Lacquer' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Federant' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Labrada' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'serif'
),
'Noto Serif Armenian' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('armenian', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Erica One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Solitreo' => array(
'variants' => array('400'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Lexend Tera' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Mea Culpa' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Hubballi' => array(
'variants' => array('400'),
'subsets' => array('kannada', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Bigelow Rules' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Mr Bedfort' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Rubik Glitch' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Namdhinggo' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'limbu'),
'category' => 'serif'
),
'Gwendolyn' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Hanalei Fill' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Butcherman' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Qahiri' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin'),
'category' => 'sans-serif'
),
'Koh Santepheap' => array(
'variants' => array('100', '300', '400', '700', '900'),
'subsets' => array('khmer', 'latin'),
'category' => 'serif'
),
'Borel' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'math', 'symbols', 'vietnamese'),
'category' => 'handwriting'
),
'Gidugu' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'sans-serif'
),
'Devonshire' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Big Shoulders Inline Text' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Peddana' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'serif'
),
'Climate Crisis' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Londrina Sketch' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Lumanosimo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'GFS Neohellenic' => array(
'variants' => array('400', 'italic', '700', '700italic'),
'subsets' => array('greek'),
'category' => 'sans-serif'
),
'Cairo Play' => array(
'variants' => array('200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Combo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Passero One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Diplomata' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Konkhmer Sleokchher' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin', 'latin-ext'),
'category' => 'display'
),
'Anek Kannada' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('kannada', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Ysabeau Infant' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'math', 'symbols', 'vietnamese'),
'category' => 'sans-serif'
),
'Agdasima' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Inspiration' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Metal' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Tiro Telugu' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext', 'telugu'),
'category' => 'serif'
),
'Neonderthaw' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Comme' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Bokor' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Ballet' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Gasoek One' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Rubik Iso' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Rubik Distressed' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Miss Fajardose' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'IBM Plex Sans Devanagari' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('cyrillic-ext', 'devanagari', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Vibes' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin'),
'category' => 'display'
),
'Chenla' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'display'
),
'Aubrey' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Tiro Devanagari Sanskrit' => array(
'variants' => array('400', 'italic'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Joan' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Micro 5' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'math', 'symbols'),
'category' => 'display'
),
'Gideon Roman' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Noto Serif Vithkuqi' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vithkuqi'),
'category' => 'serif'
),
'Siemreap' => array(
'variants' => array('400'),
'subsets' => array('khmer'),
'category' => 'sans-serif'
),
'Luxurious Roman' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Noto Serif Kannada' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('kannada', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Uchen' => array(
'variants' => array('400'),
'subsets' => array('latin', 'tibetan'),
'category' => 'serif'
),
'Redacted Script' => array(
'variants' => array('300', '400', '700'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Alumni Sans Collegiate One' => array(
'variants' => array('400', 'italic'),
'subsets' => array('cyrillic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Flow Block' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Butterfly Kids' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Island Moments' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Rubik Wet Paint' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Reem Kufi Fun' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Anek Odia' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800'),
'subsets' => array('latin', 'latin-ext', 'oriya'),
'category' => 'sans-serif'
),
'Sofadi One' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Babylonica' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Fruktur' => array(
'variants' => array('400', 'italic'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Jacquarda Bastarda 9' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'math', 'symbols'),
'category' => 'display'
),
'Annapurna SIL' => array(
'variants' => array('400', '700'),
'subsets' => array('devanagari', 'latin', 'latin-ext', 'math', 'symbols'),
'category' => 'serif'
),
'Caramel' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Bruno Ace' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Geostar' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Bagel Fat One' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin', 'latin-ext'),
'category' => 'display'
),
'Honk' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'math', 'symbols', 'vietnamese'),
'category' => 'display'
),
'Rubik Vinyl' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Updock' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Yuji Boku' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Noto Music' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'music'),
'category' => 'sans-serif'
),
'Nabla' => array(
'variants' => array('400'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'math', 'vietnamese'),
'category' => 'display'
),
'My Soul' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Trochut' => array(
'variants' => array('400', 'italic', '700'),
'subsets' => array('latin'),
'category' => 'display'
),
'Suravaram' => array(
'variants' => array('400'),
'subsets' => array('latin', 'telugu'),
'category' => 'serif'
),
'Castoro Titling' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Love Light' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Tourney' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Mynerve' => array(
'variants' => array('400'),
'subsets' => array('greek', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Tiro Devanagari Marathi' => array(
'variants' => array('400', 'italic'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Hedvig Letters Sans' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'math', 'symbols'),
'category' => 'sans-serif'
),
'Purple Purse' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Nuosu SIL' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'yi'),
'category' => 'sans-serif'
),
'Noto Sans Lepcha' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'lepcha'),
'category' => 'sans-serif'
),
'Tai Heritage Pro' => array(
'variants' => array('400', '700'),
'subsets' => array('latin', 'latin-ext', 'tai-viet', 'vietnamese'),
'category' => 'serif'
),
'Ruge Boogie' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Aref Ruqaa Ink' => array(
'variants' => array('400', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Mooli' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Explora' => array(
'variants' => array('400'),
'subsets' => array('cherokee', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Noto Serif Gujarati' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('gujarati', 'latin', 'latin-ext', 'math', 'symbols'),
'category' => 'serif'
),
'Rubik Beastly' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Snowburst One' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Edu NSW ACT Foundation' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Noto Sans Javanese' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('javanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Darumadrop One' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'display'
),
'Bonbon' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Reem Kufi Ink' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Langar' => array(
'variants' => array('400'),
'subsets' => array('gurmukhi', 'latin', 'latin-ext'),
'category' => 'display'
),
'Cherry Bomb One' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Noto Serif Khmer' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('khmer', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Syne Tactile' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Noto Sans Glagolitic' => array(
'variants' => array('400'),
'subsets' => array('cyrillic-ext', 'glagolitic', 'latin', 'latin-ext', 'math', 'symbols'),
'category' => 'sans-serif'
),
'Splash' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Fleur De Leah' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Protest Guerrilla' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'math', 'symbols', 'vietnamese'),
'category' => 'display'
),
'Tsukimi Rounded' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Yuji Mai' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'japanese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Moulpali' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'sans-serif'
),
'Handjet' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('arabic', 'armenian', 'cyrillic', 'cyrillic-ext', 'greek', 'hebrew', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Sassy Frass' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Inclusive Sans' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Alumni Sans Pinstripe' => array(
'variants' => array('400', 'italic'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Blaka' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Kolker Brush' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Petemoss' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Send Flowers' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Bacasime Antique' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'serif'
),
'Noto Serif Tamil' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
'subsets' => array('latin', 'latin-ext', 'tamil'),
'category' => 'serif'
),
'Moirai One' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin', 'latin-ext'),
'category' => 'display'
),
'Oi' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'tamil', 'vietnamese'),
'category' => 'display'
),
'Tiro Tamil' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext', 'tamil'),
'category' => 'serif'
),
'Taprom' => array(
'variants' => array('400'),
'subsets' => array('khmer', 'latin'),
'category' => 'display'
),
'Grechen Fuemen' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Noto Serif Myanmar' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('myanmar'),
'category' => 'serif'
),
'Geostar Fill' => array(
'variants' => array('400'),
'subsets' => array('latin'),
'category' => 'display'
),
'Noto Sans Osmanya' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'osmanya'),
'category' => 'sans-serif'
),
'Noto Rashi Hebrew' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('hebrew', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Edu VIC WA NT Beginner' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Flow Rounded' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Sigmar' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Noto Sans Syloti Nagri' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'syloti-nagri'),
'category' => 'sans-serif'
),
'Sixtyfour' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'math', 'symbols'),
'category' => 'monospace'
),
'Noto Sans Coptic' => array(
'variants' => array('400'),
'subsets' => array('coptic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Tagalog' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'tagalog'),
'category' => 'sans-serif'
),
'Gajraj One' => array(
'variants' => array('400'),
'subsets' => array('devanagari', 'latin', 'latin-ext'),
'category' => 'display'
),
'Ysabeau SC' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'latin', 'latin-ext', 'math', 'symbols', 'vietnamese'),
'category' => 'sans-serif'
),
'Noto Serif Khojki' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('khojki', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Zen Loop' => array(
'variants' => array('400', 'italic'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Big Shoulders Inline Display' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Noto Serif Tangut' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'tangut'),
'category' => 'serif'
),
'Noto Serif Balinese' => array(
'variants' => array('400'),
'subsets' => array('balinese', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Grey Qo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Diphylleia' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Dai Banna SIL' => array(
'variants' => array('300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
'subsets' => array('latin', 'latin-ext', 'new-tai-lue'),
'category' => 'serif'
),
'Noto Serif Tibetan' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'tibetan'),
'category' => 'serif'
),
'Palette Mosaic' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin'),
'category' => 'display'
),
'Are You Serious' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Noto Sans Sora Sompeng' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'sora-sompeng'),
'category' => 'sans-serif'
),
'Rubik 80s Fade' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Kablammo' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Rubik Maps' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext', 'math', 'symbols'),
'category' => 'display'
),
'Noto Sans Canadian Aboriginal' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('canadian-aboriginal', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Serif NP Hmong' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'nyiakeng-puachue-hmong'),
'category' => 'serif'
),
'Rubik Microbe' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Noto Serif Toto' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'toto'),
'category' => 'serif'
),
'Orbit' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Shizuru' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin'),
'category' => 'display'
),
'Rubik Glitch Pop' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext', 'math', 'symbols'),
'category' => 'display'
),
'Noto Sans Phags Pa' => array(
'variants' => array('400'),
'subsets' => array('phags-pa'),
'category' => 'sans-serif'
),
'Rubik Spray Paint' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Edu QLD Beginner' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin'),
'category' => 'handwriting'
),
'Tiro Gurmukhi' => array(
'variants' => array('400', 'italic'),
'subsets' => array('gurmukhi', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Noto Sans Egyptian Hieroglyphs' => array(
'variants' => array('400'),
'subsets' => array('egyptian-hieroglyphs', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Ruwudu' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Noto Serif Lao' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('lao', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Noto Serif Ethiopic' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('ethiopic', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Grandiflora One' => array(
'variants' => array('400'),
'subsets' => array('korean', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Lugrasimo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'handwriting'
),
'Workbench' => array(
'variants' => array('400'),
'subsets' => array('latin', 'math', 'symbols'),
'category' => 'monospace'
),
'Warnes' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'Estonia' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Noto Sans Imperial Aramaic' => array(
'variants' => array('400'),
'subsets' => array('imperial-aramaic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Mongolian' => array(
'variants' => array('400'),
'subsets' => array('chinese-simplified', 'latin', 'latin-ext', 'math', 'mongolian', 'symbols'),
'category' => 'sans-serif'
),
'Twinkle Star' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Cherish' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Rubik Pixels' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Tapestry' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Lunasima' => array(
'variants' => array('400', '700'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'hebrew', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Moo Lah Lah' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Hanalei' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext'),
'category' => 'display'
),
'M PLUS Code Latin' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'sans-serif'
),
'Rubik Puddles' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Ole' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Noto Sans Buhid' => array(
'variants' => array('400'),
'subsets' => array('buhid', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Thaana' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'thaana'),
'category' => 'sans-serif'
),
'Rubik Burned' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Kings' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Blaka Hollow' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Lisu Bosa' => array(
'variants' => array('200', '200italic', '300', '300italic', '400', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
'subsets' => array('latin', 'latin-ext', 'lisu'),
'category' => 'serif'
),
'Noto Sans Vithkuqi' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'vithkuqi'),
'category' => 'sans-serif'
),
'Rubik Scribble' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext', 'math', 'symbols'),
'category' => 'display'
),
'Rubik Gemstones' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Noto Serif Ahom' => array(
'variants' => array('400'),
'subsets' => array('ahom', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Noto Sans Chorasmian' => array(
'variants' => array('400'),
'subsets' => array('chorasmian', 'latin', 'latin-ext', 'math', 'symbols'),
'category' => 'sans-serif'
),
'Noto Serif Ottoman Siyaq' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'ottoman-siyaq-numbers'),
'category' => 'serif'
),
'Ingrid Darling' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Noto Sans Miao' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'miao'),
'category' => 'sans-serif'
),
'Noto Sans Tifinagh' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'tifinagh'),
'category' => 'sans-serif'
),
'Rubik Marker Hatch' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Noto Sans Old Italic' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'old-italic'),
'category' => 'sans-serif'
),
'Noto Sans Old Hungarian' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'old-hungarian'),
'category' => 'sans-serif'
),
'Rubik Storm' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Noto Traditional Nushu' => array(
'variants' => array('300', '400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'nushu'),
'category' => 'sans-serif'
),
'Noto Sans Nag Mundari' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'nag-mundari'),
'category' => 'sans-serif'
),
'Noto Sans Tamil Supplement' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'tamil-supplement'),
'category' => 'sans-serif'
),
'Blaka Ink' => array(
'variants' => array('400'),
'subsets' => array('arabic', 'latin', 'latin-ext'),
'category' => 'display'
),
'Noto Sans Linear A' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'linear-a'),
'category' => 'sans-serif'
),
'Noto Sans Cypro Minoan' => array(
'variants' => array('400'),
'subsets' => array('cypro-minoan', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Linear B' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'linear-b'),
'category' => 'sans-serif'
),
'Noto Sans Carian' => array(
'variants' => array('400'),
'subsets' => array('carian', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Bamum' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('bamum', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Balinese' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('balinese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Vai' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vai'),
'category' => 'sans-serif'
),
'Yuji Hentaigana Akari' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Noto Sans Nandinagari' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'nandinagari'),
'category' => 'sans-serif'
),
'Rubik Broken Fax' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext', 'math', 'symbols'),
'category' => 'display'
),
'Noto Sans Deseret' => array(
'variants' => array('400'),
'subsets' => array('deseret', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Marchen' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'marchen'),
'category' => 'sans-serif'
),
'Noto Serif Oriya' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'oriya'),
'category' => 'serif'
),
'Noto Sans Kawi' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('kawi', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Rubik Doodle Triangles' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext', 'math', 'symbols'),
'category' => 'display'
),
'Noto Sans Takri' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'takri'),
'category' => 'sans-serif'
),
'Noto Sans Batak' => array(
'variants' => array('400'),
'subsets' => array('batak', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Puppies Play' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'vietnamese'),
'category' => 'handwriting'
),
'Noto Sans Avestan' => array(
'variants' => array('400'),
'subsets' => array('avestan', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Rubik Lines' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext', 'math', 'symbols'),
'category' => 'display'
),
'Noto Sans Bassa Vah' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('bassa-vah', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Rubik Maze' => array(
'variants' => array('400'),
'subsets' => array('cyrillic', 'cyrillic-ext', 'hebrew', 'latin', 'latin-ext'),
'category' => 'display'
),
'Noto Sans Caucasian Albanian' => array(
'variants' => array('400'),
'subsets' => array('caucasian-albanian', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Serif Makasar' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'makasar'),
'category' => 'serif'
),
'Noto Sans New Tai Lue' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'new-tai-lue'),
'category' => 'sans-serif'
),
'Noto Sans Modi' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'modi'),
'category' => 'sans-serif'
),
'Noto Sans Elbasan' => array(
'variants' => array('400'),
'subsets' => array('elbasan', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Pahawh Hmong' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'pahawh-hmong'),
'category' => 'sans-serif'
),
'Noto Sans SignWriting' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'signwriting'),
'category' => 'sans-serif'
),
'Noto Sans Phoenician' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'phoenician'),
'category' => 'sans-serif'
),
'Noto Sans Mahajani' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'mahajani'),
'category' => 'sans-serif'
),
'Noto Serif Grantha' => array(
'variants' => array('400'),
'subsets' => array('grantha', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Noto Sans Kharoshthi' => array(
'variants' => array('400'),
'subsets' => array('kharoshthi', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Cherokee' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('cherokee', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Meroitic' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'meroitic', 'meroitic-cursive', 'meroitic-hieroglyphs'),
'category' => 'sans-serif'
),
'Kay Pho Du' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('kayah-li', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Noto Sans Ugaritic' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'ugaritic'),
'category' => 'sans-serif'
),
'Noto Sans Old Persian' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'old-persian'),
'category' => 'sans-serif'
),
'Noto Sans Adlam Unjoined' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('adlam', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Hanunoo' => array(
'variants' => array('400'),
'subsets' => array('hanunoo', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Indic Siyaq Numbers' => array(
'variants' => array('400'),
'subsets' => array('indic-siyaq-numbers', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Brahmi' => array(
'variants' => array('400'),
'subsets' => array('brahmi', 'latin', 'latin-ext', 'math', 'symbols'),
'category' => 'sans-serif'
),
'Wavefont' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin'),
'category' => 'display'
),
'Noto Serif Old Uyghur' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'old-uyghur'),
'category' => 'serif'
),
'Noto Sans Runic' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'runic'),
'category' => 'sans-serif'
),
'Noto Sans Inscriptional Pahlavi' => array(
'variants' => array('400'),
'subsets' => array('inscriptional-pahlavi', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Serif Yezidi' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'yezidi'),
'category' => 'serif'
),
'Noto Sans Cuneiform' => array(
'variants' => array('400'),
'subsets' => array('cuneiform', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Zanabazar Square' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'zanabazar-square'),
'category' => 'sans-serif'
),
'Linefont' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin'),
'category' => 'display'
),
'Noto Sans Multani' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'multani'),
'category' => 'sans-serif'
),
'Noto Sans Medefaidrin' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'medefaidrin'),
'category' => 'sans-serif'
),
'Noto Sans Yi' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'yi'),
'category' => 'sans-serif'
),
'Yuji Hentaigana Akebono' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext'),
'category' => 'handwriting'
),
'Noto Sans Ol Chiki' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'ol-chiki'),
'category' => 'sans-serif'
),
'Noto Sans Cypriot' => array(
'variants' => array('400'),
'subsets' => array('cypriot', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Lydian' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'lydian'),
'category' => 'sans-serif'
),
'Padyakke Expanded One' => array(
'variants' => array('400'),
'subsets' => array('kannada', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Noto Sans Osage' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'osage'),
'category' => 'sans-serif'
),
'Noto Sans Lisu' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'lisu'),
'category' => 'sans-serif'
),
'Noto Sans Sharada' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'sharada'),
'category' => 'sans-serif'
),
'Noto Serif Gurmukhi' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('gurmukhi', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Noto Sans Kaithi' => array(
'variants' => array('400'),
'subsets' => array('kaithi', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Narnoor' => array(
'variants' => array('400', '500', '600', '700', '800'),
'subsets' => array('gunjala-gondi', 'latin', 'latin-ext', 'math', 'symbols'),
'category' => 'serif'
),
'Noto Sans Kayah Li' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('kayah-li', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Mingzat' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'lepcha'),
'category' => 'sans-serif'
),
'Noto Sans Psalter Pahlavi' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'psalter-pahlavi'),
'category' => 'sans-serif'
),
'Noto Sans Chakma' => array(
'variants' => array('400'),
'subsets' => array('chakma', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Sundanese' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'sundanese'),
'category' => 'sans-serif'
),
'Noto Sans Old South Arabian' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'old-south-arabian'),
'category' => 'sans-serif'
),
'Noto Sans Tagbanwa' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'tagbanwa'),
'category' => 'sans-serif'
),
'Noto Serif Khitan Small Script' => array(
'variants' => array('400'),
'subsets' => array('khitan-small-script', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Noto Sans Siddham' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'siddham'),
'category' => 'sans-serif'
),
'Noto Sans Lycian' => array(
'variants' => array('400'),
'subsets' => array('lycian'),
'category' => 'sans-serif'
),
'Noto Sans Old Turkic' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'old-turkic'),
'category' => 'sans-serif'
),
'Noto Sans Tai Tham' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('latin', 'latin-ext', 'tai-tham'),
'category' => 'sans-serif'
),
'Noto Sans Palmyrene' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'palmyrene'),
'category' => 'sans-serif'
),
'Noto Sans Syriac Eastern' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'syriac'),
'category' => 'sans-serif'
),
'Noto Sans Limbu' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'limbu'),
'category' => 'sans-serif'
),
'Noto Sans Saurashtra' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'saurashtra'),
'category' => 'sans-serif'
),
'Noto Sans Tirhuta' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'tirhuta'),
'category' => 'sans-serif'
),
'Noto Sans Buginese' => array(
'variants' => array('400'),
'subsets' => array('buginese', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Inscriptional Parthian' => array(
'variants' => array('400'),
'subsets' => array('inscriptional-parthian', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Grantha' => array(
'variants' => array('400'),
'subsets' => array('grantha', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Khudawadi' => array(
'variants' => array('400'),
'subsets' => array('khudawadi', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Newa' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'newa'),
'category' => 'sans-serif'
),
'Chokokutai' => array(
'variants' => array('400'),
'subsets' => array('japanese', 'latin', 'latin-ext', 'vietnamese'),
'category' => 'display'
),
'Noto Sans Wancho' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'wancho'),
'category' => 'sans-serif'
),
'Noto Sans Hatran' => array(
'variants' => array('400'),
'subsets' => array('hatran', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Duployan' => array(
'variants' => array('400', '700'),
'subsets' => array('duployan', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Tai Le' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'tai-le'),
'category' => 'sans-serif'
),
'Noto Sans Old North Arabian' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'old-north-arabian'),
'category' => 'sans-serif'
),
'Noto Sans Mayan Numerals' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'mayan-numerals'),
'category' => 'sans-serif'
),
'Noto Sans Hanifi Rohingya' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('hanifi-rohingya', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Old Permic' => array(
'variants' => array('400'),
'subsets' => array('cyrillic-ext', 'latin', 'latin-ext', 'old-permic'),
'category' => 'sans-serif'
),
'Noto Sans Sogdian' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'sogdian'),
'category' => 'sans-serif'
),
'Noto Sans Rejang' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'rejang'),
'category' => 'sans-serif'
),
'Noto Sans Nabataean' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'nabataean'),
'category' => 'sans-serif'
),
'Noto Sans Ogham' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'ogham'),
'category' => 'sans-serif'
),
'Noto Sans Bhaiksuki' => array(
'variants' => array('400'),
'subsets' => array('bhaiksuki', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Syriac' => array(
'variants' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
'subsets' => array('latin', 'latin-ext', 'syriac'),
'category' => 'sans-serif'
),
'Noto Sans Mro' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'mro'),
'category' => 'sans-serif'
),
'Noto Sans Shavian' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'shavian'),
'category' => 'sans-serif'
),
'Noto Sans Gunjala Gondi' => array(
'variants' => array('400', '500', '600', '700'),
'subsets' => array('gunjala-gondi', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Mandaic' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'mandaic'),
'category' => 'sans-serif'
),
'Noto Sans Masaram Gondi' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'masaram-gondi'),
'category' => 'sans-serif'
),
'Noto Sans Warang Citi' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'warang-citi'),
'category' => 'sans-serif'
),
'Noto Serif Dogra' => array(
'variants' => array('400'),
'subsets' => array('dogra', 'latin', 'latin-ext'),
'category' => 'serif'
),
'Noto Sans Nushu' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'nushu'),
'category' => 'sans-serif'
),
'Noto Sans Old Sogdian' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'old-sogdian'),
'category' => 'sans-serif'
),
'Noto Sans Mende Kikakui' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'mende-kikakui'),
'category' => 'sans-serif'
),
'Noto Sans Pau Cin Hau' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'pau-cin-hau'),
'category' => 'sans-serif'
),
'Noto Sans Elymaic' => array(
'variants' => array('400'),
'subsets' => array('elymaic', 'latin', 'latin-ext'),
'category' => 'sans-serif'
),
'Noto Sans Manichaean' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'manichaean'),
'category' => 'sans-serif'
),
'Noto Sans Soyombo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'soyombo'),
'category' => 'sans-serif'
),
'Noto Sans NKo' => array(
'variants' => array('400'),
'subsets' => array('latin', 'latin-ext', 'nko'),
'category' => 'sans-serif'
),
);