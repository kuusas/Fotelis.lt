<p>PhoneGap - įrankis leidžiantis web developeriam lengvai kurti multiplatformines mobilias aplikacijas. Kodėl web developeriams? Nes viskas realizuojama HTML + CSS + JavaScript panaudojant standartinius API. Oficiali svetainė <a title="PhoneGap" href="http://www.phonegap.com">phonegap.com</a>. Pabandysiu trumpai apvželgti kaip pasileisti paprastą bandomają aplikaciją Android platformai. Visi pateikiami pavyzdžiai paruošti OSX aplinkai.</p>
<h2>PhoneGap įrankiai, pasiruošimas</h2>
<h3>Įrankiai</h3>
<a href="http://kuusas.lt/blog/wp-content/uploads/2012/12/Screen-Shot-2012-12-30-at-8.22.15-PM.png"><img title="Android Developer Tools" src="http://kuusas.lt/blog/wp-content/uploads/2012/12/Screen-Shot-2012-12-30-at-8.22.15-PM-300x179.png" alt="" width="300" height="179" /></a>
<p>Pasiruošiam įrankius, kuriuos naudosim:<br />
    <ul>
        <li>Parsisiunčiam <a href="http://developer.android.com/sdk/index.html">Android SDK</a>, kartu gausim ir Eclipse su jau paruoštu naujausiu ADT (Android Development Tools) pluginu.</li>
        <li>Parsisiunčiam <a href="http://cordova.apache.org/">Cordova</a> ir kadangi dirbsim su Android, išsiarchivuojam incubator-cordova-android.zip archyvą, ir pasidedam į patogią vietą (naudosim paleidžiamuosius failus iš šio archyvo).</li>
    </ul>
</p>

<h3>Sistemos paruošimas</h3>
<p>Modifikuojam $PATH aplinkos kintamąjį, kad būtų įrauktos Android SDK direktorijos (OSX, Linux aplinkoje*).<br />
<ul>
    <li>Atsidarom terminalą (Terminal, iTerm) ir paleidžiam komandas:
[code]touch ~/.bash_profile[/code]
[code]open ~/.bash_profile[/code]</li>
    <li>(atidarys su numatytuoju tekstiniu redaktoriumi)</li>
    <li>Mum reikia pridėti Android SDK platform-tools ir tools direktorijas, tam pridėsim failo pabaigoje eilutę:
[code]export PATH=${PATH}:~/MobileDev/android-sdk-macosx/platform-tools:~/MobileDev/android-sdk-macosx/tools[/code]</li>
    <li>(pavyzdyje naudojamas kelias iki Android SDK direktorijos yra <em>~/MobileDev/android-sdk/macosx/</em>, kelias iki jūsų Android SDK direktorijos priklauso nuo jūsų)</li>
    <li>Išsaugom failą</li>
    <li>Perkraunam terminalą</li>
</ul>
* <a title="PATH aplinkos kintamasis windows" href="http://http://docs.phonegap.com/en/2.2.0/guide_getting-started_android_index.md.html#Getting%20Started%20with%20Android_3b_setup_your_path_environment_variable_on_windows" target="_blank">Instrukcijos</a> kaip susitvarkyti aplinką windows platformoje.</p>
<h2>Pasileidžiam pirmąją aplikaciją</h2>
<h3>Susikuriame projektą</h3>
<p>
<ul>
    <li>Terminale nueiname į Cordova android (incubator-cordova-android) <strong>bin</strong> direktoriją ir paleidžiam <strong>create </strong>komandą. Komanda sukuria bazinę naujo projekto struktūrą su pavyzdiniais HTML, CSS ir JavaScript failais. Pradžiai tai ir laikysime mūsų pirmąja aplikacija.
[code]./create <kelias_iki_projekto> <paketo_pavadinimas> <projekto_pavadinimas>[/code]

