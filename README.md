# FARAZA
Applicazione Web per la gestione degli eventi calcistici da parte di un centro sportivo. Per la memorizzzione dei dati è stato fatto un utilizzo massiccio di database relazionale SQL, la parte funzionale invece è stata sviluppata interamente in php, con l'aiuto di HTML e Bootstrap.

## SPECIFICA PROGETTO
Si vuole implementare un sistema informativo relativo alla gestione degli eventi calcistici da parte di un centro sportivo. Il sistema gestisce i dati relativi agli utenti su di esso iscritti, a cui si accede mediante una email ed una password.

Esistono due tipologie di iscrizione con relative possibilità: un giocatore semplice si può iscrivere al sistema come normale utente, mentre un impianto sportivo che potrebbe essere interessato alla piattaforma, può iscriversi su di essa in qualità di centro sportivo per gestire i suoi eventi. Un utente viene registrato nel sistema utilizzando i seguenti parametri: ID, nome, cognome, email, password, numero di cellulare, bidoni; un centro sportivo invece viene salvato utilizzando: ID, nome del centro, indirizzo (città, civico, via, CAP), email e password. Un utente potrà rilasciare una recensione al centro sportivo, indicando il suo gradimento generale con un voto da uno a cinque e lasciando un commento. Il sistema infine, salverà la recensione con data di rilascio.

## TIPI DI PARTITA
Ogni utente è libero di prenotare e creare tre diverse tipologie di partita:
1. **Partita Privata**: si tratta di una semplice prenotazione di un campo di un centro sportivo, purchè disponibile. Ogni utente può riservarsi tanti spazi quanti desidera, premesso che questi siano in orari differenti. Con questo tipo di partita la prenotazione avviene singolarmente, starà poi all’utente decidere quanti giocatori chiamare e come organizzare la partita. Non presente in questo caso il sistema di votazione dei giocatori.
1. **Partita Utente Chiusa**: inizialmente solo l’utente organizzatore, ossia colui che ha creato la partita, potrà invitare al match altri giocatori iscritti al portale. Successivamente anche i giocatori che hanno accettato l’invito potranno invitare altre persone iscritte al servizio. Questo tipo ti gara è simile alla partita privata ma viene aggiunto un lato social, interesserà quindi le persone che vorranno tenere traccia delle loro prestazioni nel sistema ed avere un profilo sempre aggiornato, completo di match giocati e valutazione complessiva.
1. **Partita Utente Aperta**: una volta organizzata una partita di questo tipo, qualunque giocatore iscritto al sistema potrà parteciparvi, cercando un match nel database e scegliendo la squadra nella quale schierarsi. Anche qui viene incluso il lato social del sistema, con votazioni ed eventuali commenti.

**N.B. Per gli ultimi due tipi di partite, l’utente che crea la partita, dovrà occuparsi di aggiornare il punteggio finale attraverso il portale del sistema.**

## GESTIONE DELLA PRENOTAZIONE
Una singola prenotazione consiste nel riservare un campo di un centro sportivo per la durata di 1 ora. La prenotazione sarà identificata da una data e un’ora. Prenotazioni sovrapposte che riguardano lo stesso campo non potranno essere accettate.
Informazioni riguardanti ogni tipologia di partita:
* Qualora un giocatore non si presentasse alla partita senza cancellarsi, gli utenti o lo stesso gestore segneleranno la sua assenza mediante un attributo chiamato "bidoni" che verra incrementato di uno. Tale penalità non gli verrà attribuita nel caso in cui l’utente elimini la prenotazione entro un’ora dall’inizio della partita.

## TORNEO
Il sistema prevede la creazione e gestione di tornei, i quali vengono svolti come se fossero dei campionati, ovvero tutte le squadre giocano una contro l’altra. Ad ogni vittoria vengono assegnati dal gestore del centro sportivo: 3 punti in caso di vittoria, pareggio 1 punto e sconfitta 0 punti. Alla fine della competizione la squadra che vince sarà quella che ha totalizzato il maggior numero di punti. In caso di uguaglianza di punteggio tra i primi due team, si decide il vincitore secondo il meccanismo di differenza reti (reti fatte - reti subite).

Solamente un centro sportivo ha la possibilità di organizzare un torneo, il quale per essere creato necessita dei seguenti dati: nome, tipologia di gioco (calcio a 5 o calcio a 7), costo per ogni squadra, data di inizio, data di fine, data apertura iscrizioni e data chiusura iscrizioni.

Ogni utente può iscrivere una squadra, scegliendo tra due differenti tipi: squadra pubblica o squadra privata. Con la prima scelta si apre la squadra al pubblico, ossia qualunque altro utente può unirsi, se si sceglie invece di iscrivere una squadra privata il funzionamento è lo stesso di una Partita Chiusa (la possibilità di iscrivere giocatori è concessa solo al creatore e ai giocatori aggiunti). Ogni utente può iscriversi ad una sola squadra per un singolo torneo, mentre al torneo possono iscriversi N squadre.

Allo scadere delle iscrizioni il sistema si occuperà di controllare che ci sia il numero minimo di squadre altrimenti il team verrà cancellato. Successivamente, si procederà alla creazione del campionato con la lista di tutti gli eventi, completa di campo di gioco, data ed ora. Ogni partita è definita dai seguenti campi: ID, nome delle squadre coinvolte e punteggio finale. Alla fine di ogni match sarà compito dell’organizzatore del torneo di aggiornare il risultato, con relativi marcatori. Ovviamente si vorrà conoscere l’andamento generale del torneo mediante una classifica che determini per ogni squadra punti, vittorie, sconfitte, pareggi, gol fatti, gol subiti e differenza reti. In aggiunta si potrà visualizzare la classifica dei marcatori, definita da nome del giocatore, squadra di appartenenza e gol realizzati.

Al termine di ogni partita sarà data la possibilità di stilare le pagelle dell’incontro per ogni giocatore, lasciando un voto e un commento opzionale, che andranno a determinare il migliore in campo (media voto più alta). I commenti possono anche essere sottoposti a controllo da parte del centro sportivo, che potrà decidere di cancellarli, qualora lesivi.

Infine si vuole tenere traccia dello storico delle squadre che hanno partecipato ai tornei e dei giocatori che ne facevano parte, in modo da poter consultare le statistiche utili per i successivi tornei.

> Progetto di BASI DI DATI<br>Riccardo Zandegiacomo De Lugan, Antonio Faienza e Alessandro Rappini<br>Università di Bologna, CdL in Informatica per il Management<br>A.S. 2014/2015, Aprile 2015
