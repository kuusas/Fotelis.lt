<p>Daugelis programuotojų turbūt patenkinti savo kodu. Bet ar teko nagrinėti kito programuotojo kodą? Su logika buvo viskas tvarkoj, bet jum vistiek svetimas kodas nepatiko? Sunkiai skaitėsi? Kiekvienas mūsų rašom kodą kaip mum patinka, taip kaip įprantam, mum taip ir geriausiai skaitosi, bet kas nutinka kai susitinka būrelis programuotojų, sėda dirbti prie vieno projekto ir kiekvienas bando primesti savo stilių? Įsivaizduojate vieną klasę, kurioje metodai aprašyti 2, 3 ar 4 skirtingais stiliais?</p>

<p>PHP bendruomenėj niekada nebuvo labai atvirai diskutuojama apie programavimo standartus, ar programavimo stilių. Kiekvienas rimtesnis frameworkas, CMS'as ar didesnė biblioteka grubiai aprašydavo jame naudojamą kodo stilių. Bet taip buvo primetami standartai dirbant tik konkrečiam atvejui, dirbant su tuo frameworku, CMS ar biblioteka. Tik pasirodęs Zend Framework įnešė griežtesnių standartizavimo idėjų į PHP pasaulį su savo "coding conventions". Greičiausiai dėl populiarumo su šiuo frameworku pasirodžiusius standartus pamėgo daugelis programuotojų ir pradėjo naudoti savo projektuose.</p>
<h2>Kas yra kodo stilius?</h2>
<p>Tai yra kodo formatavimas laikantis tam tikrų taisyklių. Taisyklės nusako kokiais atvejais kaip turėtų būti suformatuotas kodas. Kada riestinis skliaustas turėtų būti perkeliamas į naują eilutę, kada rašomas toje pačioje. Kaip vardinti metodus? Kaip kintamuosius? CamelCase vs. Underscores ir t.t.</p>

<p>Du kodo stiliaus pavyzdžiai</p>


<p>Detaliau <a title="Programavimo stilius" href="http://lt.wikipedia.org/wiki/Programavimo_stilius" target="_blank">Wiki paaiškinimas</a>.</p>
<h2>Kas yra programavimo standartai?</h2>
<p>Programavimo standartai, kaip ir bet kurie kiti standartai skirti išlaikyti vieningumą, šiuo atveju programiniame kode. Klasės, metodai, ciklai ir t.t. turi būti rašomi laikantis standarto.</p>
<h2>Kam reikalingi standartai?</h2>
<p>Kad kiekvienas programuotojas prisėdęs prie kodo jį lengvai perskaitytų ir suprastų, o supratęs galėtų ir atlikti jam skirtą užduotį. Skaitomumas, jungiamo kodo struktūrų vientisumas - esminės problema, kurią išsprendžia programavimo standartas.</p>
<h2>Kokie standartai egzistuoja?</h2>
<p>Prieš daugiau nei pusmetį buvo priimti du PHP programavimo standartai - <a title="PSR-1 standartas" href="https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md" target="_blank">PSR-1 standartas</a> ir <a title="PSR-2 standartas" href="https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md" target="_blank">PRS-2 standartas</a>. PSR-1 yra bazinis kodo standartas, kurio taisyklės užtikrina jungiamo kodo vientisumą. PSR-2 - išplečia PSR-1 aprašytas nuostatas ir papildo taisyklėmis orientuotomis į kodo skaitomumą.</p>
<h2>Aš turiu savo standartą (stilių)!</h2>
<p>Manau kiekvienas programuotojas turi savo vidinęs nuostatas rašant kodą, nes to reikalauja pasąmonė. Nėra taisyklių - nėra tvarkos, nėra tvarkos - gaištamas laikas niekams. Turėti savo standartą - šauni praktika, tačiau laikas judėti toliau - priimti visuotinį standartą. Tokiu būdu visi kartu sutaupysime laiko kodo supratimui ir galėsim daugiau laiko skirti problemų sprendimui. Visi vadovaudamiesi standartu būsim kaip vienas programuotojas ir su malonumu galėsim refactorinti vienas kito kodą.</p>
<h2>Pagalbiniai įrankiai</h2>
<h3>PHP-CS-Fixer</h3>
<p>Iš pradžių laikytis visų aprašytų PSR-1 ir PSR-2 normų gali būti sudėtinga, tam yra sukurtas įrankis PHP-CS-Fixer (PHP Coding Standards Fixer). Jo pagalba galima greitia sutvarkyti visas esamas klaidas redaguojamame faile, ar visuose failuose nurodytoje direktorijoje.</p>
<h3>Sublime Text 2: PHPCS</h3>
<p>Naudojantiems Sublime Text 2 rekomenduoju tam skirtą <a title="Sublime Text 2: PHPCS plugin" href="https://github.com/benmatselby/sublime-phpcs" target="_blank">PHPCS pluginą</a></p>