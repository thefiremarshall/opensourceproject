# Health Insurance Manager – Installation Instructions

These steps will help you set up and run the Health Insurance Manager application on a Raspberry Pi using Apache and PHP.

---

## 📦 Prerequisites

Install the necessary packages:


sudo apt update
sudo apt install apache2 mariadb-server php php-mysqli libapache2-mod-php git

🛠️ Clone the Project

cd /var/www/html
sudo git clone https://github.com/thefiremarshall/opensourceproject.git
sudo chown -R www-data:www-data opensourceproject

Optional (if needed):
sudo rm index.html  # Remove default Apache page

⚙️ Configure MariaDB

sudo systemctl start mariadb
sudo mysql_secure_installation

Log in and create your database

run command : sudo mariadb

Inside the MariaDB prompt:

CREATE DATABASE insurance_manager;
CREATE USER 'insurance_user'@'localhost' IDENTIFIED BY 'securepassword';
GRANT ALL PRIVILEGES ON insurance_manager.* TO 'insurance_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

customize however


🧩 Import the Database Schema

sudo mariadb -u insurance_user -p insurance_manager
< /var/www/html/opensourceproject/schema.sql

🔧 Configure Project Settings

edit the includes/db.php with the info you created above

Ensure Apache is running:

sudo systemctl start apache2

Please See Readme after this 