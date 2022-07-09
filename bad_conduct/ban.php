<?php
 /**
 *
 * BAD BEHAVIOR BLOCK
 *
 * 
 * Bad behavior block doesn't just block Hackers trying to use injections on your database
 * It's meant to target Brute Force and XSS Hack Attacks from bots which overload a Web site
 *
 * ATTACKS on systems from hackers on the Internet pose a serious risk to businesses
 * Simple but effective - Bad Behavior Block can stop hack attempts
 * 
 * @author Debs Halverson, D.A.S.
 * @package Ban /BAD BEHAVIOR BLOCK
 * @license http://www.opensource.org/licenses/gpl-2.0.php GNU Public License
*/
  $filename = '../.htaccess';
  if ($fp = fopen($filename, 'a')) {
      if (flock($fp, LOCK_EX)) {
          $remote_addr = $_SERVER['REMOTE_ADDR'];
          fwrite($fp, "deny from $remote_addr\n");
      }
      flock($fp, LOCK_UN);
      fclose($fp);
  }
  $predation = $_SERVER['REQUEST_URI'];
  $stamp = date("d-m-y / H:i:s");
  $arranged = $stamp . " - " . $remote_addr . " - " . $predation . "<br />";
  $fopen = fopen("data.html", "a");
  fwrite($fopen, $arranged );
  fclose($fopen);
  
  header('HTTP/1.1 403 Forbidden');
  echo "Forbidden!<br><h1>403 Permission Denied</h1><br><br><font face=Verdana, Arial><b>Your IP is banned or file is forbidden</b></font>
<h3>You do not have permission for this request</h3>
<div align=\"center\"><table border=\"1\" width=\"95%\" cellspacing=\"4\" cellpadding=\"5\" style=\"border-collapse: collapse\">
	<tr>
		<td>
		
		<p align=\"center\"><b><font style=\"font-size: 15pt\">Request Validation has detected a potentially dangerous client input value, and processing of the request
has been aborted</font></b></p>
<ul>
	<li>This value may indicate an attempt to compromise our server security, 
such as a cross-site scripting attack.</li>
	<li>Please do not be alarmed: it is possible the suspected attempt was triggered innocently.</li>
	<li>Additionally, we will log your IP address, your request, and the date and time. This information is recorded for security purposes only.</li>
	<li>These disclosures may also be needed for data privacy or to investigate or respond to a complaint or security threat. </li>
</ul>
		
		<h4>We do not claim any ownership of the content collected. This is done for purposes such as 
		diagnosing service or technical problems, and maintaining server 
		security.</h4>
		
		</td>
	</tr>
</table>
</div>";
  exit();
?>