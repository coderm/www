<?php
class Dummy extends AppModel
{
    public $name = 'Dummy';
    public $useTable = false;
    
    
    
    
/*
    
    public function getMyPlacesOverviewData($advertId)
    {
	$result = array();
	$result['Search']['advert_id'] = 1987;
	$result['Search']['title'] = 'Başlık';
	$result['Search']['description'] = 'Açıklama';
	$result['Search']['price'] = 100;
	$result['Search']['advert_status'] = 'active';
	$result['Search']['advert_class'] = 'lac_summer_villa';
	$result['Search']['advert_class_message_text_id'] = 'lac_summer_villa'; 
	
	$result['Search']['city'] = 'İstanbul';
	$result['Search']['county'] = 'Kadıköy';
	$result['Search']['neighborhood'] = 'Osmanağa'; 
	$result['Search']['district'] = 'Osmanağa Mh';
	
	$result['Search']['private_room_count'] = 1;
	$result['Search']['shared_room_count'] = 1;
	$result['Search']['max_guest_count'] = 1;
	$result['Search']['currency_unit'] = 'TR';
	$result['Search']['picture'] =  'name=>5011744a0dfd8.jpg[|]order=>0';
	return $result;
    }
    
    public function getMyPlacesBasicsData($advertId)
    {
	$result = array();
	$result['Advertisement']['title'] = 'başlık';
	$result['Advertisement']['description'] = 'açıklama';
	$result['Advertisement']['type'] = 4;
	$result['Advertisement']['maxGuests'] = 10;
	$result['Advertisement']['demand'] = 100;
	$result['Advertisement']['currency'] = 1;
	$result['Advertisement']['salePrice'] = 115;
	
	
	
	return $result;
    }    
    
    public function getMyPlacesContactData($advertId)
    {
	$result = array();
	$result['Advertisement']['address'] = 'adres';
	$result['Advertisement']['country'] = 1;
	$result['Advertisement']['city'] = 2;
	$result['Advertisement']['district'] = 239;
	$result['Advertisement']['subDistrict'] = 124;
	$result['Advertisement']['subDistrictText'] = '';
	
	$result['Advertisement']['postCode'] = '3400';
	$result['Advertisement']['phoneCountryCode'] = '90';
	$result['Advertisement']['phoneNumber'] = '5067343035';
	$result['Advertisement']['geoLocation'] = 'zoomLevel=>12[|]latitude=>38.03307[|]longitude=>38.23719700000004';
	
	
	return $result;
    }
    
    public function getMyPlacesAdvertDetailsData($advertId)
    {
	
    }
    
    public function getMyPlacesPhotosData($advertId)
    {
	$results = array();
	$results[] = 'name=>5011744a0dfd8.jpg[|]order=>0[|]isMain=>1[|]label=>test';
	$results[] = 'name=>5011744a0dfd8.jpg[|]order=>0[|]isMain=>1[|]label=>test';
	return $results;				
    }
    
    public function getMyPlacesTitle($advertId)
    {
	$result = 'bu ilanın başlığı';
	return $result;
    }
    
    public function getMyPlacesCalendarData($advertId)
    {
	
    }
    */
    
