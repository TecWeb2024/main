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
(1, 'User', 'user@user.com', 'user', 0),
(2, 'Admin', 'admin@admin.com', 'admin', 1);




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
INSERT INTO `prodotto` (`ID`, `nome`, `immagine1`, `immagine2`, `immagine3`, `immagine4`, `categoria`, `keywords`, `prezzo`, `peso`, `dimensione`, `colore`, `volume`, `materialeUtilizzato`, `quantita` , `taglia` , `descrizione`, `tempoConsegna`, `marca`) VALUES
(1, 'Borsone Adidas', 'images/BorsoneDavanti.jpg', 'images/BorsoneDietro.jpg', 'images/BorsoneAperto.jpg', 'images/BorsoneChiuso.jpg', 1, 'Olympo Fitness, palestra, negozio palestra, borsone, borsone adidas, adidas, prodotto palestra, prodotto, pesi liberi , macchinari palestra, macchinari, nutrizione', 35, '1.5 kg', ' 22 cm x 56 cm x 28 cm', 'Nero', '39 L', 'tela, 100% poliestere riciclato', 10, 'XL', 'La scelta ideale per la palestra e le gite nel weekend. Questo borsone adidas ha una base robusta per proteggere il contenuto. Lo scomparto principale è dotato di una zip bidirezionale per un accesso rapido da entrambi i lati.\r\nLe numerose tasche offrono la massima praticità e lo scomparto interno ti consente di tenere separate le sneaker.', 'Consegna in 3-5 giorni lavorativi', 5),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16);









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