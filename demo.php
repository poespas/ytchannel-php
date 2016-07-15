<form action="" method="post">
  Input:
  <input type="text" name="input" value="">
  <br />
  <input type="submit" value="Submit">
</form>
<?php
if (isset($_POST['input'])) {
	include_once('ytApi.php');
	$channel = channel($_POST['input']);

	echo "<p>The name of the channel is <b>" . $channel['author']['name'] . "</b></p>";

	echo "<p>The last 15 videos are: </p>";

	foreach ($channel['videos'] as $vid) {
		echo '<p><b><a href="' . $vid['url'] . '">' . $vid['title'] . '</a><b></p>';
	}
}
else {
	echo '<p>Enter a input please, <p>';
	echo '<p>Example strings are: <b>https://www.youtube.com/user/YouTube</b></p>';
	echo '<p>Or <b>UCBR8-60-B28hp2BmDPdntcQ</b></p>';
}
