
<a id='kmom02'>Kmom02</a>
------

**Kursmomentet, allmänt**: 

Det här kursmomentet kändes till en början väldigt svårt. Ramverk känns som väldigt avancerade saker och jag kommer nog att få jobba en hel del för att lära mig. Varje nytt moment i uppgifterna upplevdes som att jag var ute på lite djupt vatten eller testar på stapplande steg, härmar lite, och efter ett tag så kommer mer förståelse. Att skapa möjlighet att editera och radera enskilda kommentarer var ett sådant moment. Jag fick titta mycket på metoder och anrop och klicka fram och tillbaka för att förstå hur det hängde ihop. Mycket "tänka själv". Jag har jobbat i långsammare takt än vanligt för att ta mig tid att undersöka problem och inte stressa fram. 

För att kunna lösa uppgiften var det några metoder som tillkom i `CommentController` och `CommentsInSession`, för att visa redigerings-formulär, att plocka fram en enskild kommentar, att radera kommentar och spara en redigerad kommentar. Det blev en del ändringar för att skicka med info om vilken sida man kommer ifrån och ska skickas tillbaka till (`$pagekey`, `$redirect`) och id för kommentaren (`$id`). För att separarera kommentarsflödena tyckte jag att det var en bra lösning att spara flera vektorer i en flerdimensionell `$comments`-vektor. Dvs en vektor för varje sidas kommentarer. Kommentarer kan göras på förstasidan (me-sidan) och på sidan "Kommentarer".

När jag ändrade och lade till alla mina parametrar, blev det många ställen att ändra på i koden. Det fick mig att fundera på ifall jag borde ha kommit fram till en lösning där jag inte skulle ha ändrat så mycket i originalkoden?

**Composer**: 

Det var lite oklart för mig var jag skulle installera composer. Så först installerade jag det i en katalog och insåg att det då bara fungerade i den katalogens sökväg. Såg sedan hur man skulle göra för att få det att fungera globalt, genom att lägga i `user/local/bin`. Jag blev också lite fundersam till om man skulle köra composer för att installera samma paket både lokalt och på studentservern. I vilket fall så testade jag på studentservern också. Såg filerna när jag körde `dir` kommandot i putty, men inte när jag uppdaterade filstrukturen i filezilla, vilket jag tyckte var konstigt. Senare när jag loggade in igen såg jag dock filerna i filezilla, så det verkade fungera ändå. Det är väl en ganska smidig lösning att kunna ladda ner via kommandoterminalen med ett kort kommando och alla kataloger och filer lägger sig på rätt plats, redo att börja användas.

**Packagist**: 

Jag tittade igenom Packagist, tänkte att jag kanske skulle hitta något intressant till ramverket. Tyckte att det var lite svårt att "browsa" utan att ha någon idé om vad man sökte efter. Det kunde ha funnits kategorier att välja mellan t.ex. Jag sökte med "anax" som sökord men det verkade vara väldigt många "flash message"-paket för anax, vilket får mig att misstänka att det är/har varit en uppgift i någon kurs :). Eftersom jag ville lägga till validering av kommentarer letade jag efter paket med t.ex. epostvalidering och valde ett som jag testade att installera och det fungerade direkt att använda. Paketet jag valde var ganska enkelt, men jag valde det mest för att testa. Framöver kommer jag kanske att hitta fler. Cimage som man känner igen från förra kursen tror jag faktiskt att jag ska installera.

**klasser/kontroller/begrepp**: 

Jag tyckte till en början att det var svårt att greppa dispatchningen. Det är fortfarande inte helt solklart. Men i och med att man fick jobba in nya metoder i klasserna och anropa dem på olika sätt så förstod jag bättre hur de olika delarna hänger ihop. Det vill säga hur det fungerar praktiskt, men själva begreppen, som t.ex. tjänster, behöver jag fundera lite mer på. Jag funderade lite över varför vissa funktioner låg just i `CommentController` och andra i `CommentsInSession`. Kom fram till att just `CommentsInSession` kanske kan bytas ut mot `CommentsInDatabase` eller liknande, fast med metoder med samma namn som anropas i `CommentController`? Så behöver man inte byta ut båda klasserna.

**Svagheter i koden för phpmvc/comment**: 

Jag tänkte att den data som skickas in med formuläret kanske kunde valideras innan den sparas. T.ex. att kolla att hemsideadressen har formen av en hemsideadress och att e-postadressen har formen av en epostadress. Jag lade alltså till två metoder i `CommentController`: `validateCommentAction()` och `editFormAction()`. Den ena kollar datat som kommer in, sparar felmeddelande och returnerar antingen true eller false beroende på om datat är godkänt eller ej. Den andra visar en vy med det genererade felmeddelandet och ett formulär där man får ändra det inskrivna datat. I `validateCommentAction()` använder jag en metod från det paket jag laddade ner för epostvalidering. Jag skulle säkert ha kunnat skriva kod själv för det, men ville testa att installera ett till paket från Packagist. 

**Extra**: 

Jag lade till så att formuläret först är dolt och att man klickar på det för att få det att synas. Detta var knepigt. Först testade jag att göra en metod som hette showFormAction. Som nåddes genom routern `comment/show-form`. Vilket fungerade, men jag fick inte med allt innehåll jag ville ha på sidan, jag ville att den skulle stanna på samma sida, istället skapades en ny sida med bara formuläret. Så jag testade att skicka med en variabel `$show-form` i `$_GET` genom länken. Vilket fungerade på studentservern men inte lokalt (pga att jag just då inte fått snygga länkar att funka lokalt, kanske). Till sist skickade jag med variabeln `$show-form` med `$_POST` istället, länken fick fungera som ett formulär. Då hamnade jag på samma router som jag ville. 

Jag lade till gravatarikoner. Denna uppgift var betydligt enklare än visa/dölj formulär.
