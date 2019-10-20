# 1DV610 L3 - as223jc
### Project Startup
My project for the L3 assignment in the 1dv610 course, 'Introduktion till mjukvarukvalitet'.

###### *Features*
* Login as a user
* Register a new user
* Logged in view
* Simple chat/blog system
* Logout


## *Extended use cases*

### UC5. Authenticated user can read chat messages on home screen

### Preconditions
A user is authenticated. Ex. UC1, UC3

#### Main scenario
 * Starts when a user has logged in successfully and is on on home url/index
 * System presents available messages on home screen to the user


### UC6. Authenticated user can create a new chat message on home screen

### Preconditions
A user is authenticated. Ex. UC1, UC3

#### Main scenario
 * Starts when a user has logged in successfully and is on on home url/index
 * System presents available messages on home screen to the user
 * System presents a form to create a new message
 * User provides a title and a message
 * System validates title and message and stores in the database
 * User is redirected back to home screen and is presented with the message
 
#### Alternate Scenarios
  * 5a. Message is not valid, title or message is empty
   * 1. System presents an error message
   * 2. Step 3 in main scenario.
   
### UC7. Authenticated user can edit a chat message on home screen

### Preconditions
A user is authenticated. Ex. UC1, UC3

#### Main scenario
 * Starts when a user has logged in successfully and is on on home url/index
 * System presents available messages on home screen to the user
 * System presents option to edit message
 * User gets redirected to a page to edit selected message
 * System updates the previous message with new title and message
 
#### Alternate Scenarios
  * 5a. Message is not valid, title or message is empty
   * 1. System presents an error message
   * 2. Step 4 in main scenario.
   
### UC8. Authenticated user can delete a chat message on home screen

### Preconditions
A user is authenticated. Ex. UC1, UC3

#### Main scenario
 * Starts when a user has logged in successfully and is on on home url/index
 * System presents available messages on home screen to the user
 * System presents option to delete message
 * System deletes the message
 * User is redirected to home screen and message is deleted
 
#### Alternate Scenarios
  * 4a. User is not authenticated
   * 1. System presents an error message

