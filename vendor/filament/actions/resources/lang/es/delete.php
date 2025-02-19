<?php

return [

    'single' => [

        'label' => 'Borrar',

        'modal' => [

            'heading' => 'Borrar Usuario',

            'actions' => [

                'delete' => [
                    'label' => 'Borrar',
                ],

            ],

        ],

        'notifications' => [

            'deleted' => [
                'title' => 'Usuario Borrado Exitosamente!',
            ],

        ],

    ],

    'multiple' => [

        'label' => 'Borrar seleccionados',

        'modal' => [

            'heading' => 'Borrar :label seleccionados',

            'actions' => [

                'delete' => [
                    'label' => 'Borrar',
                ],

            ],

        ],

        'notifications' => [

            'deleted' => [
                'title' => 'Borrados',
            ],

        ],

    ],

];
