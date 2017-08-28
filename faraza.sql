CREATE SCHEMA faraza;
use faraza;

CREATE TABLE faraza.utente (
	ID INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(45) NOT NULL,
  cognome VARCHAR(45) NOT NULL,
  email VARCHAR(45) NOT NULL,
  password VARCHAR(45) NOT NULL,
  telefono VARCHAR(45) NOT NULL,
  bidoni INT NOT NULL DEFAULT '0',
  path1 VARCHAR(45),
  visto INT DEFAULT 0,
  PRIMARY KEY (ID)
) ENGINE=INNODB;
  
CREATE TABLE faraza.impiantoSportivo (
	ID INT NOT NULL AUTO_INCREMENT,
  nomeCentro VARCHAR(45) NOT NULL,
  email VARCHAR(45) NOT NULL UNIQUE,
  password VARCHAR(45) NOT NULL,
  costoOrario INT NOT NULL,
  citta VARCHAR(45) NOT NULL,
  via VARCHAR(45) NOT NULL,
  civico INT NOT NULL,
  cap INT NOT NULL,
  telefono VARCHAR(45) NOT NULL,
  path1 VARCHAR(45),
  path2 VARCHAR(45),
  path3 VARCHAR(45),
  PRIMARY KEY (ID)
) ENGINE=INNODB;

CREATE TABLE faraza.squadra (
	ID INT NOT NULL AUTO_INCREMENT,
	nome VARCHAR(45) NOT NULL,
  tipo ENUM("pubblica", "privata") DEFAULT "pubblica",  
  punti INT NOT NULL DEFAULT 0,
  partiteVinte INT NOT NULL DEFAULT 0,
  partitePerse INT NOT NULL DEFAULT 0,
  partitePareggiate INT NOT NULL DEFAULT 0,
  goalFatti INT NOT NULL DEFAULT 0,
  goalSubiti INT NOT NULL DEFAULT 0,
  PRIMARY KEY (ID)
) ENGINE=INNODB;

