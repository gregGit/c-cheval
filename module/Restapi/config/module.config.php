<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Restapi\Controller\Info' => 'Restapi\Controller\InfoController',
        ),
        'factories' => array(
            'Restapi\Controller\RestapiRepriseController' => 'Restapi\Controller\Factory\RestapiRepriseControllerFactory',
            'Restapi\Controller\RestapiMovementController' => 'Restapi\Controller\Factory\RestapiMovementControllerFactory',
            'Restapi\Controller\RestapiFormController' => 'Restapi\Controller\Factory\RestapiFormControllerFactory',
        ),
    ),
//'router' => array(
//        'routes' => array(
//            'rest' => array(
//                'type' => 'Literal',
//                'options' => array(
//                    'route' => '/rest',
//                    'defaults' => array(
//                        '__NAMESPACE__' => 'Restapi\Controller',
//                        'controller' => 'Info',
//                    ),
//                ),
//                'may_terminate' => true,
//                'child_routes' => array(
//                    'rest-form' => array(
//                        'type' => 'Segment',
//                        'options' => array(
//                            'route' => '/form/:name/*',
//                            'constraints' => array(
//                                'name' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                            ),
//                            'defaults' => array(
//                            'controller' => 'Form',
//                            ),
//                        ),
//                    ),
//                ),
//            ),
//        ),
//    ),    
    'router' => array(
        'routes' => array(
            'rest-reprise' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/rest/reprise',
                    'defaults' => array(
                        'controller' => 'Restapi\Controller\RestapiRepriseController',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'rest-full' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/full[/:id[/:uuid]]',
                            'constraints' => array(
                                'id' => '[0-9]+',
                                'uuid'=> '[0-9a-z\-]+'
                            ),
                        ),
                    ),
                    'submit' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/create[/:reprise_id]',
                            'constraints' => array(
                                'reprise_id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'action' => 'submit',
                            ),
                        ),
                    ),
//                    'delete' => array(
//                        'type' => 'Segment',
//                        'options' => array(
//                            'route' => '/delete[/:id]',
//                            'constraints' => array(
//                                'id' => '[0-9]+',
//                            ),
//                            'defaults' => array(
//                                'action' => 'delete',
//                            ),
//                        ),
//                    ),
                ),
            ),
            'rest-movement' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/rest/movement',
                    'defaults' => array(
                        'controller' => 'Restapi\Controller\RestapiMovementController',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'rest-full' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/full[/:id/:uuid]',
                            'constraints' => array(
                                'id' => '[0-9]+',
                                'uuid'=> '[0-9a-z\-]+'
                            ),
                        ),
                    ),
                    'submit' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/create[/:reprise_id]',
                            'constraints' => array(
                                'reprise_id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'action' => 'submit',
                            ),
                        ),
                    ),
//                    'delete' => array(
//                        'type' => 'Segment',
//                        'options' => array(
//                            'route' => '/delete[/:id]',
//                            'constraints' => array(
//                                'id' => '[0-9]+',
//                            ),
//                            'defaults' => array(
//                                'action' => 'delete',
//                            ),
//                        ),
//                    ),
                ),
            ),
            'rest-form' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/rest/form',
                    'defaults' => array(
                        'controller' => 'Restapi\Controller\RestapiFormController',
                    ),
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'element' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/element[/:mvt_id]',
                            'constraints' => array(
                                'mvt_id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'action' => 'element',
                            ),
                        ),
                    ),
                    'movement' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/movement[/:id/:uuid]',
                            'constraints' => array(
                                'id' => '[0-9]+',
                                'uuid'=> '[0-9a-z\-]+'
                            ),
                            'defaults' => array(
                                'repository' => 'Application\Entity\CcMovement',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'application' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
