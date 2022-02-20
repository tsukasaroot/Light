<?php

require '../vendor/autoload.php';

Core\Kernel::boot(function () {
	Core\Kernel::web();
});