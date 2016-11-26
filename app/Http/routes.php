<?php

/**
 * Register a resource with the application.
 *
 * @param  string $uri
 * @param  mixed $controller
 */
function resource($uri, $controller, $keyName = 'id') {
    global $app;

    $app->get($uri, $controller . '@index');
    $app->get($uri . '/{' . $keyName . '}', $controller . '@show');
    $app->post($uri, $controller . '@store');
    $app->put($uri . '/{' . $keyName . '}', $controller . '@update');
    $app->delete($uri . '/{' . $keyName . '}', $controller . '@destroy');
}

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

$app->get('/', function () use ($app) {
    return "Welcome to Meyito Backend :3";
});

$app->get('/key', function () {
    return str_random(32);
});

$app->group([
    'middleware' => 'preflight',
    'prefix' => 'api/v1'], 
    function () use ($app) {
        $app->post('authenticate', 'AuthenticationController@authenticate');
        $app->get('/test', function () use ($app) {
            return "Welcome to Meyito Backend  :c :3";
        });
});

$app->group([
    'prefix' => 'api/v1',
    'middleware' => [
        'preflight',
        //'jwt-auth'
    ],
],
    function () use ($app) {
        $app->get("development-plans", "DevelopmentPlanController@index");
        $app->get("axes", "AxeController@index");
        $app->post("plan/upload", "DevelopmentPlanController@uploadPlan");
        $app->post("projects/upload", "ProjectController@uploadProjects");
        $app->post("municipalities/upload", "MunicipalityController@uploadTerritories");
        $app->post("areas/upload", "AreaController@uploadAreas");
        $app->post("administrative-units/upload", "AdministrativeUnitController@uploadUnits");
        $app->post("activities/upload", "ActivityController@uploadActivity");
        $app->get("identification-types", "IdentificationTypeController@index");
        $app->post('contractors/{id}/contracts', "ContractorController@addContract");
        resource("dimentions", "DimentionController");
        resource('people', 'PersonController');
        resource('secretaries', 'SecretaryController');
        resource('ethnic-groups', 'EthnicGroupController');
        resource('genders', 'GenderController');
        resource('age-range', 'AgeRangeController');
        resource('special-conditions', 'SpecialConditionController');
        resource('visual-impairments', 'VisualImpairmentController');
        resource('hearing-impairments', 'HearingImpairmentController');
        resource('users', 'UserController');
        resource('motor-disabilities', 'MotorDisabilityController');
        resource('victim-types', 'VictimTypeController');
        resource('contractors', 'ContractorController');
        resource('contracts', 'ContractController');
        resource('zones', 'ZoneController');
        resource('administrative-unit-types', 'AdministrativeUnitTypeController');
        resource('programs', 'ProgramController');
        resource('subprograms', 'SubprogramController');
        resource('goals', 'GoalController');
        resource('projects', 'ProjectController');
        resource('sisben-zones', 'SisbenZoneController');
        resource('area-types', 'AreaTypeController');
        resource('municipalities', 'MunicipalityController');
        resource('areas', 'AreaController');
        resource('administrative-units', 'AdministrativeUnitController');
        resource('activities', 'ActivityController');
        resource('departments', 'DepartmentController');
        resource('characterizations', 'CharacterizationController');
        
    });