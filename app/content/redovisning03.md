
<a id='kmom03'>Kmom03</a>
------

**Kursmomentet, allmänt**



**Vad tycker du om CSS-ramverk i allmänhet och vilka tidigare erfarenheter har du av dem?** 

Jag har inga erfarenheter av CSS-ramverk i praktiken. Jag har tittat lite på Bootstrap tidigare och läst om Blueprint och 960 gs, då jag har blivit tipsad om att man kan använda dessa. Jag förstod konceptet men tröskeln då var lite för hög för att sätta igång. Därför är jag glad att vi har kommit in på detta i kursen, det har ökat min förståelse. 

**Vad tycker du om LESS, lessphp och Semantic.gs?**

Jag tyckte inte att det var helt lätt att komma in i att använda det. LESS tilltalar mig, att man kan sätta värdet på en variabel på ett ställe och sedan återanvända den på flera ställen. Jag har testat SASS tidigare. Lessphp gick bra att installera, toppen att ha ett så enkelt verktyg för att kompilera LESS. Semantic.gs kändes lite rörigt, det är så mycket siffror att hålla rätt på, rena matematiken.

**Vad tycker du om gridbaserad layout, vertikalt och horisontellt?**

Jag tycker om konceptet med gridbaserad layout vertikalt, att dela in i kolumner. Extra fiffigt att man kan göra det responsivt på ett snyggt sätt. Det ser prydligt ut. Horisontellt upplevde jag att det var lite krångligare när det kom till typografin. Typografi har dock aldrig varit min starka sida. Tittar man på regionerna så ser det dock bra ut. Rutnät är väldigt praktiska att utgå ifrån när man ska göra layout, och gridbaserad layout känns som ett utmärkt verktyg. Problemet är kanske att det blir många små rutor att hålla reda på, och som jag nämnde tidigare finns det en matematisk aspekt i det hela (att göra uträkningar tråkar tyvärr ut mig lite). 

**Har du några kommentarer om Font Awesome, Bootstrap, Normalize?**

Jag gillar Font Awesome, det ser proffsigt ut att ha små ikoner och grafiska element på en hemsida. Dessutom är det roligt att man kan förstora, animera eller styla dem. Jag hade tänkt använda FA redan i html-kursen, och hade installerat det och lagt in ikoner på sidorna. Men så fick jag en massa valideringsfel, och valideringen var ju väldigt viktig under den kursen så jag vågade inte använda mig av Font Awesome utan gjorde mina egna ikoner. Upptäckte nu att Font Awesome återigen orsakar valideringsfel när man validerar CSS. Jag hoppas att det ska vara ok, det ingår ju trots allt i kursen att vi ska använda FA, så då måste det ju bli valideringsfel. Normalize är en bra grej. Att saker och ting hoppar runt beroende på vilken browser man tittar med är ett irritationsmoment, skönt att det finns en enkel lösning på det. Bootstrap har jag inte så mycket att säga om, jag har inte hunnit undersöka det så mycket. Jag hoppas att jag hittar tid att göra det, för det verkar användas en hel del.

**Beskriv ditt tema, hur tänkte du när du gjorde det, gjorde du några utsvävningar?**

Eftersom mitt tema till me-sidan är i lite dämpade toner tänkte jag att jag göra mitt eget tema i lite klarare färger. Några stora utsvävningar vill jag inte påstå att jag har gjort, det är ganska enkelt och påminner en del om mitt förra. Jag höll mig till det antal regioner, och placeringar av regioner efter rutnätet som var med i övningen. Om jag påbörjar något experiment är jag rädd att jag inte ska hinna resten av kursen. Jag lade in tre brytpunkter. Den stora layouten är så som jag har jobbat efter från början. Mellanlayouten har något större typsnitt och de fyra footer-col har delats upp på två rader. Vid den minsta layouten så är fontstorleken ännu större och featured, triptych och footer-col regionerna ligger alla på var sin rad.

**Extra**

Det extra jag har gjort är att förbereda så att temat ska vara lätt att styla. Html-elementet har fått en class döpt `$htmlclass` i tema-mallen. Css-klassen sätts i temats konigurationsfil `theme-grid.php`. Just nu används 'bright', man kan byta till 'moody' om man vill. Jag gjorde som så att jag lade in en `request->getRoute()` i min tema-mall som läggs till som en klass i body-elementet. Jag ville inte behöva skicka någon extra information från routern utan ville att namnet skulle hämtas automatiskt. På min tema-sajt har jag inte några sammansatta routenamn, så den kod jag har lagt in funkar för den sajten. I filen `site.less` har jag samlat klasserna för html och body som kan ändras. Jag lade även till i en av mina views (`theme/info`) så att man kan skicka med en css-klass från routern, för att kunna styla innehållet i regionerna på olika sätt.

Jag har inte gjort ett eget projekt av mitt tema på GitHub. Tills vidare nöjer jag mig med att uppdatera hela mitt projekt på GitHub. 

