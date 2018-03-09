<?php

namespace App;

class Engine
{
  private const $g = 9.81; // constante de gravité
  private const $ro = 1.2; // masse volumique de l'air en kg/m2
  private const $precision = 2 // Nombre de décimales pour la précision

  public function __construct(){
  }

  // TODO: Vérifier que cette algo soit juste ! les distances ont des comportements bizares des fois
  /**
   * Cette fonction calcule une distance sur terre avec deux points définis
   * par leur longitude et latitude (et tient compte de l'altitude)
   * @param float lat1 latitude point A
   * @param float lng1 longitude point A
   * @param float alt1 altitude point A
   * @param float lat2 latitude point B
   * @param float lng2 longitude point B
   * @param float alt2 altitude point B
   * @return float distance between the two points
   */
  private function fnDistance($lat1, $lng1, $alt1, $lat2, $lng2, $alt2){
    $d1 = 6378 * ($lat2 - $lat1) * pi() / 180;
    $d2 = 6378 * ($lng2 - $lng1) * (pi() / 180) * cos(($lat1 + $lat2) * pi() / 360);
    $d3 = ($alt1 - $alt2) / 1000; // les altitudes sont en m, les distances en km
    $d = sqrt(pow($d1, 2) + pow($d2, 2) + pow($d3, 2));

    return $d;
  }

  /**
   * La fonction renvoie l'énergie d'un tronçon en Wh
   * @param masse
   * @param scx
   * @param rendement
   * @param Cr
   * @param recup
   * @param pente
   * @param dist
   * @param v1
   * @param v2
   * @param PA
   * @return float energie d'un tronçon
   */
  private function fnEnergieDx($masse, $scx, $rendement, $Cr, $recup, $pente, $dist, $v1, $v2, $PA){
    $veq = 0; //stockera la vitesse équivalente en termes de carré de la vitesse (racine (v2^2+v1v2+v1^2)/3), voir identités remarquable en maths)

    // cette fonction calcule une distance sur terre avec deux points définis par leur longitude et latitude.
    $force = 0; // stockera la force motrice nécessaire
    $EDx = 0; //stockera l'énergie avant de la retourner
    $EA = 0; //stockera l'énergie dépensée par les accessoires

    $force = $masse * $this->g * $pente / 100; //influence de la pente, attention la pente est en %

    $veq = sqrt((pow($v2, 2) + $v1 * $v2 + pow($v1, 2)) / 3); // voir calcul d'identité remarquable
    $force += 0.5 * $this->ro * $scx * pow($veq / 3.6, 2); //influence de l'air
    $force += $masse * $this->g * $Cr;// influence du frottement des pneus
    $EDx = ($force * $dist * 1000) / $rendement;//L'énergie est la force * distance (en mètres, donc *1000), en joules
    $EDx += (0.5 * $masse * (pow($v2 / 3.6, 2) - pow($v1 / 3.6, 2)))/$rendement;
    $EA = $dist * $PA / ($v1 + $v2) * 2; //Le temps (dist / vMoyenne)*PuissanceAccessoires, en Wh
    $EDx = $EDx + $EA * 3600 ; //Énergie en joules

    if ($EDx>0) return $EDx / 3600;
    else return $EDx * $recup / 3600;
  }

