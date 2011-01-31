<?php
/**
 * Static Web.
 *
 * @copyright    Copyright (c) 2010 Jan Tvrdík
 * @license      MIT
 * @package      StaticWeb
 */

namespace StaticWeb;

use Nette;
use Nette\Debug;
use Nette\Environment as Env;
use Nette\Web\Html;



// Load libraries
require LIBS_DIR . '/Nette/loader.php';
require APP_DIR . '/routers/StaticRouter.php';
require APP_DIR . '/classes/TemplateLocator.php';
require APP_DIR . '/classes/PresenterLoader.php';

// Enable and setup Nette\Debug
Debug::enable();
Debug::$strictMode = !Debug::$productionMode;

// Configure environment
date_default_timezone_set('Europe/Prague');
Html::$xhtml = FALSE;
Env::getContext()->addService('TemplateLocator', 'StaticWeb\TemplateLocator');
Env::getContext()->addService('Nette\\Application\\IPresenterLoader', function () {
	return new PresenterLoader(Env::getVariable('appDir'));
});

// Configure application
$application = Env::getApplication();
$application->errorPresenter = 'Error';
$application->catchExceptions = Debug::$productionMode;
$application->setRouter(new StaticRouter('StaticPage', 'homepage', 'default'));

// Run the application!
$application->run();
