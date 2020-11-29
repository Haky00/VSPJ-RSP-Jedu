CREATE TABLE Uzivatel (
    uzivatel_login VARCHAR(16),
    uzivatel_jmeno VARCHAR(100) NOT NULL,
    uzivatel_prijmeni VARCHAR(100) NOT NULL,
    uzivatel_email VARCHAR(100) NOT NULL UNIQUE,
    uzivatel_opravneni ENUM('Autor', 'Redaktor', 'Recenzent', 'Šéfredaktor', 'Admin') NOT NULL,
    uzivatel_heslo_hash CHAR(40) NOT NULL,
    uzivatel_tel CHAR(16),
    uzivatel_instituce VARCHAR(100),
    uzivatel_adresa VARCHAR(100),
    PRIMARY KEY (uzivatel_login)
);
CREATE TABLE Cislo (
    cislo_id SERIAL,
    cislo_nazev VARCHAR(200) NOT NULL,
    PRIMARY KEY (cislo_id)
);
CREATE TABLE Prispevek(
    prispevek_id SERIAL,
    prispevek_autor VARCHAR(16) NOT NULL REFERENCES Uzivatel(uzivatel_login) ON DELETE CASCADE ON UPDATE CASCADE,
    prispevek_spoluautori TEXT,
    prispevek_status ENUM(
        'Podáno',
        'Vráceno z důvodu tematické nevhodnosti',
        'Předáno recenzentům',
        'Zamítnuto',
        'Přijato s výhradami',
        'Přijato'
    ) NOT NULL,
    prispevek_datum_vlozeni DATE NOT NULL,
    prispevek_tematicke_cislo INT REFERENCES Cisla(cislo_id) ON DELETE SET NULL,
    PRIMARY KEY (prispevek_id)
);
CREATE TABLE Recenze(
    recenze_id SERIAL,
    recenze_prispevek INT NOT NULL REFERENCES Prispevek(prispevek_id) ON DELETE CASCADE ON UPDATE CASCADE,
    recenze_redaktor VARCHAR(16) NOT NULL REFERENCES Uzivatel(uzivatel_login) ON DELETE CASCADE ON UPDATE CASCADE,
    recenze_due_date DATE,
    recenze_datum_zadani DATE NOT NULL,
    recenze_datum_recenze DATE,
    recenze_recenzant VARCHAR(16) NOT NULL REFERENCES Uzivatel(uzivatel_login) ON DELETE CASCADE ON UPDATE CASCADE,
    recenze_text TEXT,
    recenze_hodnoceni_a INT CHECK (
        recenze_hodnoceni_a BETWEEN 1 AND 5
    ),
    recenze_hodnoceni_b INT CHECK (
        recenze_hodnoceni_b BETWEEN 1 AND 5
    ),
    recenze_hodnoceni_c INT CHECK (
        recenze_hodnoceni_c BETWEEN 1 AND 5
    ),
    recenze_hodnoceni_d INT CHECK (
        recenze_hodnoceni_d BETWEEN 1 AND 5
    ),
    PRIMARY KEY (recenze_id)
);
CREATE TABLE Text(
    text_id SERIAL,
    text_prispevek INT NOT NULL REFERENCES Prispevek(prispevek_id) ON DELETE CASCADE ON UPDATE CASCADE,
    text_datum_nahrani DATE NOT NULL,
    PRIMARY KEY (text_id)
);