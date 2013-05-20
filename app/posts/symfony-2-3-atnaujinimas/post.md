Štai ir pasirodė pirmasis Symfony 2.3 release kandidatas, apie atnaujinimo procesą čia ir pasistengsiu parašyti.
Primenu, kad Symfony 2.3 bus pirmoji versija, kuri turės ilgalaikį palaikymą (LTS - long term support). Į tai atsižvelgiant tikrai verta atsinaujinti savo projektus jau dabar.

Pradėsiu nuo `composer.json` failo, kaip ir rekomenduojama "requireramentus" reikėtų imti iš [Symfony2 standart edition repozitorijos](https://github.com/symfony/symfony-standard).
Pasirinkus tagą: v2.3.0-RC1 galima pradėti žiurėti į 'composer.json':

Requiramentai:

    "require": {
        "php": ">=5.3.3",
        "symfony/symfony": "2.3.*",
        "doctrine/orm": ">=2.2.3,<2.4-dev",
        "doctrine/doctrine-bundle": "1.2.*",
        "twig/extensions": "1.0.*",
        "symfony/assetic-bundle": "2.3.*",
        "symfony/swiftmailer-bundle": "2.3.*",
        "symfony/monolog-bundle": "2.3.*",
        "sensio/distribution-bundle": "2.3.*",
        "sensio/framework-extra-bundle": "2.3.*",
        "sensio/generator-bundle": "2.3.*",
        "incenteev/composer-parameter-handler": "~2.0"
    },

Iškarto atkreipiau dėmesį: JMS bundle'ų nebėra, šiektiek pasigilinęs radau, kad balandžio 30 dieną JMS buvo išmesta: `removed non-MIT/BSD licensed bundles and librairies`.
Paminėjau JMS vien dėl to, kad tiek manuale (vis dar) tiek ankstesnėse versijose JMS ėjo kartu su standartine Symfony2 distribucija.

Anksčiau buvę JMS bundle'ai:

    "jms/security-extra-bundle": "1.4.*",
    "jms/di-extra-bundle": "1.3.*",
    
`Dėmesio!` šios JKMS versijos nebeveikia su Symfony 2.3, taigi, jeigu visgi jų reikia, pakeiskite versijas į `dev-master`

Toliau - tiek `post-install-cmd`, tiek `post-update-cmd` turi po naują įrašą:

    "Incenteev\\ParameterHandler\\ScriptHandler::buildParameters",
    
Tai nauja komanda, kuri turėtų composer update arba install metu nuskaityti failą `app/config/parameters.yml.dist` ir pagal tai sukurti `parameters.yml` užduodant klausimus vartotjojui pavyzdžiui kaip duomenų bazės prisijungimo duomenys.
daugiau apie tai [Incenteev repozitorijoje](https://github.com/Incenteev/ParameterHandler/blob/master/README.md)

Tačiau dėl tos pačios priežasties iškyla problema, kad šio failo pas jus greičiausiai nėra. Sprendimas tesiog nukopijuoti `app/config/parameters.yml` į `app/config/parameters.yml.dist` arba
tesiog nenaudoti šios naujos komandos ir tuo pačiu išmesti 

    "incenteev/composer-parameter-handler": "~2.0"
    
iš require listo.

Na ir paskutiniai įrašai:

    "config": {
        "bin-dir": "bin"
    },
    "minimum-stability": "RC",
    "extra": {
        "symfony-app-dir": "app",
        "symfony-web-dir": "web",
        "incenteev-parameters": {
            "file": "app/config/parameters.yml"
        },
        "branch-alias": {
            "dev-master": "2.3-dev"
        }
    }
    
Atkreipktite dėmesį į: `bin-dir`, `minimum-stability` ir `incenteev-parameters` (Jeigu visgi nenaudosite incenteev, šį įraša galite ignoruoti)

Taigi atnaujinus `composer.json` belieka tik paleisti 

`php composer.phar update`

## Symfony 2.3 Kabliukas
Symfony 2.3 su savim tuo pačiu diegia ir symfony/icu bundle'ą, šiam reikalingas php_intl plėtinys kuris paremtas libicu biblioteka. Nors ir php_intl vis dar "optional" reikalavimas, bet
be jo composer'is neatnaujins Symfony 2.3. 

Jei serveriai yra linux/mac aplinkoje tai nesukelia per daug problemų, tiesiog reikia susiinstalioti `libicu` ir `libicu-devel` bibliotekas,
o tada `php_intl` arba pasinaudojus paketų manager'iais kaip `yum`, `pacman`, `apt-get`, arba `pecl install intl`, arba tesiog perkompiliuojant php su `--enable-intl` nuoroda.

Tūrėjau problemų su CentOS 5. Pagal nutylėjimą libicu yra tik 3.6 versijos, Symfony reikalauja mažiausiai 3.8 arba 4.2. Taigi atnaujintą versiją turėjau pasiimti iš `remi-test` CentOs repozitorijos, ir php-intl susiinstalioti pecl pagalba.

Su windows operacine sistema šio klausimu padėti negaliu, nesinagrinėjau, tiesa kiek pamenu visi [windows php binaries](http://windows.php.net/download/) visi turi php_intl kartu su savimi, tačiau ar tai patenkina libicu reikalavimą? Nežinau.

## Pora pagrindinių nebenaudojamų metodų
Kontroleriuose 

    $this->getDoctrine()->getEntityManager()

buvo pažymėtas "deprecated" jau 2.1 versijoje 2.3 versijoje tai bus klaida, vietoje šio metodo reikia naudoti: 

    $this->getDoctrine()->getManager()

Twig šablonuose, norint atvaizduoti kitą šabloną, ankščiau buvo galima naudoti tesiog render:

    {% render 'Bundle:Controller:Action'%}
    
Dabar
    
    {{ render(controller('Bundle:Controller:Action')) }}

app/config/config.yml

    trust_proxy_headers: false
    
Keičiam į

     trusted_proxies: ~
     fragments:       ~
     
Šiam kartui tiek, daugiau pasikeitimų visada galite peržiurėti `UPGRADE-X.X.md` failuose [Symfony2 repozitorijoje](https://github.com/symfony/symfony/)