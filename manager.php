<?php

if (count($argv) < 3) {
	echo "Not enough arguments";
	die();
}

function make_controller($name)
{
	file_put_contents('app/Controllers/' . $name . '.php', <<<EOF
		<?php
		
		namespace App\Controllers;
		class $name extends Controller
		{
		
		}
		EOF
	);
}

function make_model($name)
{
	file_put_contents('app/Models/' . $name . '.php', <<<EOF
		<?php
		
		namespace App\Models;
		
		use Core\Model\Model;
		class $name extends Model
		{
			protected string \$table = '';
		}
		EOF
	);
}

function add_route($argv)
{
	for ($i = 2; $i < count($argv); $i++) {
		$array = explode(',', $argv[$i]);
		$comment = '';
		
		if (count($array) === 2)
			$array[2] = "closure: function () {}";
		else
			$array[2] = "action: '" . $array[2] . "'";
		$array[0] = strtolower($array[0]);
		
		if (count($array) === 4)
			$comment = "\n/* $array[3] */";
		
		file_put_contents('routes/web.php', <<<EOF
			$comment
			Routes::$array[0](route: '$array[1]', $array[2]);
			EOF
			, FILE_APPEND | LOCK_EX);
	}
}

$call = $argv[1];

switch ($call) {
	case 'controller':
		make_controller($argv[2]);
		break;
	case 'model':
		make_model($argv[2]);
		break;
	case 'add_route':
		add_route($argv);
		break;
}