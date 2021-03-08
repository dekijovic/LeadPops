## Test for LeadPos

API for Links

* Start by  command php artisan serve
* There is no database but there is two json data sets, users, and links
* First endpoint is /api/token where parameters "name" and "password" are passed (example "admin", "admin") and return token that lasts 10 minutes
* Links in storage/data/links.json are valid links that are going to work when called upon. If user want he needs to add new in order to work, otherwise it will get message not found.
* When called upon any link, it goes throught the jwt middleware where it validates provided jwt token
* Header format for jwt is " Authorization: Bearer $token"
* Example for url is "http://127.0.0.1:8000/one/one/one" that will return short url "s5g5h3y" and viceversa
