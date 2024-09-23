Loan EMI Processing System
Project Overview
This Laravel project is an EMI Processing System that allows you to manage and calculate loan EMIs for clients. The system follows the repository and service pattern and includes the following features:

Loan Details Management: Create, display, and manage loan details including client ID, number of payments, first and last payment dates, and the total loan amount.
EMI Processing: Dynamically calculates and stores EMI payments per client based on the loan amount and number of payments.
EMI Display: Show the EMI breakdown per client in an accordion-style UI for better readability, only displaying months where a payment was made.
User Authentication: A login system that uses a username and password for authentication.
Database Integration: Loan and EMI data are stored and processed dynamically in the database using migrations and seeds.
Features
Dynamic EMI Table Generation: The system dynamically creates an emi_details table that calculates EMI based on client loan details.
Adjustable EMI Payments: The last EMI payment is adjusted to ensure the total matches the loan amount.
Clean UI with Bootstrap: EMI details are displayed in an accordion format for easy navigation.
Authentication System: Simple user login using username and password.
Database Seeding: Sample loan and user data are pre-seeded for quick setup.
Prerequisites
Before setting up the project, make sure you have the following installed:

PHP >= 8.0
Composer
MySQL (or any supported database)
Node.js and NPM (for Laravel Mix)
A web server (like Apache or Nginx)
Setup Instructions
1. Clone the repository

git clone https://github.com/piyushjaiswal7668/emi-processing.git
cd emi-processing

2. Install dependencies
Run the following commands to install the required PHP and Node.js dependencies:


composer install
npm install
npm run dev

3. Configure environment variables
Rename the .env.example file to .env and set your environment variables (such as database credentials) for the project:


cp .env.example .env
Generate the application key:


php artisan key:generate
Edit the .env file to configure your database:

makefile
Copy code
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
4. Run migrations and seed the database
Run the following command to create the necessary tables and seed the database with sample loan and user data:


php artisan migrate --seed
This will create two main tables:

loan_details: Contains loan information for each client.
users: Contains user authentication data (username: developer, password: Test@Password123#).
5. Serve the application
Start the local development server:


php artisan serve
The project will be available at http://localhost:8000.

Usage
1. Login
Navigate to the login page at http://localhost:8000/login.
Use the pre-seeded credentials:
Username: developer
Password: Test@Password123#
2. Loan Details Page
After logging in, you will be redirected to the Loan Details page. Here you can view the list of clients and their respective loan details, including:

Client ID
Number of Payments
First Payment Date
Last Payment Date
Total Loan Amount
3. EMI Processing
To process the EMI data:

Click the Process Data button, which dynamically creates the emi_details table.
The EMI breakdown will be calculated, and each client's EMI will be adjusted to ensure the total matches the loan amount.
You can view the EMI schedule for each client by expanding their corresponding section in the accordion.
4. EMI Details Accordion
The EMI details are displayed in a Bootstrap accordion:

Each Client ID is an accordion item that expands to show the client's EMI breakdown.
Months with no EMI payments are hidden, so you only see months where payments were made.
Technical Details
Project Structure
Models:
LoanDetail: Handles loan details.
EMIDetail: Handles EMI calculations (generated dynamically).
Controllers:
LoanDetailsController: Manages loan data, EMI processing, and displaying the results.
Views:
loan-details/index.blade.php: Displays the loan and EMI data in an accordion-style interface.
EMI Calculation Logic
The EMI is calculated as:

javascript
Copy code
EMI = Loan Amount / Number of Payments
The last EMI is adjusted to account for rounding issues to ensure the sum of all EMIs matches the total loan amount.

Database Schema
loan_details: Stores loan data, including the client ID, number of payments, first and last payment dates, and loan amount.
emi_details: This table is dynamically created to store EMI payment breakdowns for each client.
Screenshots
Loan Details Page

EMI Details Accordion

Future Enhancements
Add functionality to edit loan details.
Implement user roles and permissions.
Integrate with a real-time payment gateway for tracking actual EMI payments.
Add pagination and sorting for large datasets.
License
This project is open-source and licensed under the MIT License.

Credits
Developer: Piyush Jaiswal 
Special thanks to Bootstrap for the UI components.
