SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `categoria` (
  `ID` int(5) UNSIGNED NOT NULL,
  `nome` varchar(11) NOT NULL,
  `keywords` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `categoria` (`ID`, `nome`,`keywords`) VALUES
(1,'Accessori','Olympo Fitness, palestra, negozio palestra, accessori palestra, accessori, pesi liberi , macchinari palestra, macchinari, nutrizione'),
(2,'Pesi Liberi','Olympo Fitness, palestra, negozio palestra, pesi liberi , macchinari palestra, macchinari, nutrizione, accessori palestra'),
(3,'Nutrizione','Olympo Fitness, palestra, negozio palestra, nutrizione, pesi liberi , macchinari palestra, macchinari, accessori palestra'),
(4,'Macchinari','Olympo Fitness, palestra, negozio palestra, pesi liberi , macchinari palestra, macchinari, macchine, nutrizione, accessori palestra');


CREATE TABLE `utente` (
  `ID` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `utente` (`ID`, `nome`, `email`, `password`, `admin`) VALUES
(1, 'user', 'user@user.com', 'user', 0),
(2, 'admin', 'admin@admin.com', 'admin', 1);


CREATE TABLE `faq` (
  `ID` int(10) UNSIGNED NOT NULL,
  `tema` varchar(100) NOT NULL,
  `domanda` text NOT NULL,
  `risposta` text NOT NULL,
  `utente` int(10) UNSIGNED NOT NULL --MI SA CHE NON SERVE UTENTE QUI,E' SBAGLIATO
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `faq` (`ID`, `tema`, `domanda`, `risposta`, `utente`) VALUES
(1,'Ordini e Spedizione', 'Come posso effettuare un ordine?', 'Puoi effettuare un ordine attraverso il nostro sito web. Sfoglia la gamma di prodotti, aggiungi gli articoli desiderati al carrello e segui il processo di checkout.', 1),
(2,'Ordini e Spedizione', 'Quali metodi di pagamento accettate?', 'Accettiamo pagamenti sicuri con carta di credito, bonifico bancario, PayPal. Troverai tutte le opzioni durante il checkout.', 1),
(3,'Ordini e Spedizione', 'Posso modificare o annullare il mio ordine dopo averlo effettuato?', 'Offriamo diverse opzioni di abbonamento, tra cui abbonamenti mensili, trimestrali e annuali, con varie formule di accesso ai servizi', 1),
(4,'Ordini e Spedizione', 'Quali sono le opzioni di spedizione disponibili?', 'Le spedizioni vengono generalmente effettuate entro 2-3 giorni lavorativi dalla data di acquisto. I dettagli sono disponibili durante il processo di checkout.', 1),
(5,'Ordini e Spedizione', 'Come posso tracciare la mia spedizione?', ' Riceverai un''email di conferma con il numero di tracciamento non appena la tua spedizione verrà inviata. Puoi utilizzare questo numero per monitorare lo stato della spedizione.', 1),
(6,'Ordini e Spedizione', 'Posso modificare il mio indirizzo di spedizione dopo aver effettuato l''ordine?', ' Le modifiche all''indirizzo di spedizione possono essere possibili entro un certo periodo di tempo. Contattaci il prima possibile per assistenza.', 1),
(7,'Alimenti', 'Quali tipi di integratori alimentari offrite?','Offriamo una vasta gamma di integratori alimentari, tra cui proteine, aminoacidi, multivitaminici e altri prodotti per supportare le tue esigenze nutrizionali.', 1),
(8,'Alimenti', 'Gli alimenti offerti sono adatti a specifiche diete o restrizioni alimentari?', 'Molti dei nostri prodotti sono adatti a diverse diete, inclusi vegetariani e vegani. Le informazioni dettagliate sono fornite nelle descrizioni dei prodotti.', 1),
(9,'Alimenti', 'Come posso ottenere consigli sulla scelta degli integratori alimentari più adatti a me?',' Il nostro team di supporto è disponibile per fornire consulenza personalizzata sulla scelta degli integratori più adatti alle tue esigenze. Contattaci per ulteriori informazioni.', 1),
(10,'Attrezzatura', 'Gli attrezzi sono adatti a utilizzi domestici o commerciali?', 'Forniamo informazioni chiare sull''idoneità degli attrezzi per utilizzi domestici o commerciali. Controlla le specifiche del prodotto o contattaci per assistenza.', 1),
(11,'Attrezzatura', 'Quali sono le politiche di garanzia sugli attrezzi?', 'Offriamo garanzie su molti dei nostri attrezzi. Le informazioni sulla garanzia sono disponibili nelle descrizioni dei prodotti o puoi contattarci per ulteriori dettagli.', 1),
(12,'Attrezzatura', 'Fornite istruzioni sull''assemblaggio degli attrezzi?', 'Sì, le istruzioni di assemblaggio sono incluse con gli attrezzi che richiedono montaggio. Se hai domande durante il processo, siamo disponibili per assistenza.', 1),
(13,'Attrezzatura', 'Come posso effettuare una manutenzione adeguata degli attrezzi?', 'Ti forniremo consigli sulla manutenzione degli attrezzi nelle istruzioni fornite. Inoltre, siamo disponibili per rispondere alle tue domande sulla manutenzione.', 1),
(14,'Resi e rimborsi', 'Cosa devo fare se ricevo un prodotto danneggiato o difettoso?', 'Contattaci immediatamente fornendo dettagli e foto del prodotto danneggiato o difettoso. Faremo del nostro meglio per risolvere il problema.', 1),
(15,'Resi e rimborsi', 'Posso restituire gli alimenti se non sono soddisfatto?', 'No, i prodotti alimentari non possono essere restituiti.', 1),
(16,'Resi e rimborsi', 'Posso restituire i prodotti "accessori", "pesi liberi" e "macchinari"?', 'Si, puoi restituire gli articoli Accessori, pesi liberi e/o macchinari entro 14 giorni dalla data di acquisto.', 1);




CREATE TABLE `marca` (
  `ID` int(20) UNSIGNED NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `marca` (`ID`, `nome`) VALUES
(1, 'Optimum Nutrition'),
(2, 'Cousin Trestec'),
(3, 'Technogym'),
(4, 'Baodelong'),
(5, 'Adidas'),
(6, 'My Protein');


CREATE TABLE `prodotto` (
  `ID` int(10) UNSIGNED NOT NULL,
  `nome` varchar(200) NOT NULL,
  `immagine1` varchar(100) NOT NULL,
  `immagine2` varchar(100) NOT NULL,
  `immagine3` varchar(100) NOT NULL,
  `immagine4` varchar(100) NOT NULL,
  `alt` varchar(65) NOT NULL,
  `categoria` int(5) UNSIGNED NOT NULL,
  `keywords` varchar(200) DEFAULT NULL,
  `prezzo` decimal(5,2) UNSIGNED NOT NULL,
  `peso` varchar(100) DEFAULT NULL,
  `dimensione` varchar(200) DEFAULT NULL,
  `colore` varchar(100) DEFAULT NULL,
  `volume` varchar(100) DEFAULT NULL,
  `materialeUtilizzato` varchar(100) DEFAULT NULL,
  `quantita` int(1000) UNSIGNED NOT NULL,
  `taglia` varchar(100) DEFAULT NULL,
  `descrizione` text NOT NULL,
  `tempoConsegna` text NOT NULL,
  `marca` int(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--CONSEGNA

--DA INSERIRE I PRODOTTI QUI, SE VOLETE UN ESEMPIO GIA' FATTO GUARDATE IL .sql DEL GRUPPO CONDIVISO SU DISCORD
--Inserire SOLO PRODOTTI delle MARCHE che abbiamo messo (vedi riga 77 di questo file). Puoi andare nei vari siti (che sono linkati nella pagina principale del nostro sito) oppure andare su Amazon
--SOLO IMMAGINI <1MB. OGNI PRODOTTO DEVE AVERE 4 IMMAGINI PER FORZA
--nella taglia mettere la taglia massima 
--nelle keywords, dopo "Olympo Fitness, palestra, negozio palestra," mettere 3 tag SPECIFICI del prodotto stesso, il resto lasciare immutato
--4 prodotti per categoria (es. pesi liberi, nutrizione,ecc.)

INSERT INTO `prodotto` (`ID`, `nome`, `immagine1`, `immagine2`, `immagine3`, `immagine4`, `alt`, `categoria`, `keywords`, 
`prezzo`, `peso`, `dimensione`, `colore`, `volume`, `materialeUtilizzato`, `quantita` , `taglia` , 
`descrizione`, `tempoConsegna`, `marca`) VALUES

(1, 'Borsone Adidas', 'images/BorsoneDavanti.jpg', 'images/BorsoneDietro.jpg', 'images/BorsoneAperto.jpg', 'images/BorsoneChiuso.jpg', 'Immagine di un borsone Adidas abbastanza capiente', 1, 'Olympo Fitness, palestra, negozio palestra, borsone, borsone adidas, adidas, prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 35, '1.5 kg', ' 22 cm x 56 cm x 28 cm', 'Nero', '39 L', 'tela, 100% poliestere riciclato', 10, null, 'La scelta ideale per la palestra e le gite nel weekend. Questo borsone adidas ha una base robusta per proteggere il contenuto. Lo scomparto principale è dotato di una zip bidirezionale per un accesso rapido da entrambi i lati.\r\nLe numerose tasche offrono la massima praticità e lo scomparto interno ti consente di tenere separate le sneaker.', 'Consegna in 3-5 giorni lavorativi', 5),
(2, 'Pantaloni Adidas', 'images/PantaloneAdidasDvanti.jpg', 'images/PantaloneAdidasDietro.jpg', 'images/PantaloneAdidas1.jpg', 'images/PantaloneAdidas2.jpg','Immagine di un pantalone corto da allenamento di marca Adidas', 1   , 'Olympo Fitness, palestra, negozio palestra, pantalone, adias , pantaloni adidas , prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 35, '1.0 kg', ' 25 cm x 30 cm x 31 cm', 'Nero', NULL, 'poliestere riciclato', 15, 'XXL', 'Pantaloni Adidas, adatti per ogni tipo di allenamento.', 'Consegna in 3-5 giorni lavorativi', 5),
(3, 'Magliettta Adidad', 'images/MagliettaAdidasDavanti.jpg', 'images/MagliettaAdidasDietro.jpg', 'images/MagliettaAdidas1.jpg', 'images/MagliettaAdidas2.jpg', 'Immagine di una maglietta Adidas sportiva',1 , 'Olympo Fitness, palestra, negozio palestra, maglietta, adias , maglietta adidas , prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 35, '1.0 kg', ' 25 cm x 30 cm x 31 cm', 'Nero', NULL, 'poliestere riciclato', 25, 'XXL', 'Questi prodotti sono progettati per soddisfare tutte le esigenze e per rendere il prodotto durevole nel tempo. Prodotti realizzati con materiali ad ottime prestazioni. Confortevoli e leggeri, con un design creativo. Prodotti di ottima qualità.', 'Consegna in 3-5 giorni lavorativi', 5),
(4, 'Telo Adidas', 'images/TeloAdidas1.jpg', 'images/TeloAdidas2.jpg', 'images/TeloAdidas3.jpg', 'images/TeloAdidas4.jpg','Immagine di un asciugamano con scritta Adidas', 1, 'Olympo Fitness, palestra, negozio palestra, telo, asciugamano, adidas,  prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 35, '1.5 kg', ' 140 cm x 70 cm', 'Nero', NULL, '100% cotone', 25, 'L', 'Tessuto robusto e leggero, Deisgn moderno.', 'Consegna in 3-5 giorni lavorativi', 5),

(5, 'Hexagon Dumbbell', 'images/peso1.jpg', 'images/peso2.jpg', 'images/peso3.jpg', 'images/peso4.jpg', 'Manubrio hexagonale da 5 kg per esercizi di sollevamento pesi.', 2, 'Olympo Fitness, palestra, negozio palestra, peso, peso libero, technogy, prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 60, '20 kg', ' 30 cm x 10 cm', 'Nero/Argento', NULL, 'Acciaio', 25, '20', 'Progettati per la forza e l’allenamento funzionale. La forma esagonale e l’impugnatura zigrinata permettono di ampliare al massimo la varietà di esercizi includendo anche quelli in appoggio a terra.', 'Consegna in 3-5 giorni lavorativi', 3),
(6, 'Kettlebell', 'images/kettlebell1.jpg', 'images/kettlebell2.jpg', 'images/kettlebell3.jpg', 'images/kettlebell4.jpg','Kettlebell in ghisa da 10 kg per allenamenti di forza.', 2, 'Olympo Fitness, palestra, negozio palestra, Kettlebell, techongym, peso libero,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 70, '8 kg', '15 cm x 5 cm', NULL, 'Acciaio', 40, '20', 'Le Kettlebells di Technogym si distinguono per il loro design ergonomico e per la qualità dei materiali costruttivi. Ideali per allenare forza ed esplosività di tutto il corpo.', 'Consegna in 3-5 giorni lavorativi' ,3),

(7,
'Dumbbell',
'images/dumbbell1.jpg',
'images/dumbbell2.jpg',
'images/dumbbell3.jpg',
'images/dumbbell4.jpg',
'Manubrio hexagonale da 5 kg per allenamenti di sollevamento pesi.',
2,
'Olympo Fitness, palestra, negozio palestra, dumbbell, techongym, peso libero,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 
70, 
'10 kg', 
'15 cm x 5 cm', 
NULL, 
'Acciaio', 
30, 
'10', 
'I manubri Technogym sono studiati per offrirti una sensazione di allenamento naturale e maggiore efficacia, grazie al controllo completo del movimento e al coinvolgimento di più muscoli.',
'Consegna in 3-5 giorni lavorativi',
3),


(8
'Bumper Plate',
'images/bumper1.jpg',
'images/bumper2.jpg',
'images/bumper3.jpg',
'images/bumper4.jpg',
'Piatto paracolpi da 10 kg per esercizi di sollevamento pesi olimpico.',
2,
'Olympo Fitness, palestra, negozio palestra, Bumper Plate, techongym, peso libero,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 
20, 
'15 kg', 
'25 cm x 10 cm x 5 cm', 
NULL, 
'Acciaio', 
20, 
'10', 
'Realizzati in gomma completamente nera, questi dischi sono progettati per resistere a un uso intensivo e assicurare un ottimo assorbimento degli impatti e un buon rimbalzo. La texture opaca sui lati esterni dei dischi li rende meno vulnerabili ai graffi.',
'Consegna in 3-5 giorni lavorativi',
3
),

(9
'Impact Whey Protein',
'images/prot1.jpg',
'images/prot2.jpg',
'images/prot3.jpg',
'images/prot4.jpg',
'Immagine di un contenitore di proteine per il recupero muscolare post-allenamento.'
3,
'Olympo Fitness, palestra, negozio palestra, proteine, myprotein, integratori,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 
80, 
'25 kg', 
'15 cm x 15 cm', 
NULL, 
'--', 
50, 
'10', 
'Siero di latte di prima qualità con ben 23 g di proteine per porzione, per garantirti le proteine di cui hai bisogno. E da dove viene questo siero di latte? Da mucche allevate al pascolo che producono il latte ed il formaggio che consumi quotidianamente -semplicemente filtrato ed atomizzato al fine di produrre sostanze nutritive completamente naturali.',
'Consegna in 3-5 giorni lavorativi',
6
),

(10,
'Clear Whey Isolate',
'images/isolate1.jpg',
'images/isolate2.jpg',
'images/isolate3.jpg',
'images/isolate4.jpg',
'Isolato di proteine Clear Whey al gusto di frutti di bosco per un opzione leggera.'
3,
'Olympo Fitness, palestra, negozio palestra, proteine, myprotein, integratori,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 
80, 
'25 kg', 
'15 cm x 15 cm', 
NULL, 
'--', 
60, 
'10', 
'Clear Whey Isolate non è uno shake proteico qualunque. A partire da pregiate proteine di siero del latte idrolizzate abbiamo ricavato un’alternativa leggera e rinfrescante, più simile a un succo che a un frullato proteico a base di latte.',
'Consegna in 3-5 giorni lavorativi',
6
),

(11,
'Brownie proteico',
'images/brownie1.jpg',
'images/brownie2.jpg',
'images/brownie3.jpg',
'images/brownie4.jpg',
'Brownie proteico al cioccolato e noci per una dolce ricompensa dopo allenamento.',
3,
'Olympo Fitness, palestra, negozio palestra, proteine, myprotein, integratori ,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 
80, 
'5 kg', 
'30 cm x 15 cm', 
NULL, 
'--', 
60, 
'10', 
'Con fino al 75% di zucchero in meno rispetto alle alternative standard dei supermercati, goditi uno spuntino pomeridiano senza rovinare tutti i progressi duramente guadagnati.',
'Consegna in 3-5 giorni lavorativi',
6
),

(12
'Omega-3 Essenziale',
'images/omega1.jpg',
'images/omega2.jpg',
'images/omega3.jpg',
'images/omega4.jpg',
'Immagine di un contenitore di integratori di Omega-3 essenziali per supportare la salute cardiaca e il benessere generale."'
3,
'Olympo Fitness, palestra, negozio palestra, vitamine, myprotein, integratori ,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 
80, 
'5 kg', 
'30 cm x 15 cm', 
NULL, 
'--', 
60, 
'10', 
'Gli omega-3 sono acidi grassi essenziali che il corpo non produce da solo, per cui è necessario ottenerli dall alimentazione. Si trovano naturalmente nell olio di pesce, ciò significa che può essere difficile ottenerne una quantità sufficiente soltanto dall alimentazione.',
6
),

(13
'Tapis roulant commerciale di lusso JB-9800',
'images/tapis1.jpg',
'images/tapis2.jpg',
'images/tapis3.jpg',
'images/tapis4.jpg',
'Tapis roulant pieghevole con display LCD per allenamento cardiovascolare.',
4,
'Olympo Fitness, palestra, negozio palestra, tapis roulant, cardio, Baodelong ,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 
80, 
'85 kg', 
'130 cm x 95 cm x 103 cm', 
NULL, 
'--', 
60, 
'10', 
'Bodystrong fitness offre tapis roulant commerciali affidabili e confortevoli, la nostra azienda è un produttore e fornitore di successo, ci siamo dedicati al campo sportivo molti anni, forniremo un servizio eccellente e un prezzo competitivo per te, ci aspettiamo di diventare il tuo partner a lungo termine in Cina.',
4
),

(14
'Chest Press Delt-HM002A',
'images/chest1.jpg',
'images/chest2.jpg',
'images/chest3.jpg',
'images/chest4.jpg',
'Immagine di una macchina Chest Press per allenare i muscoli pettorali.',
4,
'Olympo Fitness, palestra, negozio palestra, chest press, petto, Baodelong ,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 
80, 
'85 kg', 
'130 cm x 95 cm x 103 cm', 
NULL, 
'--', 
60, 
'10', 
'La chest press machine è una macchina isotonica concepita per eseguire il gesto multiarticolare di distensione del braccio con sovraccarico, utile soprattutto nel rinforzo del gran pettorale, ma che coinvolge anche il tricipite brachiale e il deltoide/spalla anteriore.',
4
),

(15
'Skillrow',
'images/vogatore1.jpg',
'images/vogatore2.jpg',
'images/vogatore3.jpg',
'images/vogatore4.jpg',
'Attrezzo Skillrow per simulare una esperienza di vogare a casa o in palestra',
4,
'Olympo Fitness, palestra, negozio palestra, vogatore, petto, TechnoGym, ,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 
80, 
'85 kg', 
'130 cm x 95 cm x 103 cm', 
NULL, 
'--', 
60, 
'10', 
'Progettato insieme agli atleti, con Skillrow puoi migliorare sia resistenza cardiovascolare che potenza tramite allenamenti total body sempre vari disponibili sulla app, e con la sensazione di vogata più realistica.',
3
),

(16
'Elliptical',
'images/Elliptical1.jpg',
'images/Elliptical2.jpg',
'images/Elliptical3.jpg',
'images/Elliptical4.jpg',
'Macchina ellittica con resistenza regolabile per un allenamento cardio completo',
4,
'Olympo Fitness, palestra, negozio palestra, Elittica, gambe, TechnoGym, ,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 
80, 
'85 kg', 
'130 cm x 95 cm x 103 cm', 
NULL, 
'--', 
60, 
'10', 
'Scopri il potere del tuo corpo con il movimento naturale e confortevole dall’impatto minimo sulle tue articolazioni. ',
3
);



ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `utente`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `faq`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `utente` (`utente`);

ALTER TABLE `marca`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `prodotto`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `categoria` (`categoria`),
  ADD KEY `marca` (`marca`);




ALTER TABLE `categoria`
  MODIFY `ID` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `utente`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `faq`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

ALTER TABLE `marca`
  MODIFY `ID` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `prodotto`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;




ALTER TABLE `prodotto`
  ADD CONSTRAINT `categoria` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `marca` FOREIGN KEY (`marca`) REFERENCES `marca` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;