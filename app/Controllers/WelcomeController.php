<?php

namespace App\Controllers;
class WelcomeController extends Controller
{
	public function test_post(): bool
	{
		if (empty($this->request['welcome'])) {
			return $this->response([ 'error' => 'Argument not provided' ]);
		}
		
		return $this->response([ 'message' => 'received', 'input' => $this->request['welcome'] ]);
	}
}