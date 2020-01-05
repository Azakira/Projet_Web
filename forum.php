<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="utf-8">

    <title>webpage Fred. Vernier </title>

    <link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="style.css">



      <?php

        // on recupere les 3 variables du dernier message

        $t = $_GET["type"];

        $n = $_GET["nom"];

        $m = $_GET["msg"];



        // selon le type on le rajoute au bon fichier

        if (isset($t) and $t=="hello"){

          $cont = file_get_contents("msghello.txt");

          // ... en concatenant le fichier existant avec une nouvelle ligne

          $cont = $cont.$n.":".date("Y-m-d-H-i-s").":".$m."\n";

          file_put_contents("msghello.txt", $cont);

        } else if (isset($t) and $t=="web"){

          $cont = file_get_contents("msgweb.txt");

          $cont = $cont.$n.":".date("Y-m-d-H-i-s").":".$m."\n";

          file_put_contents("msgweb.txt", $cont);

        } else if (isset($t) and $t=="prive" and $n!="fred" and $m!="topsecret"){

          $cont = file_get_contents("msgprive.txt");

          $cont = $cont.$n.":".date("Y-m-d-H-i-s").":".$m."\n";

          file_put_contents("msgprive.txt", $cont);

        }

      ?>



  </head>

  <body onload="init()">



      <h1>Forum</h1>

      <div>Entrez un message dans l'une des trois colonnes pour me dire bonjour, me donner votre avis sur mon site web ou bien m'envoyer un message personnel.</div>

      <!-- Le haut du tableau est statique avec des titres et 3 formulaires -->

      <table border="1">

        <tr><th colspan="2"> Hello</th><th colspan="2"> Site web</th><th colspan="2"> Privé</th></tr>

        <tr><td>Nom</td><td>Message</td><td>Nom</td><td>Message</td><td>Nom</td><td>Message</td></tr>

        <tr>

          <form action ="forum.php" method="GET">

            <td>

              <input type="hidden" name="type" value="hello"/>

              <input type="text"   name="nom"/>

            </td>

            <td>

              <input type="text"   name="msg"/>

              <input type="submit" value="Publier"/>

            </td>

          </form>





          <form action ="forum.php" method="GET">

            <td>

              <input type="hidden" name="type" value="web"/>

              <input type="text"   name="nom"/>

            </td>

            <td>

              <input type="text" name="msg"/>

              <input type="submit" value="Publier"/>

            </td>

          </form>





          <form action ="forum.php" method="GET">

            <td>

              <input type="hidden" name="type" value="prive"/>

              <input type="text" name="nom"/>

            </td>

            <td>

               <input type="text" name="msg"/>

               <input type="submit" value="Publier"/>

            </td>

          </form>

        </tr>

        <tr>

          <td colspan="2">

            <?php

            // affichage des message de bonjour

            $cont = file_get_contents("msghello.txt");

            // on coupe le contenu du fichier avec le caractere de saut de ligne

            $cc = explode("\n", $cont);

            //on affiche ligne apres ligne telle quelle

            foreach ($cc as $k => $v){

              if ($v!=""){

                $cls = explode(":", $v);

                print("<div><b>".$cls[0]."</b> a dit ".$cls[2]."</div>\n");

              }

            }

            ?>

          </td>



          <td  colspan="2">

            <?php

            // pareil pour les message sur la forme du site

            $cont = file_get_contents("msgweb.txt");

            $cc = explode("\n", $cont);

            foreach ($cc as $k => $v){

              if ($v!=""){

                  $cls = explode(":", $v);

                  print("<div><b>".$cls[0]."</b> a dit ".$cls[2]."</div>\n");

                }

            }

            ?>

          </td>



          <td  colspan="2">

            <?php

            // Pour les messages prives il faut mettre un certain nom et message qui sert de mot de passe

            if (isset($t) and $n=="fred" and $m=="topsecret"){

              $cont = file_get_contents("msgprive.txt");

              $cc = explode("\n", $cont);

              foreach ($cc as $k => $v){

                if ($v!=""){

                  $cls = explode(":", $v);

                  print("<div><b>".$cls[0]."</b> a dit ".$cls[2]."</div>\n");

                }

              }

            } else {

              print("<div>Le contenu des message privés<br> est reservé au gestionnaire du site</div>");

            }





            ?>

          </td>

      </tr>

     </table>

  </body>

</html>

