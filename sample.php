<?php
/*
 * sample.php
 *
 * Sample file for using phpScraper (https://github.com/pandronic/phpScraper)
 *
 * auteur:		https://github.com/freezed <freezed at zind dot fr>
 * version:	0.1
 * MaJ:
 * Changelog:
 *
 * [TODO]
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 */

/*
 * Config
 */

$target		= 'http://www.debian.org/News/2013/';
$content	= array();
$html		= '';


/*
 * Scraping
 */

include('phpScraper.php');
$a=new Parser();
$a->fileread($target);
$a->seekto('<h1>News from 2013</h1>');

do {
	$text=$a->search('">','','</a></strong><br>');

	if ($text!==false) {
		$content[] = $text;
	}
} while ($text!==false);

/*
 * Format
 */

foreach($content as $element) {
	 $html .= '<li>'.$element.'</li>'.PHP_EOL;
}


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO-8859-1" />
        <title>phpScraper Sample</title>
    </head>

    <body>
		<h1>phpScrapper sample file</h1>
		<p>Sample on url: <a href="<?php	echo $target; ?>"><?php	echo $target; ?></a></p>
		<ul>
<?php	echo $html;	?>
		</ul>

    </body>
</html>

