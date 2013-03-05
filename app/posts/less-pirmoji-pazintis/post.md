Šiuo postu pradėsiu postų seriją apie tai kaip šiuo metu mano aplinkoje vyksta darbas su web projektų dizaino dalimi - HTML + CSS.  
Pradėsiu nuo LESS.

## Kas yra LESS ir kam jis skirtas
LESS http://lesscss.org/ - dinaminė stilių rašymo kalba. Pagrindiniai privalumai tai, kad ji turi: kintamuosius, mixinus, nestingą, funkcijas ir operatorius. Su jų pagalba rašomas aiškesnis, struktūrizuotas neatsikartojantis kodas, o kur reikalingi aritmetiniai veiksmai - išvis pasaka!

## Kodėl būtent LESS?
Pirma priežastis kodėl pasirinkau LESS - Bootstrap frameworkas, jis naudojo LESS.  
Antra priežastis - LESS kompiliatorius parašytas su JavaScript - man artimesnė kalba norint contributint ar pasitaisyt bug'us.  
Trečia - LESS'as aktyviau developinamas. 
 
## Kintamieji
Priskiriame reikšmę vienoje vietoje ir naudojame kitose. Prireikus paredaguoti reikšmę užtenka ją pakeisti vienoje vietoje.

LESS:

    @color: #ffcc00;
    header {
        background-color: @color;
    }
    h1 {
        color: @color;
    }

Sugeneruotas CSS:

    header {
        background-color: #ffcc00;
    }
    h1 {
        color: #ffcc00;
    }



## Nesting 
### Geroji pusė
Su nestingu galime turėti semantišką ir logišką kodą neperrašinėdami to paties kelis kartus, o tiesiog elemento viduje aprašome vaikų stilius.

LESS:

    article {
        &> h1 {
            font-size: 26px;
        }
        p {
            font-size: 14px;
            a {
                text-decoration: none;
                &:hover {
                    text-decoration: underline;
                }
            }
        }
    }

Sugeneruotas CSS:

    article > h1 {
        font-size: 26px;
    }
    article p {
        font-size: 14px;
    }
    article p a {
        text-decoration: none;
    }
    article p a:hover {
        text-decoration: underline;
    }



## Nesting
### Blogoji pusė
Blogosios pusės nėra! Naudojant su protu. 
Yra manančių, kad su nestingu elgtis reikėtų atsargiai, nes greitai išaugs generuojamo CSS dydis. Tai MITAS, kilęs (turbūt) iš nesupratimo kaip veikia nestingas arba tiesiog iš nestruktūrizuoto CSS fanklubo. Jų atveju taip, sutinku, selektoriai pridės svorio CSS'ui.
Norint palaikyti sistemas, visur reikalinga tvarka. Tvarka CSS'e atsiranda per protingą struktūrizavimą, šioje vietoje ir atsiskleidžia visa LESS suteikiamo nestingo jėga - visą struktūrą matome vizualiai ir nereikia kartoti rašant parent elementų selektorių.

Kaip rašytume CSS:

    body > header {
        border: 1px solid #cfcfcf;
    }

    body > header nav {
        border-top: 2px solid #cccc;
    }

    body > header nav ul {
        margin: 20px;
    }

    body > header nav ul li {
        list-style-type: none;
        display: inline;
    }

    body > header nav ul li a {
        color: #ffcc00;
    }

    body > header nav a:hover, 
    body > header nav a.active {
        color: #ff6633;
    }

Kaip rašome LESS:

    body {
        &> header {
            border: 1px solid #cfcfcf;

            nav {
                border-top: 2px solid #cccc;

                ul {
                    margin: 20px;

                    li {
                        list-style-type: none;
                        display: inline;

                        a {
                            color: #ffcc00;

                            &:hover,
                            &.active {
                                color: #ff6633;
                            }
                        }
                    }
                }
            }
        }
    }

Nejaugi ginčysitės, kad nėra smagu vis neperrašinėt to paties parentų selektroiaus N kartų?

Begalvodamas apie nestingą vistik įžvelgiau kada galima su juo prisižaist - per daug visko užnestint, nes tada bus prigeneruoti bereikalingo gylio ir konkretumo selektoriai, kurie ir užims bereikalingą CSS failo dalį. Norint to išvengti galima bandyt taikyt taisyklę - nestint selektorius max iki 3 levelio.

## Mixins 
### Geroji pusė
Mixinai leidžia vienoj vietoj aprašyti keletą savybių ir reikiamoje vietoje juos iškviestus tas savybes panaudoti. Taip išvengiame dubliuto kodo rašymo. Mixinai priima ir argumentus - tad galima kurti universalius mixinus, kurie priima tam tikras savybes per argumentus.
Kaip mixinai veikia? Aprašius mixiną ir jį iškvietus, generuojant CSS kvietimo vietoje tiesiog surenderinama tai, kas buvo aprašyta mixine.

LESS:

    .rounded-corners (@radius: 5px) {
        border-radius: @radius;
        -webkit-border-radius: @radius;
        -moz-border-radius: @radius;
    }
    header {
        .rounded-corners();
    }
    footer {
        .rounded-corners(10px);
    }

Sugeneruotas CSS:

    header {
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
    }
    footer {
        border-radius: 10px;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
    }