  // TODO: Si on arrive à la fin du trajet et qu'un pont/tunnel a été commencé, il ne pourra pas se finir...
  /**
  * Cette fonction filtre les points qui semblent bizarre (tunnels ou viaducs)
  * en mettant une valeur assez proche du point précédent (max 7.5% de pente)
  *
  * L'élevation correspond aux valeurs renvoyées par l'api google et stockée sous forme de tableau
  * lat() et lng() sont des fonctions de l'API google map
  *
  * @param array waypoints
  * @return array filteredWaypoints
  */
  private function filtreElevation($waypoints){

    $istart = -1;
    $waypoints[0]->distance = 0;
    $waypoints[0]->distanceTotale = 0;
    $waypoints[0]->pente = 0;
    $nbrWaypoints = count($waypoints);

    for ($i = 1; $i < $nbrWaypoints; $i++) {
      // Calcul de la pente entre 2 waypoints consécutifs
      $waypoints[$i]->distance = $this->fndistance(
        $waypoints[$i-1]->location->lat,
        $waypoints[$i-1]->location->lng,
        0, $waypoints[$i]->location->lat,
        $waypoints[$i]->location->lng,
        0
      );
      $waypoints[$i]->pente = ($waypoints[$i]->elevation - $waypoints[$i-1]->elevation)/$waypoints[$i]->distance/10;
      $waypoints[$i]->distanceTotale = $waypoints[$i-1]->distanceTotale + $waypoints[$i]->distance;

      // Si il n'y a pas encore de début de tunnel ou de pont et que la pente dépasse 15%, on garde ce waypoint comme point de départ de tunnel/pont.
      if ($istart == -1 && ($waypoints[$i]->pente < -15 || $waypoints[$i]->pente > 15)) {
        $istart = $i-1;
      }

      // Si on a déjà un point de départ, on calcule la pente entre ce point de départ et le waypoint actuel ($i).
      else if ($istart != -1) {
        $distStartpoint = $this->fndistance(
          $waypoints[$istart]->location->lat,
          $waypoints[$istart]->location->lng,
          0,
          $waypoints[$i]->location->lat,
          $waypoints[$i]->location->lng,
          0
        );
        $penteStartpoint = ($waypoints[$i]->elevation - $waypoints[$istart]->elevation) / $distStartpoint / 10;

        /*
        Si la pente dans le tunnel/pont atteind les 7.5% et que la pente à la fin du tunnel/pont est correcte,
        on change l'altitude des waypoints entre le point de départ et d'arrivée pour faire une pente correcte.
        */
        if ($penteStartpoint < 7.5 && $penteStartpoint > -7.5 && $waypoints[$i]->pente > -15 && $waypoints[$i]->pente < 15) {
          $delta_i = $i - $istart;
          $deltaDistance = $waypoints[$i]->distanceTotale - $waypoints[$istart]->distanceTotale;
          $deltaElevation = $waypoints[$i]->elevation - $waypoints[$istart]->elevation;

          /**
          * Le calcul de l'elevation se fait comme suit:
          * Plus on avance dans le tunnel, plus il faudra ajouter (ou enlever) d'elevation
          * Prennons une différence de hauteur entre le début et la fin du tunnel de +40m.
          * Si on est à la moitié du tunnel, on est à 20m de plus qu'au début du tunnel (50% des 40m)
          * Si on est au quart, on est à 10m de plus que l'elevation du début du tunnel (25% des 40m)
          * Donc, on peut dire que l'elevation est proportionnel à la distance dans le tunnel
          *
          * Donc, on peut faire la formule :  (distanceDansTunnel / tailleTunnel) * differenceHauteurTunnel
          * Exemple: tunnel de 120m de long et 40m de denivelee. Si on est à 60m dans le tunnel :   (60 / 120) * 40
          *   ou, comme appliqué ci-dessous : 60 * 40 / 120
          */
          for ($y = 1; $y <= $delta_i; $y++) {
            $icurrent = $istart + $y;
            $oldElevation = $waypoints[$icurrent]->elevation;
            $waypoints[$icurrent]->elevation = $waypoints[$istart]->elevation + (($waypoints[$icurrent]->distanceTotale - $waypoints[$istart]->distanceTotale) * $deltaElevation / $deltaDistance);
            $waypoints[$icurrent]->pente = ($waypoints[$icurrent]->elevation - $waypoints[$icurrent - 1]->elevation) / $waypoints[$icurrent]->distance / 10;
          }
          $istart = -1;
        }
      }
    }
    return $waypoints;
  }

  /**
  * Cette methode calcule la distance et le temps totale que va prendre un trajet d'après les données
  * fournies par Google.
  *
  * @param array $googleSteps Doit contenir les valeurs "distance->value" et "duration->value"
  * @return StdClass(durationTot, distanceTot) Duree en secondes et distance en mètres
  */
  public function calculateDurationDistance($googleSteps){
    $ret = new StdClass();
    $ret->distanceTot = 0;
    $ret->durationTot = 0;

    foreach ($googleSteps as $step) {
      $ret->distanceTot += $step->distance->value;
      $ret->durationTot += $step->duration->value;
    }

    return $ret;
  }

