<?php
require_once "config/options.php";
?>

<p>
	<?php echo $options['name']; ?>
	<br>
	HQ Number: <a href="tel:<?php echo $options['hq_number']; ?>"><?php echo $options['hq_number']; ?></a>
	<br>
	<span class="font-weight-bold">V2 (Alpha)</span>
</p>
