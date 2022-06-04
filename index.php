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

class ExchangeRate
{
  private $currency_1;
  private $choice_1;

  private $currency_2;
  private $choice_2;

  public function __construct($choice_1, $currency_1, $choice_2, $currency_2)
  {
    $this->choice_1 = $choice_1;
    $this->currency_1 = $currency_1;

    $this->choice_2 = $choice_2;
    $this->currency_2 = $currency_2;
  }

  public function get_currency_choice()
  {
    if (!empty($_POST["calc_1"]) && !empty($_POST["calc_2"])) {
      $choice_1 = $this->choice_1 = $_POST["calc_1"];
      $choice_2 = $this->choice_2 = $_POST["calc_2"];
    } else {
      echo "Merci de bien vouloir selectionner une valeur.";
    }

    return [$choice_1, $choice_2];
  }

  public function get_value()
  {
    if (!empty($_POST["value_1"]) && !empty($_POST["value_2"])) {
      $currency_1 = $this->currency_1 = $_POST["value_1"];
      $currency_2 = $this->currency_2 = $_POST["value_2"];
    } else {
      echo "Merci de bien vouloir ajouter une valeur.";
    }

    return [$currency_1, $currency_2];
  }

  public function calc_devise($choice_1, $choice_2, $currency_1, $currency_2)
  {
    switch ($choice_1 && $choice_2) {
      case $choice_1 == "e-1" && $choice_2 == "e-2":
        function euro_and_euro($currency_1, $currency_2)
        {
          $total = $currency_1 + $currency_2;
          return $total;
        }
        $result = euro_and_euro($currency_1, $currency_2);
        $curency = "€";
        return [$result, $curency];
        break;
      case $choice_1 == "e-1" && $choice_2 == "d-2":
        function euro_and_dollar($currency_1, $currency_2)
        {
          $currency_2 = $currency_2 * 1.08126;
          $total = $currency_1 + $currency_2;
          return $total;
        }
        $result = euro_and_dollar($currency_1, $currency_2);
        $curency = "$";
        return [$result, $curency];
        break;
      case $choice_1 == "d-1" && $choice_2 == "d-2":
        function dollar_and_dollar($currency_1, $currency_2)
        {
          $total = $currency_1 + $currency_2;
          return $total;
        }
        $result = dollar_and_dollar($currency_1, $currency_2);
        $curency = "$";
        return [$result, $curency];
        break;
      case $choice_1 == "d-1" && $choice_2 == "e-2":
        function dollar_and_euro($currency_1, $currency_2)
        {
          $currency_1 = $currency_1 * 1.08126;
          $total = $currency_1 + $currency_2;
          return $total;
        }
        $result = dollar_and_euro($currency_1, $currency_2);
        $curency = "€";
        return [$result, $curency];
        break;
    }
  }
}

$choice = new ExchangeRate(
  $_POST["calc_1"],
  $_POST["value_1"],
  $_POST["calc_2"],
  $_POST["value_2"]
);

// Le choix de la devise :
$array_currency = $choice->get_currency_choice();
$choice_1 = $array_currency[0];
$choice_2 = $array_currency[1];
// echo $choice_1 . " et " .  $choice_2;

// L'ajout de la valeur :
$array_value = $choice->get_value();
$currency_1 = floatval($array_value[0]);
$currency_2 = floatval($array_value[1]);
// echo $currency_1 . " et " .  $currency_2;

// Résultat du calcul :
$result_array = $choice->calc_devise(
  $choice_1,
  $choice_2,
  $currency_1,
  $currency_2
);
$result = $result_array[0];
$currency = $result_array[1];
?>

<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>Conversions</title>
</head>

<body>

  <form method="post">
    Calculer vos devises : <input type="number" name="value_1" min="0" required />
    <select name="calc_1" required>
      <option value=""> Choissisez une devise </option>
      <option value="e-1">Euro</option>
      <option value="d-1">Dollar</option>

    </select><span> en : </span><input type="number" name="value_2" min="0" required />
    <select name="calc_2" required>
      <option value=""> Choissisez une devise </option>
      <option value="e-2">Euro</option>
      <option value="d-2">Dollar</option>
    </select>
    <input type="submit" name="submit" value="Calculer" />
  </form>
  <?php echo "<p> Voici le résultat du calcul : " .
    $result .
    $currency .
    "</p>"; ?>
</body>

</html>