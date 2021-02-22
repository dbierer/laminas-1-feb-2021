<?php
declare(strict_types=1);
namespace Market;
use Laminas\Router\Http\{Literal,Segment};
use Laminas\ServiceManager\Factory\InvokableFactory;
return [
    'router' => [
        'routes' => [
            'market' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/market',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                // this is a "switch" that allows both parent and child routes to be considered
				'may_terminate' => TRUE,
                // IMPORTANT: 'child_routes' are *after* 'options', at the same level, inside the 'market' array key
				'child_routes' => [
					'json' => [
						'type'    => Segment::class,
						'options' => [
							// add additional params to "route" key if needed
							'route'    => '/json[/:name]',
							'defaults' => [
								'controller' => Controller\IndexController::class,
								'action'     => 'json',
								'name'		 => 'Unknown',
							],
						],
					],
					'panic' => [
						'type'    => Segment::class,
						'options' => [
							// add additional params to "route" key if needed
							'route'    => '/panic[/]',
							'defaults' => [
								'controller' => Controller\IndexController::class,
								'action'     => 'panic',
							],
						],
					],
					'post' => [
						'type'    => Segment::class,
						'options' => [
							// add additional params to "route" key if needed
							'route'    => '/post[/]',
							'defaults' => [
								'controller' => Controller\PostController::class,
								'action'     => 'index',
							],
						],
					],
					'view' => [
						'type'    => Segment::class,
						'options' => [
							// add additional params to "route" key if needed
							'route'    => '/view[/]',
							'defaults' => [
								'controller' => Controller\ViewController::class,
								'action'     => 'index',
							],
						],
					],
				],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\PostController::class => Controller\PostControllerFactory::class,
            Controller\ViewController::class => Controller\ViewControllerFactory::class,
            Controller\IndexController::class => Controller\IndexControllerFactory::class,
            // alternatively: you can just specify a callback like so:
            // however ... it's not recommended to place an anonymous function in a config file
            //Controller\IndexController::class => function ($container) { return new Controller\IndexController(); },
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
		'strategies' => [	
            'ViewJsonStrategy',
        ],
    ],
    'controller_plugins' => [
        'aliases' => [
            'timePlugin' => Controller\Plugin\TimePlugin::class,
        ],
        'factories' => [
            Controller\Plugin\TimePlugin::class => InvokableFactory::class,
        ],

    ],
    'view_helpers' => [
        'aliases' => [
            'leftLinks' => View\Helper\LeftLinksHelper::class,
        ],
        'factories' => [
            View\Helper\LeftLinksHelper::class => InvokableFactory::class,
        ],

    ],
'service_manager' => [
        'factories' => [
            Form\PostFilter::class => Form\PostFilterFactory::class,
            Form\PostForm::class => Form\PostFormFactory::class,
        ],
        'services' => [
            // 'market-post-filter-config' overrides needed:
            // $filtConfig['category']['validators']['options']['haystack'] = $categories
            // $filtConfig['expires']['validators']['options']['haystack'] = $expireDays
            // $filtConfig['cityCode']['validators']['options']['callback'] =
            /*
            function ($val) {
                if (!strpos($val, ',')) return FALSE;
                [$city, $country] = explode(',', $val);
                if ($city === NULL || $country === NULL) return FALSE;
                if (strlen($country) != 2) return FALSE;
                if ($country !== strtoupper($country)) return FALSE;
                return TRUE;
            });
            */

            // 'market-post-form-config' overrides needed:
            // $formConfig['elements']['category']['spec']['options']['value_options'] = $combinedCategories
            // $formConfig['elements']['expires']['spec']['options']['value_options'] = $expireDays
            // $formConfig['elements']['captcha']['spec']['options']['captcha'] = $captchaAdapter
            'market-post-form-config' => [
                'hydrator' => ArraySerializableHydrator::class,
                'attributes' => ['method' => 'post'],
                'elements' => [
                    'category' => [
                        'spec' => [
                            'name' => 'category',
                            'type' => 'select',
                            'options' => [
                                'label' => 'Category',
                                // needs to be overridden by the factory
                                'value_options' => NULL,
                            ],
                            'attributes' => ['title' => 'Please select a category'],
                            'label_attributes' => ['style' => 'display: block'],
                        ],
                    ],
                    'title' => [
                        'spec' => [
                            'name' => 'title',
                            'type' => 'text',
                            'attributes' => ['placeholder' => 'Enter posting title'],
                            'options' => [
                                'label' => 'Title',
								'label_attributes' => ['style' => 'display: block'],
                            ],
                        ],
                    ],
                    'photo_filename' => [
                        'spec' => [
                            'name' => 'photo_filename',
                            'type' => 'text',
                            'attributes' => [
                                'maxlength' => 1024,
                                'placeholder' => 'Enter image URL',
                            ],
                            'options' => [
                                'label' => 'Photo File',
                                'label_attributes' => ['style' => 'display: block'],
                            ],
                        ],
                    ],
                    'price' => [
                        'spec' => [
                            'name' => 'price',
                            'type' => 'text',
                            'attributes' => [
                                'title' => 'Enter price as nnn.nn',
                                'size' => 16,
                                'maxlength' => 16,
                                'placeholder' => 'Enter a value',
                            ],
                            'options' => [
                                'label' => 'Price',
                                'label_attributes' => ['style' => 'display: block'],
                            ],
                        ],
                    ],
                    'expires' => [
                        'spec' => [
                            'name' => 'expires',
                            'type' => 'radio',
                            'attributes' => [
                                'title' => 'The expiration date will be calculated from today',
                                'class' =>  'expiresButton',
                            ],
                            'options' => [
                                'label' => 'Expires',
                                // needs to be overridden by the factory
                                'value_options' => NULL,
                            ],
                        ],
                    ],
                    'cityCode' => [
                        'spec' => [
                            'name' => 'cityCode',
                            'type' => 'text',
                            'attributes' => [
                                'title' => 'Enter as "city,country" using 2 letter ISO code for country',
                                'id' => 'cityCode',
                                'placeholder' => 'City Name,CC',
                            ],
                            'options' => [
                                'label' => 'Nearest City,Country',
                                'label_attributes' => ['style' => 'display: inline'],
                            ],
                        ],
                    ],
                    'contact_name' => [
                        'spec' => [
                            'name' => 'contact_name',
                            'type' => 'text',
                            'attributes' => [
                                'title' => 'Enter the name of the person to contact for this item',
                                'size' => 40,
                                'maxlength' => 255,
                            ],
                            'options' => [
                                'label' => 'Contact Name',
                                'label_attributes' => ['style' => 'display: block'],
                            ],
                        ],
                    ],
                    'contact_phone' => [
                        'spec' => [
                            'name' => 'contact_phone',
                            'type' => 'text',
                            'attributes' => [
                                'title' => 'Enter the phone number of the person to contact for this item',
                                'size' => 20,
                                'maxlength' => 32,
                            ],
                            'options' => [
                                'label' => 'Contact Phone Number',
                                'label_attributes' => ['style' => 'display: block'],
                            ],
                        ],
                    ],
                    'contact_email' => [
                        'spec' => [
                            'name' => 'contact_email',
                            'type' => 'email',
                            'attributes' => [
                                'title' => 'Enter the email address of the person to contact for this item',
                                'size' => 40,
                                'maxlength' => 255,
                            ],
                            'options' => [
                                'label' => 'Contact Email',
                                'label_attributes' => ['style' => 'display: block'],
                            ],
                        ],
                    ],
                    'description' => [
                        'spec' => [
                            'name' => 'description',
                            'type' => 'textarea',
                            'attributes' => [
                                'title' => 'Enter a suitable description for this posting',
                                'rows' => 4,
                                'cols' => 80,
                            ],
                            'options' => [
                                'label' => 'Description',
                            ],
                        ],
                    ],
                    'delete_code' => [
                        'spec' => [
                            'name' => 'delete_code',
                            'type' => 'text',
                            'attributes' => [
                                'title' => 'Enter the delete code for this item',
                                'size' => 16,
                                'maxlength' => 16,
                            ],
                             'options' => [
                                'label' => 'Delete Code',
                                'label_attributes' => ['style' => 'display: block'],
                            ],
                       ],
                    ],
                    'captcha' => [
                        'spec' => [
                            'name' => 'captcha',
                            'type' => 'captcha',
                            'attributes' => [
                                'title' => 'Enter the delete code for this item',
                                'size' => 16,
                                'maxlength' => 16,
                            ],
                            'options' => [
                                'label'   => 'Help us to prevent SPAM!',
                                // needs to be overridden by the factory
                                'captcha' => NULL,
                            ],
                        ],
                    ],
                    'csrf' => [
                        'spec' => [
                            'name' => 'csrf',
                            'type' => 'csrf',
                        ],
                    ],
                    'submit' => [
                        'spec' => [
                            'name' => 'submit',
                            'type' => 'submit',
                            'attributes' => [
                                'style' => 'font-size: 16pt; font-weight:bold;',
                                'class' => 'btn btn-success white',
                                'value' => 'Post',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'market-post-filter-config' => [
        'category' => [
            'name' => 'category',
            'required' => TRUE,
            'filters' => [
                [ 'name' => 'StringToLower' ],
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ],
        ],
        'title' => [
            'name' => 'title',
            'required' => TRUE,
            'validators' => [
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' =>'/^[a-zA-Z0-9 ]*$/',
                        // error message not showing: using default???
                        'error_message' => 'Title should only contain numbers, letters or spaces!',
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => ['min' => 1, 'max' => 128]
                ],
            ],
            'filters' => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ],
        ],
        'photo_filename' => [
            'name' => 'photo_filename',
            'allow_empty' => TRUE,
            'validators' => [
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '!^(http(s)?://)?[a-z0-9./_-]+(jp(e)?g|png)$!i',
                    ],
                ]
            ],
            'filters' => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ],
            'error_message' => 'Photo must be a URL or a valid filename ending with jpg or png.  '
                            . 'TO NOTICE: this error message overrides the default message associated with the validator.',
        ],
        'price' => [
            'name' => 'price',
            'allow_empty' => TRUE,
            'validators' => [
                [
                    'name' => 'GreaterThan',
                    'options' => [
                        'min' => 0.00,
                    ]
                ]
            ],
            'filters' => [
                ['name' => 'ToFloat']
            ],
        ],
        'expires' => [
            'name' => 'expires',
            'required' => TRUE,
            'filters' => [
                [ 'name' => 'Digits' ],
            ],
        ],
        'cityCode' => [
            'name' => 'cityCode',
            'required' => TRUE,
            'filters' => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ],
            'error_message' => 'What you entered did take this form: NNNN,CC where NNNN = the city name, and CC = 2 digit ISO country code'
        ],
        'contact_name' => [
            'name' => 'contact_name',
            'allow_empty' => TRUE,
            'validators' => [
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '/^[a-z0-9., -]{1,255}$/i',
                    ],
                ]
            ],
            'filters' => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ],
            'error_message' => 'Name should only contain letters, numbers, and some punctuation.',
        ],
        'contact_phone' => [
            'name' => 'contact_phone',
            'allow_empty' => TRUE,
            'validators' => [
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '/^\+?\d{1,4}(-\d{3,4})+$/',
                    ],
                ]
            ],
            'filters' => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ],
            'error_message' => 'Phone number must be in this format: +nnnn-nnn-nnn-nnnn',
        ],
        'contact_email' => [
            'name' => 'contact_email',
            'required' => TRUE,
            'validators' => [
                [
                    'name' => 'EmailAddress',
                ]
            ],
            'filters' => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ],
        ],
        'description' => [
            'name' => 'description',
            'allow_empty' => TRUE,
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [ 'min' => 1, 'max' => 4096 ]
                ]
            ],
            'filters' => [
                [ 'name' => 'StripTags' ],
                [ 'name' => 'StringTrim' ],
            ],
            'error_message' => 'Phone number must be in this format: +nnnn-nnn-nnn-nnnn',
        ],
        'delete_code' => [
            'name' => 'delete_code',
            'required' => TRUE,
            'filters' => [
                [ 'name' => 'Digits' ],
            ],
        ],
    ],
];
