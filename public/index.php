<?php

use App\Kernel;


 
require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

ob_start();  //Erreur : Failed to start session because headers have already been sent(route: 'crud/client/new'). Existence d'un output buffering enabled dans la configuration PHP, non employé correctement 

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};

  

      