  // TODO: Eviter de retourner tout un vehicule. Si possible, retourner que les valeurs utiles et les attribuer au véhicule après
  /**
  * Calcul de l'énergie dépensée entre chaque waypoint et de l'énergie totale consommée
  *
  * @param array $waypoints Les points donnés par Google
  * @param Vehicle $vehicle Le vehicule en question
  * @param int $speed La vitesse a utiliser en Km/h
  * @return Vehicle Le vehicule donné en paramètre mais avec les membres "usedEnergy" et un tableau
  *                contenant l'energie utilisée entre chaque waypoint
  */

  public function calculateUsedEnergies($waypoints, $vehicle, $speed){
      $vehicle->usedEnergy = 0;
      $nbrWaypoints = count($waypoints);

      for ($i = 0; $i < $nbrWaypoints; $i++) {
        if ($i == 0) $energieDx = 0;
        else{
          $energieDx = $this->fnEnergieDx(
            $vehicle->poidsVideKg,
            $vehicle->scx,
            $vehicle->rdtMoteur,
            $vehicle->cr,
            $vehicle->precup,
            $waypoints[$i]->pente,
            $waypoints[$i]->distance,
            ($i == 1 ? 0 : $speed), // Si c'est le début, il faut prendre en compte le départ de la voiture
            $speed,
            $vehicle->accessoriesPower
          );
        }

        $vehicle->waypoints[$i] = new stdClass();
        $vehicle->waypoints[$i]->energy = round($energieDx, $this->precision);

        // On cumule l'énergie nécessaire à chaque petit tronçon en kWh
        $vehicle->usedEnergy += $energieDx / 1000;

        // Le véhicule ne peut pas utiliser plus d'énergie que celle disponnible
        if ($vehicle->usedEnergy < 0) $vehicle->usedEnergy = 0;

        // TODO: Enlever ces lignes (elles sont la pour garder la compatibilité avec l'ancien javascript)
        $vehicle->waypoints[$i]->distance = round($waypoints[$i]->distanceTotale, $this->precision);
        $vehicle->waypoints[$i]->elevation = round($waypoints[$i]->elevation, $this->precision);
        $vehicle->waypoints[$i]->pente = round($waypoints[$i]->pente, $this->precision);
      }
      return $vehicle;
  }

  /**
  * Calcul de l'énergie consommée suivant le style de conduite (eco, sport)
  * x est une valeur entre 0 et 10 (Sport)
  * ex: pour la valeur 6, 6x par 10 km le véhicule accélére à 6% de vitesse en plus,
  *     freine jusqu'a 6% de vitesse en moins et réaccélére à la vitesse de consigne
  * Energie en plus: d * (x/125) * m * (vo/3.6)^2 * (1/Rendement - Rendement Récup)
  *
  * @param float $distanceTotal La distance totale du trajet
  * @param int $lvlSport Le niveau de conduite sportive (entre 0 et 10)
  * @param Vehicle $vehicle La voiture utilisée
  * @param int $speed La vitesse utilisée sur le trajet
  *
  * @return float L'énergie consommée en plus suivant le mode de conduite (en Watts)
  */
  public function energyByDrivingStyle($distanceTotal, $lvlSport, $vehicle, $speed){
    return $distanceTotal * $lvlSport/500 * $vehicle->poidsVideKg * pow($speed / 3.6, 2) * $lvlSport * (1 / $vehicle->rdtMoteur - $vehicle->precup);
  }

