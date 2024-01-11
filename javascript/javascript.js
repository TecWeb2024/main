
var checks = {};

//Aggiungi l'evento onBlur agli elementi del form
//IN SOSTANZA SE METTI DELLE COSE SBAGLIATE (ES. INPUT NON PERMESSI) IL CAMPO DIVENTA ROSSO
function addFieldsEvent(){

    let inputs    = document.getElementsByTagName('input');
    let selects   = document.getElementsByTagName('select');
    let textareas = document.getElementsByTagName('textarea');

    for (i = 0; i < inputs.length; i++) {
       inputs.item(i).addEventListener('blur',validateField);
    } 

    for (i = 0; i < selects.length; i++) {
        selects.item(i).addEventListener('blur',validateField);
    }

    for (i = 0; i < textareas.length; i++) {
        textareas.item(i).addEventListener('blur',validateField);
    }
    
}

//Validazione javascript dei form prima dell'invio
//CI SERVE PER FORZA
function validateField(event){

    let name = event.target.getAttribute('name');
    let value = event.target.value; //cerca nell'array dei controlli se esiste una regola per quel campo
    let aboveField = event.target.getAttribute("data-above") || 0;

    if(checks[name]){

        if(!checks[name].condition(value)){  //non passa il test
            
            //Togli il tag p di errore se già presente
            if(!aboveField){

                if(event.target.nextSibling){ 
                    if(event.target.nextSibling.tagName == 'P')
                      event.target.nextSibling.remove();
                }

            }else{
                
                if(event.target.previousSibling){
                    if(event.target.previousSibling.tagName == 'P')
                        event.target.previousSibling.remove();
                }
            }

            event.target.setAttribute('aria-invalid','true');

            //Crea tag <p> con il messaggio di errore
            let newElement = document.createElement('p');
            newElement.classList.add('formError');
            newElement.innerHTML = checks[name].message;

            //Classe di stile con errore
            event.target.classList.add('fieldError');

            //Inserisci il messaggio errore
            if(!aboveField){
                event.target.parentNode.insertBefore(newElement, event.target.nextSibling);
            }else{
                event.target.parentNode.insertBefore(newElement, event.target);
            }

        }else{
            //Controllo passato
            if(event.target.nextSibling){ //Togli il tag p di errore se già presente
                if(event.target.nextSibling.tagName == 'P')
                  event.target.nextSibling.remove();
                
                if(event.target.previousSibling.tagName == 'P')
                  event.target.previousSibling.remove();
            }
            event.target.setAttribute('aria-invalid','false');
            event.target.classList.remove('fieldError'); //Togli classe di errore dal campo
        }
    }
}



//QUESTI SONO DEI CHECK DELLA PAGINA CONTATTI, DOVE HANNO MESSO UN SACCO DI CAMPI DENTRO I QUALI SCRIVERE
function setContattiChecks(){

    checks = {
        nome:{
            message:"Inserire un nome lungo almeno 2 caratteri.",
            condition: function(str){
                return str.length>2;
            }
        },
        telefono:{
            message:"Inserire un numero di telefono valido composto da sole cifre numeriche.",
            condition: function(str){
                let expr = /^[0-9]+$/;
                return expr.test(str);
            }
        },
        email:{
            message:"Inserire un indirizzo <span lang='en'>email</span> valido.",
            condition: function(str){
                let expr = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return expr.test(str.toLowerCase());
            }
        },
        messaggio:{
            message:"Inserire un messaggio di almeno 10 caratteri.",
            condition: function(str){
                return str.length>=10;
            }
        },
        privacy:{
            message:'Per cortesia accettare la <span lang="en">Privacy Policy</span> per spedire il messaggio.',
            condition: function(str){
                return document.querySelector('input[name=privacy]').checked == true;
            }
        },
    }

}

   /*****************
   *                *
   *   AREA ADMIN   *
   *                *
   ******************/
//FATTO
function setAdminLoginChecks(){

    checks = {
        nome:{
            message:"Inserire un nome utente con almeno 3 lettere e/o numeri.",
            condition: function(str){
                let expr = /\w{3,}/ ;
                return expr.test(str);
            }
        },
        password:{
            message:"Inserire una <span lang='en'>password</span> con almeno 6 caratteri.",
            condition: function(str){
                return str.length>=6;
            }
        }
    };
}

