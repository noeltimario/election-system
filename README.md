# 🗳️ Simple Election System (PHP/MySQL)

A functional voting system developed for a BSIT Skills Test. This project allows voters to register, log in, and cast their votes for various positions.

## 🚀 Features
- **User Registration & Login**: Secure access using email and password.
- **Voting System**: Prevents double voting and supports multiple winners (e.g., Senators).
- **Real-time Results**: Live calculation of vote percentages.
- **Winners Circle**: Automatically identifies winners based on the top vote counts.

## 🛠️ Tech Stack
- **Frontend**: HTML5, Bootstrap 5 (CDN)
- **Backend**: PHP 8.x
- **Database**: MySQL

## 📋 Installation & Database Setup
1. Open **phpMyAdmin**.
2. Create a new database named `election_db`.
3. Click the **SQL** tab and paste the following script to create the tables and sample data:

```sql
CREATE TABLE voters (
    voterID INT AUTO_INCREMENT PRIMARY KEY,
    voterFName VARCHAR(100) NOT NULL,
    voterLName VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    voterPass VARCHAR(255) NOT NULL,
    voterStat TINYINT DEFAULT 1,
    voted TINYINT DEFAULT 0
);

CREATE TABLE positions (
    posID INT AUTO_INCREMENT PRIMARY KEY,
    posName VARCHAR(100) NOT NULL,
    numOfPositions INT DEFAULT 1,
    posStat TINYINT DEFAULT 1
);

CREATE TABLE candidates (
    candID INT AUTO_INCREMENT PRIMARY KEY,
    candFName VARCHAR(100) NOT NULL,
    candMName VARCHAR(100),
    candLName VARCHAR(100) NOT NULL,
    posID INT NOT NULL,
    candStat TINYINT DEFAULT 1,
    FOREIGN KEY (posID) REFERENCES positions(posID)
);

CREATE TABLE votes (
    voteID INT AUTO_INCREMENT PRIMARY KEY,
    voterID INT NOT NULL,
    candID INT NOT NULL,
    posID INT NOT NULL,
    FOREIGN KEY (voterID) REFERENCES voters(voterID),
    FOREIGN KEY (candID) REFERENCES candidates(candID),
    FOREIGN KEY (posID) REFERENCES positions(posID)
);

INSERT INTO positions (posName, numOfPositions) VALUES
('President', 1),
('Vice President', 1),
('Senator', 12);

INSERT INTO candidates (candFName, candMName, candLName, posID) VALUES
('Juan', 'D', 'Cruz', 1), ('Pedro', 'S', 'Santos', 1),
('Maria', 'A', 'Reyes', 2), ('Ana', 'B', 'Garcia', 2),
('Carlos', 'M', 'Lopez', 3), ('Jose', 'R', 'Torres', 3);
