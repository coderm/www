<?php

class AdvertCopiesController extends AppController {

    public $helpers = array('Html', 'Form');
    public $name = 'AdvertCopies';

    public function index($advertId = NULL) {
        if (isset($advertId))
            $advert = $this->AdvertCopy->getNextAdvert($advertId);
        else
            $advert = $this->AdvertCopy->getNextAdvert();

        $advertdetail = $this->AdvertCopy->getOldAdvertDetails($advert['advert_id']);
        pr($advertdetail);
        $detail = array();
        $detail['Interrior']['BedCapacity']['bed']['1person'] = $advertdetail['ldc_advert_single_bed'];
        $detail['Interrior']['BedCapacity']['bed']['2people'] = $advertdetail['ldc_advert_double_bed'];
        $detail['Interrior']['BedCapacity']['sofabed']['1person'] = $advertdetail['ldc_advert_sofa_bed'];
        $detail['Interrior']['FieldOptions']['roomCount'] = $advertdetail['ldc_advert_private_room_count'];
        $detail['Interrior']['FieldOptions']['livingRoomCount'] = $advertdetail['ldc_advert_shared_room_count'];
        $detail['Interrior']['FieldOptions']['bathRoomCount'] = $advertdetail['ldc_advert_bathroom_count'];
        $detail['Interrior']['FieldOptions']['areaSquareMeters'] = $advertdetail['ldc_advert_single_bed'];
        $detail['Interrior']['Tech']['TV'] = $advertdetail['ldc_lcd_tv'];
        $detail['Interrior']['Tech']['DVDPlayer'] = $advertdetail['ldc_dvd_player'];
        $detail['Interrior']['Tech']['Satelite'] = $advertdetail['interrior_tech_satelite'];
        $detail['Interrior']['Tech']['CableTV'] = 0;
        $detail['Interrior']['Tech']['PrivateChannels'] = 0;
        $detail['Interrior']['Tech']['Internet'] = $advertdetail['ldc_internet'];
        $detail['Interrior']['Tech']['BurglarAlarm'] = $advertdetail['ldc_burglar_alarm'];
        $detail['Interrior']['Tech']['FireAlarm'] = $advertdetail['ldc_fire_alarm'];
        $detail['Interrior']['Kitchen']['Refrigerator'] = $advertdetail['ldc_refrigerator'];
        $detail['Interrior']['Kitchen']['Oven'] = $advertdetail['ldc_oven'];
        $detail['Interrior']['Kitchen']['MicroWave'] = 0;
        $detail['Interrior']['Kitchen']['Cooker'] = $advertdetail['ldc_furnace'];
        $detail['Interrior']['Kitchen']['Exhauster'] = 0;
        $detail['Interrior']['Kitchen']['CoffeMachine'] = 0;
        $detail['Interrior']['Kitchen']['Kettle'] = $advertdetail['ldc_water_heater'];
        $detail['Interrior']['Kitchen']['TeaMachine'] = 0;
        $detail['Interrior']['Kitchen']['TostMachine'] = 0;
        $detail['Interrior']['Kitchen']['Dishwasher'] = $advertdetail['ldc_dish_washer'];
        $detail['Interrior']['Kitchen']['OtherKitchenEquipements'] = $advertdetail['ldc_fully_equipped_kitchen'];
        $detail['Interrior']['HeatingAndCooling']['AC'] = $advertdetail['ldc_air_conditioning'];
        $detail['Interrior']['HeatingAndCooling']['FirePlace'] = $advertdetail['ldc_fireplace'];
        $detail['Interrior']['HeatingAndCooling']['Radiator'] = 0;
        $detail['Interrior']['WaterHeating']['WaterHeater'] = 0;
        $detail['Interrior']['WaterHeating']['SolarHeater'] = 0;
        $detail['Interrior']['HouseHoldApplicances']['WashingMachine'] = $advertdetail['ldc_washing_machine'];
        $detail['Interrior']['HouseHoldApplicances']['Dryer'] = 0;
        $detail['Interrior']['HouseHoldApplicances']['Iron'] = 0;
        $detail['Interrior']['HouseHoldApplicances']['HairDrier'] = 0;
        $detail['Interrior']['HouseHoldApplicances']['Hoover'] = 0;
        $detail['Interrior']['HouseHoldApplicances']['HandHoover'] = 0;
        $detail['Interrior']['HealthAndSelfCare']['Private']['Sauna'] = 0;
        $detail['Interrior']['Bath']['Private']['TurkishBath'] = 0;
        $detail['Interrior']['Bath']['EnSuiteBathroom'] = 0;
        $detail['Interrior']['Bath']['Jacuzzi'] = $advertdetail['ldc_jacuzzi'];
        $detail['Interrior']['Bath']['Bath'] = 0;
        $detail['Interrior']['Bath']['WalkinShower'] = 0;
        $detail['Interrior']['Sport']['Private']['GYM'] = 0;
        $detail['Exterrior']['floorType'] = $advertdetail['ldc_advert_floor'];
        $detail['Exterrior']['Tech']['SecurityCam'] = 0;
        $detail['Exterrior']['SocialAreasAndFacilities']['SecurityPersonel'] = $advertdetail['ldc_security'];
        $detail['Exterrior']['SocialAreasAndFacilities']['CarParkIndoor'] = $advertdetail['ldc_parking_indoor'];
        $detail['Exterrior']['SocialAreasAndFacilities']['CarParkOutdoor'] = $advertdetail['ldc_parking_outdoor'] ;
        $detail['Exterrior']['SocialAreasAndFacilities']['Playpen'] = $advertdetail['ldc_playpen'];
        $detail['Exterrior']['SocialAreasAndFacilities']['HikingTrail'] = $advertdetail['ldc_hiking_trail'];
        $detail['Exterrior']['SocialAreasAndFacilities']['AquaPark'] = 0;
        $detail['Common']['Building']['Property']['SteelDoor'] = $advertdetail['ldc_steel_door'];
        $detail['Common']['Building']['Property']['InsulatedWindows'] = $advertdetail['ldc_insulating_glass'];
        $detail['Common']['Building']['Property']['VillaInASite'] = $advertdetail['ldc_housing_complex'];
        $detail['Common']['Building']['Property']['PrivateGarden'] = $advertdetail['ldc_private_garden'];
        $detail['Common']['Building']['Property']['SharedGarden'] = $advertdetail['ldc_shared_garden'];
        $detail['Common']['Building']['Property']['Balcony'] = $advertdetail['ldc_balcony'];
        $detail['Common']['Building']['Property']['Terrace'] = 0;
        $detail['Common']['Building']['Property']['Lift'] = $advertdetail['ldc_elevator'];
        $detail['Common']['Building']['Property']['ElectricalGenerator'] = $advertdetail['ldc_generator'];
        $detail['Common']['Building']['Type']['SelfContainedVilla'] = $advertdetail['ldc_detached'];
        $detail['Common']['Building']['Type']['DublexVilla'] = 0;
        $detail['Common']['Building']['Type']['TriplexVilla'] = 0;
        $detail['Common']['HealthAndSelfCare']['Shared']['Sauna'] = 0;
        $detail['Common']['Bath']['Shared']['TurkishBath'] = 0;
        $detail['Common']['Sport']['Shared']['GYM'] = 0;
        $detail['Common']['Landscape']['City'] = $advertdetail['ldc_city_breaks'];
        $detail['Common']['Landscape']['Mountain'] = $advertdetail['ldc_landspace_mount'];
        $detail['Common']['Landscape']['Pool'] = 0;
        $detail['Common']['Landscape']['Nature'] = $advertdetail['ldc_landspace_mount'];
        $detail['Common']['Landscape']['Sea'] = $advertdetail['ldc_landspace_sea'];
        $detail['Common']['Landscape']['Garden'] = 0;
        $detail['Common']['Fees']['ExtraFees']['Electric'] = 0;
        $detail['Common']['Fees']['ExtraFees']['Gas'] = 0;
        $detail['Common']['Fees']['ExtraFees']['Water'] = 0;
        $detail['Common']['Fees']['ExtraFees']['Cleaning'] = 0;
        $detail['Common']['Fees']['ExtraFees']['DamageDeposit'] = 0;
        $detail['Common']['Fees']['ExtraFees']['BottledGas'] = 0;
        $detail['Common']['OtherOptions']['PetFriendly'] = 0;
        $detail['Common']['OtherOptions']['SmokingFree'] = 0;
        $detail['Common']['Beach']['Range'] = '';
        $detail['Outdoor']['Pool']['Private']['Adults'] = $advertdetail['ldc_private_pool'];
        $detail['Outdoor']['Pool']['Private']['Kids'] = $advertdetail['ldc_private_child_pool'];
        $detail['Outdoor']['Pool']['Shared']['Adults'] = $advertdetail['ldc_shared_pool'];
        $detail['Outdoor']['Pool']['Shared']['Kids'] = $advertdetail['ldc_shared_child_pool'];
        $detail['Indoor']['Pool']['Private']['Kids'] = 0;
        $detail['Indoor']['Pool']['Private']['Adults'] = $advertdetail['ldc_private_indoor_pool'];
        $detail['Indoor']['Pool']['Shared']['Adults'] = $advertdetail['ldc_shared_indoor_pool'];
        $detail['Indoor']['Pool']['Shared']['Kids'] = 0;



        $pics = array();
        foreach ($advertdetail['ldc_advert_picture'] as $value) {
            $pic = $this->AdvertCopy->propertiesToArray($value);
            $key = explode('.', $pic['name']);
            $key = $key[0];
            $isMain = 0;
            if ($pic['order'] == 0)
                $isMain = 1;
            $pics[$key]['name'] = $pic['name'];
            $pics[$key]['isMain'] = $isMain;
            $pics[$key]['label'] = '';
        }

        if (!isset($advertdetail['ldc_advert_min_stay']))
            $advertdetail['ldc_advert_min_stay'] = 0;

        if ($advertdetail['ldc_advert_min_stay'] > 9)
            $cek = ';s:2:"' . $advertdetail['ldc_advert_min_stay'] . '";}}';
        else
            $cek = ';s:1:"' . $advertdetail['ldc_advert_min_stay'] . '";}}';

        if (!isset($advertdetail['ldc_advert_cancelation_terms']))
            $advertdetail['ldc_advert_cancelation_terms'] = 1;

        switch ($advertdetail['ldc_advert_cancelation_terms']) {
            case 1 || '1=>Esnek':
                $conditions = 'a:3:{s:22:"cancellationPolicyType";s:8:"flexible";s:14:"checkInOutTime";a:2:{s:2:"In";s:2:"14";s:3:"Out";s:2:"11";}s:12:"rentalPeriod";a:1:{s:3:"Min"' . $cek;
                break;
            case 2 || '2=>Yarı esnek':
                $conditions = 'a:3:{s:22:"cancellationPolicyType";s:13:"semi-flexible";s:14:"checkInOutTime";a:2:{s:2:"In";s:2:"14";s:3:"Out";s:2:"11";}s:12:"rentalPeriod";a:1:{s:3:"Min"' . $cek;
                break;
            case 3 || '3=>Sıkı':
                $conditions = 'a:3:{s:22:"cancellationPolicyType";s:9:"stringent";s:14:"checkInOutTime";a:2:{s:2:"In";s:2:"14";s:3:"Out";s:2:"11";}s:12:"rentalPeriod";a:1:{s:3:"Min"' . $cek;
                break;
            default:
                $conditions = 'a:3:{s:22:"cancellationPolicyType";s:8:"flexible";s:14:"checkInOutTime";a:2:{s:2:"In";s:2:"14";s:3:"Out";s:2:"11";}s:12:"rentalPeriod";a:1:{s:3:"Min"' . $cek;
                break;
        }


        if ($advert['advert_class_id'] == 7 || $advert['advert_class_id'] == 2)
            $class = 1;
        else
            $class = 2;



        if ($advert['advert_class_id'] == 1 || $advert['advert_class_id'] == 2 || $advert['advert_class_id'] == 3) {
            $save['demand'] = $advertdetail['ldc_advert_householder_price'];
            $save['weekend_demand'] = 0;
            $this->loadModel('ExceptionRate');
            $exceptionRate = array();
            if (isset($advertdetail['ldc_advert_may_householder_price'])) {
                $a = array();
                $a['advert_id'] = $advert['advert_id'];
                $a['start_date'] = '2013-05-01';
                $a['end_date'] = '2013-05-31';
                $a['demand'] = $advertdetail['ldc_advert_may_householder_price'];
                $a['created_user_s_id'] = 140;
                $a['modified_user_s_id'] = 140;
                $a['exception_text'] = 'Sistemden Atılan';
                $exceptionRate[] = $a;
            }
            if (isset($advertdetail['ldc_advert_june_householder_price'])) {
                $a = array();
                $a['advert_id'] = $advert['advert_id'];
                $a['start_date'] = '2013-06-01';
                $a['end_date'] = '2013-06-30';
                $a['demand'] = $advertdetail['ldc_advert_june_householder_price'];
                $a['created_user_s_id'] = 140;
                $a['modified_user_s_id'] = 140;
                $a['exception_text'] = 'Sistemden Atılan';
                $exceptionRate[] = $a;
            }
            if (isset($advertdetail['ldc_advert_july_householder_price'])) {
                $a = array();
                $a['advert_id'] = $advert['advert_id'];
                $a['start_date'] = '2013-07-01';
                $a['end_date'] = '2013-07-31';
                $a['demand'] = $advertdetail['ldc_advert_july_householder_price'];
                $a['created_user_s_id'] = 140;
                $a['modified_user_s_id'] = 140;
                $a['exception_text'] = 'Sistemden Atılan';
                $exceptionRate[] = $a;
            }
            if (isset($advertdetail['ldc_advert_august_householder_price'])) {
                $a = array();
                $a['advert_id'] = $advert['advert_id'];
                $a['start_date'] = '2013-08-01';
                $a['end_date'] = '2013-08-31';
                $a['demand'] = $advertdetail['ldc_advert_august_householder_price'];
                $a['created_user_s_id'] = 140;
                $a['modified_user_s_id'] = 140;
                $a['exception_text'] = 'Sistemden Atılan';
                $exceptionRate[] = $a;
            }
            if (isset($advertdetail['ldc_advert_september_householder_price'])) {
                $a = array();
                $a['advert_id'] = $advert['advert_id'];
                $a['start_date'] = '2013-09-01';
                $a['end_date'] = '2013-09-30';
                $a['demand'] = $advertdetail['ldc_advert_september_householder_price'];
                $a['created_user_s_id'] = 140;
                $a['modified_user_s_id'] = 140;
                $a['exception_text'] = 'Sistemden Atılan';
                $exceptionRate[] = $a;
            }
            $this->ExceptionRate->deleteAll(array('advert_id = ' . $advert['advert_id']));
            $this->ExceptionRate->saveAll($exceptionRate);
            pr($exceptionRate);
        } else {
            $save['weekend_demand'] = $advertdetail['ldc_advert_weekend_householder_price'];
            if (isset($advertdetail['ldc_advert_workday_householder_price']))
                $save['demand'] = $advertdetail['ldc_advert_workday_householder_price'];
            else
                $save['demand'] = $advertdetail['ldc_advert_householder_price'];
        }



        $this->loadModel('Advertisement');
        $save['advert_id'] = $advert['advert_id'];
        $save['advert_class_id'] = $class;
        $save['status'] = $advert['status'];


        if ($advert['show_in_homepage'])
            $save['show_in_homepage'] = TRUE;
        else
            $save['show_in_homepage'] = FALSE;

        $save['on_top_date'] = $advert['on_top_date'];

        if (!isset($advertdetail['ldc_advert_max_guest_count']))
            $advertdetail['ldc_advert_max_guest_count'] = 3;

        $save['max_guests'] = $advertdetail['ldc_advert_max_guest_count'];

        $save['guests_included_in_the_demand'] = $advertdetail['ldc_advert_max_guest_count'];
        $save['extra_charge_per_guest'] = 0;

        if (!isset($advertdetail['ldc_advert_min_stay']))
            $advertdetail['ldc_advert_min_stay'] = 1;

        $save['min_stay'] = $advertdetail['ldc_advert_min_stay'];
        $save['householder_s_id'] = $advertdetail['ldc_advert_householder_user_id'];
        $save['deposit_damage'] = $advertdetail['ldc_advert_deposit'];
        $save['cleaning_price'] = 0;
        $save['weekly_discount_rate'] = 0;
        $save['monthly_discount_rate'] = 0;
        $save['rate'] = 0;
        $save['currency_id'] = $advertdetail['ldc_advert_currency_unit'];
        $save['country_id'] = 1;
        $save['city_id'] = $advertdetail['ldc_advert_city'];
        $save['county_id'] = $advertdetail['ldc_advert_county'];
        $save['neighborhood_id'] = $advertdetail['ldc_advert_neighborhood'];
        $save['district_id'] = $advertdetail['ldc_advert_district'];
        $save['subDistrict_text'] = '';
        $save['address'] = $advertdetail['ldc_advert_address'];
        $save['postCode'] = '';
        $save['geoLocation'] = $advertdetail['ldc_advert_coordinate'];
        $save['phoneNumber'] = '';
        $save['created'] = $advertdetail['ldc_advert_add_date'];
        $save['modified'] = $advertdetail['ldc_advert_add_date'];
        $save['visibility'] = 'show';


        $save['picture'] = serialize($pics);
        $save['conditions'] = $conditions;
        $save['details'] = serialize($detail);


        $this->loadModel('AdvertsText');

        $addText = array();
        $addText['advert_id'] = $advert['advert_id'];
        $addText['Alanguage_id'] = 1;
        $addText['title'] = $advertdetail['ldc_advert_title'];
        $addText['description'] = $advertdetail['ldc_advert_description'];
        pr($addText);
        pr($save);
        $this->AdvertsText->deleteAll(array('advert_id = ' . $advert['advert_id']));
        $this->AdvertsText->save($addText);
        $this->Advertisement->save($save);
        if (isset($advertId))
            die;
    }

}

