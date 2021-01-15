CREATE TABLE uzivatel (
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
CREATE TABLE cislo (
    cislo_id SERIAL,
    cislo_nazev VARCHAR(200) NOT NULL,
    PRIMARY KEY (cislo_id)
);
CREATE TABLE prispevek(
    prispevek_id SERIAL,
    prispevek_nazev VARCHAR(100) NOT NULL,
    prispevek_autor VARCHAR(16) NOT NULL,
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
    prispevek_tematicke_cislo BIGINT UNSIGNED,
    prispevek_zmena DATETIME NOT NULL,
    CONSTRAINT FOREIGN KEY (prispevek_autor) REFERENCES uzivatel(uzivatel_login) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (prispevek_tematicke_cislo) REFERENCES cislo(cislo_id) ON DELETE SET NULL ON UPDATE CASCADE,
    PRIMARY KEY (prispevek_id)
);
CREATE TABLE recenze(
    recenze_id SERIAL,
    recenze_prispevek BIGINT UNSIGNED NOT NULL,
    recenze_redaktor VARCHAR(16) NOT NULL,
    recenze_due_date DATE,
    recenze_datum_zadani DATE NOT NULL,
    recenze_datum_recenze DATE,
    recenze_recenzant VARCHAR(16) NOT NULL,
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
    CONSTRAINT FOREIGN KEY (recenze_prispevek) REFERENCES prispevek(prispevek_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (recenze_redaktor) REFERENCES uzivatel(uzivatel_login) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (recenze_recenzant) REFERENCES uzivatel(uzivatel_login) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (recenze_id)
);
CREATE TABLE text(
    text_id SERIAL,
    text_prispevek BIGINT UNSIGNED NOT NULL,
    text_datum_nahrani DATETIME NOT NULL,
    CONSTRAINT FOREIGN KEY (text_prispevek) REFERENCES prispevek(prispevek_id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (text_id)
);