//FATTO
function setAdminProdottoInserimentoChecks(){
   
    checks = {
        nome:{
            message:"Inserire un nome con almeno 5 caratteri.",
            condition: function(str){
                return str.length>=5;
            }
        },
    /*    immagine1:{ 
            message:"Inserire una immagine valida caricata nella cartella Images.",
            condition: function(str){
                return str.length>=5;
            }
        },
        immagine2:{ 
            message:"Inserire una immagine valida caricata nella cartella Images.",
            condition: function(str){
                return str.length>=5;
            }
        },
        immagine3:{ 
            message:"Inserire una immagine valida caricata nella cartella Images.",
            condition: function(str){
                return str.length>=5;
            }
        },
        immagine4:{ 
            message:"Inserire una immagine valida caricata nella cartella Images.",
            condition: function(str){
                return str.length>=5;
            }
        },*/
        categoria:{
            message:"Selezionare una categoria.",
            condition: function(str){
                return str!=0;
            }
        },
        /*keywords:{
            message:"Inserire delle <span lang='en'>keywords</span> che rispecchia il prodotto.",
            condition: function(str){
                return str.length>=5;
            }
        },*/
        prezzo:{
            message:"Inserire un prezzo numerico maggiore di 0.",
            condition: function(str){
                return (!isNaN(parseFloat(str))) && parseFloat(str)>0;
            }
        },
        peso:{
            message:"Inserire un peso con almeno 2 caratteri.",
            condition: function(str){
                return str.length>=2;
            }
        },
        dimensione:{
            message:"Inserire una dimensione con almeno 2 caratteri.",
            condition: function(str){
                return str.length>=2;
            }
        },
        colore:{
            message:"Inserire un colore con almeno 3 caratteri (es.'blu').",
            condition: function(str){
                return str.length>=3;
            }
        },
        volume:{
            message:"Inserire il volume del prodotto.",
            condition: function(str){
                return str.length!=0;
            }
        },
        materialeUtilizzato:{
            message:"Inserire il/i materiale/i utilizzato/i nel prodotto.",
            condition: function(str){
                return str.length!=0;
            }
        },
        quantita:{
            message:"Inserire la qunatità del prodotto.",
            condition: function(str){
                return str.length>0;
            }
        },
        taglia:{
            message:"Inserire la taglia del prodotto.",
            condition: function(str){
                return str.length!=0;
            }
        },
        descrizione:{
            message:"Inserire una descrizione con almeno 25 caratteri.",
            condition: function(str){
                return str.length>=25;
            }
        },
        tempoConsegna:{
            message:"Inserire una descrizione con almeno 2 caratteri.",
            condition: function(str){
                return str.length>=2;
            }
        },
        marca:{
            message:"Selezionare la marca del prodotto.",
            condition: function(str){
                return str!=0;
            }
        },
        //immagine controllata da PHP quando avviene l'upload
    }
}

//FATTO
function setAdminProdottoCancellazioneChecks(){
   
    checks = {
        nome:{
            message:"Inserire un nome con almeno 5 caratteri.",
            condition: function(str){
                return str.length>=5;
            }
        },

        categoria:{
            message:"Selezionare una categoria.",
            condition: function(str){
                return str!=0;
            }
        },
        /*keywords:{
            message:"Inserire delle <span lang='en'>keywords</span> che rispecchia il prodotto.",
            condition: function(str){
                return str.length>=5;
            }
        },*/
        prezzo:{
            message:"Inserire un prezzo numerico maggiore di 0.",
            condition: function(str){
                return (!isNaN(parseFloat(str))) && parseFloat(str)>0;
            }
        },
        dimensione:{
            message:"Inserire una dimensione con almeno 2 caratteri.",
            condition: function(str){
                return str.length>=2;
            }
        },
        colore:{
            message:"Inserire un colore con almeno 3 caratteri (es.'blu').",
            condition: function(str){
                return str.length>=3;
            }
        },
        quantita:{
            message:"Inserire la qunatità del prodotto.",
            condition: function(str){
                return str.length>0;
            }
        },
        taglia:{
            message:"Inserire la taglia del prodotto.",
            condition: function(str){
                return str.length!=0;
            }
        },
        marca:{
            message:"Selezionare la marca del prodotto.",
            condition: function(str){
                return str!=0;
            }
        },
        //immagine controllata da PHP quando avviene l'upload
    }
}

