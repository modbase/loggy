<?php

Autoloader::directories(array(
	Bundle::path('loggy').'classes',
	Bundle::path('loggy').'config',
));

/*
AutoLoader::map(array(
	'Remote_Logger'	=> Bundle::path('loggy').'classes/remote_logger.php',
));
*/

Loggy::init();