  /**
  * Cette methode fait tout les calculs concernant la page principale de l'outil greenrace
  *
  * @return string Le JSON contenant tous les résultats des calculs
  */
  public function calculateValues(){
    // Init et vérification des variables
    $ret = new StdClass();

    // Si la requête ajax n'a pas de donnée "request", on quitte avec un message d'erreur
    if(!Input::has('request')){
      $ret->error = 'Request informations are needed';
      return json_encode($ret);
    }

    //Transforme les valeurs données sous forme de tableau par Laravel en objets
    $json =  json_decode(Input::get('request'));
    $params = $json->request->params;

    //$sldSport correspond à la valeur choisie par l'utilisateur avec le slider du type de conduite
    $lSport = intval($params->lSport);

    // Calcul des ponts, tunnels, pentes, elevations
    $ret->waypoints = $this->filtreElevation($json->request->waypoints);

    // Calcul de la distance et de la durée totale du trajet
    $ret = (object) array_merge((array) $ret, (array) $this->calculateDurationDistance($json->request->steps));

    // Calcul de la vitesse moyenne suivant le choix fait par l'utilisateur
    // Manuelle     - constante sur tout le trajet et entrée par l'utilisateur
    // Automatique  - Calculée en fonction de la distance parcourue et de la durée
    //On doit avoir la vitesse de consigne en km/h
    // Si le choix est manuel, on récupère ce que l'utilisateur à mis dans le champs. Sinon, on calcul
    $vConsigne;

    if ($params->distanceType == 'man') $vConsigne = intval($params->vConsigne);
    else $vConsigne = intval($ret->distanceTot / $ret->durationTot * 3.6);

    // Calculs de l'energie dépensée, de la batterie, de la consommation et de l'autonomie de chaque voiture
    // Transformation distance m -> km
    $ret->distanceTot = $ret->distanceTot / 1000;
    $vehicles = $json->request->vehicles;
    $nbrVehicle = count($vehicles);

    for ($i = 0 ; $i < $nbrVehicle; $i++) {
      // On utilise la plus petite vitesse entre la vitesse moyenne du trajet (ou la vitesse entrée par l'utilisateur)
      //    et la vitesse max du véhicule
      $vitesseUtilisee = ($vehicles[$i]->vMaxPm0 < $vConsigne ? $vehicles[$i]->vMaxPm0 : $vConsigne);

      // Calcul de l'énergie dépensée entre chaque waypoint et de l'énergie totale consommée
      $ret->vehicles[$i] = $this->calculateUsedEnergies($ret->waypoints, $vehicles[$i], $vitesseUtilisee);

      // Attribution de l'ID
      $ret->vehicles[$i]->id = $vehicles[$i]->idves;

      //Prise en compte du mode de conduite éco, sport
      $ret->vehicles[$i]->usedEnergy += $this->energyByDrivingStyle($ret->distanceTot, $lSport, $vehicles[$i], $vitesseUtilisee) / 3600000; // on ajoute l'énergie en kWh

      // Calculs de la batterie restante, pourcentage de batterie restante, consomation et autonomie
      $ret->vehicles[$i]->batRestante = $vehicles[$i]->batterieEnergiekWh - $ret->vehicles[$i]->usedEnergy;
      $ret->vehicles[$i]->consommation = $ret->vehicles[$i]->usedEnergy / $ret->distanceTot * 100;
      $ret->vehicles[$i]->batRestantePourcentage = $ret->vehicles[$i]->batRestante / $vehicles[$i]->batterieEnergiekWh * 100;
      $ret->vehicles[$i]->autonomie = $vehicles[$i]->batterieEnergiekWh / $ret->vehicles[$i]->consommation * 100;

      // TODO: Enlever ces lignes (elles sont la pour garder la compatibilité avec l'ancien javascript)
      $ret->vehicles[$i]->distot = round($ret->distanceTot, $this->precision);
      $ret->vehicles[$i]->vitesse = round($vConsigne, $this->precision);
      $ret->vehicles[$i]->energie = round($ret->vehicles[$i]->usedEnergy, $this->precision);

      // Si l'autonomie est plus grande ou égale à 1000 on affiche +1000
      if($ret->vehicles[$i]->autonomie >= 1000) $ret->vehicles[$i]->autonomie = '+' . 1000;
    }

    // TODO: problème avec les distance. distanceTot = distance totale de google
    //        distance utilisée pour le filtre = distance calculée par $this->fndistance (ce ne sont pas les mêmes)
    $ret->distot = round($ret->distanceTot, $this->precision);
    $ret->vitesse = round($vConsigne, $this->precision);

    return json_encode($ret);

  }

}
