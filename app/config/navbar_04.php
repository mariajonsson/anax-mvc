<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
 
    // Here comes the menu strcture
    'items' => [

        
        // This is a menu item
        'home'  => [
            'text'  => 'Me',
            'url'   => $this->di->get('url')->create(''),
            'title' => 'Me',
            'mark-if-parent-of' => 'me',
        ],
 
        
        // This is a menu item
        'dice' => [
            'text'  =>'Tärning',
            'url'   => $this->di->get('url')->create('dice'),
            'title' => 'Kasta tärning',
            'mark-if-parent-of' => 'dice',
            
        ],

        // This is a menu item
        'redovisning' => [
            'text'  =>'Redovisning',
            'url'   => $this->di->get('url')->create('redovisning'),
            'title' => 'Redovisning av kursmoment'
        ],
        
        // This is a menu item
        'comment' => [
            'text'  =>'Kommentarer',
            'url'   => $this->di->get('url')->create('comment'),
            'title' => 'Lämna kommentarer',
            'mark-if-parent-of' => 'comment',
        ],
        
        // This is a menu item
        'theme' => [
            'text'  =>'Tema',
            'url'   => $this->di->get('url')->create('theme.php'),
            'title' => 'Tema'
        ],
        
        // This is a menu item
        'users' => [
            'text'  =>'Användare',
            'url'   => $this->di->get('url')->create('users'),
            'title' => 'Användare i databasen', 
            'mark-if-parent-of' => 'users',
            
            // Here we add the submenu, with some menu items, as part of a existing menu item
            'submenu' => [

                'items' => [

                    // This is a menu item of the submenu
                    'all'  => [
                        'text'  => 'Alla användare',
                        'url'   => $this->di->get('url')->create('users/list'),
                        'title' => 'Visa alla användare'
                    ],                    
                    // This is a menu item of the submenu
                    'active'  => [
                        'text'  => 'Aktiva användare',
                        'url'   => $this->di->get('url')->create('users/active'),
                        'title' => 'Visa aktiva användare'
                    ],
                    
                    // This is a menu item of the submenu
                    'inactive'  => [
                        'text'  => 'Inaktiva användare',
                        'url'   => $this->di->get('url')->create('users/inactive'),
                        'title' => 'Visa inaktiva användare'
                    ],
                    
                    // This is a menu item of the submenu
                    'add'  => [
                        'text'  => 'Lägg till användare',
                        'url'   => $this->di->get('url')->create('users/add'),
                        'title' => 'Lägg till användare'
                    ],
                     // This is a menu item of the submenu
                    'discarded'  => [
                        'text'  => 'Papperskorgen',
                        'url'   => $this->di->get('url')->create('users/discarded'),
                        'title' => 'Visa papperskorgen'
                    ],

                    // This is a menu item of the submenu
                    'setup'  => [
                        'text'  => 'Återställ databasen',
                        'url'   => $this->di->get('url')->asset('users/reset-users'),
                        'title' => 'Återställ databasen till sitt ursprungliga skick',
                    ],
                ],
            ],
        ],
        
         // This is a menu item
        'source' => [
            'text'  =>'Källkod',
            'url'   => $this->di->get('url')->create('source'),
            'title' => 'Källkod'
        ],
    ],
 


    /**
     * Callback tracing the current selected menu item base on scriptname
     *
     */
    'callback' => function ($url) {
        if ($url == $this->di->get('request')->getCurrentUrl(false)) {
            return true;
        }
    },



    /**
     * Callback to check if current page is a decendant of the menuitem, this check applies for those
     * menuitems that has the setting 'mark-if-parent' set to true.
     *
     */
    'is_parent' => function ($parent) {
        $route = $this->di->get('request')->getRoute();
        return !substr_compare($parent, $route, 0, strlen($parent));
    },



   /**
     * Callback to create the url, if needed, else comment out.
     *
     */
   /*
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
    */
];
