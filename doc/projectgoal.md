Health Insurance Manager
A web-based application that allows insurance holders to securely access and manage their medical history. Users can view records such as doctor visits, dental appointments, prescribed medications, diagnoses and treatment plans. The system also supports role-based access for doctors and administrators to update records, ensuring real time and accurate health data for reach insured individuals.

The main features are as follows:
•	Secure Login platform
•	Insurance claims used.
•	Remaining Coverage Tracker
•	Details of medical visits
o	Date 
o	Healthcare provider
o	Symptoms 
o	Prognosis 
o	Prescribed medication
o	Treatment plans if applicable
•	Insurance Plan modification 
•	Monthly insurance payments
•	Doctor access
•	Admin Dashboard

Scenarios:
User: Insurance Holder
Purpose: User has recently moved residence has visited a clinic who is yet to have had access to the platform. The medical practitioner is requesting information from the user’s last doctor visit. Users can log into the platform using a mobile web browser to access this information. 


User: Doctor
Purpose: a new patient has visited the clinic, and the doctor is about to carry out his examination and prognosis. The Doctor can check the patients medical history if any or create a new entry for the patient  

PHP is used to handle all server-side functionality in the Health Insurance Manager. It manages user authentication, processes form submissions, interacts with the MariaDB database, and enforces role-based access. Key uses include:

User Login & Session Management – Secure login system using PHP sessions to maintain user roles (Insurance Holder, Doctor, Admin).
Database Interaction – PHP queries and updates MariaDB for medical records
Role-Based Access Control – PHP ensures only authorized users can access or modify specific data (e.g., doctors updating records, admins managing plans).
Form Handling – All forms (e.g., new visit entries, insurance updates) are processed through PHP to ensure data integrity and security.

