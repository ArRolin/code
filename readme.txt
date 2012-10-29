Digital Project Management Tool is a tool for developers who needs a planing tool, the basic idea is that you can manage your digital backlog and scrum board from one place. The only thing you need to do is to clone the code to your private server and setup the database. This project is no where close to final I'm just looking for feedback on the project at the moment.



1. Open "code\application\config\database.php" and change following.

	- Line 51 // CHANGE DATABASE TO YOUR HOST

		$db['default']['hostname'] = 'localhost';

	- Line 52  // CHANGE DATABASE TO YOUR USERNAME

		$db['default']['username'] = 'root';

	-  Line 53 // CHANGE DATABASE TO YOUR PASSWORD

		$db['default']['password'] = '';

	- Line 54 // CHANGE DATABASE NAME TO WHAT EVER YOU WAN'T

		$db['default']['database'] = 'agile';

2. Create a MySQL database

	If you didn't change the default values, just create a new database and name it "agile".


3. Open database.sql

	Copy and paste the code to your database.