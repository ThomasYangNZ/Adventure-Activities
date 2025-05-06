# Adventure Activities
Websites along with their database connections can be a complex endeavour, especially when tied in with dynamic user inputs. This project demonstrates understanding of full-stack capabilities by coordinating database schema, server-side logic, and responsive front-end behaviour. User authentication has been implemented as well as permission control via separate database connections and prepared SQL statements mitigate the risk of malicious attacks such as SQL injection. 

![Gif of homepage](images/homePageAdventureActivities.gif)
*Homepage of Adventure Activities*

## NOTE
The database has been included with this project to allow for users to properly explore its functionality note that ALL data within the database is made up and any likeness to any actual individuals or people are entirely coincidental. All passwords are also not actual passwords and were generated using random string generators.

Also another thing, I realise that while having seperate adminconnection.php and memberconnection.php is great, it makes things a little complicated if you yourself want to give the code a go! So I've just commented it out and set all the *connection.php to a default root user with no password. This should allow even a clean install of XAMPP to work!

## So What Technical Aspects Does This Project Have?
This project has many technical aspects and is reflected across multiple displines, some of the aspects are listed below!
### Backend (PHP + MySQL)
- Modular includes for head/footer/shared logic
- Separation of concerns via connection files based on user permissions
- Role checks on every page before content loads (Utilised by $_SESSION)
- Form processing done via process_edits.php, not directly on user facing pages
- mysqli_* functions for querying the MySQL database
- Multiple joins for pulling normalized data from related tables e.g., trips, users, triptypes, difficulties, permissions
- Separate tables for users, trips, triptypes, difficulties, and permissions
- Use of foreign keys for relationals e.g., TripTypeId, DifficultyId, UserId
### Frontend (HTML + CSS + JavaScript)
- Semantic HTML with \<form\>, \<select\>, and \<input\> tags for structured data entry
- Dynamic trip info loading to asynchronously update trip details when a user selects a different trip type
- Form options auto-update DOM elements like days, difficulty, and price on the fly without reloading.
### Security Features
- Users are validated using $_SESSION variables to control access based on permission levels like Public, Member, Trip Leader, and Admin
- PHP includes e.g., publicconnection.php, memberconnection.php, etc. limit database access based on roles, preventing unauthorized edits or views
- Used secure SQL queries to prevent risk of SQL injection e.g., mysqli_prepare, mysqli_stmt_bind_param
- Input sanitization and validation by using trim() and other error checking
### Project Structure / Modularity
- *includes/* folder contains connection files, reusable components, and fetch logic to provide a more modular touch
- Head and footer are require()d into every page, promoting DRY (Don’t Repeat Yourself) code practices
## Possible Improvements
There are however some improvements I would make to this project. Of course there is the typical "It straight up looks like something an amateur would do, some pages don't have proper error messages, why does page x send me to y etc" which is still valuable feedback, but I'd like to highlight specific, actionable issues which are relatively more important, and possible ways to solve them.
### Backend
- Database schema may be a great source of frustration, this is because trips and triptypes are two seperate tables. For a Tour Operator who solely runs multiple of the same trips (for example hiking, guided tours of towns etc) with no changing details such as price, duration or so on, this database schema allows for creating multiple of the same trips easily. However, if you are a Tour Operator who runs variations of trips or offers trips with changing variables (so for example, sunrise walks as times of sunrise varies throughout the year) then this database schema would require you to create a new trip type every time a variable changes. A fix to this would be to remove triptypes entirely and have a single trip table that inherits all of triptypes columns.
### Frontend
- A very bad practise I did was setting CSS values as hardcoded values (yes even the %'s are bad). A fix to this would be to use @media for CSS. This allows for resizing of elements when certain conditions are meant. And also, this would be the way to go if you want to have the webpages computer and mobile friendly!
- The use of HTML + CSS + Javascript is not as popular anymore, potentially looking into more modern stuff like React would be better for the long term. But at the end of the day, I used HTML + CSS + Javascript, cause React and its corresponding stuff is built ontop of the old! And it's good in my opinion to at least have an understanding of how it use to be done!
- Having inserted Javascript in the webpages themselves works...But in all respect I really should have modularised it further and put all Javascript in an acompanying js folder
### Security
- Added Content Security Policy (CSP) would be helpful as it restricts what type of Javascript, CSS, and images can be loaded. Specifically, we can set it so that only scripts from our own domain is trusted which in turn blocks malicious inline or external scripts, even after injection
- Regenerating session IDs after login would also be helpful. This means any existing session ID, when the user logs in, will be replaced. This prevents attackers from reusing any existing user session IDs
- Adding CSRF tokens to forms would help prevent third parties from submitting requests on behalf of logged in users as the server can verify the token upobn every form submission

## How To Run
Due to the use of PHP, we must simulate a web server to run it correctly. For the purposes of this design I used XAMPP (it's free and open source!). Follow the steps below to get your copy of the project running!

1. Locate *xampp/htdocs* directory and insert the project folder *(by default it is called Adventure-Activities-main)* in there
2. Open XAMPP Control Panel and locate under Module *"Apache"* and *"MySQL"*. Push the corresponding *"Start"* button for both modules.
3. Go into a browser of your choosing and type inside the URL bar: *localhost/phpmyadmin*
4. Under the phpMyAdmin logo on the left side of your screen click on the word "New" to create a new database and call it "yangth_assessmentdb"
5. After creating the database, click on the *Import* button inbetween *Export* and *Operations* at the top of your screen
6. Under the *File to import:* section, click *Browse...* and locate and select the *yangth_assessmentdb.sql* (File path should be *xampp/htdocs/Adventure-Activities-main/yangth_assessmentdb.sql*
7. Scroll to the bottom of the page and push the *"Import"* button.
8. Upon successful import, go into a browser of your choosing and type inside the URL bar: *localhost/Adventure-Activities-main* and your good!

## User Credentials
Once again, these users are fictitious. They do not reflect real users. That being said, below is their usernames and passwords so the login feature can be tested. Also, usernames and passwords are on index.php as well!

| *Username*      | *Password* |
| ----------------- | ----------------- |
| admin      | -w#f?J6bjPRe,H6U       |
| trip_leader_1   | r$3s!5ZFeeWzxwfe        |
|  trip_leader_2  |    XWc#5Z_p6PAbj4:-   |
|   trip_leader_3 |    g~v8.@pSnP?)"yf7   |
|    member_1  |  R!-zSKnqpJ!4kk^5  |
|     member_2 |  36s^3CG+w=Kbpbsq |


