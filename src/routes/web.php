<?php

require_once '/var/www/html/sites/all/modules/civicrm/civicrm.config.php';
require_once 'CRM/Core/Config.php';
CRM_Core_Config::singleton();



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/activities', function () use ($router) {

    $type = 'Activity';
    $result = civicrm_api3($type, 'get', ['sequential' => 1]);
    foreach($result['values'] as $fields){
        $document['data'][] = civi2jsonapi($fields, $type);
    }
    return response()->json($document, 200, [], JSON_PRETTY_PRINT);

});

$router->get('/activities/{id}', function ($id) use ($router) {

    try{
        $result = civicrm_api3('Activity', 'getsingle', ['id' => $id]);

        $document['data'] = civi2jsonapi($result, 'Activity');

        return response()->json($document, 200, [], JSON_PRETTY_PRINT);

    }catch(\Exception $e){
        // TODO: Should probably not assume all errors are 404
        return response()->json(['errors' => $e->getMessage()], 404, [], JSON_PRETTY_PRINT);

    }

});

function civi2jsonapi($fields, $type){
    $object['id'] = $fields['id'];
    unset($fields['id']);
    $object['type'] = $type;
    $object['attributes'] = $fields;
    return $object;

}
