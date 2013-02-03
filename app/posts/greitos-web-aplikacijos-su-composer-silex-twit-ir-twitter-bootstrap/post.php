<h2>Composer</h2>
<p>Composeris nusipelnęs atskiro posto, šį kartą trumpai jį pristatysiu. Composer - PHP priklausomybių valdymo įrankis, kurio pagalba į savo projektą instaliuojame naudojamas bibliotekas. Homepage http://getcomposer.org/ </p>

<h2>Silex</h2>
<p>Programuotojo karjeros pradžioje, kiekvienas mano naujas projektas gaudavo savo custom kodo bazę. Manau nebuvau niekuo išskirtinis, taip elgdamasis, kiekvienas besimokydamas manau tai perėjom. Poto pasirašiau savo šiek tiek stabilesnę bazę - MVC frameworką. Su juo pragyvenau keletą metų iki kol atsirado Zend Framework - jis buvo pirmasis man patikęs frameworkas, su kuriuo greitai, paprastai ir kokybiškai galima buvo pasikelti web aplikaciją ant protingos MVC struktūros. Tuo metu MVC buzzwordas mano galvoje šėlo, reikia to ar nereikia - privalėjau naudot. Toliau dirbau su Zend Frameworku, buvau gan patenkintas, išėjus Symfony2 - naujus projektus patikėjau jam. Bet Symfony2, ar tas pats Zend Framework (pirmasis, antrojo dar neteko čiupinėt) - dideli monstrai.</p>
<p>Norint suvaldyti vos kelis route'us ar paprastą RESTful API pakurti - ar tikrai reikia tokio gargaro? Ne. Ir tai puikiai išsprendžia Fabien Potencier, to paties Symfony2 autoriaus, mini-frameworkas Silex (http://silex.sensiolabs.org/). Kadangi esu high-end kodo fanas, alternatyvų net neieškojau, gan aklai pasitikiu Fabien'u ir jo kuriamais įrankiais.</p>


