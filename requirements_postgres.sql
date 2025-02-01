---admin

CREATE TABLE admin (
    aemail VARCHAR(255) PRIMARY KEY,       -- Admin email as the primary key
    apassword VARCHAR(255) DEFAULT NULL    -- Admin password
);

CREATE TABLE admin (aemail VARCHAR(255) PRIMARY KEY, apassword VARCHAR(255) DEFAULT NULL);

INSERT INTO admin (aemail, apassword) 
VALUES ('admin@docpoint.com', '123');




---appointment

CREATE TABLE appointment (
    appoid SERIAL PRIMARY KEY,                  -- Auto-incrementing primary key
    pid INT REFERENCES patient(pid) ON DELETE CASCADE,  -- Foreign key to patient table
    apponum INT DEFAULT NULL,                   -- Appointment number
    scheduleid INT REFERENCES schedule(scheduleid) ON DELETE CASCADE, -- Foreign key to schedule table
    appodate DATE DEFAULT NULL,                 -- Appointment date
    CONSTRAINT unique_patient_schedule UNIQUE (pid, scheduleid) -- Prevent duplicate appointments for the same patient and schedule
);

CREATE TABLE appointment (appoid SERIAL PRIMARY KEY,pid INT REFERENCES patient(pid) ON DELETE CASCADE,  apponum INT DEFAULT NULL,scheduleid INT REFERENCES schedule(scheduleid) ON DELETE CASCADE, appodate DATE DEFAULT NULL,CONSTRAINT unique_patient_schedule UNIQUE (pid, scheduleid) );

INSERT INTO appointment (appoid, pid, apponum, scheduleid, appodate) 
VALUES (1, 1, 1, 1, '2025-02-03');





---doctor

CREATE TABLE doctor (
    docid SERIAL PRIMARY KEY,                  -- Auto-incrementing primary key
    docemail VARCHAR(255) UNIQUE,             -- Doctor's email, must be unique
    docname VARCHAR(255) DEFAULT NULL,        -- Doctor's name
    docpassword VARCHAR(255) DEFAULT NULL,    -- Doctor's password
    docnic VARCHAR(15) DEFAULT NULL,          -- Doctor's national ID
    doctel VARCHAR(15) DEFAULT NULL,          -- Doctor's telephone
    specialties INT REFERENCES specialties(id) ON DELETE SET NULL -- Foreign key to specialties table
);

CREATE TABLE doctor (docid SERIAL PRIMARY KEY,docemail VARCHAR(255) UNIQUE,docname VARCHAR(255) DEFAULT NULL,docpassword VARCHAR(255) DEFAULT NULL,docnic VARCHAR(15) DEFAULT NULL,doctel VARCHAR(15) DEFAULT NULL,specialties INT REFERENCES specialties(id) ON DELETE SET NULL );


INSERT INTO doctor (docid, docemail, docname, docpassword, docnic, doctel, specialties) 
VALUES 
(1, 'doctor@docpoint.com', 'Test Doctor', '123', '000000000', '0110000000', 1);





---patient

CREATE TABLE patient (
    pid SERIAL PRIMARY KEY,           -- Auto-incrementing primary key
    pemail VARCHAR(255) UNIQUE,       -- Patient email, unique
    pname VARCHAR(255),               -- Patient name
    ppassword VARCHAR(255),           -- Patient password
    paddress VARCHAR(255) DEFAULT 'Not Provided', -- Patient address with default value
    pnic VARCHAR(15) UNIQUE,          -- Patient national ID, unique
    pdob DATE CHECK (pdob <= CURRENT_DATE), -- Date of birth, cannot be in the future
    ptel VARCHAR(15)                  -- Patient telephone
);

CREATE TABLE patient (pid SERIAL PRIMARY KEY,pemail VARCHAR(255) UNIQUE,pname VARCHAR(255),ppassword VARCHAR(255),paddress VARCHAR(255) DEFAULT 'Not Provided',pnic VARCHAR(15) UNIQUE,pdob DATE CHECK (pdob <= CURRENT_DATE),ptel VARCHAR(15));


INSERT INTO patient (pid, pemail, pname, ppassword, paddress, pnic, pdob, ptel) 
VALUES
(1, 'patient@docpoint.com', 'Test Patient', '123', 'Mumbai', '0000000000', '2000-01-01', '0120000000'),
(2, 'harshkorde05@gmail.com', 'Harsh Korde', '123', 'Pune', '0110000000', '2022-06-03', '0700000000');








---schedule

