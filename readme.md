
Quizá cambiar find por select

Check always integrity of data given. Not done.

Models are the ones that throw exceptions and Controllers catch them.

Check if the Exception should be in the documentation.

Where is validated the whole json??? Before and after.

Chose to use the model in a static way


# Gamerest

Gamerest is a REST API for the game app "Ninja Golf 2: The revenge".

Our brave ninja play golf in the field of their enemies. It is like an old 2D golf game, but our main character has to walk to the ball every time he hits it. In the way, he find enemies he has to defeat. As a part of the DLC, we could choose our main character to be a pirate. When the main character dies, he can continue playing as a zombie.

The game consist in 10 stages. We only sync data when the character finish the stage, or when it dies. In the database, every character will count with this columns:

"name": The name of the character
"description": Short description to make the player personalise a little their characters
"type": The types are ninja, pirate or zombie. To be zombie it has to be dead.
"dead": False or true.
"stage": Last stage the character reached.
"hp": Hit points that the character has last time.


## Tests

Details of testing database are in /test/config/database_test.php and real database in /app/config/database.php . We are not using the app in production so at the momment they are the same.

In most cases I find that document unit test is redundant because the functions are already documented and the test should be clear enough. I also try to maximise the semantic and legibility of my code, so the code explain itself and don't need too much documentation. 

I am doing tests with database assuming some data inside. This data is inserted with the lines of mysql at the beginning of this file. I know Unit Test shouldn't rely on a database, but since I cannot use other packages that provides me more professional testing with databases, I was forced to do that.

Regarding testing private methods: I am not doing that because it would break encapsulation. And all of those are part of a public one that is tested.




## Database

CREATE TABLE characters (
	id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(50) NOT NULL,
	description VARCHAR(100),
	type ENUM('ninja', 'pirate', 'zombie') NOT NULL DEFAULT 'ninja',
	dead bool NOT NULL,
	stage INT UNSIGNED NOT NULL,
	hp INT NOT NULL
);

INSERT INTO characters (name, description, type, dead, stage, hp) 
VALUES ('Lion Woods', 'A wonderful zombie that plays golf better than Tiger Woods', 'zombie', true,  2,  67);

INSERT INTO characters (name, description, type, dead, stage, hp) 
VALUES ('Guybrush Threepwood', 'How appropriate. You fight like a cow', 'pirate', false,  5,  100);

INSERT INTO characters (name, description, type, dead, stage, hp) 
VALUES ('Peter Akarisawa', 'The greatest cyborg samurai golf player', 'ninja', false,  1,  45);



## API REST

ID parameter will come with the URL, not as a query string.

## HTTP Method allowed

GET			Get a character
POST		Create a character
PUT			Update a character
DELETE 		Remove a character


All of the four are idempontent except POST.

## Status codes

200		Success
201		Success - new character created
400		Bad Request
401 	Unauthorised
404		Not found
422		Unprocessable Entity
500		Internal Server error
503		Service Unavailable


## Retrieve a character

[GET] Request /character/23


Response
{
	"character": {
		"id": "23",
		"name": "Peter Akarisawa",
		"description": "The greatest cyborg samurai golf player",
		"type": "ninja",
		"dead": "false",
		"stage": "1",
		"hp": "45"
	}	
}



## Create a new character

[POST] Request /character/

{
	"character": {
		"name": "Peter Akarisawa",
		"description": "The greatest cyborg samurai golf player",
		"type": "ninja",
		"dead": "false",
		"stage": "1",
		"hp": "45"
	}	
}


Response
{
	"character": {
		"id": "23",
		"name": "Peter Akarisawa",
		"description": "The greatest cyborg samurai golf player",
		"type": "ninja",
		"dead": "false",
		"stage": "1",
		"hp": "45"
	}	
}


## Update a character

[PUT] Request /character/23

{
	"character": {
		"name": "Peter Akarisawa",
		"description": "The greatest cyborg samurai golf player",
		"type": "ninja",
		"dead": "false",
		"stage": "1",
		"hp": "45"
	}
}


Response
{
	"character": {
		"id": "23",
		"name": "Peter Akarisawa",
		"description": "The greatest cyborg samurai golf player",
		"type": "ninja",
		"dead": "false",
		"stage": "1",
		"hp": "45"
	}	
}

## Remove a character

[DELETE] Request /character/23

{

}


## Check the integrity of the data

Commment out the error activators

## Request is handling response

## Things that remain to do

There are some things that I have not done, for the sake of timing with this exercise.

- Improving the status code. At the momment I am assuming that only error that a SELECT query could throw is a "404 not found" for example. That is obviously not that simple. I would have use try catch in PDO queries and check which errors should return which status codes. 

- I wanted to do a Response class. It would handle some parts done from the request. It would help to handle the StatusCodeExceptions better.

- I had finished the Validation class. It should validate every single piece of data of the request. And check if all the character data is within the ranges. Now is not implemented and if we send a POST with no json, we won't get a proper status code. The function isCharacter withing the class would solve this.