## Mixins 
### Blogoji pusė
Tačiau su mixinais būkite atsargūs - juos naudoti reikėtų, ten, kur tikrai kodo dubliavimo išvengti neįmanoma. Jokiais būdais neaprašinėti klasių savybių, kurias tikrai galima būtų elementui priskirti tiesiog nurodant tam tikrą klasę ir mixinuose nenaudokite mixinų (nebent jaučiatės pakankamai stiprūs tai suvaldyti).

LESS:

    .fancy-box () {
         .rounded-corners(10px);
         font-family:  Arial;
         border: 2px solid #303030;
         color: #ffcc00;
    }

    .post {
        .fancy-box();
    }

    .menu {
        .fancy-box();
    }

Sugeneruotas CSS:

    .post {
        border-radius: 10px;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        font-family: Arial;
        border: 2px solid #303030;
        color: #ffcc00;
    }
    .menu {
        border-radius: 10px;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        font-family: Arial;
        border: 2px solid #303030;
        color: #ffcc00;
    }


Tokiu atveju kiekvieną kartą panaudojus .fancy-box() mixiną CSS'e bus sugeneruotas gan nemažas kodo gabalas. Taip mixinas po mixino ir greitai išaugs CSS failo dydis.

## Funkcijos ir operatoriai
LESS palaiko sudėties, atimties, dalybos ir daugybos operatorius. Jais manipuliuojant galima atlikti įvairius veiksmus su savybių reikšmėm ir spalvom. Funkcijos - leidžia kontruoliuoti reikšmių elgseną.

LESS:

    @border: 1px;
    @color: #111;
    @red: #842210;
    @height: 100px;
    header {
        color: @color * 3;
        border-left: @border;
        border-right: @border * 2;
        height: @height;
    }
    footer {
        color: @color + #003300;
        border-color: desaturate(@red, 10%);
        height: @height / 2;
    }

Sugeneruotas CSS:

    header {
        color: #333333;
        border-left: 1px;
        border-right: 2px;
        height: 100px;
    }
    footer {
        color: #114411;
        border-color: #7d2717;
        height: 50px;
    }



Visų šių LESS įrankių pagalba formuojamas gražus ir aiškus kodas išvengiant selectorių ir savybių dubliavimo. Visumoj tai panašu į dar vieną programavimo kalbą CSS pagrindu ir deje to nesupranta naršyklės.

## LESS naudojimas
### Kliento pusėje (tik moderniose naršyklėse)
Kliento pusėje generuoti naudoti LESS - paprasčiausias būdas, bet tai patartina daryti tik developmento metu, vėliau reikėtų naudoti jau sukompiluotą CSS.
HEAD dalyje nurodome ryšį į LESS failą

    <link rel="stylesheet/less" type="text/css" href="styles.less" />

Būtina nurodyti rel="stylesheet/less".
Ir užkrauname less.js biblioteką (siųstis iš lesscss.org) https://raw.github.com/cloudhead/less.js/master/dist/less-1.3.3.min.js

    <script src="less.js" type="text/javascript"></script>

Įsitikinkite, kad stiliaus failas užkraunamas prieš JavaScript.

### Serverio pusėje. CSS generavimas.
Paprasčiausias būdas susiinstaliuoti LESS kompiliatorių naudojant NPM (Node Packaged Modules).

    $ npm install -g less

Ir tada jau galime kompiliuoti LESS į CSS.

    lessc styles.less > styles.css

Pridėję parametrą -x gausime minified CSS versiją

    lessc -x styles.less > styles.css

Sukompiliuotas CSS failas yra pilnavertis ir paruošas naudoti puslapyje.


## LESS alternatyvos
Yra trys man žinomos alternatyvos LESS'ui - SASS, Stylus ir ZUSS.  
SASS - pirmoji dinaminio stiliaus rašymo kalba, kuri ir įkvėpė LESS atsiradimą. http://sass-lang.com/  
Stylus - bando padaryti stiliaus kodą DRY - kuo mažiau rašymo, daugiau rezultato.  
ZUSS - Java pasaulio gyventojams, patogiai integruoja CSS'ą į Java ir leidžia netgi naudoti Java metodus https://github.com/tomyeh/ZUSS     

## Išvados
Nauji įrankiai, naujos technologijos dažniausiai iš pirmo žvilgsnio žavi, todėl juos norisi išpabandyti ir naudoti savo projektuose. Tačiau kai visas tas buzz'as nusirutulioja per internetą, kartais jau net sunku susigaudyt ar tikrai to reikia, apie ką visi šneka. Kiek šnekančiųjų realiai naudoja tai? Kodėl naudoja?   
Su LESS'u ir kitais CSS preprocessoriais ta pati istorija. Daug šnekančių, mažai susipažinusių ir dar mažiau suprantančių kaip tai veikia. Man pačiam LESS'as tikrai patiko, nes labai paprasta realizuoti modulinį kodą, neperrašinėjant vis tų pačių selektorių. Specifiniai naršyklių prefixai parametrams taipogi nebetokie erzinantys naudojant mixinus. Žinoma su LESS reikia elgtis su protu. Per daug giliai nenetestinti selektorių - pagalvoti ar rašydami pure CSS naudotume tokio tikslumo selektorius. Pažaiskite su mixinaiss, žiūrėkite kaip formuojamas CSS, kad rašydami LESS'ą įvertintumėt ar tikrai toje vietoje kurioje bandote panaudoti mixiną jis reikalingas.  
LESS tai tik dar vienas įrankis turintis supaprastinti, paspartinti darbą. Dirbant su galva - tai veikia, todėl įvertinkite, ko jūs tikitės ir ko norite pasiekti naudodami LESS. 
