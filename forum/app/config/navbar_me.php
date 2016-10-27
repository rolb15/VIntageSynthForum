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
            'text'  => 'HOME',
            'url'   => $this->di->get('url')->create(''),
            'title' => 'Home'
        ],

        'questions' => [
            'text'  =>'QUESTIONS',
            'url'   => $this->di->get('url')->create('questions'),
            'title' => 'Questions'
        ],

        'newquestion' => [
            'text'  =>'ASK A QUESTION',
            'url'   => $this->di->get('url')->create('new'),
            'title' => 'New question'
        ],

        'tags' => [
            'text'  =>'TAGS',
            'url'   => $this->di->get('url')->create('tags'),
            'title' => 'Tags'
        ],

        'users'  => [
            'text'  => 'USERS',
            'url'   => $this->di->get('url')->create('users/list'),
            'title' => 'Users'
        ],

        'about'  => [
            'text'  => 'ABOUT',
            'url'   => $this->di->get('url')->create('about'),
            'title' => 'About'
        ],

        'login'  => [
            'text'  => 'LOG IN/OUT',
            'url'   => $this->di->get('url')->create('login'),
            'title' => 'Log in'
        ],

        'signup'  => [
            'text'  => 'SIGN UP',
            'url'   => $this->di->get('url')->create('users/add'),
            'title' => 'Sign up'
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
