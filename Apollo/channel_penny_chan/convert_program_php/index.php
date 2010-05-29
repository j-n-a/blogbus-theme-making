<?php header('Content-type: text/plain; charset=UTF-8', true); ?>
<?php
include('xml.php'); // include the PHP XML Library

/* 
 * Please confirm the following 3 values are what you want.
 *
 * ------------------------------------------------------------------
 * $filename	| The name of your export file from Blogbus
 * -------------+----------------------------------------------------
 * $allowtag	| true: convert tags to categories
 *		| false:  all posts will be "Uncategorized"
 * -------------+----------------------------------------------------
 * $allowexcerpt| true: Excerpt of your old blog will be convert.
 * 		| false: dont not convert excerpt.
 * ------------------------------------------------------------------
 */

$filename = 'blogbus.xml';
$allowtag = true;
$allowexcerpt = true;

set_magic_quotes_runtime(0);
$datalines = file($filename);
$data = implode('', $datalines); // squish it
$data = str_replace(array ("\r\n", "\r"), "\n", $data);
$data = XML_unserialize($data);
$s_sep = "-----\n";
$l_sep = "--------\n";
$logs = $data['BlogBusCom']["Log"];

foreach ($logs as $log)
{
	echo 'TITLE: ' . $log['Title'] . "\n";
	echo 'AUTHOR: ' . $log['Writer'] . "\n";
	echo 'DATE: ' . $log['LogDate'] . "\n";
	echo 'STATUS: ' . (($log['Status'])?'publish':'draft') . "\n";
	echo 'ALLOW COMMENTS: ' . (($log['AllowComment']=="Y")?'1':'0') . "\n";
	echo 'ALLOW PINGS: ' . (($log['AllowPing']=="Y")?'1':'0') . "\n";

	if ($allowtag)
	{
		$tags = split(" ", $log['Tags']);
		foreach ($tags as $tag)
			echo 'CATEGORY: ' . $tag . "\n";
	}
	else
		echo 'CATEGORY: Uncategorized' . "\n";

	echo $s_sep;
	echo "BODY:\n";
	echo $log['Content'] . "\n";
	echo $s_sep;
	if ($allowexcerpt)
	{
		echo "EXCERPT:\n";
		echo $log['Excerpt'] . "\n";
	}

	if ($log['Comments'])
	{
		echo $s_sep;
		if ($log['Comments']['Comment']['0'])
			$cmts = $log['Comments']["Comment"];
		else
			$cmts = $log['Comments'];
		foreach ($cmts as $cmt)
		{
			echo 'COMMENT:' . "\n";
			echo 'AUTHOR: ' . $cmt['NiceName'] . "\n";
			echo 'EMAIL: ' . $cmt['Email'] . "\n";
			echo 'URL: ' . $cmt['HomePage'] . "\n";
			echo 'IP: ' . $cmt['PostIP'] . "\n";
			echo 'DATE: ' . $cmt['CreateTime'] . "\n";
			echo $cmt['CommentText'] . "\n";
			echo $s_sep;
		}
	}

	/* Since WP doesn't support trackback importing, 
	 * following code are comment out as to keep 
	 * WP from adding trackback entries to the last 
	 * comment entry.
	
	if ($log['TrackBacks'])
	{
		if ($log['TrackBacks']['TrackBack']['0'])
			$tbs = $log['TrackBacks']["TrackBack"];
		else
			$tbs = $log['TrackBacks'];
		foreach ($tbs as $tb)
		{
			echo 'PING:' . "\n";
			echo 'TITLE: ' . $tb['RemoteTitle'] . "\n";
			echo 'URL: ' . $tb['RemoteURL'] . "\n";
			echo 'IP: ' . $tb['RemoteHost'] . "\n";
			echo 'BLOG NAME: ' . $tb['RemoteBlogName'] . "\n";
			echo 'DATE: ' . $tb['CreateTime'] . "\n";
			echo $tb['RemoteExcerpt'] . "\n";
			echo $s_sep;
		}
	}
	 */

	echo $l_sep;
}
?>
