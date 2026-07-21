-- Désactiver la vérification des clés étrangères pendant la création
PRAGMA foreign_keys = OFF;

-- Suppression des anciennes vues et tables
DROP VIEW IF EXISTS v_client_soldes;
DROP VIEW IF EXISTS v_operateur_gains;
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS bareme_frais;
DROP TABLE IF EXISTS fee_slabs;
DROP TABLE IF EXISTS type_operations;
DROP TABLE IF EXISTS clients;
DROP TABLE IF EXISTS prefixes;
DROP TABLE IF EXISTS utilisateurs;


PRAGMA foreign_keys = ON;

CREATE TABLE utilisateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email VARCHAR(100) not null unique,
    mdp varchar(255)
);


CREATE TABLE prefixes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe VARCHAR(15) NOT NULL UNIQUE,
    notre Boolean default false,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    numero_telephone VARCHAR(10) NOT NULL UNIQUE,
    code_secret VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE type_operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code VARCHAR(20) NOT NULL UNIQUE,
    label VARCHAR(50) NOT NULL
);


CREATE TABLE bareme_frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_type_operation INTEGER NOT NULL,
    borne_min numeric NOT NULL,
    borne_max numeric NOT NULL,
    frais numeric NOT NULL,
    FOREIGN KEY (id_type_operation) REFERENCES type_operations(id) ON DELETE CASCADE
);

CREATE TABLE transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    reference VARCHAR(50) NOT NULL,
    id_client INTEGER NOT NULL,
    id_type_operation INTEGER NOT NULL,
    type_mvt VARCHAR(10) NOT NULL, -- 'CREDIT' ou 'DEBIT'
    montant numeric NOT NULL,
    frais numeric DEFAULT 0.0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_client) REFERENCES clients(id),
    FOREIGN KEY (id_type_operation) REFERENCES type_operations(id)
);

-- ============================================================
-- VUES SQL (Facilitent le calcul du solde et la situation opérateur)
-- ============================================================

-- Vue 1 : Solde en temps réel par client
CREATE VIEW IF NOT EXISTS v_client_soldes AS
SELECT 
    c.id AS id_client,
    c.numero_telephone,
    COALESCE(
        SUM(
            CASE 
                WHEN t.type_mvt = 'CREDIT' THEN t.montant
                WHEN t.type_mvt = 'DEBIT' THEN -(t.montant + t.frais)
                ELSE 0 
            END
        ), 0
    ) AS solde
FROM clients c
LEFT JOIN transactions t ON c.id = t.id_client
GROUP BY c.id, c.numero_telephone;

-- Vue 2 : Situation globale des gains de l'opérateur via les frais
CREATE VIEW IF NOT EXISTS v_operateur_gains AS
SELECT 
    top.label AS type_operation,
    COUNT(t.id) AS nombre_operations,
    COALESCE(SUM(t.montant), 0) AS volume_total,
    COALESCE(SUM(t.frais), 0) AS total_gains_frais
FROM transactions t
JOIN type_operations top ON t.id_type_operation = top.id
GROUP BY top.id, top.label;

-- ============================================================
-- DONNÉES INITIALES (SEEDING)
-- ============================================================

-- Préfixes autorisés (Ex: 033, 037)
insert into prefixes(prefixe, notre) values ('032', true), ('034', false);

-- Types d'opérations
INSERT INTO type_operations (id, code, label) VALUES 
(1, 'DEP', 'Dépôt'),
(2, 'RET', 'Retrait'),
(3, 'TRA', 'Transfert');

INSERT INTO bareme_frais (id_type_operation, borne_min, borne_max, frais) VALUES
-- Type d'opération 2
(2, 100, 1000, 50),
(2, 1001, 5000, 50),
(2, 5001, 10000, 100),
(2, 10001, 25000, 200),
(2, 25001, 50000, 400),
(2, 50001, 100000, 800),
(2, 100001, 250000, 1500),
(2, 250001, 500000, 1500),
(2, 500001, 1000000, 2500),
(2, 1000001, 2000000, 3000),

-- Type d'opération 3
(3, 100, 1000, 75),
(3, 1001, 5000, 75),
(3, 5001, 10000, 150),
(3, 10001, 25000, 300),
(3, 25001, 50000, 600),
(3, 50001, 100000, 1000),
(3, 100001, 250000, 1800),
(3, 250001, 500000, 2000),
(3, 500001, 1000000, 3000),
(3, 1000001, 2000000, 3500);

INSERT INTO clients (numero_telephone, code_secret) VALUES 
('0321234567', 'secret1'),
('0322345678', 'secret2'),
('0323456789', 'secret3');

INSERT INTO transactions (reference, id_client, id_type_operation, type_mvt, montant, frais) VALUES
('TXN001', 1, 2, 'CREDIT', 5000, 0),
('TXN002', 1, 3, 'DEBIT', 2000, 75),
('TXN003', 2, 2, 'CREDIT', 10000, 0),
('TXN004', 2, 3, 'DEBIT', 5000, 75),
('TXN005', 3, 2, 'CREDIT', 15000, 0),
('TXN006', 3, 3, 'DEBIT', 7000, 150);

INSERT INTO utilisateurs (email, mdp) VALUES 
('admin@mvola.com', '123456');

CREATE TABLE IF NOT EXISTS commission (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_prefixe INTEGER NOT NULL,
    pourcentage DECIMAL(5,2) NOT NULL,
    FOREIGN KEY (id_prefixe) REFERENCES prefixes(id) ON DELETE CASCADE
);

INSERT INTO commission (pourcentage, id_prefixe) VALUES 
(1.5, 2); -- 1.5% pour 033

CREATE VIEW IF NOT EXISTS v_operateur_gains2 AS
SELECT 
    p.prefixe, 
    SUM(t.montant) as total_transfert,
    c.pourcentage,
    (SUM(t.montant) * c.pourcentage / 100) as montant_commission
FROM transactions t
JOIN clients cl ON t.id_client = cl.id
JOIN prefixes p ON p.prefixe = SUBSTR(cl.numero_telephone, 1, 3)
LEFT JOIN commission c ON p.id = c.id_prefixe
GROUP BY p.prefixe;

CREATE VIEW IF NOT EXISTS v_historique_client AS
SELECT
    t.id as id_transaction,
    t.id_client as id_client,
    t.reference as reference,
    t_o.label as operation,
    CASE
        WHEN t.type_mvt = 'CREDIT' THEN t.montant
        WHEN t.type_mvt = 'DEBIT' THEN -(t.montant + t.frais)
        ELSE 0
    END AS montant_total,
    t.created_at as datet
FROM transactions t
JOIN type_operations t_o
    ON t.id_type_operation = t_o.id;