&lt;kelias_iki_projekto&gt; - kelias, kur saugosime savo projekto failus
&lt;paketo_pavadinimas&gt; - paketo pavadinimas, pvz. com.KompanijosPavadinimas.AplikacijosPavadinimas
&lt;projekto_pavadinimas&gt; - kuriamos aplikacijos pavadinimas (be tarpų)</li>
    <li>Pasileidžiame Eclipse ir iš meniu pasirenkame <strong>New project</strong> ir pasirenkame <strong>Android &gt; Android Project from Existing Code
<a href="http://kuusas.lt/blog/wp-content/uploads/2012/12/android_project_from_existing_code.png"><img class="alignnone size-large wp-image-47" title="android_project_from_existing_code" src="http://kuusas.lt/blog/wp-content/uploads/2012/12/android_project_from_existing_code-1024x1012.png" alt="" width="550" height="543" /></a>
</strong></li>
    <li>Pasirenkame direktoriją, kurioje sukūrėme savo projektą</li>
    <li><strong>Finish</strong></li>
</ul>
</p>
<h3>Diegiame aplikaciją į telefoną *</h3>
<p>
<ul>
    <li>Android telefone įjungiame <strong>USB debugging</strong> (<strong>Settings &gt; Applications &gt; Development</strong>)</li>
    <li>Prijungiame telefoną prie kompiuterio per USB</li>
    <li>Eclipse spaudžiam dešinį pelės mygtuką ant projekto ir renkamės <strong>Run As &gt; Android Application</strong></li>
    <li>Pasižiūrim ką turim telefono ekrane.</li>
</ul>
* Šiuo atveju aprašytas diegimas į telefoną, bet taipogi bandomąją aplikaciją galima <a title="Diegimas į Android emuliatorių" href="http://docs.phonegap.com/en/2.2.0/guide_getting-started_android_index.md.html#Getting%20Started%20with%20Android_5a_deploy_to_emulator" target="_blank">pasileisti Android emuliatoriuje</a>.
</p>
<h2>Projekto struktūra</h2>
<a href="http://kuusas.lt/blog/wp-content/uploads/2012/12/Screen-Shot-2012-12-30-at-9.16.43-PM.png"><img class="alignright" title="Screen Shot 2012-12-30 at 9.16.43 PM" src="http://kuusas.lt/blog/wp-content/uploads/2012/12/Screen-Shot-2012-12-30-at-9.16.43-PM-300x255.png" alt="" width="300" height="255" /></a>
<p>Prieš pradedant gaminti savo aplikaciją reikia žinoti kur ir kokius failus rasti. Web developeriui reikalingi failai (HTML, CSS, JavaScript) guli projekto <strong>assets/www</strong> direktorijoje.</p>

<p>Kiti reikalingi failai:<br />
<ul>
    <li><strong>&lt;projektas&gt;/res/xml/config.xml </strong>- šiame faile aprašomos taisės į naudojamus įskiepius. Pagal nutylėjimą Cordova įtraukia visus palaikomus standartinius įskiepius.</li>
    <li><strong>&lt;projektas&gt;/bin/&lt;projekto_pavadinimas&gt;.apk</strong> - sukompiliuotas Android aplikacijos APK paleidžiamasis failas. Jis kompiliuojamas kiekvieną kartą diegiant aplikaciją į telefoną arba emuliatorių.</li>
</ul>
</p>
<h2>Žaidžiam toliau</h2>
<p>Toliau siūlau:<br />
<ul>
    <li>Pažaisti su PhoneGap duodamais <a title="PhoneGap API" href="http://docs.phonegap.com/en/2.2.0/index.html" target="_blank">API</a></li>
    <li>Paeksperimentuoti su <a title="jQuery mobile" href="http://jquerymobile.com/test/docs/pages/phonegap.html" target="_blank">jQuery Mobile</a></li>
    <li>Pabandyti pasirašyti patiem <a title="PhoneGap įskiepis" href="http://www.adobe.com/devnet/html5/articles/extending-phonegap-with-native-plugins-for-android.html" target="_blank">PhoneGap įskiepį</a></li>
</ul>
</p>
<p>Sėkmės!</p>