USE mpan;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


DROP TABLE IF EXISTS prodotto;
DROP TABLE IF EXISTS categoria;
DROP TABLE IF EXISTS utente;
DROP TABLE IF EXISTS faq;
DROP TABLE IF EXISTS marca;




CREATE TABLE `categoria` (
  `ID` int(5) UNSIGNED NOT NULL,
  `nome` varchar(11) NOT NULL,
  `immagineSfondo` varchar(100) NOT NULL,
  `keywords` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `categoria` (`ID`, `nome`, `immagineSfondo`, `keywords`) VALUES
(1,'Accessori','images/accessorifatto.jpg','Olympo Fitness, palestra, negozio palestra, accessori palestra, accessori, pesi liberi , macchinari palestra, macchinari, nutrizione'),
(2,'Pesi Liberi','images/pasiliberifatto2.jpg','Olympo Fitness, palestra, negozio palestra, pesi liberi , macchinari palestra, macchinari, nutrizione, accessori palestra'),
(3,'Nutrizione','images/nutrizionefatto2.png','Olympo Fitness, palestra, negozio palestra, nutrizione, pesi liberi , macchinari palestra, macchinari, accessori palestra'),
(4,'Macchinari','images/macchinarifatto2.jpg','Olympo Fitness, palestra, negozio palestra, pesi liberi , macchinari palestra, macchinari, macchine, nutrizione, accessori palestra');



CREATE TABLE `utente` (
  `ID` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `amministratore` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `utente` (`ID`, `nome`, `email`, `password`, `amministratore`) VALUES
(1, 'user', 'user@user.com', 'user', 0),
(2, 'admin', 'admin@admin.com', 'admin', 1);


CREATE TABLE `faq` (
  `ID` int(10) UNSIGNED NOT NULL,
  `domanda` text NOT NULL,
  `risposta` text DEFAULT NULL,
  `utente` int(10) UNSIGNED NOT NULL,
  `amministratore` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO `faq` (`ID`, `domanda`, `risposta`, `utente`, `amministratore`) VALUES
(1, 'Quale compagnia si occupa della spedizione?', 'Le spadizioni sono a carico della ditta DHL.', 1, 2),
(2, 'Quali brand collaborano con Olympo Fitness?', 'Puoi consultare l''insieme dei brand tramite la pagine Home, nella sezione: I Nostri Brand.', 1, 2),
(3, 'Avete intenzione di aggiungere nuovi prodotti alimentari in futuro?', 'Si, siamo sempre alla ricerca dei prodotti che soddisfino i nostri clienti.', 1, 2);



CREATE TABLE `marca` (
  `ID` int(20) UNSIGNED NOT NULL,
  `nome` varchar(50) NOT NULL,
  `immagineSfondo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `marca` (`ID`, `nome`, `immagineSfondo`) VALUES
(1, 'Optimum Nutrition', 'images/OptimumNutrition.jpg'),
(2, 'Cousin-Trestec', 'images/cousintrestecImage.png'),
(3, 'Technogym', 'images/Technogym.jpg'),
(4, 'Bodystrong Fitness', 'images/baodelong.jpg'),
(5, 'Adidas', 'images/adidas.jpg'),
(6, 'My Protein', 'images/myprotein.png');


CREATE TABLE `prodotto` (
  `ID` int(10) UNSIGNED NOT NULL,
  `nome` varchar(200) NOT NULL,
  `immagine1` varchar(100) NOT NULL,
  `immagine2` varchar(100) NOT NULL,
  `immagine3` varchar(100) NOT NULL,
  `immagine4` varchar(100) NOT NULL,
  `categoria` int(5) UNSIGNED NOT NULL,
  `keywords` varchar(200) DEFAULT NULL,
  `prezzo` decimal(5,2) UNSIGNED NOT NULL,
  `peso` varchar(100) DEFAULT NULL,
  `dimensione` varchar(200) DEFAULT NULL,
  `colore` varchar(100) DEFAULT NULL,
  `volume` varchar(100) DEFAULT NULL,
  `materialeUtilizzato` varchar(100) DEFAULT NULL,
  `quantita` int(255) UNSIGNED NOT NULL,
  `taglia` varchar(100) DEFAULT NULL,
  `descrizione` text NOT NULL, -- da controllare se funziona
  `tempoConsegna` text NOT NULL,
  `marca` int(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO `prodotto` (`ID`, `nome`, `immagine1`, `immagine2`, `immagine3`, `immagine4`, `categoria`, `keywords`, `prezzo`, `peso`, `dimensione`, `colore`, `volume`, `materialeUtilizzato`, `quantita` , `taglia` , `descrizione`, `tempoConsegna`, `marca`) VALUES
(1, 'Borsone Adidas', 'images/BorsoneDavanti.jpg', 'images/BorsoneDietro.jpg', 'images/BorsoneAperto.jpg', 'images/BorsoneChiuso.jpg', 1, 'Olympo Fitness, palestra, negozio palestra, borsone, borsone adidas, adidas, prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 35, '1.5 kg', ' 22 cm x 56 cm x 28 cm', 'Nero', '39 L', 'tela, 100% poliestere riciclato', 10, null, 'La scelta ideale per la palestra e le gite nel weekend. Questo borsone adidas ha una base robusta per proteggere il contenuto. Lo scomparto principale è dotato di una zip bidirezionale per un accesso rapido da entrambi i lati. Le numerose tasche offrono la massima praticità e lo scomparto interno ti consente di tenere separate le sneaker.', 'Consegna in 3-5 giorni lavorativi',5),
(2, 'Borraccia Adidas', 'images/borraccia1.jpg', 'images/borraccia2.jpg', 'images/borraccia3.jpg', 'images/borraccia4.jpg', 1 , 'Olympo Fitness, palestra, negozio palestra, adias , borraccia adidas , prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 27, '1.0 kg', ' 25 cm x 30 cm x 31 cm', 'Nero', NULL, 'poliestere riciclato', 15, NULL, 'Borraccia  Adidas per fitness, ideale per tutte le attività fitness. Facile da infilare nella borsa.', 'Consegna in 3-5 giorni lavorativi',5),
(3, 'Rullo di schiuma Adidas', 'images/rullo1.jpg', 'images/rullo2.jpg', 'images/rullo3.jpg', 'images/rullo4.jpg',1 , 'Olympo Fitness, palestra, negozio palestra, rullo, adias , maglietta adidas , prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 45, '1.5 kg', ' 25 cm x 50 cm x 8 cm', 'Nero', NULL, 'gomma', 25, 'M', 'Per recuperare più velocemente dall affaticamento dei tessuti molli.', 'Consegna in 3-5 giorni lavorativi',5),
(4, 'Telo Adidas', 'images/TeloAdidas1.jpg', 'images/TeloAdidas2.jpg', 'images/TeloAdidas3.jpg', 'images/TeloAdidas4.jpg', 1, 'Olympo Fitness, palestra, negozio palestra, telo, asciugamano, adidas,  prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 35, '1.5 kg', ' 140 cm x 70 cm', 'Nero', NULL, '100% cotone', 25, 'L', 'Tessuto robusto e leggero, Deisgn moderno.', 'Consegna in 3-5 giorni lavorativi',5),
(5, 'Hexagon Dumbbell', 'images/peso1.jpg', 'images/peso2.jpg', 'images/peso3.jpg', 'images/peso4.jpg', 2, 'Olympo Fitness, palestra, negozio palestra, peso, peso libero, technogy, prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 60, '20 kg', ' 30 cm x 10 cm', 'Nero/Argento', NULL, 'Acciaio', 25, NULL, 'Progettati per la forza e l’allenamento funzionale. La forma esagonale e l’impugnatura zigrinata permettono di ampliare al massimo la varietà di esercizi includendo anche quelli in appoggio a terra.', 'Consegna in 3-5 giorni lavorativi',3),
(6, 'Kettlebell', 'images/kettlebells1.jpg', 'images/kettlebells2.jpg', 'images/kettlebells3.jpg', 'images/kettlebells4.jpg', 2, 'Olympo Fitness, palestra, negozio palestra, Kettlebell, techongym, peso libero,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 70, '8 kg', '15 cm x 5 cm', NULL, NULL,'Acciaio', 40, NULL, 'Le Kettlebells di Technogym si distinguono per il loro design ergonomico e per la qualità dei materiali costruttivi. Ideali per allenare forza ed esplosività di tutto il corpo.', 'Consegna in 3-5 giorni lavorativi',3),
(7,'Dumbbell','images/dumbbell1.jpg','images/dumbbell2.jpg','images/dumbbell3.jpg','images/dumbbell4.jpg',2,'Olympo Fitness, palestra, negozio palestra, dumbbell, techongym, peso libero,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 70, '10 kg', '15 cm x 5 cm', NULL, NULL, 'Acciaio', 30, NULL, 'I manubri Technogym sono studiati per offrirti una sensazione di allenamento naturale e maggiore efficacia, grazie al controllo completo del movimento e al coinvolgimento di più muscoli.','Consegna in 3-5 giorni lavorativi',3),
(8, 'Bumper Plate', 'images/bumper1.jpg', 'images/bumper2.jpg', 'images/bumper3.jpg', 'images/bumper4.jpg',2, 'Olympo Fitness, palestra, negozio palestra, Bumper Plate, techongym, peso libero,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 20, '15 kg', '25 cm x 10 cm x 5 cm', NULL, NULL,'Acciaio', 20, NULL, 'Realizzati in gomma completamente nera, questi dischi sono progettati per resistere a un uso intensivo e assicurare un ottimo assorbimento degli impatti e un buon rimbalzo. La texture opaca sui lati esterni dei dischi li rende meno vulnerabili ai graffi.','Consegna in 3-5 giorni lavorativi',3),
(9, 'Impact Whey Protein', 'images/prot1.jpg', 'images/prot2.jpg', 'images/prot3.jpg', 'images/prot4.jpg',3, 'Olympo Fitness, palestra, negozio palestra, proteine, myprotein, integratori,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 80, '25 kg', '15 cm x 15 cm', NULL, '3 L',NULL, 50, NULL, 'Siero di latte di prima qualità con ben 23 g di proteine per porzione, per garantirti le proteine di cui hai bisogno. E da dove viene questo siero di latte? Da mucche allevate al pascolo che producono il latte ed il formaggio che consumi quotidianamente -semplicemente filtrato ed atomizzato al fine di produrre sostanze nutritive completamente naturali.','Consegna in 3-5 giorni lavorativi',6),
(10, 'Clear Whey Isolate', 'images/isolate1.jpg', 'images/isolate2.jpg', 'images/isolate3.jpg', 'images/isolate4.jpg' ,3, 'Olympo Fitness, palestra, negozio palestra, proteine, myprotein, integratori,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 80, '25 kg', '15 cm x 15 cm', NULL, '2 L', NULL, 60, NULL, 'Clear Whey Isolate non è uno shake proteico qualunque. A partire da pregiate proteine di siero del latte idrolizzate abbiamo ricavato un’alternativa leggera e rinfrescante, più simile a un succo che a un frullato proteico a base di latte.','Consegna in 3-5 giorni lavorativi',6),
(11, 'Brownie proteico', 'images/brownie1.jpg', 'images/brownie2.jpg', 'images/brownie3.jpg', 'images/brownie4.jpg',3, 'Olympo Fitness, palestra, negozio palestra, proteine, myprotein, integratori ,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 80, '5 kg', '30 cm x 15 cm', NULL, NULL, NULL, 60, NULL, 'Con fino al 75% di zucchero in meno rispetto alle alternative standard dei supermercati, goditi uno spuntino pomeridiano senza rovinare tutti i progressi duramente guadagnati.','Consegna in 3-5 giorni lavorativi',6),
(12, 'Omega-3 Essenziale', 'images/omega1.jpg', 'images/omega2.jpg', 'images/omega3.jpg', 'images/omega4.jpg' ,3, 'Olympo Fitness, palestra, negozio palestra, vitamine, myprotein, integratori ,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 80, '5 kg', '30 cm x 15 cm', NULL, '0.5 L', NULL, 60, NULL, 'Gli omega-3 sono acidi grassi essenziali che il corpo non produce da solo, per cui è necessario ottenerli dall alimentazione. Si trovano naturalmente nell olio di pesce, ciò significa che può essere difficile ottenerne una quantità sufficiente soltanto dall alimentazione.','Consegna in 3-5 giorni lavorativi',6),
(13, 'Chest Press Delt-HM002A', 'images/chest1.jpg', 'images/chest2.jpg', 'images/chest3.jpg', 'images/chest4.jpg', 4, 'Olympo Fitness, palestra, negozio palestra, chest press, petto, Baodelong ,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 80, '85 kg', '130 cm x 95 cm x 103 cm', NULL, NULL,'Acciaio', 60, NULL, 'La chest press machine è una macchina isotonica concepita per eseguire il gesto multiarticolare di distensione del braccio con sovraccarico, utile soprattutto nel rinforzo del gran pettorale, ma che coinvolge anche il tricipite brachiale e il deltoide/spalla anteriore.','Consegna in 3-5 giorni lavorativi',4),
(14, 'Vogatore', 'images/vogatore1.jpg', 'images/vogatore2.jpg', 'images/vogatore3.jpg', 'images/vogatore4.jpg', 4, 'Olympo Fitness, palestra, negozio palestra, vogatore, petto, TechnoGym, ,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 120, '85 kg', '130 cm x 95 cm x 103 cm', NULL, NULL, 'Acciaio', 60, NULL, 'Progettato insieme agli atleti, con il vogatore puoi migliorare sia resistenza cardiovascolare che potenza tramite allenamenti total body sempre vari disponibili sulla app, e con la sensazione di vogata più realistica.','Consegna in 3-5 giorni lavorativi',3),
(15, 'Elliptical', 'images/Elliptical1.jpg', 'images/Elliptical2.jpg', 'images/Elliptical3.jpg', 'images/Elliptical4.jpg', 4, 'Olympo Fitness, palestra, negozio palestra, Elittica, gambe, TechnoGym, ,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 85, '85 kg', '130 cm x 95 cm x 103 cm', NULL,  NULL,'Acciaio', 60, NULL, 'Scopri il potere del tuo corpo con il movimento naturale e confortevole dall’impatto minimo sulle tue articolazioni.','Consegna in 3-5 giorni lavorativi',3),
(16, 'Artis Arm Curl',  'images/artis1.jpg', 'images/artis2.jpg', 'images/artis3.jpg', 'images/artis4.jpg', 4, 'Olympo Fitness, palestra, negozio palestra, Artis Arm Curl, braccia, TechnoGym, ,prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 90, '205 kg', '140 cm x 95 cm x 103 cm', NULL,  NULL,'Acciaio', 60, NULL, 'Artis Arm è specificamente progettata per allenare in modo sicuro ed efficace, ed in comoda posizione seduta, i muscoli delle braccia, specialmente i bicipiti.','Consegna in 3-5 giorni lavorativi',3);





ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `utente`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `faq`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `utente` (`utente`),
  ADD KEY `amministratore` (`utente`);

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
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `marca`
  MODIFY `ID` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `prodotto`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;




ALTER TABLE `prodotto`
  ADD CONSTRAINT `categoria` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `marca` FOREIGN KEY (`marca`) REFERENCES `marca` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;