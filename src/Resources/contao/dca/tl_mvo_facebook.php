<?php

declare(strict_types=1);

/*
 * Contao Facebook Import Bundle for Contao Open Source CMS
 *
 * @copyright  Copyright (c) 2017-2018, Moritz Vondano
 * @license    MIT
 * @link       https://github.com/m-vo/contao-facebook-import
 *
 * @author     Moritz Vondano
 */

$GLOBALS['TL_DCA']['tl_mvo_facebook'] =
    [

        // Config
        'config'      =>
            [
                'dataContainer'    => 'Table',
                'ctable'           => ['tl_mvo_facebook_event', 'tl_mvo_facebook_post'],
                'switchToEdit'     => true,
                'enableVersioning' => true,
                'sql'              =>
                    [
                        'keys' =>
                            [
                                'id' => 'primary',
                            ]
                    ]
            ],

        // List
        'list'        =>
            [
                'sorting'           =>
                    [
                        'mode'        => 2,
                        'fields'      => ['description'],
                        'flag'        => 1,
                        'panelLayout' => 'sort,search,limit'
                    ],
                'label'             =>
                    [
                        'fields' => ['description'],
                        'format' => '%s',
                    ],
                'global_operations' => [],
                'operations'        =>
                    [
                        'edit'   =>
                            [
                                'label' => &$GLOBALS['TL_LANG']['tl_theme']['edit'],
                                'href'  => 'act=edit',
                                'icon'  => 'edit.svg'
                            ],
                        'events' =>
                            [
                                'label' => &$GLOBALS['TL_LANG']['tl_mvo_facebook']['events'],
                                'href'  => 'table=tl_mvo_facebook_event',
                                'icon'  => 'bundles/mvocontaofacebookimport/img/events.svg'
                            ],
                        'posts'  =>
                            [
                                'label' => &$GLOBALS['TL_LANG']['tl_mvo_facebook']['posts'],
                                'href'  => 'table=tl_mvo_facebook_post',
                                'icon'  => 'bundles/mvocontaofacebookimport/img/posts.svg'
                            ],
                        'toggle' =>
                            [
                                'label'                => &$GLOBALS['TL_LANG']['tl_mvo_facebook']['toggle'],
                                'attributes'           => 'onclick="Backend.getScrollOffset();"',
                                'haste_ajax_operation' => [
                                    'field'   => 'importEnabled',
                                    'options' => [
                                        [
                                            'value' => '',
                                            'icon'  => 'invisible.svg'
                                        ],
                                        [
                                            'value' => '1',
                                            'icon'  => 'visible.svg'
                                        ]
                                    ]
                                ]
                            ],
                        'delete' =>
                            [
                                'label' => &$GLOBALS['TL_LANG']['tl_mvo_facebook']['delete'],
                                'href'  => 'act=delete',
                                'icon'  => 'delete.svg'
                            ]
                    ]
            ],

        // Select
        'select'      =>
            [
                'buttons_callback' => []
            ],

        // Edit
        'edit'        =>
            [
                'buttons_callback' => []
            ],

        // Palettes
        'palettes'    =>
            [
                '__selector__' => ['createNativeEvents'],
                'default'      => '{basic_legend},description,fbPageName;' .
                                  '{api_legend},fbAppId,fbAppSecret,fbAccessToken;' .
                                  '{import_legend},importEnabled,minimumCacheTime,numberOfPosts,createNativeEvents;' .
                                  '{media_legend},uploadDirectory;'
            ],

        // Subpalettes
        'subpalettes' =>
            ['createNativeEvents' => 'calendarId,calendarEventAuthor'],

        // Fields
        'fields'      =>
            [
                'id'     =>
                    [
                        'sql' => "int(10) unsigned NOT NULL auto_increment"
                    ],
                'tstamp' =>
                    [
                        'sql' => "int(10) unsigned NOT NULL default '0'"
                    ],

                'description'         =>
                    [
                        'label'     => &$GLOBALS['TL_LANG']['tl_mvo_facebook']['description'],
                        'exclude'   => true,
                        'inputType' => 'text',
                        'eval'      => ['mandatory' => true, 'maxlength' => 255],
                        'sql'       => "varchar(255) NOT NULL default ''"
                    ],
                'fbAppId'             =>
                    [
                        'label'     => &$GLOBALS['TL_LANG']['tl_mvo_facebook']['fbAppId'],
                        'exclude'   => true,
                        'inputType' => 'text',
                        'eval'      => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
                        'sql'       => "varchar(255) NOT NULL default ''"
                    ],
                'fbAppSecret'         =>
                    [
                        'label'     => &$GLOBALS['TL_LANG']['tl_mvo_facebook']['fbAppSecret'],
                        'exclude'   => true,
                        'inputType' => 'text',
                        'eval'      => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
                        'sql'       => "varchar(255) NOT NULL default ''"
                    ],
                'fbAccessToken'       =>
                    [
                        'label'         => &$GLOBALS['TL_LANG']['tl_mvo_facebook']['fbAccessToken'],
                        'exclude'       => true,
                        'inputType'     => 'text',
                        'eval'          => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
                        'sql'           => "varchar(255) NOT NULL default ''",
                        'save_callback' => [
                            [
                                'mvo_contao_facebook.listener.datacontainer.facebook',
                                'onGenerateAccessToken'
                            ]
                        ]
                    ],
                'fbPageName'          =>
                    [
                        'label'     => &$GLOBALS['TL_LANG']['tl_mvo_facebook']['fbPageName'],
                        'exclude'   => true,
                        'inputType' => 'text',
                        'eval'      => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
                        'sql'       => "varchar(255) NOT NULL default ''"
                    ],
                'minimumCacheTime'    =>
                    [
                        'label'     => &$GLOBALS['TL_LANG']['tl_mvo_facebook']['minimumCacheTime'],
                        'exclude'   => true,
                        'inputType' => 'text',
                        'eval'      => [
                            'mandatory' => true,
                            'maxlength' => 6,
                            'rgxp'      => 'natural',
                            'tl_class'  => 'w50'
                        ],
                        'sql'       => "int(6) unsigned NOT NULL default '250'"
                    ],
                'numberOfPosts'       =>
                    [
                        'label'     => &$GLOBALS['TL_LANG']['tl_mvo_facebook']['numberOfPosts'],
                        'exclude'   => true,
                        'inputType' => 'text',
                        'eval'      => [
                            'mandatory' => true,
                            'maxlength' => 5,
                            'rgxp'      => 'natural',
                            'tl_class'  => 'w50'
                        ],
                        'sql'       => "int(5) unsigned NOT NULL default '15'"
                    ],
                'importEnabled'       =>
                    [
                        'label'     => &$GLOBALS['TL_LANG']['tl_mvo_facebook']['importEnabled'],
                        'exclude'   => true,
                        'default'   => false,
                        'inputType' => 'checkbox',
                        'eval'      => ['isBoolean' => true],
                        'sql'       => "char(1) NOT NULL default '0'"
                    ],
                'uploadDirectory'     =>
                    [
                        'label'     => &$GLOBALS['TL_LANG']['tl_mvo_facebook']['uploadDirectory'],
                        'exclude'   => true,
                        'inputType' => 'fileTree',
                        'eval'      => ['mandatory' => true, 'fieldType' => 'radio'],
                        'sql'       => "blob NOT NULL"
                    ],
                'createNativeEvents'  =>
                    [
                        'label'     => &$GLOBALS['TL_LANG']['tl_mvo_facebook']['createNativeEvents'],
                        'exclude'   => true,
                        'inputType' => 'checkbox',
                        'eval'      => ['submitOnChange' => true, 'tl_class' => 'w50 m12'],
                        'sql'       => "char(1) NOT NULL default ''"
                    ],
                'calendarId'          =>
                    [
                        'label'            => &$GLOBALS['TL_LANG']['tl_mvo_facebook']['calendarId'],
                        'exclude'          => true,
                        'inputType'        => 'select',
                        'options_callback' => [
                            'mvo_contao_facebook.listener.datacontainer.facebook',
                            'onGetCalendars'
                        ],
                        'eval'             => [
                            'chosen'             => true,
                            'mandatory'          => true,
                            'includeBlankOption' => true,
                            'tl_class'           => 'w50'
                        ],
                        'sql'              => "int(10) unsigned"
                    ],
                'calendarEventAuthor' =>
                    [
                        'label'      => &$GLOBALS['TL_LANG']['tl_mvo_facebook']['calendarEventAuthor'],
                        'default'    => BackendUser::getInstance()->id,
                        'exclude'    => true,
                        'inputType'  => 'select',
                        'foreignKey' => 'tl_user.name',
                        'eval'       => array(
                            'chosen'             => true,
                            'mandatory'          => true,
                            'includeBlankOption' => true,
                            'tl_class'           => 'w50'
                        ),
                        'sql'        => "int(10) unsigned NOT NULL default '0'",
                    ]
            ]
    ];