<?php
require_once 'database.php';

//---------------------------------------------------------------------------------------------------------
function city_name( $city_id ){
    return get_value('City', $city_id, 'Name');
}

function town_name( $town_id ){
    return get_value('Town', $town_id, 'Name');
}

function school_name( $school_id ){
    return get_value('School', $school_id, 'Name');
}
//---------------------------------------------------------------------------------------------------------
function get_city( $city_id ){
    return get_details('City', $city_id);
}

function get_town( $town_id ){
    $TownInfo = get_details('Town', $town_id);
    if( is_array($TownInfo) && count($TownInfo) > 0 ){
        $CityInfo = get_city($TownInfo['CityID']);
        if( is_array($CityInfo) && count($CityInfo) > 0 ){
            $TownInfo['CityName'] = $CityInfo['Name'];
            $TownInfo['CoverUrl'] = $CityInfo['CoverUrl'];
            $TownInfo['ThumbnailUrl'] = $CityInfo['ThumbnailUrl'];
        }
    }
    return $TownInfo;
}

function get_school( $school_id ){
    $SchoolInfo = get_details('School', $school_id);
    if( is_array($SchoolInfo) && count($SchoolInfo) > 0 ){
        $TownInfo = get_town($SchoolInfo['TownID']);
        if( is_array($TownInfo) && count($TownInfo) > 0 ){
            $SchoolInfo['TownName'] = $TownInfo['Name'];
            $SchoolInfo['CityName'] = $TownInfo['CityName'];
            $SchoolInfo['CoverUrl'] = $TownInfo['CoverUrl'];
            $SchoolInfo['ThumbnailUrl'] = $TownInfo['ThumbnailUrl'];
        }
    }
    return $SchoolInfo;
}
//---------------------------------------------------------------------------------------------------------
function list_cities(){
    return get_list('City');
}

function list_towns( $city_id ){
    return get_list('Town', "CityID={$city_id}");
}

function list_schools( $town_id ){
    return get_list('School', "TownID={$town_id}");
}
//---------------------------------------------------------------------------------------------------------