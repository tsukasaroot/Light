# Light framework aimed toward APIs
Only compatible with php >8.0
-
First, need to do a `composer install`.
- app - Contains Controllers and Models.
- Controllers - The files called by your Routes.
- Models - Contains the Database logic for a table.
- Core - The core files of the framework.
- public - Where the magic is done.
- routes - Contain your routes, linked either to a function or a Closure.
------------
Manager
-
Is called with `php manager.php` -<br>
It's a kind of artisan like laravel uses, you can generate Models or Controllers (more to come).

The prototype is as followed :
`php manager.php @action @args[]`

Example Commands
-
Controller and Model commands automatically extends to default, a way to override will be done later.
<br>
*To create a new Controller*<br>
`php manager.php controller UserController`

*To create a new Model*<br>
`php manager.php model User`

*To add multiple routes to api.php at once (the method argument is case insensitive)*<br>
`php manager.php add_route GET,/home POST,/register,RegisterController@execute`