<?php

use Core\Routes;
use Core\Http;
use Core\Token;

Routes::post(route: '/renew_token', closure: function () {
	$token = new Token();
	$auth_key_is_activated = apache_request_headers()['auth-token'] ?? '';
	$token->renewToken($auth_key_is_activated);
});

Routes::get(route: '/', closure: function () {
	Http::sendJson([ 'message' => 'Welcome' ]);
});

Routes::post(route: '/', closure: function () {
	Http::sendJson([ 'message' => 'Welcome' ]);
});

Routes::post(route: '/welcome', action: 'WelcomeController@test_post');