
<a id='kmom05'>Kmom05</a>
------


**Var hittade du inspiration till ditt val av modul och var hittade du kodbasen som du använde?**

Jag läste igenom förslagen som fanns på dbwebb. Jag fastnade för "Innehåll i databasen" eftersom jag tänker att det är något jag vill ha på en webbplats. Tyckte också att det lät intressant att återanvända kod som jag redan skrivit och se om det går att anpassa. 

Jag tyckte också att HTML helpers kändes intressant, att automatiskt bygga upp tabeller, eftersom man ofta presenterar innehåll från databasen på det sättet.

Kodbasen hittade jag i de klasser jag redan byggt i oophp, CContent och CHTMLTable. Fast när det gäller CContent blev det istället DatabaseModel från phpmvc som fick utgöra den mesta av koden till modulen. Och i CHTMLTable fick jag förenkla ganska mycket för att göra det hanterbart just nu, det fick bli enbart en tabell, och ingen paginerings- eller sorteringsfuntion än så länge.

Det fanns många andra uppslag som kändes intressanta, som man skulle vilja ha med i sitt ramverk.

**Hur gick det att utveckla modulen och integrera i ditt ramverk?**

Jag började med Content-modulen. Tänkte att jag kunde använda det jag redan utvecklat i DatabaseModel, eftersom man gör samma saker med Content - sparar, tar bort, uppdaterar... Sedan, efter att ha läst lite mer om uppgiften, att man skulle bygga nåt som inte hade så många beroenden, insåg jag att det jag gjort var ju att göra den beroende av CDatabase. Och att jag dessutom slängt in lite CForm formulär här och där. Tänkte att jag fick tänka om, tänka enklare så att modulen skulle bli greppbar. Och då började jag även jobba med min SimpleHTMLTable för att göra en enklare modul ifall jag inte skulle hinna klart med den andra. Det gick ändå över förväntan att utveckla modulen och få det att fungera. Jag hade varit orolig inför uppgiften, men det var inte så svårt som jag trott, eftersom man kunde utgå från kod man tidigare gjort. 

**Hur gick det att publicera paketet på Packagist?**

Lättare än förväntat. Jag fick felmeddelanden ett par gånger, men av meddelandena man fick var det enkelt att förstå var man hade gjort fel (hade skrivit lite fel i composer.json-filen). Däremot var det lite knepigare att fixa kopplingen mellan Packagist och Github. Egentligen var det enkelt, men istället för att gå in på "Service" gick jag in på "Webhook" och förstod inte alls var jag skulle skriva in Packagist informationen... men till slut hittade jag rätt och då gick det lätt.  

**Hur gick det att skriva dokumentationen och testa att modulen fungerade tillsammans med Anax MVC?**

Dokumentationen är viktig att ha med, men jag är inte van att skriva dokumentation, så det är ganska svårt faktiskt. Jag känner ofta att jag saknar info i dokumentationer, men jag inser att det är svårt att avgöra vad som är viktigt att ta med. Man är så inne i sin kod eftersom man har ju har jobbat med den.

Att testa att modulen fungerade med Anax MVC gick smidigt. Jag gjorde en ny installation av anax för test. Laddade ner modulerna med composer som packagist paketen, och flyttade på min testfiler. När det gällde min Content modul fick jag skriva in ett beroende till CDatabase i Anax composer.json fil för att det skulle funka. 

**Gjorde du extrauppgiften? Beskriv i så fall hur du tänkte och vilket resultat du fick.**


**Om mina moduler**

**chtmltable**

chtmltable är skriven för att skapa enkla HTML-tabeller. Den stödjer inte paginering eller sortering, men man kan skapa länkar efter ett enkelt pattern och man kan konvertera vissa värden.

*  klassen  `SimpleHTMLTable.php` [(källkod)](source?path=app/src/HTMLTable/SimpleHTMLTable.php) 
*  exempelfilen `simplehtmltable.php` [(källkod)](source?path=kmom05/simplehtmltable.php).

Jag har installerat chtmltable i [min vanliga Anax-MVC installation](simplehtmltable.php)  och som ett paket från packagist [i en "ren" testinstallation av Anax-MVC](http://www.student.bth.se/~maje15/phpmvc/anax-test/webroot/simplehtmltable.php).  

Paketet finns på [GitHub](https://github.com/mariajonsson/chtmltable) och på [Packagist](https://packagist.org/packages/meax/chtmltable) och där kan man läsa Readme-filen.  

**ccontent**

ccontent är skriven för att hantera innehåll i form av blogposter eller innehållsposter. Den är en vidareutveckling på CContent från oophp-kursen. Med Content kan man skapa innehåll av olika typ. Jag har inte lagt in någon hantering för olika typer än, tänker att det kommer. Jag har lagt in fält där man kan ange filter, för jag tänker att man kanske vill kunna ha stöd av CTextFilter eller liknande. Det finns ett fält för författare (acronym), men det är inte kopplat till user än, det kändes för komplicerat att göra i detta läget, men det är en funktionalitet jag tänker mig kan skapas senare.

*  klassen `ContentBasic.php` [(källkod)](source?path=app/src/Content/ContentBasic.php), 
*  kontrollern `ContentBasicController.php` [(källkod)](source?path=app/src/Content/ContentBasicController.php) 
*  exempelfilen `basiccontent.php` [(källkod)](source?path=kmom05/basiccontent.php). 

Man behöver installera `CDatabase` för att modulen ska fungera. Paketet inluderar även `DatabaseModel.php` som skapades i tidigare kursmoment.

Jag har installerat ccontent i [min vanliga Anax-MVC installation](basiccontent.php) och som ett paket från packagist [i en "ren" testinstallation av Anax-MVC](http://www.student.bth.se/~maje15/phpmvc/anax-test/webroot/basiccontent.php).  

Paketet finns på [GitHub](https://github.com/mariajonsson/ccontent) och på [Packagist](https://packagist.org/packages/meax/ccontent) och där kan man läsa Readme-filen.  


**Vidareutveckling**

Jag har jobbat vidare med chtmltable och ccontent i mitt Anax-MVC. Till exempel så har jag arbetat vidare med `ContentBasicController()` och skapat en `ContentController()`. 

I den nya `ContentController()` har jag till exempel testat att använda mig av `SimpleHTMLTable()` för att skapa listor över innehållet för vissa sidor. 

Jag har även använt mig av `CForm()` för att skapa formulär för att lägga till och redigera innehåll. 

Jag har även börjat arbeta vidare med tänkta metoder i en `HTMLTable`, men inget av detta är färdigt nog för att bli egna moduler.  

Resultatet går att se under menyvalet "[Innehåll](content)". 
