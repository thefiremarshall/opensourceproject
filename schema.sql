CREATE TABLE Insurance_Plan (
    plan_id INT AUTO_INCREMENT PRIMARY KEY,
    plan_name VARCHAR(50) not null unique,
    monthly_fee decimal,
    coverage_limit decimal,
    refund_amount decimal
);
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    role ENUM('patient', 'doctor', 'admin') NOT NULL,
    plan_id int null,
    coverage_used decimal,
    Foreign key (plan_id) references Insurance_Plan(plan_id)
);


create table claims (
    claim_id int  AUTO_INCREMENT PRIMARY KEY,
    user_id int not null,
    amount decimal not null,
    date_submitted date not null,
    status varchar(20) default 'Pending',
    foreign key (user_id) references users (user_id)
);

create table visits(
    visit_id int AUTO_INCREMENT PRIMARY KEY,
    user_id int not null,
    foreign key (user_id) references users (user_id),
    doctor_id int not null,
    foreign key (doctor_id) references users (user_id),
    visit_date date not null,
    symptoms text not null,
    diagnosis text not null,
    treatment_plan text not null,
    visit_cost decimal not null
);
-- creates admin with password as open1234
INSERT INTO users (username, password_hash, full_name, role)
VALUES (
  'admin',
  '$2y$10$7kiWf2Ht50b6tFiMp0uc9e5dVLZrNCYeYT44.bz1NTr2xVZUqMNFi',
  'John Doe',
  'admin'
);

insert into Insurance_Plan (plan_name, monthly_fee, coverage_limit, refund_amount)
VALUES (
    'Standard',
    100,
    3000,
    80
);

insert into Insurance_Plan (plan_name, monthly_fee, coverage_limit, refund_amount)
VALUES (
    'no plan',
    0,
    0,
    0
);