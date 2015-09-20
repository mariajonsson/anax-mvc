Jag har skapat två moduler för uppgiften i Kmom05: `chtmltable` och `ccontent`. Jag har även påbörjat lite vidareutveckling.

## chtmltable

chtmltable är skriven för att skapa HTML-tabeller. 

Innehåll:

*  klassen  `SimpleHTMLTable.php` [(källkod)](source?path=app/src/HTMLTable/SimpleHTMLTable.php) 
*  exempelfilen `simplehtmltable.php` [(källkod)](source?path=kmom05/simplehtmltable.php).

Jag har installerat chtmltable i [den här Anax-MVC installationen](simplehtmltable.php)  och som ett paket från packagist [i en "ren" testinstallation av Anax-MVC](http://www.student.bth.se/~maje15/phpmvc/anax-test/webroot/simplehtmltable.php).  

Paketet finns på [GitHub](https://github.com/mariajonsson/chtmltable) och på [Packagist](https://packagist.org/packages/meax/chtmltable) och där kan man läsa Readme-filen.  

## ccontent

ccontent är skriven för att hantera innehåll i form av blogposter eller innehållsposter. Den är en vidareutveckling på CContent från oophp-kursen.

Innehåll:

*  klassen `ContentBasic.php` [(källkod)](source?path=app/src/Content/ContentBasic.php), 
*  kontrollern `ContentBasicController.php` [(källkod)](source?path=app/src/Content/ContentBasicController.php) 
*  exempelfilen `basiccontent.php` [(källkod)](source?path=kmom05/basiccontent.php). 

Man behöver installera `CDatabase` för att modulen ska fungera. Paketet inluderar även `DatabaseModel.php` som skapades i tidigare kursmoment.

Jag har installerat ccontent i [den här Anax-MVC installationen](basiccontent.php) och som ett paket från packagist [i en "ren" testinstallation av Anax-MVC](http://www.student.bth.se/~maje15/phpmvc/anax-test/webroot/basiccontent.php).  

Paketet finns på [GitHub](https://github.com/mariajonsson/ccontent) och på [Packagist](https://packagist.org/packages/meax/ccontent) och där kan man läsa Readme-filen.  


## Vidareutveckling

Jag har jobbat vidare med chtmltable och ccontent i mitt Anax-MVC. Till exempel så har jag arbetat vidare med `ContentBasicController()` och skapat en `ContentController()`. 

I den nya `ContentController()` har jag till exempel testat att använda mig av `SimpleHTMLTable()` för att skapa listor över innehållet för vissa sidor. 

Jag har även använt mig av `CForm()` för att skapa formulär för att lägga till och redigera innehåll. 

Jag har även börjat arbeta vidare med tänkta metoder i en `HTMLTable`, men inget av detta är färdigt nog för att bli egna moduler.  

Resultatet går att se under menyvalet "[Innehåll](content)". 




