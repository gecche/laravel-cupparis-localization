<?php

namespace Gecche\Cupparis\Localization;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class Localization {



    /**
     * The environment file to load during bootstrapping.
     *
     * @var string
     */
    protected $app;
    protected $request;

    /**
     * Create a new manager instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->request = $app['request'];
    }

 /**
     * Detect and set application localization environment (language).
     * NOTE: Don't foreget to ADD/SET/UPDATE the locales array in app/config/app.php!
     *
     */


    public function configureLocale()
    {

        // Set default locale.
        $mLocale = $this->app['config']->get( 'app.locale' );

        // Has a session locale already been set?
        if ( !$this->app['session']->has( 'locale' ) )
        {
            // No, a session locale hasn't been set.
            // Was there a cookie set from a previous visit?
            $mFromCookie = $this->request->cookie( 'lang', null );
            //$mFromCookie = Arr::get($_COOKIE,'lang',null);

            if ( $mFromCookie != null && in_array( $mFromCookie, $this->app['config']->get( 'app.langs' ) ) )
            {
                // Cookie was previously set and it's a supported locale.
                $mLocale = $mFromCookie;
            }
            else
            {
                // No cookie was set.
                // Attempt to get local from current URI.
                $mFromURI = $this->app['request']->segment( 1 );
                if ( $mFromURI != null && in_array( $mFromURI, $this->app['config']->get( 'app.langs' ) ) )
                {
                    // supported locale
                    $mLocale = $mFromURI;
                }
                else
                {
                    // attempt to detect locale from browser.
                    $mFromBrowser = substr( $this->app['request']->server( 'http_accept_language' ), 0, 2 );
                    if ( $mFromBrowser != null && in_array( $mFromBrowser, $this->app['config']->get( 'app.langs' ) ) )
                    {
                        // browser lang is supported, use it.
                        $mLocale = $mFromBrowser;
                    } // $mFromBrowser
                } // $mFromURI
            } // $mFromCookie

            $this->app['session']->put( 'locale', $mLocale );

            //$_COOKIE['lang'] = $mLocale;
            $this->app['cookie']->forever( 'lang', $mLocale);
        } // Session?
        else
        {
            // session locale is available, use it.
            $mLocale = $this->app['session']->get( 'locale' );
        } // Session?

        // set application locale for current session.
        $this->app->setLocale( $mLocale );

    }

}
