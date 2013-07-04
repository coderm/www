<?php

class Fixed extends AppModel {

    public $name = 'Fixed';
    public $useTable = false;

    public function mainBanners() {
        $return['images'] = Array('kredi_imkani.jpg'
            , 'denizlere_indik.jpg'
            , 'otellere_en_iyi_alternatif.jpg'
            , 'butun_aile_tatilde.jpg'
            , '2013_erken_reza_2.jpg'
            , 'turkiyenin_her_yerinde.jpg'
            , 'tabela.jpg'
            , 'istanbul.jpg'
            , 'aquamarine.jpg');
        $return['urls'] = Array("#"
            , "#"
            , "#"
            , "#"
            , "#"
            , "#"
            , "/gunluk-kiraliklar"
            , "/gunluk-kiralik-evler/istanbul"
            , "/gunluk-kiralik-yazliklar/aydin/didim/yenihisar-efeler/ekonomik/1261/aqua-marina-sitesinde-sahane-2-1");
        return $return;
    }

    public function getAdvertProperties() {
        $properties = array();

        $properties['tech_properties'][] = 'Interrior.Tech.TV';
        $properties['tech_properties'][] = 'Interrior.Tech.DVDPlayer';
        $properties['tech_properties'][] = 'Interrior.Tech.Satelite';
        $properties['tech_properties'][] = 'Interrior.Tech.CableTV';
        $properties['tech_properties'][] = 'Interrior.Tech.PrivateChannels';
        $properties['tech_properties'][] = 'Interrior.Tech.Internet';
        $properties['tech_properties'][] = 'Interrior.Tech.BurglarAlarm';
        $properties['tech_properties'][] = 'Interrior.Tech.FireAlarm';
        $properties['kitchen_properties'][] = 'Interrior.Kitchen.Refrigerator';
        $properties['kitchen_properties'][] = 'Interrior.Kitchen.Oven';
        $properties['kitchen_properties'][] = 'Interrior.Kitchen.MicroWave';
        $properties['kitchen_properties'][] = 'Interrior.Kitchen.Cooker';
        $properties['kitchen_properties'][] = 'Interrior.Kitchen.Exhauster';
        $properties['kitchen_properties'][] = 'Interrior.Kitchen.CoffeMachine';
        $properties['kitchen_properties'][] = 'Interrior.Kitchen.Kettle';
        $properties['kitchen_properties'][] = 'Interrior.Kitchen.TeaMachine';
        $properties['kitchen_properties'][] = 'Interrior.Kitchen.TostMachine';
        $properties['kitchen_properties'][] = 'Interrior.Kitchen.Dishwasher';
        $properties['kitchen_properties'][] = 'Interrior.Kitchen.OtherKitchenEquipements';
        $properties['heating_and_cooling'][] = 'Interrior.HeatingAndCooling.AC';
        $properties['heating_and_cooling'][] = 'Interrior.HeatingAndCooling.FirePlace';
        $properties['heating_and_cooling'][] = 'Interrior.HeatingAndCooling.Radiator';
        $properties['water_heating_properties'][] = 'Interrior.WaterHeating.WaterHeater';
        $properties['water_heating_properties'][] = 'Interrior.WaterHeating.SolarHeater';
        $properties['structure_properties'][] = 'Common.Building.Property.SteelDoor';
        $properties['structure_properties'][] = 'Common.Building.Property.InsulatedWindows';
        $properties['structure_properties'][] = 'Common.Building.Type.SelfContainedVilla';
        $properties['structure_properties'][] = 'Common.Building.Property.VillaInASite';
        $properties['structure_properties'][] = 'Common.Building.Type.DublexVilla';
        $properties['structure_properties'][] = 'Common.Building.Type.TriplexVilla';
        $properties['structure_properties'][] = 'Common.Building.Property.PrivateGarden';
        $properties['structure_properties'][] = 'Common.Building.Property.SharedGarden';
        $properties['structure_properties'][] = 'Common.Building.Property.Balcony';
        $properties['structure_properties'][] = 'Common.Building.Property.Terrace';
        $properties['structure_properties'][] = 'Common.Building.Property.Lift';
        $properties['structure_properties'][] = 'Common.Building.Property.ElectricalGenerator';
        $properties['structure_properties'][] = 'Exterrior.Tech.SecurityCam';
        $properties['social_fields_and_properties'][] = 'Exterrior.SocialAreasAndFacilities.SecurityPersonel';
        $properties['social_fields_and_properties'][] = 'Exterrior.SocialAreasAndFacilities.CarParkIndoor';
        $properties['social_fields_and_properties'][] = 'Exterrior.SocialAreasAndFacilities.CarParkOutdoor';
        $properties['social_fields_and_properties'][] = 'Exterrior.SocialAreasAndFacilities.Playpen';
        $properties['social_fields_and_properties'][] = 'Exterrior.SocialAreasAndFacilities.HikingTrail';
        $properties['social_fields_and_properties'][] = 'Exterrior.SocialAreasAndFacilities.AquaPark';
        $properties['household_appliances'][] = 'Interrior.HouseHoldApplicances.WashingMachine';
        $properties['household_appliances'][] = 'Interrior.HouseHoldApplicances.Dryer';
        $properties['household_appliances'][] = 'Interrior.HouseHoldApplicances.Iron';
        $properties['household_appliances'][] = 'Interrior.HouseHoldApplicances.HairDrier';
        $properties['household_appliances'][] = 'Interrior.HouseHoldApplicances.Hoover';
        $properties['household_appliances'][] = 'Interrior.HouseHoldApplicances.HandHoover';
        $properties['sport_health_and_self_care_options'][] = 'Interrior.HealthAndSelfCare.Private.Sauna';
        $properties['sport_health_and_self_care_options'][] = 'Interrior.Bath.Private.TurkishBath';
        $properties['sport_health_and_self_care_options'][] = 'Interrior.Sport.Private.GYM';
        $properties['sport_health_and_self_care_options'][] = 'Common.HealthAndSelfCare.Shared.Sauna';
        $properties['sport_health_and_self_care_options'][] = 'Common.Bath.Shared.TurkishBath';
        $properties['sport_health_and_self_care_options'][] = 'Common.Sport.Shared.GYM';
        $properties['sport_health_and_self_care_options'][] = 'Interrior.Bath.EnSuiteBathroom';
        $properties['sport_health_and_self_care_options'][] = 'Interrior.Bath.Jacuzzi';
        $properties['sport_health_and_self_care_options'][] = 'Interrior.Bath.Bath';
        $properties['sport_health_and_self_care_options'][] = 'Interrior.Bath.WalkinShower';
        $properties['landscape_properties'][] = 'Common.Landscape.City';
        $properties['landscape_properties'][] = 'Common.Landscape.Mountain';
        $properties['landscape_properties'][] = 'Common.Landscape.Pool';
        $properties['landscape_properties'][] = 'Common.Landscape.Nature';
        $properties['landscape_properties'][] = 'Common.Landscape.Sea';
        $properties['landscape_properties'][] = 'Common.Landscape.Garden';

        $properties['pool_properties'][] = 'Outdoor.Pool.Private.Adults';
        $properties['pool_properties'][] = 'Outdoor.Pool.Shared.Adults';
        $properties['pool_properties'][] = 'Outdoor.Pool.Private.Kids';
        $properties['pool_properties'][] = 'Indoor.Pool.Private.Kids';
        $properties['pool_properties'][] = 'Indoor.Pool.Private.Adults';
        $properties['pool_properties'][] = 'Indoor.Pool.Shared.Adults';
        $properties['pool_properties'][] = 'Outdoor.Pool.Shared.Kids';
        $properties['pool_properties'][] = 'Indoor.Pool.Shared.Kids';

        $properties['extra_fees'][] = 'Common.Fees.ExtraFees.Electric';
        $properties['extra_fees'][] = 'Common.Fees.ExtraFees.Gas';
        $properties['extra_fees'][] = 'Common.Fees.ExtraFees.Water';
        $properties['extra_fees'][] = 'Common.Fees.ExtraFees.Cleaning';
        $properties['extra_fees'][] = 'Common.Fees.ExtraFees.DamageDeposit';
        $properties['extra_fees'][] = 'Common.Fees.ExtraFees.BottledGas';

        $properties['other_options'][] = 'Common.OtherOptions.PetFriendly';
        $properties['other_options'][] = 'Common.OtherOptions.SmokingFree';


        return $properties;
    }
      public function popularDestinations() {
          $content['destination'] = 'Antalya';
          $content['url'] = '/gunluk-kiralik/antalya';
          $destinations['tur'][]= $content;
          $content['destination'] = 'Bodrum';
          $content['url'] = '/gunluk-kiralik/mugla/bodrum';
          $destinations['tur'][]= $content;
          $content['destination'] = 'Marmaris';
          $content['url'] = '/gunluk-kiralik/mugla/marmaris';
          $destinations['tur'][]= $content;
          $content['destination'] = 'Didim';
          $content['url'] = '/gunluk-kiralik/aydin/didim';
          $destinations['tur'][]= $content;
          $content['destination'] = 'Kuşadası';
          $content['url'] = '/gunluk-kiralik/aydin/kusadasi';
          $destinations['tur'][]= $content;
          $content['destination'] = 'Fethiye';
          $content['url'] = '/gunluk-kiralik/mugla/fethiye';
          $destinations['tur'][]= $content;
          $content['destination'] = 'Kaş';
          $content['url'] = '/gunluk-kiralik/mugla/kas';
          $destinations['tur'][]= $content;
          $content['destination'] = 'Alanya';
          $content['url'] = '/gunluk-kiralik/antalya/alanya';
          $destinations['tur'][]= $content;
          return $destinations;
      }
    
    

}























