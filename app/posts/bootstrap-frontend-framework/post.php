<h2>Įvadas</h2>

<h3>Kas yra Bootstrap ir kam jis skirtas</h3>

<p>Bootstrap - frontendo frameworkas. Turi paruoštą bazę - globalūs stiliai, CSS resetai ir grid sistema ant kurios labai patogu greitai pasikelti bet kokį nesudėtingą layoutą. Pasikėlus layoutą bootstrap frameworkas iš karto siūlo savoi aprašytą tvarkingos tipografijos stilių, taipogi stilius lentelėms, formoms, mygtukams ir ikonėlėms.<br />
Papildomai galima naudoti bootstrapo vartotojo sąsajos komponentus, tokius kaip tab'ai, navigacijos juostos, pranešimų langai, puslapių headeriai ir t.t. http://twitter.github.com/bootstrap/components.html  Į pagalbą pasitelkian JS bootstrap'as siūlo interaktyvius komponentus, tokius kaip tooltipai, modaliniai langai, dropdowns input fields ir t.t. (http://twitter.github.com/bootstrap/javascript.html)<br />
Trumpai tariant - bootstraps duoda HTML struktūros ir CSS bazę, ant kurios galima pakelti web aplikaciją atrodančią tvarkingai.<br />
<a href="http://twitter.github.com/bootstrap/">Bootstrap namai</a></p>

<h3>Kada naudoti framework? Kada ne?</h3>

<p>Man bootstrapas sutaupo nemažai laiko paleidinėjant web projektus. Negana to, kad mažiau laiko sugaištu HTML+CSS layouto pasikėlimui, bet dar tuo pačiu gaunu responsive dizainą ir netgi suderinamumą su IE7.<br />
Nori sutaupyti laiko? Naudok frameworką.<br />
Bet yra įvairių bet. Viskas labai priklauso ir nuo projekto, prie kurio dirbsite. Jeigu projektas turi sudėtingą dizainą ir reikalaujama, kad puslapis būtų pixel perfect, o dizaineris nežinojo apie grid system - pražilsit bandydami layoutą sudėlioti ant frameworko grid sistemos ir komponentus suderint su tuo kas nupiešta dizainerio. Tokiu atveju, kai turite sudėtingą grafinį dizainą ir reikalaujama pixel perfect - rinkčiausi rašyti CSS nuo nulio.<br />
Frontend frameworkas idealiai tinka projektam, į kuriuos nėra prasmės investuoti į dizainą, ar tiesiog nėra kam užsiimti dizainu - pasiimi, pasidėlioji komponentus - turi tvarkingą ir gan solidų vaizdą.<br />
Sudėtingiau su projektais, kuriems yra ruošiamas dizainas. Šioje vietoje kyla tema apie dizianų ruošimo principus, bet šį kartą į tai nesigilinsiu. Įsivaizduokime, kad paruoštas dizainas yra PSD failas. Tokiais atvejais labai svarbu, kad dizaineris naudotų grid sistemą ir dizaino komponentai būtų protingai išlygiuoti tame gride. Tokiu atveju galim daryti prielaidą, kad dizainą bus įmanoma integruoti su bootstrapu. Kad galutinai įsitikintume, kad galim naudoti boostrapą turim įsivertinti ar dizainerio naudota grid sistema suderinama su bootstrapu. Bootstrapas turi galimybę per kintamuosius konfigūruoti gridą - stulpelių skaičių (@gridColumns), stulpelio plotis (@gridColumnWidth) ir tarpų tarp stulpelių dydis (@gridGutterWidth). Būtent tai ir turėtume įsivertinti, ar tikrai galim sukonfigūruoti bootstrapo gridą pagal dizainerio naudojamą.<br />
Jeigu gridus pavyksta suderint - super, pusę darbo turim, nebereikia patiem rašytis. Jei neturim - tada galim toliau vertinti ką galim panaudoti iš bootsrapo. Aš kaip pagrindinius komponentus dizaine vertinu formas, lenteles, mygtukus - žiūrim ką turim dizaine ir vertinam ar tai suderinama su bootstrapu. Jei suderinama - puiku, pritaikę stilių prie dizaino galim naudoti bootstrapo komponentus.<br />
Dar kada verta naudoti frameworką - jeigu turim PSD dizainą desktop versijai ir reikia mum responsive dizaino, bet niekas nesiruošia piešti visų dizainų. Tokiu atveju responsive dalis turėtų būti daroma prieinant kompromiso su dizaineriu kas ir kur aukojama dizaine, kai jis scale'inamas mažesniam ekranui. Ką laimim tokiu atveju - nereikia dizainerio laiko paruošti dar dvi dizaino versijas tabletui ir mobile'ui, tai padaroma HTML'erio su dizainerio guideline'ais.<br />
Jeigu abejojat ar jum verta naudoti frontend frameworką - tiesiog imkit ir pabandykit padirbėti bootstrap ar kitu. Manau tikrai gausit naudos iš to. Jeigu nesutaupysit laiko, gal išmoksit ką nors naujo HTML+CSS srityje?</p>

<h2>Bootstrap naudojimas</h2>

<p>Praktinė dalis - bandom bootstrap. Norėdamas išlaikyt tvarką projektuose, visom third-party bibliotekom įtraukti į projektą naudoju composer. Bootstrap neišimtis.<br />
composer.json:</p>

<pre><code>{
    "name": "fotelis/projektas",
    "description": "Fotelio bootstrap projektas",
    "require": {
        "twitter/bootstrap": "dev-master"
    },
    "authors": [
        {
            "name": "Zilvinas Kuusas",
            "email": "info@fotelis.lt"
        }
    ]
}
</code></pre>

<p>Instaliuojame composer</p>

<pre><code>composer install
</code></pre>

<p>Kuriame projekto struktūrą</p>

<pre><code>mkdir -p src/twitter/bootstrap/less
mkdir -p web/assets/css
mkdir -p web/assets/img
mkdir -p web/assets/js
touch src/twitter/bootstrap/less/bootstrap.less
touch src/twitter/bootstrap/less/bootstrap-responsive.less
touch src/twitter/bootstrap/less/app.less
touch web/index.html
cp -r vendor/twitter/bootstrap/img/ web/assets/img
cp -r vendor/twitter/bootstrap/js/ web/assets/js
</code></pre>

<p>Į bootstrap.less įdedam eilutę, kad importuotume originalų bootstrap.less failą</p>

<pre><code>@import "../../../../vendor/twitter/bootstrap/less/bootstrap.less";
@import "app.less";
</code></pre>

<p>Į bootstrap-responsive.less:</p>

<pre><code>@import "../../../../vendor/twitter/bootstrap/less/responsive.less";
</code></pre>

<p>Idėja - paveldėti visus stilius iš bootstrapo, o pas save perrašyti (override) tai, ką reikia. Taip išlaikom veikiančius visus bootstrapo komponentus ir nesukam galvos kaip kiekvieną komponentą nepamiršti aprašyti vis naujam projektui. Tuo pačiu mūsų naudojamas bootstrapas bus up-to-date. Parsisiuntus (su composer) naują bootstrap versiją pakeitimai mūsų projekte išliks, nes mes neliečiam bootstrapo failų, kurie  gali būti atnaujinami.<br />
Prieš atnaujindami bootstrapą pasitikrinkite changelog - ar pakeitimai nesugriaus jūsų projekto. Dėl to composer.json vertėtų nurodyti konkrečią naudojamą bootstrapo versiją.<br />
Savo aplikacijos kodą dėsim į atskirą failą - app.less. Vėliau turėsim galimybę jį sukompiliuoti atskirai nuo bootstrap, kad galėtume įvertinti tik aplikacijos CSS dydį, selektorių performance ir pan.</p>

<p>web/index.html turinys (vienas iš numatytųjų bootstrap layoutų):</p>

<ul>
<li>Parsisiųsti index.html iš <a href="https://github.com/kuusas/do-stuff-examples/blob/master/example-bootstrap-frontend-framework/web/index.html">example-bootstrap-frontend-framework@GitHub</a></li>
</ul>

<h3>Kompiliuojam LESS'ą</h3>

<p>Apie LESS rašiau ankstesniame poste <linkas></p>

<pre><code>lessc src/twitter/bootstrap/less/bootstrap.less &gt; web/assets/css/bootstrap.css
lessc src/twitter/bootstrap/less/bootstrap-responsive.less &gt; web/assets/css/bootstrap-responsive.css
</code></pre>

<p>Atsidarom web/index.html - tai mūsų standartinis bootstrapo template.</p>

<h3>Failų struktūra</h3>

<p>Failus išskirstau pagal bendrinius kodo skirstymo principus. 
* src/ - mano projekto source
* vendor/ - trečių šalių bibliotekos
* web/ - viešai (per www) pasiekiami failai
* web/assets/ - projekto frontendo turtai
* web/assets/css/ - production ready css (sugeneruotas less, sucompressintas). Rankomis failai neliečiami.
* web/assets/img/ - production ready images. Rankomis failai neliečiami.
w* eb/assets/js - production ready JS. Čia dedu tim su UI susijusį JavaScript.</p>

<p>Kodėl folderiuose web/assets/css/ ir web/assets/css/img esantys failai rankomis neliečiami? Nes jie čia atsiranda generuojant projekto source.</p>

<p>Projekto source laikome src/ folderyje ir atitinkama viduje folderių struktūrą kokią vendor biblioteką extendinam. Šiuo atveju src/twitter/bootstrap. Čia jau išlaikom tokią pačią struktūą kokia ir yra tos bibliotekos vendor folderyje. T.y. yra /vendor/twitter/bootstrap/less/variables.less, mes norėdami perrašyti (override) šį failą sukuriame /src/twitter/bootstrap/less/variables.less. Kodėl - kad būtų aišku koks failas yra perrašomas. Kad mūsų failas paveldėtų vendor'iuose esančias failo savybes turim pradžioje tą failą importuoti:</p>

<pre><code>@import "../../../../vendor/twitter/bootstrap/less/variables.less";
</code></pre>

<p>Ir dabar visi kintamieji, kuriuos apsirašysime savo (src/.../variables.less) faile perrašys vendor esančią reikšmę.</p>

<h2>Pagalbiniai įrankiai</h2>

<h3>Makefile</h3>

<p>Atrodo labai daug komandų? Darbo supraprastinimui galiu pasiūlyti bash Makefile, kurį naudoju savo bootstrapo projektam.</p>

<ul>
<li>Siųskitės <a href="https://github.com/kuusas/tools/blob/master/Bootstrap/Makefile">Makefile@GitHub</a>.</li>
</ul>

<p>Make - pagalbinė programa skirta buildinti source (ar kitą) kodą pagal instrukcijas aprašytas failuose vadinamais "makefile".<br />
Linux distribucijose turėtumėt turėti by default.<br />
OSX - reikia susiinstaliuoti XCode komponentą "Command Line Tools".
Windows - sakykim, kad neįmanoma.</p>

<p>Parsiųstą Makefile pasidėkite savo projekto root'e, tuo pačiu pavadinimu "Makefile" ir galite naudotis.</p>

<h3>Makefile naudojimas</h3>

<p>Komandų paleidimas - simple, tiesiog konsolėj ar kaip bevadintumėt savo CLI (komandinę eilutę) būdami projekto root'e, ten kur ir pasidėjot failą Makefile, tiesiog leiskite komandas.<br />
Komandos leidžiamos</p>

<pre><code>make &lt;komanda&gt;
</code></pre>

<h4>Konfigūracija</h4>

<p>Pradžioje aprašyti path'ų kintamieji:
projekto source</p>

<pre><code> SRC = src/twitter/bootstrap
</code></pre>

<p>projekto assets</p>

<pre><code> ASSETS = web/assets
</code></pre>

<p>projekto vendor</p>

<pre><code> VENDOR = vendor/twitter/bootstrap
</code></pre>

<p>projekto dev versija (projekto html - viena repozitorija, projekto dev - kita repozitorija). Šiuo atveju nurodoma lygiu aukščiau esančią projekto direktoriją</p>

<pre><code> DEV_ASSETS = ../&lt;project&gt;/web/assets
</code></pre>

<h4>Komandos</h4>

<h4>bootstrap</h4>

<pre><code> make bootstrap arba tiesiog make
</code></pre>

<p>Sukompiliuoja LESS į CSS ir padeda į assets direktoriją (web/assets/css/)
Perkopijuoja paveikslėlius iš vendor ir iš src į assets direktoriją.</p>

<h4>init</h4>

<pre><code> make init
</code></pre>

<p>Sukuria pradinę failų struktūrą projektui. src ir web/assets direktorijas, pradinius src/twitter/bootstrap/less/bootstrap.less, responsive.less ir variables.less, kurie paveldi pagrindinius bootstrapo failus.</p>

<h4>extend</h4>

<pre><code> make extend COMPONENT=&lt;komponentas&gt;
</code></pre>

<p>Sukuria bootstrapo paveldėjimo failą, kuriame galime override'int bootstrap funkcionalumą. Turi būtinai egzistuoti vendor/twitter/bootstrap/less/<komponentas>.less failas.</p>

<h4>usejs</h4>

<pre><code> make usejs NAME=&lt;js-pavadinimas&gt;
</code></pre>

<p>Perkopijuoja bootstrapo JS iš vendor/twitter/bootstrap/js/<js-pavadinimas>.js į web/assets/js, kad galėtume naudoti JS savo projekte mum telieka įdėti į html</p>

<pre><code> &lt;script src="assets/js/&lt;js-pavadinimas&gt;.js"&gt;&lt;/script&gt; 
</code></pre>

<h4>watch</h4>

<pre><code> make watch 
</code></pre>

<p>Laukia failų pakeitimų src/twitter/bootstrap/ direktorijoje ir įvykus jiem paleidžia komandą make bootstrap. Išsaugojus LESS failą ar įdėjus paveikslėlį mum iškarto subuildinamas CSS ir perkopijuojami paveikslėliai į reikiamą vietą, t.y. web/assets, mes negaišdami laiko tam skirtos laiko komandos paleidimui, atlikus pakeitimus, tik atsidarome naršyklę ir žiūrime kokį rezultatą turim.
* kad galėtume naudoti šią komandą turime turėti watchr https://github.com/mynyml/watchr</p>

<h4>showcss</h4>

<pre><code> make showcss
</code></pre>

<p>Sukompiliuoja ir į konsolę išveda mūsų aplikacijos CSS kodą (app.less), kad galėtume greitai įvertinti ar nepersistengta su LESS'u ir neturime per daug sudėtingų selektorių ir pan.
Pasinaudodami bash'o galimybėmis galime outputą išsaugoti į failą</p>

<pre><code> make showcss &gt; app.css
</code></pre>

<p>Dabar galime įvertinti aplikacijos stilių apimtį (app.css failo dydį).</p>

<h4>deploy</h4>

<pre><code> make deploy
</code></pre>

<p>Deployinam html assetus į dev versiją. Sumažina rankinio darbo failų kopijavimui. Paleidus komandą tiesiog perkopijuojami failai esantys web/assets/img, css/ ir js/ į projekto dev versijos assets atitinkamas direktorijas.</p>

<h3>Bootstrap dizainas</h3>

<h4>HTML Layout</h4>

<p>Nuo ko pradėti kurti savo custom HTML layout? Kaip pavyzdį pasiimkime gan standartinį header, content, sidebar, footer layoutą.
<img src="/media/posts/bootstrap-frontend-framework/img/layout.jpg" alt="Standartinis header, content, sidebar, footer layoutas" /></p>

<p>Eilutės, stulpeliai: kas tie .row, .span*, .offset*?
Toliau viduje dėliojame struktūrą:</p>

<pre><code> &lt;div class="container"&gt;
      &lt;header class="row-fluid"&gt;
                ...
      &lt;/header&gt;

      &lt;div class="row-fluid"&gt;
           &lt;div class="span8&gt;
                ...
           &lt;/div&gt;
           &lt;div class="span3 offset1&gt;
                ...
           &lt;/div&gt;
      &lt;/div&gt;

      &lt;footer class="row-fluid"&gt;
           ...
      &lt;/footer&gt;
 &lt;/div&gt;
</code></pre>

<p>Bootstrapo layouto principas - turim konteinerį</p>

<pre><code> &lt;div class="container"&gt;
      …
 &lt;/div&gt;
</code></pre>

<p>į kurį dedama eilutė</p>

<pre><code> &lt;div class="row-fluid"&gt;
      …
 &lt;/div&gt;
</code></pre>

<p>eilutė užpildoma stulpeliais turinčiais klases .span* ir .offset*,</p>

<pre><code> &lt;div class="span8&gt;
      ...
 &lt;/div&gt;
 &lt;div class="span3 offset1&gt;
      ...
 &lt;/div&gt;
</code></pre>

<p>kurių skaičių, nurodytų prie klasių, maksimali suma lygi 12 (default reikšmė), arba tiek, kiek nurodome bootstrapo variables.less konfige</p>

<pre><code> @gridColumns:             12;
</code></pre>

<h4>Nestingas</h4>

<p>Visada galima giliau skaidyti layoutą ir į .span* elementus dėti naujas eilutes.</p>

<pre><code>&lt;body&gt;
      ...
      &lt;div class="span8&gt;
           &lt;div class="row-fluid"&gt;
                &lt;div class="span6"&gt;
                     ...
                &lt;/div&gt;
                &lt;div class="span6"&gt;
                     ...
                &lt;/div&gt;
           &lt;/div&gt;
      &lt;/div&gt;
      ... 
 &lt;/body&gt;
</code></pre>

<p>Nestinant eilutes idėja skaičiuojant pločius išlieka ta pati - .row-fluid esančių .span* elementų pločiai skaičiuojami procentaliai nuo eilutės (.row-fluid) pločio. Eilutė visada paveldi tėvinio elemento plotį. Šiuo atveju .row-fluid plotis bus lygus .span8 pločiui.</p>

<p>Nestinant eilutes reikia nepamiršti taisyklės, kad viduje esančių .span* ir .offset* elementų suma turėtų sudaryti sumą lygią @gridColumns reikšmei.</p>

<p>Suprantant šiuos principus galima konstruoti pačius įvairiausius gridus daug įvairių elementų turintiem dizainam.</p>

<h4>CSS dekoravimas</h4>

<p>Prie dekoravimo prieinu tik turėdamas pilną arba beveik pilną HTML layout strukūrą su visais reikalingais elementais.<br />
Bootstrap layoutų ir elementų dekoravimą skirstyčiau į dvi dalis - bazinių reikšmių nustatymas: spalvos, fontai, baziniai dydžiai, viskas ką galima valdyti per standartinį boostrapo variables.less. Kita dalis - nuosavų elementų dekoracijų aprašai.</p>

<h5>Reikšmių valdymas variables.less</h5>

<p>Per variabless.less kintamuosius galima pasidaryti stiprų pagrindą visam dizainui nustatant bazinius dydžius, marginus ir paddingus įvarieims elementams, fontų šeimas ir dydžius, elementų spalvas.<br />
Nuo ko aš paprastai pradedu.</p>

<p>Gridas:</p>

<pre><code> @gridColumns:             12;
 @gridColumnWidth:         60px;
 @gridGutterWidth:         20px;
 @gridRowWidth:            (@gridColumns * @gridColumnWidth) + (@gridGutterWidth * (@gridColumns - 1));
</code></pre>

<p>Fontai:</p>

<pre><code> @sansFontFamily:        "Helvetica Neue", Helvetica, Arial, sans-serif;
 @serifFontFamily:       Georgia, "Times New Roman", Times, serif;

 @baseFontSize:          14px;
 @baseFontFamily:        @sansFontFamily;
 @baseLineHeight:        20px;
</code></pre>

<p>Tuomet eina nuorodų spalvos</p>

<pre><code> @linkColor:             #08c;
 @linkColorHover:        darken(@linkColor, 15%);
</code></pre>

<p>Spalvos. Pilkiems atspalviams priskiriu artimiausias reikšmes iš turimo dizaino. Imu nebūtinai pilkus atspalvius, žiūriu kaip tiksliai kas keičiasi dizaine keičiant reikšmes, nes kolkas pilnai visko neatsimenu, kokie kintamieji kokiuose elementuose naudojami.</p>

<pre><code> // Grays
 // -------------------------
 @black:                 #000;
 @grayDarker:            #222;
 @grayDark:              #333;
 @gray:                  #555;
 @grayLight:             #999;
 @grayLighter:           #eee;
 @white:                 #fff;
</code></pre>

<p>Kitas spalvas renku pagal dizainą:</p>

<pre><code> // Accent colors
 // -------------------------
 @blue:                  #049cdb;
 @blueDark:              #0064cd;
 @green:                 #46a546;
 @red:                   #9d261d;
 @yellow:                #ffc40d;
 @orange:                #f89406;
 @pink:                  #c3325f;
 @purple:                #7a43b6;
</code></pre>

<p>Toliau žaidžiu su mygtukais, input fieldais ir kitom reikšmėm pateiktom variables.less, kad kuo daugiau pasiekčiau panašumo į turimą dizainą.<br />
Tiesiog buvau laimingas žmogus, nes turėjau dizainus, su kurių dizaineriais, galėjau prieiti kompromiso nesilaikydamas pixel-perfekcionizmo.</p>

<h5>Detalesnis dizainas/dekoracijos</h5>

<p>Šešėliai, gradientai, užapvalinti kampai - jei iki šiol vis dar tai realizavote karpydami jpg/png iš PSD failų, pats laikas įvaldyti CSS3, kurį jau normaliai palaiko visos rimtos naršyklės.<br />
Bootstrapas turi tam paruoštus patogius mixinus</p>

<pre><code> .border-radius(@radius)

 .box-shadow(@shadow) 

 #gradient &gt; .horizontal(@startColor: #555, @endColor: #333)

 #gradient &gt; .vertical(@startColor: #555, @endColor: #333)

 #gradient &gt; .directional(@startColor: #555, @endColor: #333, @deg: 45deg)
</code></pre>

<p>Ir tik tada, kai jau išnaudojom viską, ką įmanoma padaryti su CSS - imamės dekoruoti iliustracijomis.<br />
Kadangi su bootstrapu dažniausiai gaminami responsive dizainai būtina numatyti kaip dekoracijos ir jomis dekoruoti fiksuoto dydžio elementai atrodys įvairaus dydžio ekranuose. Mažėjant ekranui, vienais atvejais gali tekti mažinti elementus (scale) pasitelkiant media querius, kitais atvejais išvis pakeisti dekoraciją į mažesnę, pritaikytą būtent tam ekranui.</p>

<h3>Resursai bootstrapui</h3>

<p><a href="https://wrapbootstrap.com">Wrapbootstrap</a> - Puikus market place'as duodantis didelį pasirinkimą paruoštų bootstrap temų.</p>

<p><a href="http://fortawesome.github.com/Font-Awesome">Font Awesome</a> Patogus sprendimas įvairių dydžių ikonėlėm, pritaikytas naudoti su bootstrap.</p>

<p><a href="http://www.bootstraphero.com/the-big-badass-list-of-twitter-bootstrap-resources">THE BIG BADASS LIST OF USEFUL TWITTER BOOTSTRAP RESOURCES</a> Sąrašas įvairių resurų, nuo bootstrap komponentų iki temų market place'ų.</p>

<h2>Bootstrap alternatyvos</h2>

<h3>Foundation front-end framework</h3>

<p>Susidūriau besidomėdamas SASS vs. LESS. Šis frameworkas paruoštas SASS pagrindu. Kuris geriau - Bootstrap ar Foundation - nespręsiu pilnai neįsigilinęs. Ką paviršutiniškai analizuojant teko pastebėt - prasčiau suderinamas su IE versijom, nei bootstrap.
<a href="http://foundation.zurb.com/">Foundation homepage</a></p>

<h3>Gravity framework (SASS)</h3>

<p>Gan skurdus lydinant su Foundation ir Bootstrap
<a href="http://gravityframework.com/">Gravity homepage</a></p>

<h3>LESS framework (LESS)</h3>

<p>Duoda tik grid system
<a href="http://lessframework.com/">LESS framework homepage</a></p>

<h3>Centage (LESS)</h3>

<p>Skirtas grid'ui formuoti
<a href="http://centage.peruste.net/">Centage homepage</a></p>

<h2>Pabaigai</h2>

<p>Vienoks ar kitoks frameworkas neišspręs jūsų visų frontendo problemų, bet manau, bent laiko - tikrai gali sutaupyti. Jeigu iki šiol dar nenaudojote - pabandykite. Nebūtinai Bootstrap, paskaitinėkit ir apie kitus frameworkus, galbūt rasit širdžiai mielesnį.
Bet nepamirškit - kad ir ką benaudotumėt pagrindinis tikslas turėtų būti produktyvumo kėlimas.</p>

<hr />

<p>Ką nors praleidau? Nusišnekėjau? Nesutinkate su mano nuomone? Komentuokite arba rašykite asmeniškai.</p>
