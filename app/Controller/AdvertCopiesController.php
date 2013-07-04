<?php

class AdvertCopiesController extends AppController {

    public $helpers = array('Html', 'Form');
    public $name = 'AdvertCopies';

    public function index($advertId = NULL) {
        Configure::write('debug', 0);
        if (isset($advertId))
            $advert = $this->AdvertCopy->getNextAdvert($advertId);
        else
            $advert = $this->AdvertCopy->getNextAdvert();

        $advertdetail = $this->AdvertCopy->getOldAdvertDetails($advert['advert_id']);
        pr($advertdetail);
        $detail = array();
        $detail['bed_properties']['Interrior.bed.1person'] = $advertdetail['ldc_advert_single_bed'];
        $detail['bed_properties']['Interrior.bed.2people'] = $advertdetail['ldc_advert_double_bed'];
        $detail['bed_properties']['Interrior.sofabed.1person'] = $advertdetail['ldc_advert_sofa_bed'];
        $detail['FieldOptions']['Interrior.FieldOptions.roomCount'] = $advertdetail['ldc_advert_private_room_count'];
        $detail['FieldOptions']['Interrior.FieldOptions.livingRoomCount'] = $advertdetail['ldc_advert_shared_room_count'];
        $detail['FieldOptions']['Interrior.FieldOptions.bathRoomCount'] = $advertdetail['ldc_advert_bathroom_count'];
        $detail['FieldOptions']['Interrior.FieldOptions.areaSquareMeters'] = $advertdetail['ldc_advert_interior_area'];
        $detail['FieldOptions']['Interrior.FieldOptions.floorType'] = $advertdetail['ldc_advert_floor'];

        $detail['tech_properties']['Interrior.Tech.TV'] = $advertdetail['ldc_lcd_tv'];
        $detail['tech_properties']['Interrior.Tech.DVDPlayer'] = $advertdetail['ldc_dvd_player'];
        $detail['tech_properties']['Interrior.Tech.Satelite'] = $advertdetail['interrior_tech_satelite'];
        $detail['tech_properties']['Interrior.Tech.CableTV'] = 0;
        $detail['tech_properties']['Interrior.Tech.PrivateChannels'] = 0;
        $detail['tech_properties']['Interrior.Tech.Internet'] = $advertdetail['ldc_internet'];
        $detail['tech_properties']['Interrior.Tech.BurglarAlarm'] = $advertdetail['ldc_burglar_alarm'];
        $detail['tech_properties']['Interrior.Tech.FireAlarm'] = $advertdetail['ldc_fire_alarm'];

        $detail['kitchen_properties']['Interrior.Kitchen.Refrigerator'] = $advertdetail['ldc_refrigerator'];
        $detail['kitchen_properties']['Interrior.Kitchen.Oven'] = $advertdetail['ldc_oven'];
        $detail['kitchen_properties']['Interrior.Kitchen.MicroWave'] = 0;
        $detail['kitchen_properties']['Interrior.Kitchen.Cooker'] = $advertdetail['ldc_furnace'];
        $detail['kitchen_properties']['Interrior.Kitchen.Exhauster'] = 0;
        $detail['kitchen_properties']['Interrior.Kitchen.CoffeMachine'] = 0;
        $detail['kitchen_properties']['Interrior.Kitchen.Kettle'] = $advertdetail['ldc_water_heater'];
        $detail['kitchen_properties']['Interrior.Kitchen.TeaMachine'] = 0;
        $detail['kitchen_properties']['Interrior.Kitchen.TostMachine'] = 0;
        $detail['kitchen_properties']['Interrior.Kitchen.Dishwasher'] = $advertdetail['ldc_dish_washer'];
        $detail['kitchen_properties']['Interrior.Kitchen.OtherKitchenEquipements'] = $advertdetail['ldc_fully_equipped_kitchen'];

        $detail['heating_and_cooling']['Interrior.HeatingAndCooling.AC'] = $advertdetail['ldc_air_conditioning'];
        $detail['heating_and_cooling']['Interrior.HeatingAndCooling.FirePlace'] = $advertdetail['ldc_fireplace'];
        $detail['heating_and_cooling']['Interrior.HeatingAndCooling.Radiator'] = 0;

        $detail['water_heating_properties']['Interrior.WaterHeating.WaterHeater'] = 0;
        $detail['water_heating_properties']['Interrior.WaterHeating.SolarHeater'] = 0;


        $detail['structure_properties']['Common.Building.Property.SteelDoor'] = $advertdetail['ldc_steel_door'];
        $detail['structure_properties']['Common.Building.Property.InsulatedWindows'] = $advertdetail['ldc_insulating_glass'];
        $detail['structure_properties']['Common.Building.Property.VillaInASite'] = $advertdetail['ldc_housing_complex'];
        $detail['structure_properties']['Common.Building.Property.PrivateGarden'] = $advertdetail['ldc_private_garden'];
        $detail['structure_properties']['Common.Building.Property.SharedGarden'] = $advertdetail['ldc_shared_garden'];
        $detail['structure_properties']['Common.Building.Property.Balcony'] = $advertdetail['ldc_balcony'];
        $detail['structure_properties']['Common.Building.Property.Terrace'] = 0;
        $detail['structure_properties']['Common.Building.Property.Lift'] = $advertdetail['ldc_elevator'];
        $detail['structure_properties']['Common.Building.Property.ElectricalGenerator'] = $advertdetail['ldc_generator'];
        $detail['structure_properties']['Common.Building.Type.SelfContainedVilla'] = $advertdetail['ldc_detached'];
        $detail['structure_properties']['Common.Building.Type.DublexVilla'] = 0;
        $detail['structure_properties']['Common.Building.Type.TriplexVilla'] = 0;
        $detail['structure_properties']['Exterrior.Tech.SecurityCam'] = 0;

        $detail['social_fields_and_properties']['Exterrior.SocialAreasAndFacilities.SecurityPersonel'] = $advertdetail['ldc_security'];
        $detail['social_fields_and_properties']['Exterrior.SocialAreasAndFacilities.CarParkIndoor'] = $advertdetail['ldc_parking_indoor'];
        $detail['social_fields_and_properties']['Exterrior.SocialAreasAndFacilities.CarParkOutdoor'] = $advertdetail['ldc_parking_outdoor'];
        $detail['social_fields_and_properties']['Exterrior.SocialAreasAndFacilities.Playpen'] = $advertdetail['ldc_playpen'];
        $detail['social_fields_and_properties']['Exterrior.SocialAreasAndFacilities.HikingTrail'] = $advertdetail['ldc_hiking_trail'];
        $detail['social_fields_and_properties']['Exterrior.SocialAreasAndFacilities.AquaPark'] = 0;



        $detail['household_appliances']['Interrior.HouseHoldApplicances.WashingMachine'] = $advertdetail['ldc_washing_machine'];
        $detail['household_appliances']['Interrior.HouseHoldApplicances.Dryer'] = 0;
        $detail['household_appliances']['Interrior.HouseHoldApplicances.Iron'] = 0;
        $detail['household_appliances']['Interrior.HouseHoldApplicances.HairDrier'] = 0;
        $detail['household_appliances']['Interrior.HouseHoldApplicances.Hoover'] = 0;
        $detail['household_appliances']['Interrior.HouseHoldApplicances.HandHoover'] = 0;

        $detail['sport_health_and_self_care_options']['Interrior.HealthAndSelfCare.Private.Sauna'] = 0;
        $detail['sport_health_and_self_care_options']['Interrior.Bath.Private.TurkishBath'] = 0;
        $detail['sport_health_and_self_care_options']['Interrior.Sport.Private.GYM'] = 0;
        $detail['sport_health_and_self_care_options']['Common.HealthAndSelfCare.Shared.Sauna'] = 0;
        $detail['sport_health_and_self_care_options']['Common.Bath.Shared.TurkishBath'] = 0;
        $detail['sport_health_and_self_care_options']['Common.Sport.Shared.GYM'] = 0;
        $detail['sport_health_and_self_care_options']['Interrior.Bath.EnSuiteBathroom'] = 0;
        $detail['sport_health_and_self_care_options']['Interrior.Bath.Jacuzzi'] = $advertdetail['ldc_jacuzzi'];
        $detail['sport_health_and_self_care_options']['Interrior.Bath.Bath'] = 0;
        $detail['sport_health_and_self_care_options']['Interrior.Bath.WalkinShower'] = 0;





        $detail['landscape_properties']['Common.Landscape.City'] = $advertdetail['ldc_city_breaks'];
        $detail['landscape_properties']['Common.Landscape.Mountain'] = $advertdetail['ldc_landspace_mount'];
        $detail['landscape_properties']['Common.Landscape.Pool'] = 0;
        $detail['landscape_properties']['Common.Landscape.Nature'] = $advertdetail['ldc_landspace_mount'];
        $detail['landscape_properties']['Common.Landscape.Sea'] = $advertdetail['ldc_landspace_sea'];
        $detail['landscape_properties']['Common.Landscape.Garden'] = 0;
        $detail['landscape_properties']['Common.Landscape.Beach_Range'] = '';


        $detail['pool_properties']['Outdoor.Pool.Private.Adults'] = $advertdetail['ldc_private_pool'];
        $detail['pool_properties']['Outdoor.Pool.Private.Kids'] = $advertdetail['ldc_private_child_pool'];
        $detail['pool_properties']['Indoor.Pool.Private.Adults'] = $advertdetail['ldc_private_indoor_pool'];
        $detail['pool_properties']['Indoor.Pool.Private.Kids'] = 0;
        $detail['pool_properties']['Outdoor.Pool.Shared.Adults'] = $advertdetail['ldc_shared_pool'];
        $detail['pool_properties']['Outdoor.Pool.Shared.Kids'] = $advertdetail['ldc_shared_child_pool'];
        $detail['pool_properties']['Indoor.Pool.Shared.Adults'] = $advertdetail['ldc_shared_indoor_pool'];
        $detail['pool_properties']['Indoor.Pool.Shared.Kids'] = 0;



        $detail['extra_fees']['Common.Fees.ExtraFees.Electric'] = 0;
        $detail['extra_fees']['Common.Fees.ExtraFees.Gas'] = 0;
        $detail['extra_fees']['Common.Fees.ExtraFees.Water'] = 0;
        $detail['extra_fees']['Common.Fees.ExtraFees.Cleaning'] = 0;
        $detail['extra_fees']['Common.Fees.ExtraFees.DamageDeposit'] = 0;
        $detail['extra_fees']['Common.Fees.ExtraFees.BottledGas'] = 0;

        $detail['other_options']['Common.OtherOptions.PetFriendly'] = 0;
        $detail['other_options']['Common.OtherOptions.SmokingFree'] = 0;




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



        if (!isset($advertdetail['ldc_advert_cancelation_terms']))
            $advertdetail['ldc_advert_cancelation_terms'] = 1;

        switch ($advertdetail['ldc_advert_cancelation_terms']) {
            case 1 || '1=>Esnek':
                $conditions = 'a:2:{s:22:"cancellationPolicyType";s:8:"flexible";s:14:"checkInOutTime";a:2:{s:2:"In";s:2:"14";s:3:"Out";s:2:"11";}}';
                break;
            case 2 || '2=>Yarı esnek':
                $conditions = 'a:2:{s:22:"cancellationPolicyType";s:13:"semi-flexible";s:14:"checkInOutTime";a:2:{s:2:"In";s:2:"14";s:3:"Out";s:2:"11";}}';
                break;
            case 3 || '3=>Sıkı':
                $conditions = 'a:2:{s:22:"cancellationPolicyType";s:9:"stringent";s:14:"checkInOutTime";a:2:{s:2:"In";s:2:"14";s:3:"Out";s:2:"11";}}';
                break;
            default:
                $conditions = 'a:2:{s:22:"cancellationPolicyType";s:8:"flexible";s:14:"checkInOutTime";a:2:{s:2:"In";s:2:"14";s:3:"Out";s:2:"11";}}';
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

        if (!isset($advertdetail['ldc_advert_min_stay']) || $advertdetail['ldc_advert_min_stay'] == '' || $advertdetail['ldc_advert_min_stay'] < 1)
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
        $addText['description'] = str_replace('&nbsp;', ' ', strip_tags($advertdetail['ldc_advert_description'], '<br>'));
        pr($addText);
        pr($save);
        print_r($addText);
        $this->AdvertsText->deleteAll(array('advert_id = ' . $advert['advert_id']));
        $this->AdvertsText->save($addText);
        $this->Advertisement->save($save);
        if (isset($advertId))
            die;
    }

}

