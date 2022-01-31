<?php

use Core\Routes;

Routes::get(route: '/', closure: function () {
	echo '<h1>Welcome</h1>';
});

Routes::post(route: '/', closure: function () {
	echo 'Welcome!';
});

Routes::post(route: '/welcome', action: 'WelcomeController@test_post');