    public function getAdvertProperties($array_mode = false)
    {
	$properties = array();
	
	$properties['tech_properties'][] = 'Advertisement.details.Interrior.Tech.TV';
	$properties['tech_properties'][] = 'Advertisement.details.Interrior.Tech.DVDPlayer';
	$properties['tech_properties'][] = 'Advertisement.details.Interrior.Tech.Satelite';
	$properties['tech_properties'][] = 'Advertisement.details.Interrior.Tech.CableTV';
	$properties['tech_properties'][] = 'Advertisement.details.Interrior.Tech.PrivateChannels';
	$properties['tech_properties'][] = 'Advertisement.details.Interrior.Tech.Internet';
	$properties['tech_properties'][] = 'Advertisement.details.Interrior.Tech.BurglarAlarm';
	$properties['tech_properties'][] = 'Advertisement.details.Interrior.Tech.FireAlarm';
	$properties['kitchen_properties'][] = 'Advertisement.details.Interrior.Kitchen.Refrigerator';
	$properties['kitchen_properties'][] = 'Advertisement.details.Interrior.Kitchen.Oven';
	$properties['kitchen_properties'][] = 'Advertisement.details.Interrior.Kitchen.MicroWave';
	$properties['kitchen_properties'][] = 'Advertisement.details.Interrior.Kitchen.Cooker';
	$properties['kitchen_properties'][] = 'Advertisement.details.Interrior.Kitchen.Exhauster';
	$properties['kitchen_properties'][] = 'Advertisement.details.Interrior.Kitchen.CoffeMachine';
	$properties['kitchen_properties'][] = 'Advertisement.details.Interrior.Kitchen.Kettle';
	$properties['kitchen_properties'][] = 'Advertisement.details.Interrior.Kitchen.TeaMachine';
	$properties['kitchen_properties'][] = 'Advertisement.details.Interrior.Kitchen.TostMachine';
	$properties['kitchen_properties'][] = 'Advertisement.details.Interrior.Kitchen.Dishwasher';
	$properties['kitchen_properties'][] = 'Advertisement.details.Interrior.Kitchen.OtherKitchenEquipements';
	$properties['heating_and_cooling'][] = 'Advertisement.details.Interrior.HeatingAndCooling.AC';
	$properties['heating_and_cooling'][] = 'Advertisement.details.Interrior.HeatingAndCooling.FirePlace';
	$properties['heating_and_cooling'][] = 'Advertisement.details.Interrior.HeatingAndCooling.Radiator';
	$properties['water_heating_properties'][] = 'Advertisement.details.Interrior.WaterHeating.WaterHeater';
	$properties['water_heating_properties'][] = 'Advertisement.details.Interrior.WaterHeating.SolarHeater';
	$properties['structure_properties'][] = 'Advertisement.details.Common.Building.Property.SteelDoor';
	$properties['structure_properties'][] = 'Advertisement.details.Common.Building.Property.InsulatedWindows';
	$properties['structure_properties'][] = 'Advertisement.details.Common.Building.Type.SelfContainedVilla';
	$properties['structure_properties'][] = 'Advertisement.details.Common.Building.Property.VillaInASite';
	$properties['structure_properties'][] = 'Advertisement.details.Common.Building.Type.DublexVilla';
	$properties['structure_properties'][] = 'Advertisement.details.Common.Building.Type.TriplexVilla';
	$properties['structure_properties'][] = 'Advertisement.details.Common.Building.Property.PrivateGarden';
	$properties['structure_properties'][] = 'Advertisement.details.Common.Building.Property.SharedGarden';
	$properties['structure_properties'][] = 'Advertisement.details.Common.Building.Property.Balcony';
	$properties['structure_properties'][] = 'Advertisement.details.Common.Building.Property.Terrace';
	$properties['structure_properties'][] = 'Advertisement.details.Common.Building.Property.Lift';
	$properties['structure_properties'][] = 'Advertisement.details.Common.Building.Property.ElectricalGenerator';
	$properties['structure_properties'][] = 'Advertisement.details.Exterrior.Tech.SecurityCam';
	$properties['social_fields_and_properties'][] = 'Advertisement.details.Exterrior.SocialAreasAndFacilities.SecurityPersonel';
	$properties['social_fields_and_properties'][] = 'Advertisement.details.Exterrior.SocialAreasAndFacilities.CarParkIndoor';
	$properties['social_fields_and_properties'][] = 'Advertisement.details.Exterrior.SocialAreasAndFacilities.CarParkOutdoor';
	$properties['social_fields_and_properties'][] = 'Advertisement.details.Exterrior.SocialAreasAndFacilities.Playpen';
	$properties['social_fields_and_properties'][] = 'Advertisement.details.Exterrior.SocialAreasAndFacilities.HikingTrail';
	$properties['social_fields_and_properties'][] = 'Advertisement.details.Exterrior.SocialAreasAndFacilities.AquaPark';
	$properties['household_appliances'][] = 'Advertisement.details.Interrior.HouseHoldApplicances.WashingMachine';
	$properties['household_appliances'][] = 'Advertisement.details.Interrior.HouseHoldApplicances.Dryer';
	$properties['household_appliances'][] = 'Advertisement.details.Interrior.HouseHoldApplicances.Iron';
	$properties['household_appliances'][] = 'Advertisement.details.Interrior.HouseHoldApplicances.HairDrier';
	$properties['household_appliances'][] = 'Advertisement.details.Interrior.HouseHoldApplicances.Hoover';
	$properties['household_appliances'][] = 'Advertisement.details.Interrior.HouseHoldApplicances.HandHoover';
	$properties['sport_health_and_self_care_options'][] = 'Advertisement.details.Interrior.HealthAndSelfCare.Private.Sauna';
	$properties['sport_health_and_self_care_options'][] = 'Advertisement.details.Interrior.Bath.Private.TurkishBath';
	$properties['sport_health_and_self_care_options'][] = 'Advertisement.details.Interrior.Sport.Private.GYM';
	$properties['sport_health_and_self_care_options'][] = 'Advertisement.details.Common.HealthAndSelfCare.Shared.Sauna';
	$properties['sport_health_and_self_care_options'][] = 'Advertisement.details.Common.Bath.Shared.TurkishBath';
	$properties['sport_health_and_self_care_options'][] = 'Advertisement.details.Common.Sport.Shared.GYM';
	$properties['sport_health_and_self_care_options'][] = 'Advertisement.details.Interrior.Bath.EnSuiteBathroom';
	$properties['sport_health_and_self_care_options'][] = 'Advertisement.details.Interrior.Bath.Jacuzzi';
	$properties['sport_health_and_self_care_options'][] = 'Advertisement.details.Interrior.Bath.Bath';
	$properties['sport_health_and_self_care_options'][] = 'Advertisement.details.Interrior.Bath.WalkinShower';
	$properties['landscape_properties'][] = 'Advertisement.details.Common.Landscape.City';
	$properties['landscape_properties'][] = 'Advertisement.details.Common.Landscape.Mountain';
	$properties['landscape_properties'][] = 'Advertisement.details.Common.Landscape.Pool';
	$properties['landscape_properties'][] = 'Advertisement.details.Common.Landscape.Nature';
	$properties['landscape_properties'][] = 'Advertisement.details.Common.Landscape.Sea';
	$properties['landscape_properties'][] = 'Advertisement.details.Common.Landscape.Garden';
        
	$properties['pool_properties'][] = 'Advertisement.details.Outdoor.Pool.Private.Adults_opp';
	$properties['pool_properties'][] = 'Advertisement.details.Outdoor.Pool.Shared.Adults_ops';
	$properties['pool_properties'][] = 'Advertisement.details.Outdoor.Pool.Private.Kids_opp';
	$properties['pool_properties'][] = 'Advertisement.details.Indoor.Pool.Private.Kids_ipp';
	$properties['pool_properties'][] = 'Advertisement.details.Indoor.Pool.Private.Adults_ipp';
	$properties['pool_properties'][] = 'Advertisement.details.Indoor.Pool.Shared.Adults_ips';
	$properties['pool_properties'][] = 'Advertisement.details.Outdoor.Pool.Shared.Kids_ops';
	$properties['pool_properties'][] = 'Advertisement.details.Indoor.Pool.Shared.Kids_ips';

	$properties['extra_fees'][] = 'Advertisement.details.Common.Fees.ExtraFees.Electric';
	$properties['extra_fees'][] = 'Advertisement.details.Common.Fees.ExtraFees.Gas';
	$properties['extra_fees'][] = 'Advertisement.details.Common.Fees.ExtraFees.Water';
	$properties['extra_fees'][] = 'Advertisement.details.Common.Fees.ExtraFees.Cleaning';
	$properties['extra_fees'][] = 'Advertisement.details.Common.Fees.ExtraFees.DamageDeposit';
	$properties['extra_fees'][] = 'Advertisement.details.Common.Fees.ExtraFees.BottledGas';

	$properties['other_options'][] = 'Advertisement.details.Common.OtherOptions.PetFriendly';
	$properties['other_options'][] = 'Advertisement.details.Common.OtherOptions.SmokingFree';	
	
	
	return $properties;
    }
    
}