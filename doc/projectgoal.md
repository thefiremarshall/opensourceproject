Health Insurance Manager
A web-based application that allows insurance holders to securely access and manage their medical history. Users can view records such as doctor visits, dental appointments, prescribed medications, diagnoses, and treatment plans. The system also supports role-based access for doctors and administrators to update records, ensuring real-time and accurate health data for each insured individual.

Main Features
Secure Login platform

Insurance claims used

Remaining Coverage Tracker

Details of medical visits:

Date

Healthcare provider

Symptoms

Prognosis

Prescribed medication

Treatment plans (if applicable)

Insurance Plan modification

Monthly insurance payments

Doctor access

Admin Dashboard

Scenarios
User: Insurance Holder
Purpose:
The user has recently moved residence and visited a clinic which is not yet connected to the platform. The medical practitioner is requesting information from the user’s last doctor visit. Users can log into the platform using a mobile web browser to access this information.

User: Doctor
Purpose:
A new patient has visited the clinic, and the doctor is about to carry out the examination and prognosis. The doctor can check the patient's medical history if available or create a new entry for the patient.

Technology Stack: PHP and MariaDB
PHP handles all server-side functionality in the Health Insurance Manager application, including:

User Login & Session Management
Secure login system using PHP sessions to maintain user roles (Insurance Holder, Doctor, Admin).

Database Interaction
PHP queries and updates the MariaDB database for medical records.

Role-Based Access Control
PHP ensures only authorized users can access or modify specific data (e.g., doctors updating records, admins managing plans).

Form Handling
All forms (e.g., new visit entries, insurance updates) are processed through PHP to ensure data integrity and security.

