<?php

/**
 * Summary :
 *  -> A list of various messages
 *  -> Admin
 *  -> Captcha
 *  -> Error
 *  -> Filter
 *  -> Languages
 *  -> Literal numbers
 *  -> Map
 *  -> Months
 *  -> Placeholder
 */

return [
    //'Actions'                    => '',
    //'add'                        => '',
    //'at'                         => '',
    //'Bad credentials'            => '',
    //'by date'                    => '',
    //'by tag'                     => '',
    //'Cancel'                     => '',
    //'Close'                      => '',
    //'Comments'                   => '',
    //'Contents under CC0 license' => '',
    //'Create'                     => '',
    //'Delete'                     => '',
    //'Delete filter(s)'           => '',
    //'Edit'                       => '',
    //'Error'                      => '',
    'Error(s)'                   => 'There is/are <b>0</b> error/s : at 1.',
    //'General'                    => '',
    //'Help'                       => '',
    //'Home'                       => '',
    //'Login'                      => '',
    //'Logout'                     => '',
    //'No'                         => '',
    //'none'                       => '',
    //'Older'                      => '',
    //'Other'                      => '',
    //'Password'                   => '',
    //'Post'                       => '',
    //'Posted by'                  => '',
    //'Preview'                    => '',
    //'Read'                       => '',
    //'Read more'                  => '',
    //'Run search'                 => '',
    //'Search'                     => '',
    //'Submit'                     => '',
    //'Tags'                       => '',
    //'to'                         => '',
    //'Top'                        => '',
    //'Update'                     => '',
    //'website'                    => '',
    //'Yes'                        => '',
    //'Younger'                    => '',

    // Admin
    'admin' => [
        'cacheClear'   => 'Clear the cache',
        'cacheCleared' => 'Cache cleared.',
        'home'         => 'Administration',
    ],

    // Captcha
    'captcha' => [
        'field' => 'Anti-spam system',

        'help' => '<i class="fa fa-exclamation-triangle"></i> '.
            'Please enter the characters displayed in the picture to prevent automated spam systems.',

        'help.change' => 'Please click here to change the picture',
    ],

    // Error
    'error' => [
        'go2home'   => 'Maybe you should <a href="/home">go back to home</a> ?!',
        'contactUs' => 'Or <a href="/contact">contact us</a> if the problem seems fishy...',

        'title' => [
            '404'   => 'Hu hu 404 ! You are lost !',
            'other' => 'Hu hu ! Fatal error !',
        ],

        'message' => [
            '404'   => 'The requested page could not be found.',
            'other' => 'We are sorry, but something went terribly wrong.',
        ],
    ],

    // Filter
    'filter' => [
        'tags'           => 'Filtered by tag <b>0</b>|'.
                            'Filtered by tags <b>0</b>',
        'tags.hideSmall' => 'Hide the small tags',
        'tags.showSmall' => 'Show all tags',
        'year'           => "Filtered by year <b>0</b>",
        'year-month'     => "Filtered by date <b>1 0</b>",
    ],

    // Languages
    'lang' => [
        'fr' => 'French',
        'en' => 'English',
    ],

    // Literal numbers
    'literal' => [
        '8'  => 'eight',
        '9'  => 'nine',
        '10' => 'ten',
        '11' => 'eleven',
        '12' => 'twelve',
        '13' => 'thirteen',
        '14' => 'forteen',
        '15' => 'fifteen',
    ],

    // Map
    'map' => [
        'clusterLabel.other' => 'and OTHER_L other points...',
        'clusterLabel.all'   => 'Click to see the TOTAL_L points of the area.',
        'helpTitle'          => 'Understand the map',
        'home'               => 'The map',
    ],

    // Months
    'month' => [
        '1'  => 'January',
        '2'  => 'February',
        '3'  => 'March',
        '4'  => 'April',
        '5'  => 'May',
        '6'  => 'June',
        '7'  => 'July',
        '8'  => 'August',
        '9'  => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    ],
    //'January'   => '',
    //'February'  => '',
    //'March'     => '',
    //'April'     => '',
    //'May'       => '',
    //'June'      => '',
    //'July'      => '',
    //'August'    => '',
    //'September' => '',
    //'October'   => '',
    //'November'  => '',
    //'December'  => '',

    // Placeholder
    'placeholder' => [
        'tags' => 'Tags separated by a comma',
    ],
];
