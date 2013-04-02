<p>Pats nuobodžiausias ir painiausias darbas developinant yra atnaujinti duomenų bazės struktūrą su kiekvienu deploymentu. Kokių tik būdų neprisigalvoja tam developeriai. Pats esu bandęs įvairiausius - developinant ir darant pakeitimus, visus juos saugoti į vieną sql failą ir deployinant tą failą paimportuoti į DB. Vėliau esu kūręs atskirus failus kiekvienam naujam pakeitimui: 00001.sql, 00002.sql, 00003.sql…. 00143.sql... Susidarius nemažai krūvai pakeitimų, tikrai užsiknisdavau, kai reikėdavo atsekt kuris iš tų mano failų buvo importuotas paskutinį kartą.</p>

<p>Pradėjus dirbt su Symfony2, be Doctrine ORM, kolegos parodė jų kurtą įrankį skirtą palengvinti darbą su duomenų bazės struktūros atnaujimu. Šį kartą ir pristatysiu šį įrankį - EstinaMigrationBundle, skirtą, dirbant su Symfony2 be Doctrine ORM, kontroliuoti duomenų bazės struktūrą per migracijų failus.</p>

<p>Migracijų failai - atskiri SQL skriptai, kuriuose aprašomi mūsų atliekami duomenų bazės pakeitimai developmento metu. Sukuriam migracijos failą, importuojam, skuriam - importuojam. EstinaMigrationBundle visada atsimena paskutinę importuotą migraciją, tad deployinant projektą nereikia sukti galvos ar viskas bus tvarkoje su duombaze, tiesiog paleidžiat migration:apply komandą ir vuolia - visos migracijos suvažiuoja.</p>

<p>Migracijose gali būti duomenų bazės schemos pakeitimai, tiek duomenų insert'ai ar update'ai. Viskas, ką darydami duombazei savo dev environmente norite perduoti ir kitiem.</p>

<h2>Reikalingi paketai</h2>

<p>composer.json konfigūracija:</p>

<pre><code>"repositories": [
    {
        "type": "vcs",
        "url": "http://github.com/Estina/MigrationBundle"
    }
],
"require": {
    "estina/migration-bundle"         : "*"
}
</code></pre>

<p>Ir paleidžiam <code>composer update</code></p>

<h2>Darbas su EstinaMigrationBundle</h2>

<p>EstinaMigrationBundle naudoja direktoriją <code>&lt;project_root&gt;/schema/migrations</code> ir failus <code>&lt;project_root&gt;/schema/structure.sql</code>, <code>&lt;project_root&gt;/schema/data.sql</code><br />
<code>structure.sql</code> - pradinė jūsų duombazės struktūra. SQL create table ir pan.<br />
<code>data.sql</code> - pradiniai jūsų duomenys. Paprastai SQL insertai.</p>

<p>Prieš naudojant paleidžiam komandą</p>

<pre><code> $ ./app/console migration:init
</code></pre>

<p>Ji sukuria duomenų bazėje lentelę, kurią naudoja migracijų loginimui.
Tuomet</p>

<pre><code> $ ./app/console migration:setup
</code></pre>

<p>Ši komanda į duomenų bazę suimportuoja pradinę duomenų bazės struktūrą iš <code>/schema/structure.sql</code> ir pradinius duomenis iš <code>/schema/data.sql</code> failo.</p>

<p>Toliau, norėdami atlikti pakeitimą duomenų bazėje, sukuriame migracijos failą</p>

<pre><code> $ ./app/console migration:new
 New migration script: /Users/Zilvinas/Sites/projektas/schema/migrations/20130403004411.sql
</code></pre>

<p>Sukuriamas migracijos failas ir parodomas jo path.<br />
Atsidarome nurodytą failą su savo mėgiamu editoriumi ir jame aprašome lentelės sukūrimą</p>

<pre><code>CREATE TABLE IF NOT EXISTS `labadiena` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `content` text NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
</code></pre>

<p>Turime migraciją, kuri sukurs lentelę "labadiena". Kad lentelė patektų į duombazę - migracijas turim importuoti.</p>

<pre><code> $ ./app/console migration:apply
 Applying file 20130403004411.sql OK 
</code></pre>

<p>Komanda migration:apply suimportuoja visas iki šiol neimportuotas migracijas. Kurios migracijos importuojamos - išvedama konsolėje.   Migracijos importuojamos pagal sukūrimo laiką, seniausios - pirmiausiai. Migracijos failo pavadinimas - timestampas. Pagal jį identifikuojamas sukūrimo laikas.</p>

<h2>Argumentai už ir prieš</h2>

<p>Gan paprasto funkcionalumo įrankis, bet labai stipriai palengvina darbą komandoje, taip pat ir deployinant pakeitimus į test ar production environmentus.</p>

<p>Minusas būtų tas, kad su šiuo įrankiu neišeina pilnai versijuoti duomenų bazės. Migracijos yra vienos krypties, tik up (upgrade), nėra down (downgrade) funkcionalumo. Bet duomenų bazės degradavimo skriptus ne visada developeriai rašo ir naudodami pilnaverčius duomenų bazių migracijų įrankius. Ne visada to reikia.</p>

<h2>Opensource</h2>

<p>Projektas yra viešas, skirtas bendruomenei, tikintis, kad padės sutaupyt laiko ir kitiems, palengvinant duomenų bazės migracijas. Source guli <a href="https://github.com/Estina/MigrationBundle">GitHub'e</a>, tad jei turite minčių kaip galima būtų patobulint - junkitės.</p>

<blockquote>
  <p><a href="https://github.com/Estina/MigrationBundle">https://github.com/Estina/MigrationBundle</a></p>
</blockquote>

<p>Jeigu neturite laiko, kada patys pakodint - bent prisidėkite idėjomis.</p>
