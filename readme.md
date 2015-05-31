

database unitesting



# Gamerest

Gamerest is a REST API for the game app "Ninja Golf 2: The revenge".

Our brave ninja play golf in the field of their enemies. It ss like an old 2D golf game, but our main character has to walk to the ball every time he hits it. In the way, he find enemies he has to defeat. As a part of the DLC, we could choose our main character to be a space marine. When the main character dies, he can continue playing as a zombie.


create table characters (
	id int unsigned not null primary key auto_increment,
	name varchar(50) not null,
	description varchar(100),
	type enum('ninja', 'space marine', 'zombie') not null default 'ninja',
	dead bool not null,
	stage int unsigned not null,
	hp int not null
);



# API REST

It only accept JSON. ID parameter will come with the URL, not
as a query string.

## HTTP Method allowed

GET			Get a character
POST		Create a character
PUT			Update a character
DELETE 		Remove a character


## Status code

200		Success
201		Success - new character created
400		Bad Request
401 	Unauthorized
404		Not found
422		Unprocessable Entity
500		Internal Server error
503		Service Unavailable


## Create a new character

[POST] Request /character

{
	"character": {
		"name": "Peter Akarisawa",
		"description": "The most incredible Ninja Golf player",
		"type": "ninja",
		"dead": true,
		"stage": 2,
		"hp": 0
	}	
}


Response
{
	"character": {
		"id": "23",
		"name": "Peter Akarisawa",
		"description": "The most incredible Ninja Golf player",
		"type": "ninja",
		"dead": true,
		"stage": 2,
		"hp": 0
	}	
}


## Retrieve a character

[GET] Request /character/23


Response
{
	"character": {
		"id": "23",
		"name": "Peter Akarisawa",
		"description": "The most incredible Ninja Golf player",
		"type": "ninja",
		"dead": true,
		"stage": 2,
		"hp": 0
	}	
}



## Update a character

[PUT] Request /character/

{
	"character": {
		"name": "Peter Akarisawa",
		"description": "The most incredible Ninja Golf player",
		"type": "ninja",
		"dead": true,
		"stage": 2,
		"hp": 0
	}	
}


Response
{
	"character": {
		"id": "23",
		"name": "Peter Akarisawa",
		"description": "The most incredible Ninja Golf player",
		"type": "ninja",
		"dead": true,
		"stage": 2,
		"hp": 0
	}	
}

## Remove a character

[DELETE] Request /character/23

{

}