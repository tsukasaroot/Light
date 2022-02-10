<?php

use Core\Routes;
use Core\Http;

Routes::get(route: '/', closure: function () {
	Http::sendJson([ 'message' => 'Welcome' ]);
});

Routes::post(route: '/', closure: function () {
	Http::sendJson([ 'message' => 'Welcome' ]);
});

Routes::post(route: '/welcome', action: 'WelcomeController@test_post');