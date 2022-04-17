<?php
/*
Cas client : Calcul de taux de change

Voici les résultats à obtenir :
100 dollars + 100 dollars = 200 dollars
10 euros + 5 euros = 15 euros
100 dollars + 5 euros = 95euros


Objectif visuel :
2 input de valeur
2 input de devise
Un bouton Calculer

L'objectif fonctionnel :
Le résultat doit être celui énoncé au dessus

Objectif de temps : 2-3H

A noter que pour le test, le taux de change pour chaque devise sera fixe. (Ne pas prévoir de taux de change variable)

Il est tout aussi important d'expliquer la démarche technique abordée
et la démarche technique si tu avais 10H de temps sur le sujet.

Il me faut soit un zip, soit un git au choix.
Le test doit être réalisé en PHP (natif ou avec framework au choix)

N.B :
- Le client est ambitieux, il voudra sûrement utiliser ce petit outil pour différentes devises à terme.
J'ai besoin de savoir comment nous pouvons faire évoluer l'outil assez simplement. (explication à fournir dans la démarche)

Autres informations à prendre en compte :
- Pour finir le client souhaite recevoir l'historique des calculs du jour par Email 
(pour simplifier nous utiliserons la fonction mail de PHP sans configuration spécifique SMTP ou autres)

Bonne journée,
-- 

*/

$result_eu_1;
$result_dollar_1;

$result_eu_2;
$result_dollar_2;

$currency_1;
$currency_2;

$sum1;
$sum2;

$result;

if (isset($_POST["submit"])) {
  if (!empty($_POST["calc_1"])) {
    $selected_1 = $_POST["calc_1"];
    $result_1 = $_POST["value_1"];
    // print $selected_1 . "  ";
    // print $result_1;
    switch ($selected_1) {
      case "e-1":
        $result_eu_1 = euro($_POST["value_1"]);
        // print $result_eu_1;
        $currency_1 = "€";
        break;
      case "d-1":
        $result_dollar_1 = dollar($_POST["value_1"]);
        // print $result_dollar_1;
        $currency_1 = "$";
        break;
    }

    echo "<br/>";
  } else {
    echo "Merci de bien vouloir selectionner une valeur.";
  }

  if (!empty($_POST["calc_2"])) {
    $selected_2 = $_POST["calc_2"];
    $result_2 = $_POST["value_2"];
    // print $selected_2 . "  ";

    switch ($selected_2) {
      case "e-2":
        $result_eu_2 = euro($_POST["value_2"]);
        // print $result_eu_2;
        $currency_2 = "€";
        break;
      case "d-2":
        $result_dollar_2 = dollar($_POST["value_2"]);
        // print $result_dollar_2;
        $currency_2 = "$";
        break;
    }
  } else {
    echo "Merci de bien vouloir selectionner une valeur.";
  }

  switch ($selected_1 && $selected_2) {
    case $selected_1 == "e-1" && $selected_2 == "e-2":
      $result = euro_and_euro($result_eu_1, $result_eu_2);
      $curency = "€";
      break;
    case $selected_1 == "e-1" && $selected_2 == "d-2":
      $result = euro_and_dollar($result_eu_1, $result_dollar_2);
      $curency = "$";
      break;
    case $selected_1 == "d-1" && $selected_2 == "d-2":
      $result = dollar_and_dollar($result_dollar_1, $result_dollar_2);
      $curency = "$";
      break;
    case $selected_1 == "d-1" && $selected_2 == "e-2":
      $result = dollar_and_euro($result_dollar_1, $result_eu_2);
      $curency = "€";
      break;
  }
}

function euro($val1)
{
  $sum1 = $val1;
  return $sum1;
}

function dollar($val2)
{
  $sum2 = $val2;
  return $sum2;
}

function euro_and_euro($result_eu_1, $result_eu_2)
{
  $sum1 = $result_eu_1;
  $sum2 = $result_eu_2;
  $total = $sum1 + $sum2;
  return $total;
}

function euro_and_dollar($result_eu_1, $result_dollar_2)
{
  $sum1 = $result_eu_1;
  $sum2 = $result_dollar_2 * 1.08126;
  $total = $sum1 + $sum2;
  return $total;
}

function dollar_and_dollar($result_dollar_1, $result_dollar_2)
{
  $sum1 = $result_dollar_1;
  $sum2 = $result_dollar_2;
  $total = $sum1 + $sum2;
  return $total;
}

function dollar_and_euro($result_dollar_1, $result_eu_2)
{
  $sum1 = $result_dollar_1 * 1.08126;
  $sum2 = $result_eu_2;
  $total = $sum1 + $sum2;
  return $total;
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Conversions</title>
    </head>
    <body>

        <form method="post">
                 Calculer vos devises : <input type="number" name="value_1" required />
            <select name="calc_1" required>
                    <option value=""> Choissisez une devise </option>
                    <option value="e-1">Euro</option>
                    <option value="d-1">Dollar</option>
              
            </select><span> en : </span><input type="number" name="value_2" required />
            <select name="calc_2" required>
                    <option value=""> Choissisez une devise </option>
                    <option value="e-2">Euro</option>
                    <option value="d-2">Dollar</option>
            </select>
            <input type="submit" name="submit" value="Calculer" />
        </form>

        <?php if (!empty($selected_1 && $selected_2)) {
          echo "<p> Voici le résultat du calcul pour : </p>";
          echo "<p>" .
            $result_1 .
            $currency_1 .
            "  +  " .
            $result_2 .
            $currency_2 .
            " = " .
            $result .
            $curency .
            "</p>";
        } else {
          echo "<p>" . "La saisie n'est pas correcte" . "</p>";
        } ?>
    </body>
</html>

