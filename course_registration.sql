-- -----------------------------
-- Create the database if it does not exist
-- -----------------------------
CREATE DATABASE IF NOT EXISTS login_system;

-- -----------------------------
-- Switch to the created database
-- -----------------------------
USE login_system;

-- -----------------------------
-- Create a table to store login credentials
-- ID → auto-increment primary key
-- Username → unique, not null
-- Password → not null
-- -----------------------------
CREATE TABLE login_credentials (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(20) NOT NULL
);

-- -----------------------------
-- Insert sample users into login_credentials table
-- Rules for redirection:
-- Username starting with '1' → redirects to linkpage1.html
-- Username starting with 'n' → redirects to linkpage2.html
-- Username starting with 'h' → redirects to linkpage6.html
-- -----------------------------
INSERT INTO login_credentials (Username, Password) 
VALUES ('1NC22CS001', '01-01-2004');

INSERT INTO login_credentials (Username, Password) 
VALUES ('ncetuser', '15-05-2003');

INSERT INTO login_credentials (Username, Password) 
VALUES ('hod123', '10-08-1985');

-- -----------------------------
-- Create a table to store course registration details
-- USN → primary key
-- Student_Name → not null
-- Registered_Date → not null
-- Elective → not null
-- Counsellor_Name → not null
-- Uploaded_File → optional (path to uploaded file)
-- Status → defaults to 'Pending'
-- -----------------------------
CREATE TABLE course_registration (
    USN VARCHAR(20) PRIMARY KEY,
    Student_Name VARCHAR(100) NOT NULL,
    Registered_Date DATE NOT NULL,
    Elective VARCHAR(100) NOT NULL,
    Counsellor_Name VARCHAR(100) NOT NULL,
    Uploaded_File VARCHAR(255),
    Status VARCHAR(20) DEFAULT 'Pending'
);

-- -----------------------------
-- Create a table to store total students
-- USN → primary key
-- Student_Name → not null
-- -----------------------------
CREATE TABLE total_students (
    USN VARCHAR(20) PRIMARY KEY,
    Student_Name VARCHAR(100) NOT NULL
);

-- -----------------------------
-- Create a table to store registered student data
-- USN → primary key
-- Student_Name → not null
-- Uploaded_File → optional
-- Status → defaults to 'Pending'
-- -----------------------------
CREATE TABLE registered_data (
    USN VARCHAR(20) PRIMARY KEY,
    Student_Name VARCHAR(100) NOT NULL,
    Uploaded_File VARCHAR(255),
    Status VARCHAR(20) DEFAULT 'Pending'
);
