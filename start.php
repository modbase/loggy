<?php

Autoloader::directories(array(
	Bundle::path('loggy').'classes',
	Bundle::path('loggy').'config',
));

Loggy::init();