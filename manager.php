<?php

if (count($argv) != 3)
{
	echo "Not enough arguments";
	die();
}

function make_controller($name)
{
	file_put_contents('app/Controllers/' . $name . '.php',<<<EOF
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
	file_put_contents('app/Models/' . $name . '.php',<<<EOF
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

$call = $argv[1];

switch ($call) {
	case 'controller':
		make_controller($argv[2]);
		break;
	case 'model':
		make_model($argv[2]);
		break;
}