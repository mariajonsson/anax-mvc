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
