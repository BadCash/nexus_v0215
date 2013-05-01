Redovisning
===========

Mom05 - Innehåll
----------------
Nexus v0.2.15: http://www.student.bth.se/~mawi13/phpmvc/nexus_v0215/  
Källkod: http://www.student.bth.se/~mawi13/phpmvc/nexus_v0215/source/display  

Det första jag stötte på när jag laddade ner version 0.2.15 av Lydia och anpassade det till min installation var att jag fick problem med att sessionerna inte ville fungera, och kikade runt bland filerna för att se om det var någon ändring i den senaste versionen som gjorde att det strulade, men jag hittade inget konstigt. Efter mycket felsökande insåg jag att min lokala webbserver inte gillar namngivna sessioner, och det var alltså där felet låg! Jag borde ju ha kommit ihåg att jag har ändrat det tidigare både i denna kursen och de föregående...

Jag skumläste (!) artiklarna om "Att skriva för webben" och XSS. XSS har jag hört talas om förut, men har aldrig satt mig in i det ordentligt. SQL-injection har jag alltid sett till att skydda mig mot, men XSS verkar också kunna ställa till med en hel del bekymmer om man har otur. 

Jag tyckte det var en intressant lösning med wrappern för HTMLPurifier! Jag antar att man egentligen skulle kunna strunta i att instansiera CHtmlPurifier, eftersom dess enda funktion ändå är statisk? Å andra sidan gör ju konstruktionen med $instance att man kan köra viss kod endast en gång (även om require_once() ju endast körs en gång ändå). Plus att man kan bygga ut klassen med icke-statiska funktioner i framtiden. Men helt klart intressant att se att man inte behöver följa en viss mall alltid.

Extrauppgiften gick smärtfritt tyckte jag, även om jag först inte riktigt förstod hur funktionen CTextFilter::Filter($filters_array) skulle läggas upp. Jag tolkade den först som att Filter endast skulle aktivera vissa filter, och att man sedan skulle köra t.ex. CTextFilter::Run($text_string) för att applicera filtren. Men det kändes som en onödigt krånglig lösning, så jag bestämde mig istället för att baka in variabeln $text i funktionen Filter(). Självklart skulle man kunna ha båda två lösningarna - t.ex. funktionerna SetActiveFilters() + ApplyActiveFilters() samt Filter().

Som en fin avslutning på övningen gjorde jag om både min "Om mig"-sida och Redovisningssida till Markdown syntax. Jag valde dock att göra det enkelt för mig och inkludera template-filerna som tidigare, och de i sin tur skriver ut den formaterade markdown-filen. Egentligen skulle man kunna göra en funktion som direkt läser in och formaterar markdown-filer (vilket jag anar att Mos kommer att göra längre fram i kursen, därför gav jag mig inte på det nu). Ett problem jag stötte på med denna lösning var dock att jag var tvungen att använda kompletta URL'er för min länkar, istället för att använda mig av funktionen CreateUrl()... det kan ju såklart också åtgärdas om man ger sig den på det.


Mom04 - Modeller för login, användare och grupper
-------------------------------------------------
Nexus v0.2.10: http://www.student.bth.se/~mawi13/phpmvc/nexus_v0215/  
Källkod: http://www.student.bth.se/~mawi13/phpmvc/nexus_v0215/source/display  

Har tidigare använt egna lösningar liknande CodeIgniters formhantering, så strukturen och tänket kändes igen direkt. Då har jag helt enkelt skrivit formuläret i HTML, samt lagt in PHP-funktioner i stil med

		<input type="text" name="username" value="<?php echo post_value('username', ''); ?>">
		<?php display_errors('username'); ?>
		

Den andra variabeln i post_value()-anropet anger ett default-värde som används ifall $_POST inte innehåller fältet 'username'. Felmeddelanden har sparats lokalt i en global PHP-variabel, eftersom jag inte använt mig av redirects då det uppstått fel. Man kan väl kalla det ett slags latmans-MVC, där kontroller, modell och view ligger i samma fil men i olika funktioner. T.ex. display_myform(), exec_myform() samt en kontrollstruktur ute i det globala scopet.

Jag tyckte CForm verkade lite för krångligt till en början med egna klasser för varje typ av formulärelement. Så när Mos föreslog den alternativa lösningen med en array så tyckte jag det blev mycket enklare och överskådligare!

En detalj jag reagerade på i avsnittet om lösenord och salt/hash var följande kodstycke:

		public function CreatePassword($plain, $salt=true) {
			if($salt) {
			  $salt = md5(microtime());
			  $password = md5($salt . $plain);
			} else {
			  $salt = null;
			  $password = md5($plain);
			}
			return array('salt'=>$salt, 'password'=>$password);
		}
		

