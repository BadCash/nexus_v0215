<?=$content;  // Print out the markdown text ?>
<?php return; // Stop this included script and return to the script that included it ?>


<!-- 

	THE OLD REDOVISNING PAGE
	========================
	
-->


<h1>Redovisning</h1>


Filter
------

	<p>
		<?=CTextFilter::Filter( 'Clickable: http://www.google.com?q=search', array('clickable') ); ?>
	</p>
	<p>
		<?=CTextFilter::Filter( 'BBCode: A [b]bold[/b] word.', array('bbcode') ); ?>
	</p>
	<p>
		<?=CTextFilter::Filter( 'HTMLPurify: This <b>string</b> contains <span style="color: red;">HTML-tags</span> and a <script>alert(\'script\');</script>.', array('purify') ); ?>
	</p>
	<p>
		<?=CTextFilter::Filter( <<<EOD
Markdown 
--------

This text is written using *markdown syntax*.
EOD
, array('markdown') ); ?>
	</p>
	<p>
		<?=CTextFilter::Filter( <<<EOD
All filters
-----------

This text uses [b]all[/b] the filters at the same time. 

<script>
	alert('XSS');
</script>


Read more
---------
http://en.wikipedia.org/wiki/Markdown  
http://en.wikipedia.org/wiki/Bbcode  
http://htmlpurifier.org/  

EOD
, array('clickable', 'bbcode', 'markdown', 'purify') ); ?>
	</p>

	<h2>Mom05 - Innehåll</h2>
	<!--
		Fick problem med att sessionerna inte ville fungera, och kikade runt bland filerna för att se om det var någon ändring i den senaste versionen som gjorde att det strulade, men jag hittade inget konstigt. Efter mycket felsökande insåg jag att min lokala webbserver inte gillar namngivna sessioner, och det var alltså där felet låg! Jag borde ju ha kommit ihåg att jag har ändrat det tidigare både i denna kursen och de föregående...
		
		Intressant lösning med wrappern för HTMLPurifier! Jag antar att man egentligen skulle kunna strunta i att instansiera CHtmlPurifier, eftersom dess enda funktion ändå är statisk? Å andra sidan gör ju konstruktionen med $instance att man kan köra viss kod endast en gång (även om require_once() ju endast körs en gång ändå). Plus att man kan bygga ut klassen med icke-statiska funktioner i framtiden. Men helt klart intressant att se att man inte behöver följa en viss mall alltid.
	-->
	<p>
		<a href="<?=CNexus::Instance()->request->CreateUrl();?>">Nexus v0.2.15</a><br>
		<a href="<?=CNexus::Instance()->request->CreateUrl('source', 'display');?>">Källkod</a>
	</p>
	<p>
		
	</p>

	
	
	<h2>Mom04 - Modeller för login, användare och grupper</h2>
	<p>
		<a href="<?=CNexus::Instance()->request->CreateUrl();?>">Nexus v0.2.10</a><br>
		<a href="<?=CNexus::Instance()->request->CreateUrl('source', 'display');?>">Källkod</a>
	</p>
	<p>
		Har tidigare använt egna lösningar liknande CodeIgniters formhantering, så strukturen och tänket kändes igen direkt. Då har jag helt enkelt skrivit formuläret i HTML, samt lagt in PHP-funktioner i stil med
		<code><pre>
	&lt;input type="text" name="username" value="&lt;?php echo post_value('username', ''); ?&gt">
	&lt;?php display_errors('username'); ?&gt;
		</pre></code>
		Den andra variabeln i post_value()-anropet anger ett default-värde som används ifall $_POST inte innehåller fältet 'username'.
		Felmeddelanden har sparats lokalt i en global PHP-variabel, eftersom jag inte använt mig av redirects då det uppstått fel. Man kan väl kalla det ett slags latmans-MVC, där kontroller, modell och view ligger i samma fil men i olika funktioner. T.ex. display_myform(), exec_myform() samt en kontrollstruktur ute i det globala scopet.
	</p>
	<p>
		Jag tyckte CForm verkade lite för krångligt till en början med egna klasser för varje typ av formulärelement. Så när Mos föreslog den alternativa lösningen med en array så tyckte jag det blev mycket enklare och överskådligare!
	</p>
	<p>
		En detalj jag reagerade på i avsnittet om lösenord och salt/hash var följande kodstycke:
		<code><pre>
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
		</pre></code>
		Fick läsa om koden flera gånger för att hänga med i varför ingångsvariabeln $salt först är ett booleskt värde, och sedan helt plötsligt används för att lagra själva saltet... Även om koden ju fungerar rent tekniskt så är jag lite undrande till varför man skulle vilja återanvända variabler på ett så konstigt sätt? Det känns som en såndär grej som kan reta gallfeber på den stackare som någon gång ska gå igenom och ändra i koden...
	</p>	
	<p>
		Istället för extrauppgift tog jag mig an att integrera min Me-sida och source.php i ramverket, som egna applikationer under katalogen site/src. Me-sidan var inga större problem, den resulterade i en controller (CCMe) och två template-filer (hem.tpl.php och redovisning.tpl.php). 
		<br>
		Source.php var däremot betydligt krångligare! Jag utgick från den befintliga filen och försökte till en början få det att fungera tillsammans med URL-strukturen /source/display/katalog/underkatalog/fil.txt. Jag slet mitt hår i någon timme med det men fick inte rätt på sökvägarna, så jag bestämde mig till slut för att skriva om alltihopa för att få full koll på sökvägarna och vad som egentligen händer. 
		Efter ett par timmar fick jag allt att klaffa, och det resulterade i en controller (CCSource), en model (CMSource) och en view (source.tpl.php). Komplett med flashiga ikoner till på köpet!
	</p>
		
	<h2>Mom03 - En gästbok i ditt MVC-ramverk</h2>
	<p>
		<a href="../nexus_v019">Nexus v0.1.9</a><br>
		<a href="../source.php">Källkod</a>
	</p>
	<p>
		Jag läste igenom "Kom igång med CodeIgniter", men på grund av extrem tidsbrist skippade jag extrauppgiften att göra en gästbok i det ramverket. Jag tycker dock CodeIgniter verkar bra, att göra en gästbok i systemet var ju väldigt enkelt. Det är definitivt ett ramverk jag kommer kika närmare på framöver när jag får tid till det.
	</p>
	<p>
		MVC-strukturen börjar kännas riktigt självklar, jag gillar verkligen att man kan dela upp HTML-koden och PHP-koden på ett tydligt sätt. Till en början var jag lite förvirrad över Mos tilltag att lägga alla funktionerna för databasen i kontrollern - där började jag tvivla på att jag fattat hela MVC-grejen rätt. Men när han senare introducerade CMGuextbook-klassen så drog jag en lättnadens suck, eftersom det var precis så jag förväntat mig att det skulle se ut.
	</p>
	<p>
		Jag tittade på tråden om SPAM-hantering, och hade först förväntat mig något i stil med en CAPTCHA-lösning. Men lösningen med ett dolt email-fält var ju riktigt genialisk! Den ska definitivt testas i fortsättningen, man vet ju själv hur tråkigt det är att fylla i CAPTCHA-fält i formulär, så det är ju bättre ur användarvänlighetssynpunkt att sköta det hela bakom kulisserna.
	</p>
	<p>
		Efter att hittat ett par olikheter mellan Mos exempelkodsnuttar i instruktionerna och den riktiga koden på GitHub bestämde jag mig för att det var dags att sluta klippa och klistra koden i instruktionerna. Rätt vad det är så dyker det upp någon ändring som inte nämns i instruktionerna och så fungerar ingenting som det ska. Så nu bestämde jag mig istället för att läsa igenom alla instruktionerna, ladda ner hela den slutgiltiga koden från GitHub och i efterhand ändra det som behöver ändras. Speciellt frustrerande är att det ibland ändras i en funktion på ett ställe i instruktionerna, och längre ner i samma instruktion så ändras samma kod en gång till. Det går helt enkelt åt för mycket tid till att skriva om samma saker om och om igen. Bättre att lägga tiden på att sätta sig in i och förstå koden än att skriva den tycker jag.
	</p>
	<p>
		Blev glad att Mos valde den avancerade vyhanteringen, eftersom de första två varianterna kändes lite för primitiva. Ska det göras så ska det göras ordentligt, och nu fick man ju en riktigt bra separering av M, V och C. 
	</p>
	<p>
		En grej jag verkligen gillade var "flashminnet" i CSession. I tidigare projekt jag gjort har jag skött feedback till användaren antingen via GET-variabler eller PHP-variabler, men denna lösning ger ju en både enklare och mer pålitlig hantering då den klarar t.ex. redirects.
	</p>