//FATTO
//NON SO SE CI SERVA
function setAdminCategoriaChecks(){
    checks = {
        nome:{
            message:"Inserire un nome con almeno 2 caratteri.",
            condition: function(str){
                return str.length>=2;
            }
        },
        keywords:{
            message:"Inserire delle <span lang='en'>keywords</span> della categoria desiderata.",
            condition: function(str){
                return str.length>=5;
            }
        },
    };
}


//FATTO
//NON SO SE CI SERVA,REGISTRAZIONE
function setAdminRegistrationChecks(){
    checks = {
        nome:{
            message:"Inserire un nome utente con almeno 3 lettere e/o numeri.",
            condition: function(str){
                let expr = /\w{3,}/ ;
                return expr.test(str);
            }
        },
        password:{
            message:"Inserire una <span lang='en'>password</span> con almeno 6 caratteri.",
            condition: function(str){
                return str.length>=6;
            }
        },
        email:{
            message:"Inserire un indirizzo <span lang='en'>email</span> valido.",
            condition: function(str){
                let expr = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return expr.test(str.toLowerCase());
            }
        }
    };
}


//FATTO
//FORSE CI POTREBBE SERVIRE CON LA DOMANDA APERTA DEL NOSTRO FAQ, QUESTO E' QUANDO L'ADMIN RISPONDE ALLA DOMANDA
function setAdminFAQChecks(){ //UN ADMIN NON PUO' INVENTARSI LE DOMANDE NELLA FAQ E RISPNDERSI, 1A PARTE DELLA FAQ STATICA IN HTML, PUO' SOLO INTERAGIRE CON IL CAMPO APERTO
    checks = {
        risposta:{
            message:"Inserire una risposta con almeno 20 caratteri.",
            condition: function(str){
                return str.length>=20;
            }
        }
    };
}




   /******************
   *                 *
   *   AREA UTENTE   *
   *                 *
   *******************/

//FATTO
//CI SERVE PER FORZA, PENSO SIA PARTE LOGIN
function setUserLoginChecks(){

    checks = {
        nome:{
            message:"Inserire un nome utente con almeno 3 lettere e/o numeri.",
            condition: function(str){
                let expr = /\w{3,}/ ;
                return expr.test(str);
            }
        },
        password:{
            message:"Inserire una <span lang='en'>password</span> con almeno 6 caratteri.",
            condition: function(str){
                return str.length>=6;
            }
        }
    };

}




//FATTO
//FORSE QUESTO CI PUO' AIUTARE QUANDO L'UTENTE INSERISCE LA DOMANDA APERTA NEL FAQ
function setUserDomandaApertaChecks(){
    checks = {
        domanda:{
            message:"Inserire la domanda aperta con almeno 5 caratteri.",
            condition: function(str){
                return str.length>=5;
            }
        }
    };
}

//FATTO
//CI SERVE PER FORZA
function setUserRegistrationChecks(){
    checks = {
        nome:{
            message:"Inserire un nome utente con almeno 3 lettere e/o numeri.",
            condition: function(str){
                let expr = /\w{3,}/ ;
                return expr.test(str);
            }
        },
        password:{
            message:"Inserire una <span lang='en'>password</span> con almeno 6 caratteri.",
            condition: function(str){
                return str.length>=6;
            }
        },
        email:{
            message:"Inserire un indirizzo <span lang='en'>email</span> valido.",
            condition: function(str){
                let expr = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return expr.test(str.toLowerCase());
            }
        }
    };
}

//DA CONTROLLARE PARTE GRAFICA
//Aggiungi listener per evento scroll
//per il pulsante "torna in cima alla pagina"
//CI POTREBBE TORNARE UTILE
function addScrollEventListener(){
    window.addEventListener("scroll",toggleUpButton)
}

//Mostra o nascondi il pulsante "torna in cima alla pagina"
//in base alla posizione di scroll
//CI POTREBBE TORNARE UTILE
function toggleUpButton(){

    let button = document.getElementById('buttonToTop');
    let scrollPos = window.scrollY || window.scrollTop || document.getElementsByTagName("html")[0].scrollTop;
    
    let body = document.body; 
    let html = document.documentElement;

    let bodyHeight = Math.max( body.scrollHeight, body.offsetHeight, 
        html.clientHeight, html.scrollHeight, html.offsetHeight );

    if(scrollPos>bodyHeight/6){
        button.classList.add('show');
    }else{
        button.classList.remove('show');
    }

}