# Prerequisites:
- Php 8: https://www.php.net/downloads.php
- NPM: https://nodejs.org/en/download
- xampp: https://www.apachefriends.org/download.html


# How to setup:
- Make sure that all pre-requisites are properly installled.
- Run xampp and start `Apache` and `MySQL`.
- Create a database named `registration-app`.
- Run the `registration-app.sql` query to create the necessary tables and insert the admin account (Running the query will also add the admin account).
    - Username: admin
    - Password: Password
- Clone the github repository and checkout to the develop branch using a terminal of your choice.
- Make sure that the .env file is updated and contains the correct data to be used by the app.
- Run `npm install`.
- Run `npm run dev`.
- Run `php artisan serve`.
- The app should now be accesible in the browser of your choice.
    - http://localhost:8000/login


# Note:
I wanted to use either homestead or sail/octane for the setup but was not able to due to the limitations of the current operating system installed in my local PC. I intend to reformat my PC after the exam and not before as it may cause a delay since I have to setup everything again from scratch and might not be able to finish the task on time.
