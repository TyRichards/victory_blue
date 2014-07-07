<?php
include("variables.sl.php");
include("top-nav.php");
?>
<div class='wrap'>
<!--h2>About Lots of Locales (LoL) Store Locator Plugin</h2><br-->
<?php

//print "<span style='font-size:14px; font-family:Helvetica'>";
ob_start();
include('readme.txt');
$txt=ob_get_contents();
ob_clean();
//print ereg_replace("(http://.*\..*\..{2,3}\n)", "<a href='\\1' target='_blank'>\\1</a>", $txt);
//$txt=ereg_replace("(http://www.viadat.com)", "<a href='\\1' target='_blank'>\\1</a>", $txt);


//$txt=ereg_replace("( \=\=\r\n)([[:space:]*[:alnum:][:punct:]^(\r\n\=\=\ )]+)(\r\n\=\= )","\\1<div class='moyo'>\\2</div>\\3", $txt);

$txt=ereg_replace("\=\=\= ", "<h2>", $txt);
$txt=ereg_replace(" \=\=\=", "</h2>", $txt);
//$txt=ereg_replace("\=\= ", "<div id='wphead' style='color:black; background: -moz-linear-gradient(center bottom, #D7D7D7, #E4E4E4) repeat scroll 0 0 transparent'><h1 id='site-heading'><span id='site-title'>", $txt);
$txt=ereg_replace("\=\= ", "<table class='widefat' ><thead><th style='font-size:150%; font-weight:bold;'>", $txt);
$txt=ereg_replace(" \=\=", "</th></thead></table>", $txt);
$txt=ereg_replace("\= ", "<strong>", $txt);
$txt=ereg_replace(" \=", "</strong>", $txt);

//$txt=ereg_replace("\[(.*)\]\((a-z\.\:\/)\)", "<a href='\\2'>\\1</a>", $txt);
//$txt=do_hyperlink($txt);

//creating hyperlinks on top of labeled URLs (ones preceded w/a label in brackets)
$txt=ereg_replace("\[([a-zA-Z0-9_/?&amp;\&\ \.%20,=-\+-]+)*\]\(([a-zA-Z]+://)(([.]?[a-zA-Z0-9_/?&amp;%20,=-\+-]+)*)\)", "<a onclick=\"window.parent.open('\\2'+'\\3');return false;\" href=\"#\">\\1</a>", $txt);

//converting asterisked lines into HTML list items
$txt=ereg_replace("\*[ ]?[ ]?([a-zA-Z0-9_/?&amp;\&\ \.%20,=-\+-\(\)\`\'\<\>\"\#\:]+)*(\r\n)?", "<li style='margin-left:15px; margin-bottom:0px;'>\\1</li>", $txt);

//$txt=ereg_replace("\[(.*)\]\(([a-zA-Z]+\://[.]?[a-zA-Z0-9_/?&amp;%20,=-\+-])*\)", "<a href=\"\\2\" target=_blank>\\1</a>", $txt);

//creating hyperlinks out of text URLs (which have 'http:' in the front)
$txt=do_hyperlink($txt, "'_blank'", "protocol");

print nl2br($txt);
//print "</span>";

?>
</div>