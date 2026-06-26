CREATE DATABASE IF NOT EXISTS speed_reporting;
USE speed_reporting;

-- On supprime la table de test si elle existe déjà
DROP TABLE IF EXISTS table_projectcard;

CREATE TABLE table_projectcard (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    consumed INT DEFAULT 0,
    total INT NOT NULL,
    created DATE,
    finPrevue DATE,
    finReelle DATE,
    color VARCHAR(7)
);

INSERT INTO table_projectcard (name, consumed, total, created, finPrevue, finReelle, color) VALUES
('Dashboard 2.0', 40, 60, '2026-01-10', '2026-06-26', '2026-07-02', '#990000'),
('Dashboard 3.0', 40, 60, '2027-01-10', '2027-06-26', '2027-07-02', '#420000'),
('GreenVald', 15, 50, '2026-02-15', '2026-07-15', '2026-07-15', '#007722'),
('ParisGo', 45, 50, '2026-03-01', '2026-08-01', '2026-08-12', '#999900'),
('Éduc+', 16, 16, '2026-01-05', '2026-06-30', '2026-06-28', '#330088'),
('Développement de site web', 10, 40, '2026-04-10', '2026-09-10', '2026-09-20', '#b35900'),
('Application mobile de gestion', 5, 30, '2026-05-01', '2026-10-15', '2026-10-10', '#00b3ff'),
('Refonte de la plateforme e-commerce', 60, 120, '2026-02-20', '2026-11-30', '2026-12-15', '#880055'),
('Refonte de la plateforme sans-commerce', 60, 120, '2026-02-20', '2026-11-30', '2026-12-15', '#ae006b');