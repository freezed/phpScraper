<?php

  /* ERROR CODES: 0=no error; 1=can't read file */

  class parser {

    private $tmpx,$posx,$error;

    function error() {
      return $this->error;
    }

    function filereset() {
      $this->posx=0;
    }

    function fileread($file,$sleep=false,$usecurl=false) {
      $this->error=0;

      if (!$usecurl) {
        $this->tmpx=@file_get_contents($file);
        if (!$this->tmpx) $this->error=1;
      } else {

          $ch = curl_init();

          curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.835.202 Safari/535.1');
          curl_setopt($ch,CURLOPT_URL,$file);
          curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
/*
          $cookie_file="/tmp/cookies.txt";
          curl_setopt($ch,CURLOPT_COOKIEJAR,$cookie_file);
          curl_setopt($ch,CURLOPT_COOKIEFILE,$cookie_file);
*/
          $this->tmpx=curl_exec($ch);

          curl_close($ch);
        }

      $this->filereset();

      if ($sleep) sleep($sleep);
    }

    function filefeed($text) {
      $this->tmpx=$text;
      $this->filereset();
    }

    function seekto($text1) {
      $f1=strpos($this->tmpx,$text1,$this->posx);
      if ($f1!==false) {

        $this->posx=$f1+strlen($text1);
        return true;

      } else return false;
    }

    function getposition() {
      return $this->posx;
    }

    function setposition($pos) {
      if ($pos<strlen($this->tmpx)) {
        $this->posx=$pos;
        return true;
      } else return false;
    }

    function getfile() {
      return ($this->tmpx);
    }

    function search($text1,$text2,$text3,$dir='forward') { // $dir=forward ... first search forward / $dir=backward ... first search backward

      if ($dir=='forward') $f1=strpos($this->tmpx,$text1,$this->posx);
        else $f1=strrpos($this->tmpx,$text1,$this->posx);

      if ($f1!==false) {
		$nf=0;
        $this->posx=$f1+strlen($text1);
        if ($text2) {
          $f2=strpos($this->tmpx,$text2,$this->posx);
          if ($f2!==false) $this->posx=$f2+strlen($text2);
            else $nf=1;
        }
        if (!$nf) {
          $f3=strpos($this->tmpx,$text3,$this->posx);
          if ($f3!=false) $this->posx=$f3+strlen($text3);
            else $nf=1;
        }
      } else $nf=1;

      if ($nf) return (false);
        else {
          if (!$text2) $start=$f1+strlen($text1);
            else $start=$f2+strlen($text2);
          $end=$f3;
          return (substr($this->tmpx,$start,$end-$start));
        }

    }

    function istext($text) {

      return (strpos($this->tmpx,$text)!==false?true:false);

    }
  } // end parser

  function strip_diacritics($x) {

    $dfrom=array(
      "\xc3\xae","\xc3\x8e",
      "\xc5\xa3","\xc5\xa2",

      "\xc3\xab","\xc3\x8b",
      "\xc5\xa1","\xc5\xa0",
      "\xc5\xbc","\xc5\xbb",
      "\xc5\x82","\xc5\x81",

      "\x26\x23\x32\x35\x39\x3b",
      "\xe3",
      "\x26\x23\x32\x35\x38\x3b",
      "\xc3",
      "\xe2",
      "\xc2",
      "\x26\x23\x33\x35\x31\x3b",
      "\x26\x23\x33\x35\x30\x3b",
      "\x26\x23\x33\x35\x35\x3b",
      "\x26\x23\x33\x35\x34\x3b",
      "\xee",
      "\xce",
      "\x84", "\x93", "\x94", "\x61\x80\x9c", "\x61\x80\x9d", "\x61\x80\x9e",
      "\x61\x80\x98", "\x61\x80\x99", "\x92",
      "\x96", "\x61\x80\x22",
      "\x80\xa6", "\x85",
      "\x41\xab", "\x41\xbb",
      "\x41\xa2", "\x41\xa3", "\x41\xae", "\x41\x8e",
      "\xc4\x83", "\xc5\x9e", "\xc5\x9f", "\xc5\xa3",
      "\xfe"
    );

    $dto=array(
      "i","I",
      "t","T",

      "e","E",
      "s","S",
      "z","Z",
      "l","L",

      "a",
      "a",
      "A",
      "A",
      "a",
      "A",
      "s",
      "S",
      "t",
      "T",
      'i',
      'I',
      '"', '"', '"', '"', '"', '"',
      "'", "'", "'",
      '-', '-',
      '...', '...',
      '&lt;', '&gt;',
      "a", "a", "i", "I",
      "a", "S", "s", "t",
      "t"
    );

    return (str_replace($dfrom,$dto,$x));

  }

?>