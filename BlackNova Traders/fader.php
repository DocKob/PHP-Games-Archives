<SCRIPT LANGUAGE="JavaScript1.2" TYPE="text/javascript">
<!--
/* Original script by Peter Belesis and Andy King. v1.01
# Copyright (c) 1999 internet.com Corp. All Rights Reserved.
# Under the GPL.
#
# Heavily modified for use in BNT by L. Patrick Smallwood.
*/

prefix=' ';

<?
$newspath = $gamepath."news.php";
$startdate = date("Y/m/d");
$res = $db->Execute("SELECT * from $dbtables[news] where date = '$startdate' order by news_id");

echo "arURL = new Array(";
if($res->EOF)
{

echo "\"$newspath\");";
}
else
{
  while (!$res->EOF)
  {
  $row = $res->fields;
  echo "\"$newspath\",";
  $res->MoveNext();
  }
echo "\"$newspath\");\n";
}

echo "arTXT = new Array(";
// Here is the php function to populate the javascript array.

$res = $db->Execute("SELECT * from $dbtables[news] where date = '$startdate' order by news_id");
if($res->EOF)
{
echo "\"$l_news_none\");";
}
else
{
  while (!$res->EOF) 
  {
  $row = $res->fields;
  echo "\"$row[headline]\",";
  $res->MoveNext();
  }
echo "\"end of news\");";
}
?>

document.write('<LAYER ID=fad1><\/LAYER>');
NS4 = (document.layers);
IE4 = (document.all);

FDRblendInt = 5; // seconds between flips
FDRmaxLoops = 20; // max number of loops (full set of headlines each loop)
FDRendWithFirst = true;

FDRfinite = (FDRmaxLoops > 0);
blendTimer = null;

arTopNews = [];
for (i=0;i<arTXT.length;i++)
{
 arTopNews[arTopNews.length] = arTXT[i];
 arTopNews[arTopNews.length] = arURL[i];
}
TopPrefix = prefix;

if(NS4)
{
	fad1 = document.fad1;
	fad1.visibility="hide";

	pos1 = document.images['pht'];
	pos1E = document.images['ph1E'];
	fad1.left = pos1.x;
	fad1.top = pos1.y;
	fad1.clip.width = 354;
	fad1.clip.height = pos1E.y - fad1.top;
}
else 
{
	document.getElementById('IEfad1').style.pixelHeight = document.getElementById('IEfad1').offsetHeight;
}

function FDRredo()
{
	if (innerWidth==origWidth && innerHeight==origHeight) return;
	location.reload();
}

function FDRcountLoads() 
{
	if (NS4)
	{
		origWidth = innerWidth;
		origHeight = innerHeight;
		window.onresize = FDRredo;
	}

    TopnewsCount = 0;
    TopLoopCount = 0;

    FDRdo();
	blendTimer = setInterval("FDRdo()",FDRblendInt*1000)
}

function FDRdo() 
{
    if (FDRfinite && TopLoopCount>=FDRmaxLoops) 
    {
		FDRend();
		return;
    }
	FDRfade();

	if (TopnewsCount >= arTopNews.length) 
	{
		TopnewsCount = 0;
		if (FDRfinite) TopLoopCount++;
	}
}

function FDRfade(){
	if(TopLoopCount < FDRmaxLoops) {
		TopnewsStr = "";
		for (var i=0;i<1;i++)
		{
			if(TopnewsCount < arTopNews.length) 
			{
			    TopnewsStr += "<P><A CLASS=headlines TARGET=_new "
							+ "HREF='" + TopPrefix + arTopNews[TopnewsCount+1] + "'>"
				            + arTopNews[TopnewsCount] + "</" + "A></" + "P>"
				TopnewsCount += 2;
			}
		}
		if (NS4) 
		{
			fad1.document.write(TopnewsStr);
			fad1.document.close();
			fad1.visibility="show";
		}
	    else 
	    {
	        document.getElementById('IEfad1').innerHTML = TopnewsStr;
	    }
	}
}

function FDRend(){
	clearInterval(blendTimer);
	if (FDRendWithFirst) 
	{
	    TopnewsCount = 0;
	    TopLoopCount = 0;
	    FDRfade();
	}
}

window.onload = FDRcountLoads;
//-->
</SCRIPT>


