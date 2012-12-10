phpScraper
==========

A method that helps you extract information from a text (it can be an HTML page).

Methods:

**error()**

Return last error code
* 0 = no error
* 1 = can't read file

**filereset()**

Move pointer to begining

**fileread($file,$sleep=false,$usecurl=false)**

Read the text form an URL

* $file = URL
* $sleep = wait $sleep seconds between requests
* $usecurl = if true it uses the cURL library instead of file_get_contents()

**filefeed($text)**

Feed the text into the class

* $text = text to feed

**seekto($text)**

Search for the text and move the pointer after it

* $text = text to search

**getposition()**

Get current pointer position

**setposition($pos)**

Set pointer position. If the new value is greater than the text's length, nothing happens

* $pos = new pointer position

**getfile()**

Get current text

**search($text1,$text2,$text3,$dir='forward')**

Search for $text1, then search for $text2, and return the text between $text2 and $text3

* $text1 - search for this text from the current pointer position and move the pointer after it
* $text2 - search for this text next and move the pointer after it (this parameter can be '' and nothing will happen)
* $text3 - copy the text between the current pointer position and the beginning of $text3
* $dir - direction for the search for $text1

**istext($text)**

Search for $text and return true if it's found

**strip_diacritics($x)**

Strip some diacritic characters from $x. Returns result.

Example:
========

    <?php
    
      $a=new Parser();
      $a=fileread('http://somesite.com/somefile.html');
      $a->seekto('<div class="top">');
      do {
        $text=$a->search('<li>','','</li>');
        echo "$text<br/>";
      } while ($text!==false);
      
    ?>