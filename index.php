<?php

	include 'app.php';
	echo App::getBoilerplate();

?>	


<link rel="stylesheet" href="life.css" type="text/css" media="screen"/>
<script src="date.js"></script>
<script src="life.js"></script>


<h1>Life is Long</h1>

<form>
	Birthdate <input id="birthdate" type="text" value="1/29/1969" />
	Expectancy <input id="expectancy" type="text" value="79" />
	<input id="goBtn" type="submit" value="Go" />
</form>
<div id="life"></div>

<h1>Time&rsquo;s A-Wastin&rsquo;</h1>

	<label><input id="showDays" type="checkbox" /> Show Days</label>



<?php

	echo App::getBoilerplateClose();

?>