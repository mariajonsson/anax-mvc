
<a id='kmom05'>Kmom05</a>
------


**Var hittade du inspiration till ditt val av modul och var hittade du kodbasen som du använde?**

Jag läste igenom förslagen som fanns på dbwebb. Jag fastnade för "Innehåll i databasen" eftersom jag tänker att det är något jag vill ha på en webbplats. Tyckte också att det lät intressant att återanvända kod som jag redan skrivit och se om det går att anpassa. 

Jag tyckte också att HTML helpers kändes intressant, att automatiskt bygga upp tabeller, eftersom man ofta presenterar innehåll från databasen på det sättet.

Kodbasen hittade jag i de klasser jag redan byggt i oophp, CContent och CHTMLTable. Fast när det gäller CContent blev det istället DatabaseModel från phpmvc som fick utgöra den mesta av koden till modulen. Och i CHTMLTable fick jag förenkla ganska mycket för att göra det hanterbart just nu, det fick bli enbart en tabell, och ingen paginerings- eller sorteringsfuntion än så länge.

**Hur gick det att utveckla modulen och integrera i ditt ramverk?**

Jag började med Content-modulen. Tänkte att jag kunde använda det jag redan utvecklat i DatabaseModel, eftersom man gör samma saker med Content - sparar, tar bort, uppdaterar... Sedan, efter att ha läst lite mer om uppgiften, att man skulle bygga nåt som inte hade så många beroenden, insåg jag att det jag gjort var ju att göra den beroende av CDatabase. Och att jag dessutom slängt in lite CForm formulär här och där. Tänkte att jag fick tänka om, tänka enklare så att modulen skulle bli greppbar. Och då började jag även jobba med min SimpleHTMLTable för att göra en enklare modul ifall jag inte skulle hinna klart med den andra. Det gick ändå över förväntan att utveckla modulen och få det att fungera. Jag hade varit orolig inför uppgiften, men det var inte så svårt som jag trott, eftersom man kunde utgå från kod man tidigare gjort. 

**Hur gick det att publicera paketet på Packagist?**

Lättare än förväntat. Jag fick felmeddelanden ett par gånger, men av meddelandena man fick var det enkelt att förstå var man hade gjort fel (hade skrivit lite fel i composer.json-filen). Däremot var det lite knepigare att fixa kopplingen mellan Packagist och Github. Egentligen var det enkelt, men istället för att gå in på "Service" gick jag in på "Webhook" och förstod inte alls var jag skulle skriva in Packagist informationen... men till slut hittade jag rätt och då gick det lätt.  

**Hur gick det att skriva dokumentationen och testa att modulen fungerade tillsammans med Anax MVC?**

**Gjorde du extrauppgiften? Beskriv i så fall hur du tänkte och vilket resultat du fick.**
