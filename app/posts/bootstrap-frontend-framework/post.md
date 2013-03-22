## Įvadas

### Kas yra Bootstrap ir kam jis skirtas
Bootstrap - frontendo frameworkas. Turi paruoštą bazę - globalūs stiliai, CSS resetai ir grid sistema ant kurios labai patogu greitai pasikelti bet kokį nesudėtingą layoutą. Pasikėlus layoutą bootstrap frameworkas iš karto siūlo savoi aprašytą tvarkingos tipografijos stilių, taipogi stilius lentelėms, formoms, mygtukams ir ikonėlėms.  
Papildomai galima naudoti bootstrapo vartotojo sąsajos komponentus, tokius kaip tab'ai, navigacijos juostos, pranešimų langai, puslapių headeriai ir t.t. http://twitter.github.com/bootstrap/components.html  Į pagalbą pasitelkian JS bootstrap'as siūlo interaktyvius komponentus, tokius kaip tooltipai, modaliniai langai, dropdowns input fields ir t.t. (http://twitter.github.com/bootstrap/javascript.html)   
Trumpai tariant - bootstraps duoda HTML struktūros ir CSS bazę, ant kurios galima pakelti web aplikaciją atrodančią tvarkingai.  
[Bootstrap namai](http://twitter.github.com/bootstrap/)

### Kada naudoti framework? Kada ne?
Man bootstrapas sutaupo nemažai laiko paleidinėjant web projektus. Negana to, kad mažiau laiko sugaištu HTML+CSS layouto pasikėlimui, bet dar tuo pačiu gaunu responsive dizainą ir netgi suderinamumą su IE7.  
Nori sutaupyti laiko? Naudok frameworką.  
Bet yra įvairių bet. Viskas labai priklauso ir nuo projekto, prie kurio dirbsite. Jeigu projektas turi sudėtingą dizainą ir reikalaujama, kad puslapis būtų pixel perfect, o dizaineris nežinojo apie grid system - pražilsit bandydami layoutą sudėlioti ant frameworko grid sistemos ir komponentus suderint su tuo kas nupiešta dizainerio. Tokiu atveju, kai turite sudėtingą grafinį dizainą ir reikalaujama pixel perfect - rinkčiausi rašyti CSS nuo nulio.  
Frontend frameworkas idealiai tinka projektam, į kuriuos nėra prasmės investuoti į dizainą, ar tiesiog nėra kam užsiimti dizainu - pasiimi, pasidėlioji komponentus - turi tvarkingą ir gan solidų vaizdą.  
Sudėtingiau su projektais, kuriems yra ruošiamas dizainas. Šioje vietoje kyla tema apie dizianų ruošimo principus, bet šį kartą į tai nesigilinsiu. Įsivaizduokime, kad paruoštas dizainas yra PSD failas. Tokiais atvejais labai svarbu, kad dizaineris naudotų grid sistemą ir dizaino komponentai būtų protingai išlygiuoti tame gride. Tokiu atveju galim daryti prielaidą, kad dizainą bus įmanoma integruoti su bootstrapu. Kad galutinai įsitikintume, kad galim naudoti boostrapą turim įsivertinti ar dizainerio naudota grid sistema suderinama su bootstrapu. Bootstrapas turi galimybę per kintamuosius konfigūruoti gridą - stulpelių skaičių (@gridColumns), stulpelio plotis (@gridColumnWidth) ir tarpų tarp stulpelių dydis (@gridGutterWidth). Būtent tai ir turėtume įsivertinti, ar tikrai galim sukonfigūruoti bootstrapo gridą pagal dizainerio naudojamą.  
Jeigu gridus pavyksta suderint - super, pusę darbo turim, nebereikia patiem rašytis. Jei neturim - tada galim toliau vertinti ką galim panaudoti iš bootsrapo. Aš kaip pagrindinius komponentus dizaine vertinu formas, lenteles, mygtukus - žiūrim ką turim dizaine ir vertinam ar tai suderinama su bootstrapu. Jei suderinama - puiku, pritaikę stilių prie dizaino galim naudoti bootstrapo komponentus.  
Dar kada verta naudoti frameworką - jeigu turim PSD dizainą desktop versijai ir reikia mum responsive dizaino, bet niekas nesiruošia piešti visų dizainų. Tokiu atveju responsive dalis turėtų būti daroma prieinant kompromiso su dizaineriu kas ir kur aukojama dizaine, kai jis scale'inamas mažesniam ekranui. Ką laimim tokiu atveju - nereikia dizainerio laiko paruošti dar dvi dizaino versijas tabletui ir mobile'ui, tai padaroma HTML'erio su dizainerio guideline'ais.  
Jeigu abejojat ar jum verta naudoti frontend frameworką - tiesiog imkit ir pabandykit padirbėti bootstrap ar kitu. Manau tikrai gausit naudos iš to. Jeigu nesutaupysit laiko, gal išmoksit ką nors naujo HTML+CSS srityje?  

## Bootstrap naudojimas
Praktinė dalis - bandom bootstrap. Norėdamas išlaikyt tvarką projektuose, visom third-party bibliotekom įtraukti į projektą naudoju composer. Bootstrap neišimtis.  
composer.json:


    {
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

Instaliuojame composer

    composer install

Kuriame projekto struktūrą

    mkdir -p src/twitter/bootstrap/less
    mkdir -p web/assets/css
    mkdir -p web/assets/img
    mkdir -p web/assets/js
    touch src/twitter/bootstrap/less/bootstrap.less
    touch src/twitter/bootstrap/less/bootstrap-responsive.less
    touch src/twitter/bootstrap/less/app.less
    touch web/index.html
    cp -r vendor/twitter/bootstrap/img/ web/assets/img
    cp -r vendor/twitter/bootstrap/js/ web/assets/js

Į bootstrap.less įdedam eilutę, kad importuotume originalų bootstrap.less failą
    
    @import "../../../../vendor/twitter/bootstrap/less/bootstrap.less";
    @import "app.less";

Į bootstrap-responsive.less: 

    @import "../../../../vendor/twitter/bootstrap/less/responsive.less";

Idėja - paveldėti visus stilius iš bootstrapo, o pas save perrašyti (override) tai, ką reikia. Taip išlaikom veikiančius visus bootstrapo komponentus ir nesukam galvos kaip kiekvieną komponentą nepamiršti aprašyti vis naujam projektui. Tuo pačiu mūsų naudojamas bootstrapas bus up-to-date. Parsisiuntus (su composer) naują bootstrap versiją pakeitimai mūsų projekte išliks, nes mes neliečiam bootstrapo failų, kurie  gali būti atnaujinami.  
Prieš atnaujindami bootstrapą pasitikrinkite changelog - ar pakeitimai nesugriaus jūsų projekto. Dėl to composer.json vertėtų nurodyti konkrečią naudojamą bootstrapo versiją.  
Savo aplikacijos kodą dėsim į atskirą failą - app.less. Vėliau turėsim galimybę jį sukompiliuoti atskirai nuo bootstrap, kad galėtume įvertinti tik aplikacijos CSS dydį, selektorių performance ir pan.  

web/index.html turinys (vienas iš numatytųjų bootstrap layoutų):

* Parsisiųsti index.html iš [example-bootstrap-frontend-framework@GitHub](https://github.com/kuusas/do-stuff-examples/blob/master/example-bootstrap-frontend-framework/web/index.html)

### Kompiliuojam LESS'ą
Apie LESS rašiau ankstesniame [poste](http://fotelis.lt/frontend/frontend-less)

    lessc src/twitter/bootstrap/less/bootstrap.less > web/assets/css/bootstrap.css
    lessc src/twitter/bootstrap/less/bootstrap-responsive.less > web/assets/css/bootstrap-responsive.css

Atsidarom web/index.html - tai mūsų standartinis bootstrapo template.

### Failų struktūra
Failus išskirstau pagal bendrinius kodo skirstymo principus. 
* src/ - mano projekto source
* vendor/ - trečių šalių bibliotekos
* web/ - viešai (per www) pasiekiami failai
* web/assets/ - projekto frontendo turtai
* web/assets/css/ - production ready css (sugeneruotas less, sucompressintas). Rankomis failai neliečiami.
* web/assets/img/ - production ready images. Rankomis failai neliečiami.
w* eb/assets/js - production ready JS. Čia dedu tim su UI susijusį JavaScript.

Kodėl folderiuose web/assets/css/ ir web/assets/css/img esantys failai rankomis neliečiami? Nes jie čia atsiranda generuojant projekto source.  

Projekto source laikome src/ folderyje ir atitinkama viduje folderių struktūrą kokią vendor biblioteką extendinam. Šiuo atveju src/twitter/bootstrap. Čia jau išlaikom tokią pačią struktūą kokia ir yra tos bibliotekos vendor folderyje. T.y. yra /vendor/twitter/bootstrap/less/variables.less, mes norėdami perrašyti (override) šį failą sukuriame /src/twitter/bootstrap/less/variables.less. Kodėl - kad būtų aišku koks failas yra perrašomas. Kad mūsų failas paveldėtų vendor'iuose esančias failo savybes turim pradžioje tą failą importuoti: 
    
    @import "../../../../vendor/twitter/bootstrap/less/variables.less";

Ir dabar visi kintamieji, kuriuos apsirašysime savo (src/.../variables.less) faile perrašys vendor esančią reikšmę.

## Pagalbiniai įrankiai

### Makefile
Atrodo labai daug komandų? Darbo supraprastinimui galiu pasiūlyti bash Makefile, kurį naudoju savo bootstrapo projektam.

* Siųskitės [Makefile@GitHub](https://github.com/kuusas/tools/blob/master/Bootstrap/Makefile).

Make - pagalbinė programa skirta buildinti source (ar kitą) kodą pagal instrukcijas aprašytas failuose vadinamais "makefile".  
Linux distribucijose turėtumėt turėti by default.  
OSX - reikia susiinstaliuoti XCode komponentą "Command Line Tools".
Windows - sakykim, kad neįmanoma.  

Parsiųstą Makefile pasidėkite savo projekto root'e, tuo pačiu pavadinimu "Makefile" ir galite naudotis.

### Makefile naudojimas

Komandų paleidimas - simple, tiesiog konsolėj ar kaip bevadintumėt savo CLI (komandinę eilutę) būdami projekto root'e, ten kur ir pasidėjot failą Makefile, tiesiog leiskite komandas.  
Komandos leidžiamos
    
    make <komanda>

#### Konfigūracija

Pradžioje aprašyti path'ų kintamieji:
projekto source

     SRC = src/twitter/bootstrap


projekto assets

     ASSETS = web/assets


projekto vendor
     
     VENDOR = vendor/twitter/bootstrap


projekto dev versija (projekto html - viena repozitorija, projekto dev - kita repozitorija). Šiuo atveju nurodoma lygiu aukščiau esančią projekto direktoriją

     DEV_ASSETS = ../<project>/web/assets


#### Komandos


#### bootstrap

     make bootstrap arba tiesiog make

Sukompiliuoja LESS į CSS ir padeda į assets direktoriją (web/assets/css/)
Perkopijuoja paveikslėlius iš vendor ir iš src į assets direktoriją.


#### init
     make init

Sukuria pradinę failų struktūrą projektui. src ir web/assets direktorijas, pradinius src/twitter/bootstrap/less/bootstrap.less, responsive.less ir variables.less, kurie paveldi pagrindinius bootstrapo failus.

#### extend

     make extend COMPONENT=<komponentas>

Sukuria bootstrapo paveldėjimo failą, kuriame galime override'int bootstrap funkcionalumą. Turi būtinai egzistuoti vendor/twitter/bootstrap/less/<komponentas>.less failas.

#### usejs

     make usejs NAME=<js-pavadinimas>

Perkopijuoja bootstrapo JS iš vendor/twitter/bootstrap/js/<js-pavadinimas>.js į web/assets/js, kad galėtume naudoti JS savo projekte mum telieka įdėti į html 

     <script src="assets/js/<js-pavadinimas>.js"></script> 

#### watch

     make watch 

Laukia failų pakeitimų src/twitter/bootstrap/ direktorijoje ir įvykus jiem paleidžia komandą make bootstrap. Išsaugojus LESS failą ar įdėjus paveikslėlį mum iškarto subuildinamas CSS ir perkopijuojami paveikslėliai į reikiamą vietą, t.y. web/assets, mes negaišdami laiko tam skirtos laiko komandos paleidimui, atlikus pakeitimus, tik atsidarome naršyklę ir žiūrime kokį rezultatą turim.
* kad galėtume naudoti šią komandą turime turėti watchr https://github.com/mynyml/watchr 


#### showcss

     make showcss

Sukompiliuoja ir į konsolę išveda mūsų aplikacijos CSS kodą (app.less), kad galėtume greitai įvertinti ar nepersistengta su LESS'u ir neturime per daug sudėtingų selektorių ir pan.
Pasinaudodami bash'o galimybėmis galime outputą išsaugoti į failą


     make showcss > app.css

Dabar galime įvertinti aplikacijos stilių apimtį (app.css failo dydį).


#### deploy

     make deploy

Deployinam html assetus į dev versiją. Sumažina rankinio darbo failų kopijavimui. Paleidus komandą tiesiog perkopijuojami failai esantys web/assets/img, css/ ir js/ į projekto dev versijos assets atitinkamas direktorijas.


### Bootstrap dizainas

#### HTML Layout
Nuo ko pradėti kurti savo custom HTML layout? Kaip pavyzdį pasiimkime gan standartinį header, content, sidebar, footer layoutą.
![Standartinis header, content, sidebar, footer layoutas](/media/posts/bootstrap-frontend-framework/img/layout.jpg)

Eilutės, stulpeliai: kas tie .row, .span*, .offset*?
Toliau viduje dėliojame struktūrą:

     <div class="container">
          <header class="row-fluid">
                    ...
          </header>
     
          <div class="row-fluid">
               <div class="span8>
                    ...
               </div>
               <div class="span3 offset1>
                    ...
               </div>
          </div>

          <footer class="row-fluid">
               ...
          </footer>
     </div>

Bootstrapo layouto principas - turim konteinerį
     
     <div class="container">
          …
     </div>

į kurį dedama eilutė

     <div class="row-fluid">
          …
     </div>

eilutė užpildoma stulpeliais turinčiais klases .span* ir .offset*,
     
     <div class="span8>
          ...
     </div>
     <div class="span3 offset1>
          ...
     </div>

kurių skaičių, nurodytų prie klasių, maksimali suma lygi 12 (default reikšmė), arba tiek, kiek nurodome bootstrapo variables.less konfige
     
     @gridColumns:             12;


#### Nestingas

Visada galima giliau skaidyti layoutą ir į .span* elementus dėti naujas eilutes.

    <body>
          ...
          <div class="span8>
               <div class="row-fluid">
                    <div class="span6">
                         ...
                    </div>
                    <div class="span6">
                         ...
                    </div>
               </div>
          </div>
          ... 
     </body>

Nestinant eilutes idėja skaičiuojant pločius išlieka ta pati - .row-fluid esančių .span* elementų pločiai skaičiuojami procentaliai nuo eilutės (.row-fluid) pločio. Eilutė visada paveldi tėvinio elemento plotį. Šiuo atveju .row-fluid plotis bus lygus .span8 pločiui.  

Nestinant eilutes reikia nepamiršti taisyklės, kad viduje esančių .span* ir .offset* elementų suma turėtų sudaryti sumą lygią @gridColumns reikšmei.  

Suprantant šiuos principus galima konstruoti pačius įvairiausius gridus daug įvairių elementų turintiem dizainam.  


#### CSS dekoravimas

Prie dekoravimo prieinu tik turėdamas pilną arba beveik pilną HTML layout strukūrą su visais reikalingais elementais.  
Bootstrap layoutų ir elementų dekoravimą skirstyčiau į dvi dalis - bazinių reikšmių nustatymas: spalvos, fontai, baziniai dydžiai, viskas ką galima valdyti per standartinį boostrapo variables.less. Kita dalis - nuosavų elementų dekoracijų aprašai.  

##### Reikšmių valdymas variables.less
Per variabless.less kintamuosius galima pasidaryti stiprų pagrindą visam dizainui nustatant bazinius dydžius, marginus ir paddingus įvarieims elementams, fontų šeimas ir dydžius, elementų spalvas.  
Nuo ko aš paprastai pradedu.

Gridas:

     @gridColumns:             12;
     @gridColumnWidth:         60px;
     @gridGutterWidth:         20px;
     @gridRowWidth:            (@gridColumns * @gridColumnWidth) + (@gridGutterWidth * (@gridColumns - 1));

Fontai:
     
     @sansFontFamily:        "Helvetica Neue", Helvetica, Arial, sans-serif;
     @serifFontFamily:       Georgia, "Times New Roman", Times, serif;

     @baseFontSize:          14px;
     @baseFontFamily:        @sansFontFamily;
     @baseLineHeight:        20px;

Tuomet eina nuorodų spalvos
     
     @linkColor:             #08c;
     @linkColorHover:        darken(@linkColor, 15%);

Spalvos. Pilkiems atspalviams priskiriu artimiausias reikšmes iš turimo dizaino. Imu nebūtinai pilkus atspalvius, žiūriu kaip tiksliai kas keičiasi dizaine keičiant reikšmes, nes kolkas pilnai visko neatsimenu, kokie kintamieji kokiuose elementuose naudojami.

     // Grays
     // -------------------------
     @black:                 #000;
     @grayDarker:            #222;
     @grayDark:              #333;
     @gray:                  #555;
     @grayLight:             #999;
     @grayLighter:           #eee;
     @white:                 #fff;


Kitas spalvas renku pagal dizainą:

     // Accent colors
     // -------------------------
     @blue:                  #049cdb;
     @blueDark:              #0064cd;
     @green:                 #46a546;
     @red:                   #9d261d;
     @yellow:                #ffc40d;
     @orange:                #f89406;
     @pink:                  #c3325f;
     @purple:                #7a43b6;


Toliau žaidžiu su mygtukais, input fieldais ir kitom reikšmėm pateiktom variables.less, kad kuo daugiau pasiekčiau panašumo į turimą dizainą.  
Tiesiog buvau laimingas žmogus, nes turėjau dizainus, su kurių dizaineriais, galėjau prieiti kompromiso nesilaikydamas pixel-perfekcionizmo.  


##### Detalesnis dizainas/dekoracijos

Šešėliai, gradientai, užapvalinti kampai - jei iki šiol vis dar tai realizavote karpydami jpg/png iš PSD failų, pats laikas įvaldyti CSS3, kurį jau normaliai palaiko visos rimtos naršyklės.  
Bootstrapas turi tam paruoštus patogius mixinus

     .border-radius(@radius)

     .box-shadow(@shadow) 

     #gradient > .horizontal(@startColor: #555, @endColor: #333)

     #gradient > .vertical(@startColor: #555, @endColor: #333)

     #gradient > .directional(@startColor: #555, @endColor: #333, @deg: 45deg)

Ir tik tada, kai jau išnaudojom viską, ką įmanoma padaryti su CSS - imamės dekoruoti iliustracijomis.  
Kadangi su bootstrapu dažniausiai gaminami responsive dizainai būtina numatyti kaip dekoracijos ir jomis dekoruoti fiksuoto dydžio elementai atrodys įvairaus dydžio ekranuose. Mažėjant ekranui, vienais atvejais gali tekti mažinti elementus (scale) pasitelkiant media querius, kitais atvejais išvis pakeisti dekoraciją į mažesnę, pritaikytą būtent tam ekranui.  

### Resursai bootstrapui
[Wrapbootstrap](https://wrapbootstrap.com) - Puikus market place'as duodantis didelį pasirinkimą paruoštų bootstrap temų.

[Font Awesome](http://fortawesome.github.com/Font-Awesome) Patogus sprendimas įvairių dydžių ikonėlėm, pritaikytas naudoti su bootstrap.

[THE BIG BADASS LIST OF USEFUL TWITTER BOOTSTRAP RESOURCES](http://www.bootstraphero.com/the-big-badass-list-of-twitter-bootstrap-resources) Sąrašas įvairių resurų, nuo bootstrap komponentų iki temų market place'ų.


## Bootstrap alternatyvos
### Foundation front-end framework
Susidūriau besidomėdamas SASS vs. LESS. Šis frameworkas paruoštas SASS pagrindu. Kuris geriau - Bootstrap ar Foundation - nespręsiu pilnai neįsigilinęs. Ką paviršutiniškai analizuojant teko pastebėt - prasčiau suderinamas su IE versijom, nei bootstrap.
[Foundation homepage](http://foundation.zurb.com/)

### Gravity framework (SASS)
Gan skurdus lydinant su Foundation ir Bootstrap
[Gravity homepage](http://gravityframework.com/)

### LESS framework (LESS)
Duoda tik grid system
[LESS framework homepage](http://lessframework.com/)

### Centage (LESS)
Skirtas grid'ui formuoti
[Centage homepage](http://centage.peruste.net/)


## Pabaigai
Vienoks ar kitoks frameworkas neišspręs jūsų visų frontendo problemų, bet manau, bent laiko - tikrai gali sutaupyti. Jeigu iki šiol dar nenaudojote - pabandykite. Nebūtinai Bootstrap, paskaitinėkit ir apie kitus frameworkus, galbūt rasit širdžiai mielesnį.
Bet nepamirškit - kad ir ką benaudotumėt pagrindinis tikslas turėtų būti produktyvumo kėlimas.

* * *

Ką nors praleidau? Nusišnekėjau? Nesutinkate su mano nuomone? Komentuokite arba rašykite asmeniškai.