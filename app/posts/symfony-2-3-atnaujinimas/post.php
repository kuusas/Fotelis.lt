<p>Štai ir pasirodė pirmasis Symfony 2.3 release kandidatas, apie atnaujinimo procesą čia ir pasistengsiu parašyti.
Primenu, kad Symfony 2.3 bus pirmoji versija, kuri turės ilgalaikį palaikymą (LTS - long term support). Į tai atsižvelgiant tikrai verta atsinaujinti savo projektus jau dabar.</p>

<p>Pradėsiu nuo <code>composer.json</code> failo, kaip ir rekomenduojama "requireramentus" reikėtų imti iš <a href="https://github.com/symfony/symfony-standard">Symfony2 standart edition repozitorijos</a>.
Pasirinkus tagą: v2.3.0-RC1 galima pradėti žiurėti į 'composer.json':</p>

<p>Requiramentai:</p>

<pre><code>"require": {
    "php": "&gt;=5.3.3",
    "symfony/symfony": "2.3.*",
    "doctrine/orm": "&gt;=2.2.3,&lt;2.4-dev",
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
</code></pre>

<p>Iškarto atkreipiau dėmesį: JMS bundle'ų nebėra, šiektiek pasigilinęs radau, kad balandžio 30 dieną JMS buvo išmesta: <code>removed non-MIT/BSD licensed bundles and librairies</code>.
Paminėjau JMS vien dėl to, kad tiek manuale (vis dar) tiek ankstesnėse versijose JMS ėjo kartu su standartine Symfony2 distribucija.</p>

<p>Anksčiau buvę JMS bundle'ai:</p>

<pre><code>"jms/security-extra-bundle": "1.4.*",
"jms/di-extra-bundle": "1.3.*",
</code></pre>

<p><code>Dėmesio!</code> šios JKMS versijos nebeveikia su Symfony 2.3, taigi, jeigu visgi jų reikia, pakeiskite versijas į <code>dev-master</code></p>

<p>Toliau - tiek <code>post-install-cmd</code>, tiek <code>post-update-cmd</code> turi po naują įrašą:</p>

<pre><code>"Incenteev\\ParameterHandler\\ScriptHandler::buildParameters",
</code></pre>

<p>Tai nauja komanda, kuri turėtų composer update arba install metu nuskaityti failą <code>app/config/parameters.yml.dist</code> ir pagal tai sukurti <code>parameters.yml</code> užduodant klausimus vartotjojui pavyzdžiui kaip duomenų bazės prisijungimo duomenys.
daugiau apie tai <a href="https://github.com/Incenteev/ParameterHandler/blob/master/README.md">Incenteev repozitorijoje</a></p>

<p>Tačiau dėl tos pačios priežasties iškyla problema, kad šio failo pas jus greičiausiai nėra. Sprendimas tesiog nukopijuoti <code>app/config/parameters.yml</code> į <code>app/config/parameters.yml.dist</code> arba
tesiog nenaudoti šios naujos komandos ir tuo pačiu išmesti</p>

<pre><code>"incenteev/composer-parameter-handler": "~2.0"
</code></pre>

<p>iš require listo.</p>

<p>Na ir paskutiniai įrašai:</p>

<pre><code>"config": {
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
</code></pre>

<p>Atkreipktite dėmesį į: <code>bin-dir</code>, <code>minimum-stability</code> ir <code>incenteev-parameters</code> (Jeigu visgi nenaudosite incenteev, šį įraša galite ignoruoti)</p>

<p>Taigi atnaujinus <code>composer.json</code> belieka tik paleisti</p>

<p><code>php composer.phar update</code></p>

<h2>Symfony 2.3 Kabliukas</h2>

<p>Symfony 2.3 su savim tuo pačiu diegia ir symfony/icu bundle'ą, šiam reikalingas php_intl plėtinys kuris paremtas libicu biblioteka. Nors ir php_intl vis dar "optional" reikalavimas, bet
be jo composer'is neatnaujins Symfony 2.3.</p>

<p>Jei serveriai yra linux/mac aplinkoje tai nesukelia per daug problemų, tiesiog reikia susiinstalioti <code>libicu</code> ir <code>libicu-devel</code> bibliotekas,
o tada <code>php_intl</code> arba pasinaudojus paketų manager'iais kaip <code>yum</code>, <code>pacman</code>, <code>apt-get</code>, arba <code>pecl install intl</code>, arba tesiog perkompiliuojant php su <code>--enable-intl</code> nuoroda.</p>

<p>Tūrėjau problemų su CentOS 5. Pagal nutylėjimą libicu yra tik 3.6 versijos, Symfony reikalauja mažiausiai 3.8 arba 4.2. Taigi atnaujintą versiją turėjau pasiimti iš <code>remi-test</code> CentOs repozitorijos, ir php-intl susiinstalioti pecl pagalba.</p>

<p>Su windows operacine sistema šio klausimu padėti negaliu, nesinagrinėjau, tiesa kiek pamenu visi <a href="http://windows.php.net/download/">windows php binaries</a> visi turi php_intl kartu su savimi, tačiau ar tai patenkina libicu reikalavimą? Nežinau.</p>

<h2>Pora pagrindinių nebenaudojamų metodų</h2>

<p>Kontroleriuose</p>

<pre><code>$this-&gt;getDoctrine()-&gt;getEntityManager()
</code></pre>

<p>buvo pažymėtas "deprecated" jau 2.1 versijoje 2.3 versijoje tai bus klaida, vietoje šio metodo reikia naudoti:</p>

<pre><code>$this-&gt;getDoctrine()-&gt;getManager()
</code></pre>

<p>Twig šablonuose, norint atvaizduoti kitą šabloną, ankščiau buvo galima naudoti tesiog render:</p>

<pre><code>{% render 'Bundle:Controller:Action'%}
</code></pre>

<p>Dabar</p>

<pre><code>{{ render(controller('Bundle:Controller:Action')) }}
</code></pre>

<p>app/config/config.yml</p>

<pre><code>trust_proxy_headers: false
</code></pre>

<p>Keičiam į</p>

<pre><code> trusted_proxies: ~
 fragments:       ~
</code></pre>

<p>Šiam kartui tiek, daugiau pasikeitimų visada galite peržiurėti <code>UPGRADE-X.X.md</code> failuose <a href="https://github.com/symfony/symfony/">Symfony2 repozitorijoje</a></p>