<h2>Twitter Bootstrap front-end framework</h2>
<p>Dizainas. HTML layoutas. Back-end programuotojui tai didžiausi galvos skausmai. Vien paruošt tvarkingą išvedimą kai kuriems tampa galvos skausmu, o ką jau bekalbėti apie gražų dizainą? </p>
<p><img src="/media/posts/greitos-web-aplikacijos-su-composer-silex-twit-ir-twitter-bootstrap/img/worst-website.jpg" alt=""></p>
<p>Pritaikymą mobilioms aplikacijoms? Čia į pagalbą ateina Twitter Bootstrap front-end frameworkas ( http://twitter.github.com/bootstrap/ ) . </p>


<h3>Kodėl Twitter Bootsrap?</h3>
<p>Rinkomės tarp Twitter Bootstrap ir Foundation 3 (http://foundation.zurb.com/) , su kolegomis diskutavom, priėjom išvados, kad Twitter Bootstrap būtų racionalesnis pasirinkimas. Pagrindinės priežastys:<br>
<ul>
  <li>naudoja LESS (Foundation - SASS)</li>
  <li>Turi paprasčiau panaudojams komponentus (bent toks buvo pirmas įspūdis)</li>
  <li>Geresnis suderinamumas su Internet Explorer</li>
  <li>Turi gan patogų webinį customizer'į</li>
</ul>
</p>
<p>Taškas Foundationui - šią savaitę kaip tik kolega pabandė Foundation ir Twitter Bootstrap, jo nuomone - Foundation paprastesnis ir intuityvesnis nei Twitter Bootstrap.</p>

<p>Front-end frameworkai išsprendžia esmines problemas:<br>
  <ul>
    <li>Bazinis dizainas</li>
    <li>Layoutas</li>
    <li>Pritaikymas mobiliems įrenginiams - adaptive responsive layout</li>
  </ul>
</p>


<h2>Twig</h2>
<p>Ideologiškai aš esu prieš template'ų varikliukus. Man patinka pure PHP view'ai, naudojant blokinę sintaksę kontrolinėm struktūrom: if (): .. endif; foreach(): … endforeach; ir pan. Bet šiuo atveju renkuosi Twig, nes Silex jį palaiko pagal nutylėjimą, o kaip užsiloadinti PHP template engine'ą - reikia pasukt galvą. Taupom laiką - imam tai ką gaunam "out of the box".</p>
<p>Kadangi naudosju Twig, tai panaudosiu du esminius dalykus, kurie man labai patinka: tai Twig blokus ir view'ų paveldėjimą.</p>


<h2>Susikonfigūruojam parsisiunčiam visas priklausomybes</h2>

<p>Jeigu dar neturime - parsisiunčiame Composer
  <pre>
    curl -s https://getcomposer.org/installer | php
  </pre>
</p>

<p>Susikonfigūruojame mūsų projekto priklausomybes. Tam yra du būdai: būnant projekto direktorijoje paleisti composer init arba rankiniu būdu sukurti priklausomybes aprašantį failą composer.json.</p>
<p>Kuriame projektą su composer init

  <pre>
    php composer.phar init
    Package name: fotelis/projektas
    Description: Pavyzdinis projektas
    Author: Zilvinas Kuusas <info@fotelis.lt>
    Minimum Stability: stable
    Would you like to define your dependencies (require) interactively [yes]? : Yes
    Search for a package []: silex/silex (jeigu randą keletą versijų, renkamės paskutinę stabilią)
    Search for a package []: twig/twig (renkamės taipogi paskutinę stabilią versiją)
    Search for a package []: twitter/bootstrap
    Would you like to define your dev dependencies (require-dev) interactively [yes]? no
    Do you confirm generation [yes]? yes
  </pre>
</p>

<p>Priklausomybės sukonfiguruotos. Projekto direktorijoje turim sugeneruotą composer.json, kurio turinys panašus į:
  <pre>
  {
      "name": "fotelis/projektas1",
      "description": "Pavyzdinis projektas",
      "require": {
          "silex/silex": "dev-master",
          "twig/twig": "dev-master",
          "twitter/bootstrap": "dev-master"
      },
      "authors": [
          {
              "name": "Zilvinas Kuusas",
              "email": "info@fotelis.lt"
          }
      ],
      "minimum-stability": "stable"
  }
  </pre>
</p>


<p>Kai turim composer.json galim parsisiųsti priklausomybių paketus:
  <pre>
    php composer.phar update
  </pre>
</p>

<p>Visi paketai parsiunčiami į projekto vendor/ direktoriją. Autoloaderis, sugeneruotas composerio, guli vendor/autoload.php</p>


<h2>Pasileidžiam Silex</h2>


<p>app/bootstrap.php:
  <pre>
  <?=htmlentities('<?php')?>

  require_once __DIR__.'/../vendor/autoload.php'; 

  // Init Application
  $app = new Silex\Application(); 
  $app['debug'] = true; // kad matytume sistemines klaidas

  // Define routes
  $app->get('/', function() use($app) { 
      return 'Labadiena';
  }); 

  // Run Application
  $app->run(); 
  </pre>
</p>

<p>web/index.php:
  <pre>
  <?=htmlentities('<?php')?>

  require_once(__DIR__ . '/../app/bootstrap.php');
  </pre>
</p>


<p>Pabandome pažiūrėti ką turim: http://localhost/projektas1/web/index.php</p>
<p><img src="/media/posts/greitos-web-aplikacijos-su-composer-silex-twit-ir-twitter-bootstrap/img/screen-1.png" alt=""></p>

<h2>Užsikraunam Twig</h2>
<p>bootstrap.php pridedam:
  <pre>
  <?=htmlentities('<?php')?>

  // services
  $app->register(new Silex\Provider\TwigServiceProvider(), array(
      'twig.path' => __DIR__.'/views',
  ));
  </pre>
</p>

<p>Susikuriam bazinį layout ir puslapio viewus</p>
<p>app/views/layout.html.twig:
  <pre><?=htmlentities('
  <!doctype html>
  <html lang="en">
    <head>
      <meta charset="utf-8">
      <title>{% block title %}{% endblock %}</title>
    </head>


    <body>
      <h1>Pavyzdinis projektas</h1>
      <hr>
      {% block content %}
      {% endblock %}
    </body>
  </html>')?>
  </pre>
</p>

<p>app/views/index.html.twig:
  <pre><?=htmlentities('
  {% extends "layout.html.twig" %}

  {% block title %}
      Labadiena
  {% endblock %}

  {% block content %}
      <h2>Labadiena</h2>
      <p>Lorem ipsum.</p>
  {% endblock %}')?>
  </pre>
</p>

<p>bootstrap.php aprašytą / route'ą paredaguojam, kad grąžintų viewą:
  <pre>
    return $app['twig']->render('index.html.twig');
  </pre>
</p>

<p>Jau turim web aplikaciją generuojančią view'us.</p>
<p><img src="/media/posts/greitos-web-aplikacijos-su-composer-silex-twit-ir-twitter-bootstrap/img/screen-2.png" alt=""></p>

<p>Pridedam dar vieną route'ą su kintamuoju ir perduodam kintamajį view'ui:
  <pre>
  $app->get('/labas/{name}', function($name) use($app) { 
      return $app['twig']->render('labas.html.twig', array(
          'name' => $name
      ));
  }); 
  </pre>
</p>

<p>app/views/labas.html.twig:
  <pre><?=htmlentities('
  {% extends "layout.html.twig" %}


  {% block title %}
      Labas, {{ name }}
  {% endblock %}


  {% block content %}
      <h2>Labas, {{ name }}</h>
  {% endblock %}
  ')?>
  </pre>
</p>

<p>Bandom:
http://localhost/projektas1/web/index.php/labas/zmogau
</p>
<p><img src="/media/posts/greitos-web-aplikacijos-su-composer-silex-twit-ir-twitter-bootstrap/img/screen-3.png" alt=""></p>

<p>Pridedam bazinę navigaciją</p>
<p>app/views/layout.hmtl.twig pačioje <?=htmlentities('<body>')?> pradžioje
<pre><?=htmlentities('
<ul>
      <li><a href="{{ app.request.basePath }}/index.php">Pradžia</a></li>
      <li><a href="{{ app.request.basePath }}/index.php/labas/zmogau">Labas, žmogau</a></li>
      <li><a href="{{ app.request.basePath }}/index.php/labas/kosmose">Labas, kosmose</a></li>
    </ul>')?>
</pre>
</p>

<h2>Darom dizainą su Twitter Bootstrap!</h2>
<p>Panaudosim jau sukurtą pavyzdinį layoutą: http://twitter.github.com/bootstrap/examples/marketing-narrow.html</p>
<p>Pirmiausia reikia failus, kuriuos naudosim, susidėti į vietas. </p>


<p>Sukuriam direktoriją web/assets/css<br>
Į ją perkopijuojame twitter bootstrap css failus iš bootstrap docs projekto folderio (šį kartą LESS kompiliavimu neužsiimsim):
  <pre>
    cp vendor/twitter/bootstrap/twitter/bootstrap/docs/assets/css/bootstrap.css web/assets/css/bootstrap.css
    cp vendor/twitter/bootstrap/twitter/bootstrap/docs/assets/css/bootstrap-responsive.css web/assets/css/bootstrap-responsive.css
  </pre>
</p>
<p>Persikopijuojame paveikslėlius į web/assets/img direktoriją:
  <pre>
    cp -r vendor/twitter/bootstrap/twitter/bootstrap/img/ web/assets/img/
  </pre>
</p>
<p>Užsikrauname CSS failus<br>
app/views/layout.html.twig <?=htmlentities('<head>')?> sekcijoje pride dame:
  <pre><?=htmlentities('
  <link href="{{ app.request.basePath }}/assets/css/bootstrap.css" rel="stylesheet">
  <link href="{{ app.request.basePath }}/assets/css/bootstrap-responsive.css" rel="stylesheet">
  ')?>
  </pre>
</p>

<p>Susitvarkom HTML layoutą pagal pavyzdį http://twitter.github.com/bootstrap/examples/marketing-narrow.html
 ir gaunam app/views/layout.html.twig štai tokį:
<pre><?=htmlentities('
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>{% block title %}{% endblock %}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ app.request.basePath }}/assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 40px;
      }
      /* Custom container */
      .container-narrow {
        margin: 0 auto;
        max-width: 700px;
      }
      .container-narrow > hr {
        margin: 30px 0;
      }
      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 60px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 72px;
        line-height: 1;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }
      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }
    </style>
    <link href="{{ app.request.basePath }}/assets/css/bootstrap-responsive.css" rel="stylesheet">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container-narrow">
      <div class="masthead">
        <ul class="nav nav-pills pull-right">
          <li><a href="{{ app.request.basePath }}/index.php">Pradžia</a></li>
          <li><a href="{{ app.request.basePath }}/index.php/labas/zmogau">Labas, žmogau</a></li>
          <li><a href="{{ app.request.basePath }}/index.php/labas/kosmose">Labas, kosmose</a></li>
        </ul>
        <h3 class="muted">Fotelio projektas</h3>
      </div>
      <hr>
      <div class="jumbotron">
        {% block content %}
        {% endblock %}
        <a class="btn btn-large btn-success" href="{{ app.request.basePath }}/index.php/labas/veiksmas">Veiksmas!</a>
      </div>
      <hr>
      <div class="row-fluid marketing">
        <div class="span6">
          <h4>Subheading</h4>
          <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>
          <h4>Subheading</h4>
          <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>
          <h4>Subheading</h4>
          <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
        </div>
        <div class="span6">
          <h4>Subheading</h4>
          <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>
          <h4>Subheading</h4>
          <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>
          <h4>Subheading</h4>
          <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
        </div>
      </div>
      <hr>
      <div class="footer">
        <p>&copy; Company 2013</p>
      </div>
    </div> <!-- /container -->
  </body>
</html>
')?></pre></p>

<p>O vaizdas turėtų būti panašus į:<br>
<img src="/media/posts/greitos-web-aplikacijos-su-composer-silex-twit-ir-twitter-bootstrap/img/screen-4.png" alt=""></p>

<p>Štai ir turim greitai pakuriamą bazinę web aplikaciją. Kaip pavyzdžiai projektai, prie kurių prisidėjau, padaryti šiuo principu:
<ul>
  <li><a href="http://www.fotelis.lt" title="web development programuotojams">Fotelis.lt</a></li>
  <li><a href="http://www.jokiosreklamos.lt">jokiosreklamos.lt</a></li>
</ul>

<p>Projekto archyvą be naudojamų bibliotekų galite <a href="/media/posts/greitos-web-aplikacijos-su-composer-silex-twit-ir-twitter-bootstrap/files/projektas1-no-vendors.zip">parsisiųsti</a>. Bibliotekas parsiųs composeris projekto direktorijoje paleidus komandą<br>
<pre>
  composer update
</pre></p>

<p>Linkiu neužsiknisti savo custom kodo bazėse, gigantiškuose frameworkuose ar CMS'uose paleidinėjant nedidelius projektus.</p>

 




