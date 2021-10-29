CREATE TABLE login (
  id int PRIMARY KEY auto_increment,
  user varchar(200) NOT NULL,
  password varchar(200) NOT NULL
);

CREATE TABLE gruppo (
  id int PRIMARY KEY auto_increment,
  nome varchar(100) NOT NULL
);

CREATE TABLE utente (
  id int PRIMARY KEY auto_increment,
  gruppo_id int NOT NULL,
  nome varchar(100) NOT NULL,
  cognome varchar(100) NOT NULL,
  luogo_residenza varchar(100),
  data_nascita date,
  descrizione text,
  numero_telefono varchar(100),
  mail varchar(100),

  INDEX utente_gruppo_id (gruppo_id),
    FOREIGN KEY (gruppo_id)
        REFERENCES gruppo(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE appuntamento (
  id int PRIMARY KEY auto_increment,
  utente_id int NOT NULL,
  datetime datetime NOT NULL,
  luogo varchar(100),
  descrizione text,

  INDEX appuntamento_utente_id (utente_id),
    FOREIGN KEY (utente_id)
        REFERENCES utente(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE sinistro (
  id int PRIMARY KEY auto_increment,
  utente_id int NOT NULL,
  data date,
  luogo varchar(100),
  compagnia_utente varchar(100),
  compagnia_controparte varchar(100),
  diagnosi text,
  fisici_visite varchar(100),
  fisici_esami varchar(100),
  fisici_certificazione varchar(100),
  fisici_parte varchar(100),
  fisici_controparte varchar(100),
  materiali_preventivo varchar(100),
  materiali_perizia varchar(100),
  materiali_liquidazione varchar(100),
  attivo tinyint(1),

  INDEX sinistro_utente_id (utente_id),
    FOREIGN KEY (utente_id)
        REFERENCES utente(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE file (
  id int PRIMARY KEY auto_increment,
  utente_id int NOT NULL,
  nome varchar(100),
  tipo varchar(100),
  size int,
  dati longblob,

  INDEX file_utente_id (utente_id),
    FOREIGN KEY (utente_id)
        REFERENCES utente(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