CREATE TABLE faraza.recensione (
  data TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  voto INT NOT NULL DEFAULT 1,
  commento VARCHAR(200) NOT NULL,
  IDUtente INT NOT NULL,
  IDImpiantoSportivo INT NOT NULL,
  PRIMARY KEY (data, IDUtente, IDImpiantoSportivo),  
  CONSTRAINT FOREIGN KEY (IDUtente)   REFERENCES faraza.utente (ID) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (IDImpiantoSportivo) REFERENCES faraza.impiantoSportivo (ID)  ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB;

CREATE TABLE faraza.campo (
  ID INT NOT NULL,
  IDImpiantoSportivo INT NOT NULL,
  PRIMARY KEY (ID, IDImpiantoSportivo),
  CONSTRAINT FOREIGN KEY (IDImpiantoSportivo) REFERENCES faraza.impiantoSportivo (ID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB;

CREATE TABLE faraza.torneo (
  nome VARCHAR(45) NOT NULL,
  IDImpiantoSportivo INT NOT NULL,
  tipo ENUM('5','7') DEFAULT '5',
  costo INT NOT NULL,
  inizioTorneo DATE NOT NULL,
  fineTorneo DATE NOT NULL,
  inizioIscrizioni DATE NULL,
  fineIscrizioni DATE NULL,
  numeroMinimoSquadre INT NOT NULL DEFAULT 5,
  processato INT NOT NULL DEFAULT 0,
  PRIMARY KEY (nome),
  CONSTRAINT FOREIGN KEY (IDImpiantoSportivo) REFERENCES faraza.impiantoSportivo (ID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB;

CREATE TABLE faraza.partecipa (
  IDSquadra INT NOT NULL,
  nomeTorneo VARCHAR(45) NOT NULL,
  PRIMARY KEY (IDSquadra, nomeTorneo),
  CONSTRAINT FOREIGN KEY (IDSquadra) REFERENCES faraza.squadra (ID) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (nomeTorneo) REFERENCES faraza.torneo (nome) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB;
  
CREATE TABLE faraza.giocatore (
  IDGiocatore INT NOT NULL,
  IDSquadra INT NOT NULL,
  goalFatti INT NOT NULL DEFAULT 0,
  PRIMARY KEY (IDGiocatore, IDSquadra), 
  CONSTRAINT FOREIGN KEY (IDGiocatore) REFERENCES faraza.utente (ID) ON DELETE CASCADE  ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (IDSquadra) REFERENCES faraza.squadra (ID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB;	 

CREATE TABLE faraza.prenotazione (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  IDCentroSportivo INT(11)  NOT NULL,
  numCampo INT(11) NOT NULL,
  dataPrenotazione DATE NOT NULL,
  oraInizio TIME NOT NULL,
  oraFine TIME NOT NULL,
  tipoPartita ENUM ("partitaUtente", "partitaPrivata", "partitaTorneo") DEFAULT "partitaUtente",  
  CONSTRAINT FOREIGN KEY (numCampo) REFERENCES faraza.campo (ID) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (IDCentroSportivo) REFERENCES faraza.impiantoSportivo (ID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB;

CREATE TABLE faraza.partitaTorneo (
  ID INT NOT NULL AUTO_INCREMENT,
  IDSquadraA INT NOT NULL,
  IDSquadraB INT NOT NULL,
  IDPrenotazione INT UNIQUE, 
  punteggioSquadraA INT NOT NULL DEFAULT 0,
  punteggioSquadraB INT NOT NULL DEFAULT 0,
  nomeTorneo VARCHAR(45) NOT NULL,
  PRIMARY KEY (ID),
  CONSTRAINT FOREIGN KEY (IDSquadraA) REFERENCES faraza.squadra (ID) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (IDSquadraB) REFERENCES faraza.squadra (ID) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FOREIGN KEY (IDPrenotazione) REFERENCES faraza.prenotazione(ID) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (nomeTorneo) REFERENCES faraza.torneo (nome) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB;
	
CREATE TABLE faraza.pagellaPartitaTorneo (
  ID INT NOT NULL AUTO_INCREMENT,
  voto INT NOT NULL DEFAULT 1, 
  commento VARCHAR(45) NOT NULL,
  IDUtenteVotante INT NOT NULL,
  IDGiocatore INT NOT NULL,
  IDPartitaTorneo INT NOT NULL,
  visto TINYINT(1),
  PRIMARY KEY (ID),
  CONSTRAINT FOREIGN KEY (IDUtenteVotante) REFERENCES faraza.utente (ID) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (IDGiocatore) REFERENCES faraza.giocatore (IDGiocatore) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (IDPartitaTorneo) REFERENCES faraza.partitatorneo (ID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB;


CREATE TABLE faraza.partitaUtente (
	ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	IDUtenteCreante INT NOT NULL,
	IDPrenotazione INT UNIQUE,
	punteggio VARCHAR(10) NOT NULL DEFAULT '0-0',
	numeroMinimoGiocatori ENUM('5', '7') DEFAULT '5',
	tipo ENUM('partitaAperta', 'partitaChiusa') DEFAULT 'partitaAperta', 
	CONSTRAINT FOREIGN KEY (IDUtenteCreante) REFERENCES faraza.utente(ID) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FOREIGN KEY (IDPrenotazione) REFERENCES faraza.prenotazione(ID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB;

CREATE TABLE faraza.iscrizione ( 
	IDUtente INT NOT NULL,
	IDPartite INT NOT NULL,
	squadra ENUM('a','b'),
	PRIMARY KEY(IDUtente,IDPartite),
	CONSTRAINT FOREIGN KEY (IDUtente) REFERENCES faraza.utente(ID) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FOREIGN KEY (IDPartite) REFERENCES faraza.partitaUtente(ID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB;

CREATE TABLE faraza.pagella (
	ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  voto INT NOT NULL DEFAULT 1, 
  commento VARCHAR(45) NOT NULL,
  IDUtenteVotante INT NOT NULL,
  IDGiocatore INT  NOT NULL,
  IDPartitaUtente INT NOT NULL,  
  visto TINYINT(1),
  CONSTRAINT FOREIGN KEY (IDUtenteVotante) REFERENCES faraza.utente(ID) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (IDGiocatore) REFERENCES faraza.iscrizione(IDUtente) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (IDPartitaUtente) REFERENCES faraza.iscrizione(IDPartite) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB;

CREATE TABLE faraza.partitaPrivata (
	ID INT PRIMARY KEY AUTO_INCREMENT,
	IDUtenteCreante INT,
	IDPrenotazione INT UNIQUE,
	CONSTRAINT FOREIGN KEY (IDUtenteCreante) REFERENCES faraza.utente(ID) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FOREIGN KEY (IDPrenotazione) REFERENCES faraza.prenotazione(ID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB;

-- ------------------------------ Store Procedure & Trigger ------------------------------
-- Verifica se c'e' gia' un centro sportivo registrato con quella email
DELIMITER //
CREATE PROCEDURE verificaMailImpianto(IN email VARCHAR(45), OUT verifica BOOLEAN)
BEGIN 
	DECLARE cur INT DEFAULT 0; 
	DECLARE cursore CURSOR FOR
	SELECT count(i.email)
    FROM faraza.impiantoSportivo as i
    WHERE (email = i.email);
    
    OPEN cursore;
		FETCH cursore INTO cur;
		IF(cur > 0) then
			SET verifica := TRUE;
		END IF;
    CLOSE cursore;  
END; //
DELIMITER ;

-- Verifica se c'e' gia' un utente registrato con quella email
DELIMITER //
CREATE PROCEDURE verificaMailUtente(IN email VARCHAR(45), OUT verifica BOOLEAN)
BEGIN 
	DECLARE cur INT DEFAULT 0; 
	DECLARE cursore CURSOR FOR
	SELECT count(u.email)
	FROM faraza.utente as u
	WHERE (email = u.email);
    
    OPEN cursore;
		FETCH cursore INTO cur;
		IF(cur > 0) then
			SET verifica := TRUE;
		END IF;
    CLOSE cursore;  
END; //
DELIMITER ;

-- Verifica se c'e' gia' un torneo con quel nome
DELIMITER //
CREATE PROCEDURE verificaNomeTorneo(IN nome VARCHAR(20), OUT verifica BOOLEAN)
BEGIN	
	DECLARE cur INT DEFAULT 0; 
	DECLARE cursore CURSOR FOR
	SELECT count(t.nome)
    FROM faraza.torneo as t
    WHERE (nome = t.nome);
    
    OPEN cursore;
    FETCH cursore INTO cur;
    IF(cur > 0) then
		SET verifica := TRUE;
    END IF;
    CLOSE cursore;
END; //
DELIMITER ;

-- Store procedure che in base al valore passato come primo parametro mi inserisce le righe per i campi di un centro sportivo
DELIMITER //
CREATE PROCEDURE inserisciCampo(IN numeroCampi INT, IN ID INT)
BEGIN 
	DECLARE inc INT DEFAULT 1;
	DECLARE num INT DEFAULT 1;        
	WHILE inc <= numeroCampi DO
		INSERT INTO faraza.campo (ID, IDImpiantoSportivo) VALUES (num, ID);
    SET num = num + 1;
    	SET inc = inc + 1;
	END WHILE;
END; //
DELIMITER ;

-- Trigger che setta l'ora in cui la partita finira'
-- NON FUNZIONA SU OSX (da cancellare ad ogni nuovo import) - Implementato in php
DELIMITER //
  CREATE TRIGGER determinaOraFine
  BEFORE INSERT ON faraza.prenotazione
  FOR EACH ROW 
  BEGIN 
		SET NEW.oraFine = NEW.oraInizio + INTERVAL 1 HOUR;
  END; //
DELIMITER ;

-- Trigger che determina la fine delle iscrizioni due giorni prima dell'inizio del torneo
-- NON FUNZIONA SU OSX (da cancellare ad ogni nuovo import) - Implementato in php
DELIMITER // 
  CREATE TRIGGER determinaFineIscrizioni
  BEFORE INSERT ON faraza.torneo
  FOR EACH ROW 
  BEGIN
		SET NEW.fineIscrizioni = NEW.inizioTorneo - INTERVAL 2 DAY;
  END; //
DELIMITER ;

-- ------------------------------ Viste ------------------------------
-- Con questa vista implementiamo meccanismi di indipendenza tra il livello logico e quello esterno e ci permette di scrivere una query complessa in modo piu' semplice.
-- Vogliamo avere a portata di mano le recensioni relative ad un dato centro sportivo e in particolare il nome dell'utente creante (non il suo ID contenuto in recensione), la data,
-- il voto, il commento e l'ID del centro. Successivamente selezioniamo l'impianto che ci interessa con query apposita.
CREATE VIEW vediCommenti(nome, cognome, data, voto, commento, IDCentro)
AS SELECT u.nome, u.cognome, r.data, r.voto, r.commento, r.IDImpiantoSportivo
FROM faraza.recensione as r, faraza.utente as u
WHERE r.IDUtente = u.ID;
-- Questa vista serve per poter arginare il problema relativo alla cardinalità fra partitaTorneo e squadra che è di 2-2. In questo le partite saranno visualizzate non per id,
-- ma facendo un Join tra le viste.
CREATE VIEW infoSquadraA(IDPartita, squadra, punteggio, IDPrenotazione, nomeTorneo)
AS
SELECT pt.ID, s.nome, pt.punteggioSquadraA, pt.IDPrenotazione, pt.nomeTorneo
FROM faraza.partitaTorneo as pt, faraza.squadra as s
WHERE pt.IDSquadraA=s.ID;

CREATE VIEW infoSquadraB(IDPartita, squadra, punteggio, IDPrenotazione, nomeTorneo)
AS
SELECT pt.ID, s.nome, pt.punteggioSquadraB, pt.IDPrenotazione, pt.nomeTorneo
FROM faraza.partitaTorneo as pt, faraza.squadra as s
WHERE pt.IDSquadraB=s.ID;
-- Vista che permette di avere una visione d'insieme di tutte le informazioni utili che riguardano una partita Utente.
CREATE VIEW partiteDisponibili(ID, tipo, numeroGiocatori, costo, risultato, luogo, campo, email, data, oraInizio, citta, via, civico, cap, telefono)
AS SELECT pren.ID, part.tipo, part.numeroMinimoGiocatori, imp.costoOrario, part.punteggio, imp.nomeCentro, pren.numCampo, imp.email, pren.dataPrenotazione, pren.oraInizio, imp.citta, imp.via, imp.civico, imp.cap, imp.telefono
FROM faraza.prenotazione as pren, faraza.partitaUtente as part, faraza.impiantoSportivo as imp
WHERE pren.ID = part.IDPrenotazione AND pren.IDCentroSportivo = imp.ID
ORDER BY pren.dataPrenotazione;
-- Le due viste qui di seguito, servono per permettere la visualizzazione delle pagelle (utente e torneo) non attraverso gli ID ma attraverso i nomi degli utenti interessati.
-- E' stato necessario fare una vista per poter fare una una query contenuta nel primo caso nell file 'pagellaPartitaUtente.php' e nel secondo caso in 'pagellaPartitaTorneo.php' che permette
-- di vedere solo le partite che si riferiscono al centro sportivo loggato.
CREATE VIEW vistaPagella(ID,nome,cognome, voto, commento, nomeVotato, cognomevotato, partita)
AS
SELECT p.ID, u.nome, u.cognome, p.voto, p.commento, utd.nome, utd.cognome, p.IDPartitaUtente
FROM faraza.pagella as p, faraza.utente as u, faraza.utente as utd
WHERE u.ID=p.IDUtenteVotante AND utd.ID = p.IDGiocatore;

CREATE VIEW vistaPagellaTorneo(ID,nome,cognome, voto, commento, nomeVotato, cognomeVotato, partita)
AS
SELECT pt.ID, u.nome, u.cognome, pt.voto, pt.commento,utd.nome,utd.cognome, pt.IDPartitaTorneo
FROM faraza.pagellapartitatorneo as pt, faraza.utente as u, faraza.utente as utd
WHERE u.ID=pt.IDUtenteVotante AND utd.ID = pt.IDGiocatore;