Pats nuobodžiausias ir painiausias darbas developinant yra atnaujinti duomenų bazės struktūrą su kiekvienu deploymentu. Kokių tik būdų neprisigalvoja tam developeriai. Pats esu bandęs įvairiausius - developinant ir darant pakeitimus, visus juos saugoti į vieną sql failą ir deployinant tą failą paimportuoti į DB. Vėliau esu kūręs atskirus failus kiekvienam naujam pakeitimui: 00001.sql, 00002.sql, 00003.sql…. 00143.sql... Susidarius nemažai krūvai pakeitimų, tikrai užsiknisdavau, kai reikėdavo atsekt kuris iš tų mano failų buvo importuotas paskutinį kartą.

Pradėjus dirbt su Symfony2, be Doctrine ORM, kolegos parodė jų kurtą įrankį skirtą palengvinti darbą su duomenų bazės struktūros atnaujimu. Šį kartą ir pristatysiu šį įrankį - EstinaMigrationBundle, skirtą, dirbant su Symfony2 be Doctrine ORM, kontroliuoti duomenų bazės struktūrą per migracijų failus. 

Migracijų failai - atskiri SQL skriptai, kuriuose aprašomi mūsų atliekami duomenų bazės pakeitimai developmento metu. Sukuriam migracijos failą, importuojam, skuriam - importuojam. EstinaMigrationBundle visada atsimena paskutinę importuotą migraciją, tad deployinant projektą nereikia sukti galvos ar viskas bus tvarkoje su duombaze, tiesiog paleidžiat migration:apply komandą ir vuolia - visos migracijos suvažiuoja.  

Migracijose gali būti duomenų bazės schemos pakeitimai, tiek duomenų insert'ai ar update'ai. Viskas, ką darydami duombazei savo dev environmente norite perduoti ir kitiem.  


## Reikalingi paketai
composer.json konfigūracija:
     
    "repositories": [
        {
            "type": "vcs",
            "url": "http://github.com/Estina/MigrationBundle"
        }
    ],
    "require": {
        "estina/migration-bundle"         : "*"
    }

Ir paleidžiam `composer update`


## Darbas su EstinaMigrationBundle
EstinaMigrationBundle naudoja direktoriją `<project_root>/schema/migrations` ir failus `<project_root>/schema/structure.sql`, `<project_root>/schema/data.sql`  
`structure.sql` - pradinė jūsų duombazės struktūra. SQL create table ir pan.  
`data.sql` - pradiniai jūsų duomenys. Paprastai SQL insertai.  

Prieš naudojant paleidžiam komandą

     $ ./app/console migration:init

Ji sukuria duomenų bazėje lentelę, kurią naudoja migracijų loginimui.
Tuomet

     $ ./app/console migration:setup

Ši komanda į duomenų bazę suimportuoja pradinę duomenų bazės struktūrą iš `/schema/structure.sql` ir pradinius duomenis iš `/schema/data.sql` failo.

Toliau, norėdami atlikti pakeitimą duomenų bazėje, sukuriame migracijos failą

     $ ./app/console migration:new
     New migration script: /Users/Zilvinas/Sites/projektas/schema/migrations/20130403004411.sql

Sukuriamas migracijos failas ir parodomas jo path.  
Atsidarome nurodytą failą su savo mėgiamu editoriumi ir jame aprašome lentelės sukūrimą

    CREATE TABLE IF NOT EXISTS `labadiena` (
        `id` int(10) NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `content` text NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

Turime migraciją, kuri sukurs lentelę "labadiena". Kad lentelė patektų į duombazę - migracijas turim importuoti.

     $ ./app/console migration:apply
     Applying file 20130403004411.sql OK 

Komanda migration:apply suimportuoja visas iki šiol neimportuotas migracijas. Kurios migracijos importuojamos - išvedama konsolėje.   Migracijos importuojamos pagal sukūrimo laiką, seniausios - pirmiausiai. Migracijos failo pavadinimas - timestampas. Pagal jį identifikuojamas sukūrimo laikas.

## Argumentai už ir prieš
Gan paprasto funkcionalumo įrankis, bet labai stipriai palengvina darbą komandoje, taip pat ir deployinant pakeitimus į test ar production environmentus.  

Minusas būtų tas, kad su šiuo įrankiu neišeina pilnai versijuoti duomenų bazės. Migracijos yra vienos krypties, tik up (upgrade), nėra down (downgrade) funkcionalumo. Bet duomenų bazės degradavimo skriptus ne visada developeriai rašo ir naudodami pilnaverčius duomenų bazių migracijų įrankius. Ne visada to reikia.  


## Opensource
Projektas yra viešas, skirtas bendruomenei, tikintis, kad padės sutaupyt laiko ir kitiems, palengvinant duomenų bazės migracijas. Source guli [GitHub'e](https://github.com/Estina/MigrationBundle), tad jei turite minčių kaip galima būtų patobulint - junkitės. 

> [https://github.com/Estina/MigrationBundle](https://github.com/Estina/MigrationBundle)

Jeigu neturite laiko, kada patys pakodint - bent prisidėkite idėjomis.  