CREATE TABLE schedule (
    scheduleid SERIAL PRIMARY KEY,                  -- Auto-incrementing primary key
    docid INT NOT NULL,                             -- Doctor ID (assumes an integer ID for doctors)
    title VARCHAR(255) DEFAULT 'General Schedule', -- Title of the schedule with a default value
    scheduledate DATE,                              -- Scheduled date
    scheduletime TIME,                              -- Scheduled time
    nop INT DEFAULT 0 CHECK (nop >= 0),             -- Number of patients, must be non-negative
    CONSTRAINT fk_schedule_docid FOREIGN KEY (docid) REFERENCES doctor(docid) -- Foreign key to doctor table
);
CREATE TABLE schedule (scheduleid SERIAL PRIMARY KEY,docid INT NOT NULL,title VARCHAR(255) DEFAULT 'General Schedule', scheduledate DATE,scheduletime TIME,nop INT DEFAULT 0 CHECK (nop >= 0),CONSTRAINT fk_schedule_docid FOREIGN KEY (docid) REFERENCES doctor(docid));

-- Index for scheduledate to improve query performance
CREATE INDEX idx_scheduledate ON schedule (scheduledate);

INSERT INTO schedule (scheduleid, docid, title, scheduledate, scheduletime, nop) 
VALUES
(1, 1, 'Test Session', '2050-01-01', '18:00:00', 50),
(2, 1, 'Appointment with doctor 1', '2025-01-18', '20:36:00', 1),
(3, 1, 'Appointment with doctor for fever', '2025-02-15', '20:33:00', 1),
(4, 1, 'Appointment with doctor 1 -2', '2025-01-23', '12:32:00', 1),
(5, 1, 'Fever', '2025-02-01', '20:35:00', 1),
(6, 1, 'Cold', '2025-03-02', '20:35:00', 1),
(7, 1, 'OPD', '2025-01-24', '20:36:00', 1),
(8, 1, 'Tests', '2025-02-10', '13:33:00', 1);



---specialities

CREATE TABLE specialties (
    id SERIAL PRIMARY KEY,       -- Auto-incrementing primary key
    sname VARCHAR(50) UNIQUE DEFAULT 'General' -- Specialty name with uniqueness and default value
);

CREATE TABLE specialties (id SERIAL PRIMARY KEY,sname VARCHAR(50) UNIQUE DEFAULT 'General');

INSERT INTO specialties (id, sname) 
VALUES
(1, 'Accident and emergency medicine'),
(2, 'Allergology'),
(3, 'Anaesthetics'),
(4, 'Biological hematology'),
(5, 'Cardiology'),
(6, 'Child psychiatry'),
(7, 'Clinical biology'),
(8, 'Clinical chemistry'),
(9, 'Clinical neurophysiology'),
(10, 'Clinical radiology'),
(11, 'Dental, oral and maxillo-facial surgery'),
(12, 'Dermato-venerology'),
(13, 'Dermatology'),
(14, 'Endocrinology'),
(15, 'Gastro-enterologic surgery'),
(16, 'Gastroenterology'),
(17, 'General hematology'),
(18, 'General Practice'),
(19, 'General surgery'),
(20, 'Geriatrics'),
(21, 'Immunology'),
(22, 'Infectious diseases'),
(23, 'Internal medicine'),
(24, 'Laboratory medicine'),
(25, 'Maxillo-facial surgery'),
(26, 'Microbiology'),
(27, 'Nephrology'),
(28, 'Neuro-psychiatry'),
(29, 'Neurology'),
(30, 'Neurosurgery'),
(31, 'Nuclear medicine'),
(32, 'Obstetrics and gynecology'),
(33, 'Occupational medicine'),
(34, 'Ophthalmology'),
(35, 'Orthopaedics'),
(36, 'Otorhinolaryngology'),
(37, 'Paediatric surgery'),
(38, 'Paediatrics'),
(39, 'Pathology'),
(40, 'Pharmacology'),
(41, 'Physical medicine and rehabilitation'),
(42, 'Plastic surgery'),
(43, 'Podiatric Medicine'),
(44, 'Podiatric Surgery'),
(45, 'Psychiatry'),
(46, 'Public health and Preventive Medicine'),
(47, 'Radiology'),
(48, 'Radiotherapy'),
(49, 'Respiratory medicine'),
(50, 'Rheumatology'),
(51, 'Stomatology'),
(52, 'Thoracic surgery'),
(53, 'Tropical medicine'),
(54, 'Urology'),
(55, 'Vascular surgery'),
(56, 'Venereology');











---webuser

CREATE TABLE webuser (
    email VARCHAR(255) PRIMARY KEY,               -- Email as the primary key
    usertype CHAR(1) DEFAULT 'p',                 -- User type with a default value of 'p' (patient)
    CONSTRAINT check_usertype CHECK (usertype IN ('a', 'd', 'p')) -- Restrict usertype to 'a', 'd', or 'p'
);


CREATE TABLE webuser (email VARCHAR(255) PRIMARY KEY,usertype CHAR(1) DEFAULT 'p',CONSTRAINT check_usertype CHECK (usertype IN ('a', 'd', 'p')));

INSERT INTO webuser (email, usertype) 
VALUES
('admin@docpoint.com', 'a'),
('doctor@docpoint.com', 'd'),
('patient@docpoint.com', 'p'),
('harshkorde05@gmail.com', 'p');




-- pg_dump -U postgres -h localhost -d docpoint_ -f final_database.sql

-- sudo apt install php-pgsql