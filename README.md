# Light framework aimed toward APIs
Only compatible with php >8.0
-
First, need to do a `composer install`.
- app - Contains Controllers and Models.
- controllers - The Controller is usually called by your Routes.
- models - Contains the Database logic for a table mostly called by Controller to get database informations or specific class methods.
- core - The core files of the framework.
- public - Where the magic is done.
- routes - Contain your routes, linked either to a function or a Closure.
- database - Contains migrations/ folder in which we can store the SQL files to migrate
------------
Manager
-
Is called with `php manager` -<br>
It's a kind of artisan like laravel uses, you can generate Models or Controllers (more to come).

The prototype is as followed :
`php manager @action @args[]`

Example Commands
-
Controller and Model commands automatically extends to default, a way to override will be done later.
<br>
*To create a new Controller*<br>
`php manager controller UserController`

*To create a new Model*<br>
`php manager model User`

*To add multiple routes to api.php at once (the method argument is case insensitive)*<br>
`php manager add_route GET,/home POST,/register,RegisterController@execute`
