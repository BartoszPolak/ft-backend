## To install project

- composer install
- configure database connection in the .env file
- php artisan migrate --seed

### ToDo next:
- Add layers to architecture (application, domain)
- Divide application into 3 main contexts:
  - User / Player - Player should be created when adding new User. This context also include Opponent model.
  - Cards - Storing, adding new cards, assignments of Cards to Player.
  - Duel / Game - Main part of application, representing all logic of a game.
- Add feature / functional tests for all API requests / endpoints
- Decide whether to use Eloquent or Doctrine
- Redesign FE regarding the data sent in each request
  - Plenty of unused information in requests
  - Unnecessary calls to endpoints after duel / game ended
  - User / Player stats not updated after duel / game ended
