<?php

namespace App\Controllers;
use App\Models\Users;

class WelcomeController extends Controller
{
	public function test_post(): bool
	{
		if (empty($this->request['welcome'])) {
			return $this->response(['error' => 'Argument not provided'], 404);
		}
		$user = new Users();
		return $this->response(['message' => 'received', 'input' => $this->request['welcome']]);
	}
}