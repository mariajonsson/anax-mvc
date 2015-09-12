
<a id='kmom04'>Kmom04</a>
------

**Kursmomentet, allmänt**

Inför detta moment var jag lite nervös över att det skulle bli väldigt svårt. Kurslitteraturen gjorde mig inte så mycket klokare när det gällde Database Patterns t.ex. I början tog det ganska lång tid att gå tillbaka, läsa igen, kolla kod, skriva kod, testa för att få det att bli rätt. Men ju mer jag har jobbat med det, desto mer har jag lärt mig vad som funkar. Frågan är om det jag lär mig i Anax-MVC kommer att gå att tillämpa på något annat ramverk eller om det kommer att vara lika svårt eller svårare att lära sig från början. Jag tror jag har börjat lära mig mer skillnader och sambanden mellan dispatchers, views, controllers, routers etc. 

Den största delen av tiden lade jag på användar-implementeringen (även om kommentarerna tog en del tid att fixa till också). Det tar ju ändå en del tid att försöka få det att bli användbart och överskådligt. På förstasidan för "samtliga användare" kan man genom att klicka på en akronym få upp en användarprofil. Om man klickar på pennan kan man redigera användaren, och papperskorgssymbolen gör en soft-delete. Om man klickar på den lilla användare-symbolen framför akronymen kan man inaktivera och aktivera en användare. Och om användaren har lagt i papperskorgen kan man ta tillbaka den från papperskorgen på detta sätt. Användaren får då samma aktiv/inaktiv-status som den hade innan den lades i papperskorgen. En borttagen användare går inte att redigera uppgifterna för, den måste hämtas upp ur papperskorgen igen. Den kan också raderas permanent. 

Jag var lite konfunderad över instruktionen att användar-kontrollern skulle stödja routern `setup`, då de andra routrarna i kontrollern är på formen `users/view`, `users/edit` etc. Jag gjorde en router `setup` i frontkontrollern där man kan i en vy kan klicka på länken `users/reset-users` som finns i `UsersController()` som `resetUsersAction()`. 


**Vad tycker du om formulärhantering som visas i kursmomentet?**

Jag gillar verkligen tanken med att ha php-kod som skapar html-formulär och att det finns stöd för validering. Det kan vid första anblicken kanske kännas enklare att helt enkelt bara skriva in formuläret i html. Men det här var smidigt att kunna hämta upp värdena som postats i fälten genom t.ex. `$this->Value('content')`. Jag tror att jag fortfarande har en del att greppa kring formulärhanteringen.

Jag ändrade lite i koden formulärhanteringen för att få valideringsmeddelanden på svenska. Jag lade även till validering för webadresser eftersom jag hade det på mina sessions-kommentarer. Jag valde att låta formuläret acceptera antingen tom sträng eller ett regex pattern som motsvarar en websideadress. Jag valde att låta mina formulär ligga i egna klasser: `CFormUserAdd()`, `CFormUserUpdate()`, `CFormCommentAdd()`, `CFormCommentEdit()` och en ångra-knapp `CFormCommentUndo()`. Jag gillade tanken på att få mindre kod i kontrollern, så därför gjorde jag det valet.

**Vad tycker du om databashanteringen som visas, föredrar du kanske traditionell SQL?**

Jag är nu van vid att skriva SQL-frågor direkt, och därför kändes det lite konstigt, som att ta en lång omväg nu. Men det förenklar faktiskt en hel del nu när man slipper skriva explicita frågor. Jag gillar hur man kopplar upp sig till databasen, det känns flexibelt på något sätt, och att man rätt enkelt kan skapa olika modeller som använder sig av samma databasfunktionalitet.

**Gjorde du några vägval, eller extra saker, när du utvecklade basklassen för modeller?**

När jag gjorde basklassen för modeller gjorde jag inte så mycket extra. Jag lade till en egen funktion `deleteAll()` i min `CDatabaseModel()` som tar bort alla rader i tabellen, för att man skulle kunna ta bort alla kommentarer, eftersom den funktionen fanns i kmom02 för kommentarerna. När jag gjorde `Users()` lät jag den vara tom och ärva alla metoder från `CDatabaseModel()`. 

**Beskriv vilka vägval du gjorde och hur du valde att implementera kommentarer i databasen.**

När jag gjorde `Comments()` lade jag in några egna och modifierade metoder där, för att de skulle matcha de metoder som användes för `CommentsInSession()`, dvs samma namn på metoderna och samma parametrar, där man skickar in "pagekey" och "redirect"-sida. Min tanke var att jag skulle kunna återanvända min `CommentController()` klass. Bytte ut `CommentsInSession()`-instanser till `Comments`-instanser i min kontroller. Men så gick jag in på min kmom02-sida och såg att allt blivit trasigt, för den behövde ju fortfarande använda `CommentsInSession()` (den var inte rättad än så den var tvungen att fungera). Jag gjorde därför en ny kontroller, `CommentsController()` (lägg märke till det extra s:et efter "Comment" som skiljer klasserna åt. Jag behövde inte lika många metoder i min `Comments()` klass som i min `CommentsInSession()` eftersom callbackfunktionerna i mina formulär skötte insert, edit och update av mina kommentarer.

Jag stötte på andra små roadbumps när jag skulle anpassa kommentarerna till det nya, och samtidigt inte ändra för mycket för att den tidigare sidan fortfarande skulle fungera. Min dölj/visa-formulärfunktion använde sig av en länk som gjorde en `$_POST`, vilket fick mitt CFormUserAdd-formulär att tro att fälten var fel ifyllda innan man ens fyllt i något. Fick lösa detta med en switch()-lösning och redirects.

Jag valde att lägga till några fält i databasen som inte fanns för kommentarerna i sessionen. T.ex. 'id' och 'updated'. Det tidigare 'id':et baserades på vart i arrayen som kommentaren fanns, och det kunde vara flera array uppdelade efter en nyckel som berättade vilken sida som kommentarerna hörde till. I databasen ligger kommentarerna i samma tabell med löpande id-nr. Därför kan kommentarerna #1 och #3 vara på en sida och kommentarerna #2 och #4 på en annan. Fältet 'updated' används för att markera när en kommentar har uppdaterats.

Min tidsberäkning i kommentarerna (ex: "kommentaren skrevs för xx sekunder sedan") blev helt knasig eftersom tiden angavs i `time()` på ett ställe och `gmdate()` på ett annat. För att standardisera valde jag att formatera tiden som `date()`. 

**Gjorde du extrauppgiften? Beskriv i så fall hur du tänkte och vilket resultat du fick.**

Jag gjorde inte extrauppgiften. Jag tycker att det låter väldigt spännande och skulle vilja prova, men jag har lagt dubbelt så mycket tid på detta moment som de tidigare, och tänker att jag måste gå vidare till nästa moment så att jag inte halkar efter.