<!--
	Skapa CObject som huvudklass för kontrollerna för att få tillgång till CNexus's variabler direkt i kontrollerna.
	 Rätt okej lösning, men kan man inte skapa en gemensam huvudklass för både CNexus och alla kontrollers/modeller/vyer?
	 En annan lösning vore att helt enkelt döpa CNexus till NX och Instance() till I - då behöver man bara skriva NX::I()...
	 
	 $formattedMethod - det står i instruktioerna att det räckte med att lägga till EN rad för att uppnå målet, men man måste
	 ju även ändra i referenserna till $method (eller döpa $formattedMEthod till $method istaället)
	 
	 i CCGuestbook finns inte $pageMessages deklarerad i instruktionerna, man får börja tanka från GitHub istället tydligen.
	 
	 Gav upp att försöka implementera ändringarna efter hand, eftersom det innebär att man ibland måste ändra variabelnamn mm. 
	  flera gånger efter att mos har ändrat sig... och att enbart klippa & klistra kodexempel är inte längre tillförlitligt.
	  
	Gillar vyhanteringen, skönt att slippa ha HTML-kod inbakad i variabler! Inte enbart för separeringens skull, men det 
	blir mer lättläst i editorn också. Den avancerade varianten av vyhantering föredrar jag, även om den är krångligare att
	göra så blir det enklare i slutänden.
	
	Gillar skarpt implementeringen av "flash"-minnet i CSession, något jag skött via get-variabler i tidigare projekt. 
	Detta är ju en betydligt enklare och mer pålitlig hantering.