Fick läsa om koden flera gånger för att hänga med i varför ingångsvariabeln $salt först är ett booleskt värde, och sedan helt plötsligt används för att lagra själva saltet... Även om koden ju fungerar rent tekniskt så är jag lite undrande till varför man skulle vilja återanvända variabler på ett så konstigt sätt? Det känns som en såndär grej som kan reta gallfeber på den stackare som någon gång ska gå igenom och ändra i koden...

Istället för extrauppgift tog jag mig an att integrera min Me-sida och source.php i ramverket, som egna applikationer under katalogen site/src. Me-sidan var inga större problem, den resulterade i en controller (CCMe) och två template-filer (hem.tpl.php och redovisning.tpl.php).
Source.php var däremot betydligt krångligare! Jag utgick från den befintliga filen och försökte till en början få det att fungera tillsammans med URL-strukturen /source/display/katalog/underkatalog/fil.txt. Jag slet mitt hår i någon timme med det men fick inte rätt på sökvägarna, så jag bestämde mig till slut för att skriva om alltihopa för att få full koll på sökvägarna och vad som egentligen händer. Efter ett par timmar fick jag allt att klaffa, och det resulterade i en controller (CCSource), en model (CMSource) och en view (source.tpl.php). Komplett med flashiga ikoner till på köpet!


Mom03 - En gästbok i ditt MVC-ramverk
-------------------------------------
Nexus v0.1.9: http://www.student.bth.se/~mawi13/phpmvc/nexus_v019  
Källkod: http://www.student.bth.se/~mawi13/phpmvc/nexus_v019/source.php  

Jag läste igenom "Kom igång med CodeIgniter", men på grund av extrem tidsbrist skippade jag extrauppgiften att göra en gästbok i det ramverket. Jag tycker dock CodeIgniter verkar bra, att göra en gästbok i systemet var ju väldigt enkelt. Det är definitivt ett ramverk jag kommer kika närmare på framöver när jag får tid till det.

MVC-strukturen börjar kännas riktigt självklar, jag gillar verkligen att man kan dela upp HTML-koden och PHP-koden på ett tydligt sätt. Till en början var jag lite förvirrad över Mos tilltag att lägga alla funktionerna för databasen i kontrollern - där började jag tvivla på att jag fattat hela MVC-grejen rätt. Men när han senare introducerade CMGuextbook-klassen så drog jag en lättnadens suck, eftersom det var precis så jag förväntat mig att det skulle se ut.

Jag tittade på tråden om SPAM-hantering, och hade först förväntat mig något i stil med en CAPTCHA-lösning. Men lösningen med ett dolt email-fält var ju riktigt genialisk! Den ska definitivt testas i fortsättningen, man vet ju själv hur tråkigt det är att fylla i CAPTCHA-fält i formulär, så det är ju bättre ur användarvänlighetssynpunkt att sköta det hela bakom kulisserna.

Efter att hittat ett par olikheter mellan Mos exempelkodsnuttar i instruktionerna och den riktiga koden på GitHub bestämde jag mig för att det var dags att sluta klippa och klistra koden i instruktionerna. Rätt vad det är så dyker det upp någon ändring som inte nämns i instruktionerna och så fungerar ingenting som det ska. Så nu bestämde jag mig istället för att läsa igenom alla instruktionerna, ladda ner hela den slutgiltiga koden från GitHub och i efterhand ändra det som behöver ändras. Speciellt frustrerande är att det ibland ändras i en funktion på ett ställe i instruktionerna, och längre ner i samma instruktion så ändras samma kod en gång till. Det går helt enkelt åt för mycket tid till att skriva om samma saker om och om igen. Bättre att lägga tiden på att sätta sig in i och förstå koden än att skriva den tycker jag.

Blev glad att Mos valde den avancerade vyhanteringen, eftersom de första två varianterna kändes lite för primitiva. Ska det göras så ska det göras ordentligt, och nu fick man ju en riktigt bra separering av M, V och C.

En grej jag verkligen gillade var "flashminnet" i CSession. I tidigare projekt jag gjort har jag skött feedback till användaren antingen via GET-variabler eller PHP-variabler, men denna lösning ger ju en både enklare och mer pålitlig hantering då den klarar t.ex. redirects.


