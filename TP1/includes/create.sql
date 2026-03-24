CREATE DATABASE IF NOT EXISTS auditdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'audit_user'@'localhost' IDENTIFIED BY 'audit_pass1!';
GRANT ALL ON auditdb.* TO 'audit_user'@'localhost';
FLUSH PRIVILEGES;

USE auditdb;

CREATE TABLE IF NOT EXISTS utilisateur (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO utilisateur (login, mot_de_passe) VALUES
('admin', 'admin123'),
('user1', 'password'),
('user2', 'test123')
ON DUPLICATE KEY UPDATE mot_de_passe = VALUES(mot_de_passe);

CREATE TABLE IF NOT EXISTS poste (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    hostname VARCHAR(64) NOT NULL,
    ip VARCHAR(45) NOT NULL,
    cidr TINYINT UNSIGNED NOT NULL,
    gateway VARCHAR(45) NOT NULL,
    vlan SMALLINT UNSIGNED NOT NULL,
    port VARCHAR(32) NOT NULL,
    utilisateur_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_poste_utilisateur FOREIGN KEY (utilisateur_id)
        REFERENCES utilisateur(id)
);

CREATE TABLE IF NOT EXISTS pentest (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    poste_id INT UNSIGNED NOT NULL,
    utilisateur_id INT UNSIGNED NOT NULL,
    type ENUM('nmap','vuln_scan','password_policy','patch_check','config_review') NOT NULL,
    test_date DATE NOT NULL,
    result ENUM('OK','WARN','FAIL') NOT NULL,
    comment VARCHAR(200),
    score TINYINT UNSIGNED NOT NULL,
    level ENUM('Bon','Moyen','Eleve') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pentest_poste FOREIGN KEY (poste_id)
        REFERENCES poste(id) ON DELETE CASCADE,
    CONSTRAINT fk_pentest_utilisateur FOREIGN KEY (utilisateur_id)
        REFERENCES utilisateur(id)
);