-->


<h2>Mom02 - Grunden till ett MVC-ramverk</h2>
	<p>
		<a href="../nexus/developer/links/">Nexus</a><br>
		<a href="../source.php">Källkod</a>
	</p>
	<p>
		Jag valde att kalla mitt ramverk för "Nexus", eftersom jag tyckte det passar bra då ramverket (eller snarare controllern) fungerar som ett slags nav som binder samman olika delar av en komplett applikation. Min första tanke var att försöka få det att fungera ihop med HTML5-boilerplaten redan från början, men jag övergav snabbt de tankarna. Bättre att vänta med sådana detaljer tills det börjar bli mer färdigt, så jag slipper ändra om en massa i varje kursmoment.
	</p>
	<p>
		Jag följde tutorialen ganska till punkt och pricka, men nappade på erbjdandet om att skriva koden i CRequest som tolkar de olika länktyperna på egen hand. Jag lät denna kod bestå även efter steget i instruktionerna då denna funktionalitet implementerades i CRequest.
		Först hade jag denna lösning:
	</p>
	<p>
		<code><pre>
	if( $splits[0] == 'index.php' || $splits[0] == 'index.php?q=' ){
		array_splice($splits, 0, 1);
	}
		</pre></code>
	</p>
	<p>
		Men då den kräver att q-variabeln MÅSTE börja med en / för att fungera så bytte jag taktik. Den nya funktionen är
	</p>
	<p>	
		<code><pre>
	if( $splits[0] == 'index.php' ){
		array_splice($splits, 0, 1);
	}
	elseif( substr($splits[0], 0, 12) == 'index.php?q=' ){
		$splits = explode( '/', trim($_GET['q'], '/') );
	}
		</pre></code>
	</p>
	<p>
		Grundstrukturen i MVC'et verkar genomtänkt och flexibel, och även om det känns som att jag i framtiden kommer använda mig av något färdigt ramverk så är det bra att få en inblick bakom kulisserna redan nu.
	</p>
	<p>
		Jag tyckte det var väldigt utmanande att hänga med i instruktionerna trots att jag sysslat mycket med PHP och programmering tidigare. Steget från förra kursen (Databaser och objektorienterad PHP) var enormt!
	</p>
	<p>
		Jag kikade lite snabbt på den senaste versionen av Lydia, och komplexiteten i ramverket har verkligen ökat. Framförallt lade jag märke till att det verkade ha tillkommit stöd för olika språk och lokalisering, samt ett tillägg för att läsa in filer utöver de vanliga controller/method -URL'erna.
	</p>
	
<!--
		Först körde jag detta i CRequest:
		
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
		
-->
		
		
<h2>Mom01 - HTML5 boilerplate</h2>
	<p>
		<a href="hem.php">Om mig</a><br />
		<a href="source.php?dir=&file=hem.php">Källkod</a>
	</p>
	<p>
		Jag har genom tidigare programmeringserfarenheter stött på både GitHub och begreppet "Boilerplate", men aldrig haft tid och behov av att sätta mig in i närmare vad det innebär. Nu när jag fått en inblick i vad det egentligen är kommer jag kanske undra hur jag klarade mig utan dem förut...
	</p>
	<p>
		Jag gillar tanken med "HTML5 Boilerplate" - istället för att uppfinna hjulet på nytt varje gång en hemsida ska skapas från grunden, varför inte använda kunskap och erfarenhet från folk som gjort det tidigare?
	</p>
	<p>
		Eftersom jag aldrig varit en Unix-anhängare har jag lite svårt att ta till mig Git. Visst, tanken är ju såklart bra, men det känns ändå lite som att resa tillbaka till 80-talet med kryptiska kommandoradskommandon. Jag har läst igenom studiematerialet, laddat ner Git, skapat mig ett konto på GitHub och kört igenom "Try Git"-övningen, men är ändå inte övertygad om systemets förträfflighet. Antagligen mest p.g.a. att det verkar onödigt avancerat för mina behov just nu. Vi får se om jag ändrar uppfattning under kursens gång.
	</p>
	<p>
		Jag har gjort ett par större webbprojekt tidigare och har fått in en struktur i ryggmärgen som jag tycker fungerar bra. Denna består i att varje sida laddar in en header och footer som innehåller HTML-koden för allt utom själva innehållet på sidan. Därför körde jag detta upplägg även i denna uppgiften, genom att kopiera övre delen av index.html till min header.php och undre delen till footer.php. Det gör det relativt enkelt att uppdatera koden vid uppdatering av HTML5 Boilerplate.
	</p>
	<p>
		Utvecklingsmaskinen jag använder för tillfället är en MacBook Air. Men kodningen sköts i Windows 7 genom Parallels Desktop. Detta främst för den oöverträffade texteditorn Notepad++. Andra program jag använder är GIMP och FileZilla.
	</p>
	<p>
		Allt som allt var det enda riktiga bekymret i övningen att försöka lära känna (och komma överens med) Git. Förhoppningsvis kan det bli en bra bekantskap när jag bekantat mig närmre med systemet.
	</p>
