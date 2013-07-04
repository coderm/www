<?php

/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    public function getLanguageId() {
        $lang = CakeSession::read('Config.language');
        switch ($lang) {
            case 'tur':
                $id = 1;
                break;
            case 'eng':
                $id = 2;
                break;
            case 'rus':
                $id = 3;
                break;
            case 'ger':
                $id = 4;
                break;
            case 'spa':
                $id = 5;
                break;
            default:
                $id = 1;
                break;
        }
        return $id;
    }

    public function returnLanguage($LanguageId) {
        switch ($LanguageId) {
            case 1:
                $lang = 'tur';
                break;
            case 2:
                $lang = 'eng';
                break;
            case 3:
                $lang = 'rus';
                break;
            case 4:
                $lang = 'ger';
                break;
            case 5:
                $lang = 'spa';
                break;
            default:
                $lang = 'tur';
                break;
        }
        return $lang;
    }

    function formatFormDateToMySQLDate($dateString) {
        $a = explode('-', $dateString);
        return $a[2] . '-' . $a[1] . '-' . $a[0];
    }

    public function convertCurrency($currencyId = NULL, $siteCurrency = NULL) {
        // $siteCurrency = CakeSession::read('Currency.messageTextId');
        if (!isset($currencyId))
            $currencyId = 1;
        if ($siteCurrency == NULL)
            $siteCurrency = '€';
        $multiplier = $this->query('select fn_change_currency(1, message_text_id, "' . $siteCurrency . '") multiplier  from lu_currency_unit where currency_unit_id = ' . $currencyId);
        $result = array();
        $result['Currency'] = $siteCurrency;
        $result['multiplier'] = $multiplier['0']['0']['multiplier'];
        return $result;
    }

    public function propertiesToArray($propertiesString) {
        $propertiesString;
        $a = array();
        if ($propertiesString != '' && strpos($propertiesString, "[|]") > 0 && strpos($propertiesString, "=>") > 0) {
            $properties = explode('[|]', $propertiesString);
            foreach ($properties as $property) {
                if (strpos($property, "[||]") > 0) {
                    $p = explode('=>', $property);
                    $key = $p[0];
                    $p = explode($p[0] . '=>', $property);
                    $properties2 = explode('[||]', $p[1]);
                    foreach ($properties2 as $property2) {
                        $p = explode('=>', $property2);
                        $a[$key][$p[0]] = $p[1];
                    }
                } else {
                    $p = explode('=>', $property);
                    $a[$p[0]] = $p[1];
                }
            }
        }
        return $a;
    }

    public function getGlobalRate() {
        $result = $this->query('SELECT value FROM lu_global_variable lgv where message_text_id = "global_rate" ');
        return $result['0']['lgv']['value'];
    }

    public function priceRound($pirce) {
        return round($pirce + 0.25);
    }

    public function priceRound2($pirce) {
        return round($pirce - 0.25);
    }

}
