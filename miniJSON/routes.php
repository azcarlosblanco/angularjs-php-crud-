<?php
/**
 * miniJSON
 * - a very super simple, basic json php framework.
 *
 * Routes
 */

// Token authentication
$routes[] = array('uri' => '/token/get', 'call' => 'get@token', 'requires_token' => false);
$routes[] = array('uri' => '/token/destroy', 'call' => 'destroy@token', 'requires_token' => true);

// Users
$routes[] = array('uri' => '/users/get', 'call' => 'get@users', 'requires_token' => true);
$routes[] = array('uri' => '/users/put', 'call' => 'put@users', 'requires_token' => false);

// Tasks
$routes[] = array('uri' => '/tasks/getall', 'call' => 'get@tasks', 'requires_token' => false);
$routes[] = array('uri' => '/tasks/get/*', 'call' => 'get@tasks', 'requires_token' => true);
$routes[] = array('uri' => '/tasks/get', 'call' => 'get@tasks', 'requires_token' => true);
$routes[] = array('uri' => '/tasks/put', 'call' => 'put@tasks', 'requires_token' => true);
$routes[] = array('uri' => '/tasks/delete', 'call' => 'delete@tasks', 'requires_token' => true);
$routes[] = array('uri' => '/tasks/update', 'call' => 'update@tasks', 'requires_token' => true);

$routes[] = array('uri' => '/persons/get', 'call' => 'get@persons', 'requires_token' => true);
$routes[] = array('uri' => '/persons/get/*', 'call' => 'get@persons', 'requires_token' => true);
$routes[] = array('uri' => '/persons/put', 'call' => 'put@persons', 'requires_token' => true);
$routes[] = array('uri' => '/persons/delete', 'call' => 'delete@persons', 'requires_token' => true);
$routes[] = array('uri' => '/persons/update', 'call' => 'update@persons', 'requires_token' => true);


// Liteman
$routes[] = array('uri' => '/liteman/tables', 'call' => 'tables@liteman', 'requires_token' => true);
$routes[] = array('uri' => '/liteman/pragma/*', 'call' => 'pragma@liteman', 'requires_token' => true);
$routes[] = array('uri' => '/liteman/records/*', 'call' => 'records@liteman', 'requires_token' => true);
$routes[] = array('uri' => '/liteman/pk/*', 'call' => 'pk@liteman', 'requires_token' => true);
$routes[] = array('uri' => '/liteman/update', 'call' => 'update@liteman', 'requires_token' => true);
$routes[] = array('uri' => '/liteman/delete', 'call' => 'delete@liteman', 'requires_token' => true);

// Standard form
$routes[] = array('uri' => '/schemaform/schema/*', 'call' => 'schema@schemaform', 'requires_token' => true);
$routes[] = array('uri' => '/schemaform/form/*', 'call' => 'form@schemaform', 'requires_token' => true);
$routes[] = array('uri' => '/schemaform/data', 'call' => 'data@schemaform', 'requires_token' => true);