**Mom02 - Grunden till ett MVC-ramverk**
----------------------------------------
Nexus: http://www.student.bth.se/~mawi13/phpmvc/nexus_v0.1.2/developer/links/  
Källkod: http://www.student.bth.se/~mawi13/phpmvc/nexus_v0.1.2/source.php  

Jag valde att kalla mitt ramverk för "Nexus", eftersom jag tyckte det passar bra då ramverket (eller snarare controllern) fungerar som ett slags nav som binder samman olika delar av en komplett applikation. Min första tanke var att försöka få det att fungera ihop med HTML5-boilerplaten redan från början, men jag övergav snabbt de tankarna. Bättre att vänta med sådana detaljer tills det börjar bli mer färdigt, så jag slipper ändra om en massa i varje kursmoment.

Jag följde tutorialen ganska till punkt och pricka, men nappade på erbjdandet om att skriva koden i CRequest som tolkar de olika länktyperna på egen hand. Jag lät denna kod bestå även efter steget i instruktionerna då denna funktionalitet implementerades i CRequest. Först hade jag denna lösning:

		if( $splits[0] == 'index.php' || $splits[0] == 'index.php?q=' ){
			array_splice($splits, 0, 1);
		}
		

Men då den kräver att q-variabeln MÅSTE börja med en / för att fungera så bytte jag taktik. Den nya funktionen är

		if( $splits[0] == 'index.php' ){
			array_splice($splits, 0, 1);
		}
		elseif( substr($splits[0], 0, 12) == 'index.php?q=' ){
			$splits = explode( '/', trim($_GET['q'], '/') );
		}
		

Grundstrukturen i MVC'et verkar genomtänkt och flexibel, och även om det känns som att jag i framtiden kommer använda mig av något färdigt ramverk så är det bra att få en inblick bakom kulisserna redan nu.

Jag tyckte det var väldigt utmanande att hänga med i instruktionerna trots att jag sysslat mycket med PHP och programmering tidigare. Steget från förra kursen (Databaser och objektorienterad PHP) var enormt!

Jag kikade lite snabbt på den senaste versionen av Lydia, och komplexiteten i ramverket har verkligen ökat. Framförallt lade jag märke till att det verkade ha tillkommit stöd för olika språk och lokalisering, samt ett tillägg för att läsa in filer utöver de vanliga controller/method -URL'erna.


Mom01 - HTML5 boilerplate
-------------------------
Om mig: http://www.student.bth.se/~mawi13/phpmvc/me/hem.php  
Källkod: http://www.student.bth.se/~mawi13/phpmvc/me/source.php?dir=&file=hem.php  

Jag har genom tidigare programmeringserfarenheter stött på både GitHub och begreppet "Boilerplate", men aldrig haft tid och behov av att sätta mig in i närmare vad det innebär. Nu när jag fått en inblick i vad det egentligen är kommer jag kanske undra hur jag klarade mig utan dem förut...

Jag gillar tanken med "HTML5 Boilerplate" - istället för att uppfinna hjulet på nytt varje gång en hemsida ska skapas från grunden, varför inte använda kunskap och erfarenhet från folk som gjort det tidigare?

Eftersom jag aldrig varit en Unix-anhängare har jag lite svårt att ta till mig Git. Visst, tanken är ju såklart bra, men det känns ändå lite som att resa tillbaka till 80-talet med kryptiska kommandoradskommandon. Jag har läst igenom studiematerialet, laddat ner Git, skapat mig ett konto på GitHub och kört igenom "Try Git"-övningen, men är ändå inte övertygad om systemets förträfflighet. Antagligen mest p.g.a. att det verkar onödigt avancerat för mina behov just nu. Vi får se om jag ändrar uppfattning under kursens gång.

Jag har gjort ett par större webbprojekt tidigare och har fått in en struktur i ryggmärgen som jag tycker fungerar bra. Denna består i att varje sida laddar in en header och footer som innehåller HTML-koden för allt utom själva innehållet på sidan. Därför körde jag detta upplägg även i denna uppgiften, genom att kopiera övre delen av index.html till min header.php och undre delen till footer.php. Det gör det relativt enkelt att uppdatera koden vid uppdatering av HTML5 Boilerplate.

Utvecklingsmaskinen jag använder för tillfället är en MacBook Air. Men kodningen sköts i Windows 7 genom Parallels Desktop. Detta främst för den oöverträffade texteditorn Notepad++. Andra program jag använder är GIMP och FileZilla.

Allt som allt var det enda riktiga bekymret i övningen att försöka lära känna (och komma överens med) Git. Förhoppningsvis kan det bli en bra bekantskap när jag bekantat mig närmre med systemet. 
