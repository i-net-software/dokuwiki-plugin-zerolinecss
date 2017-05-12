<?php
/**
 * DokuWiki Plugin inlinedcss (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  i-net software / Gerry Weißbach <tools@inetsoftware.de>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class action_plugin_zerolinecss extends DokuWiki_Action_Plugin {

    var $httpClient = null;

    /**
     * Registers a callback function for a given event
     *
     * @param Doku_Event_Handler $controller DokuWiki's event controller object
     * @return void
     */
    public function register(Doku_Event_Handler $controller) {
       $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, 'handle_tpl_metaheader_output');
    }

    /**
     * [Custom event handler which performs action]
     *
     * @param Doku_Event $event  event object by reference
     * @param mixed      $param  [the parameters passed as fifth argument to register_hook() when this
     *                           handler was registered]
     * @return void
     */
    public function handle_tpl_metaheader_output(Doku_Event &$event, $param) {
        foreach( $event->data['link'] as &$link ) {

            if ( $link['rel'] != 'zerolinecss' && !empty($link['href']) ) continue;
            $this->_init_http_client();
            $data = $this->httpClient->get( DOKU_URL . $link['href'] );

            if ( !empty($data) ) {
                $event->data['style'][] = array(
                    'rel' => 'stylesheet',
                    'type' => $link['type'],
                    '_data' => '/* ZEROLINECSS */ ' . $data
                );

                // empty original array
                $link = array();
            }
        }
    }

    private function _init_http_client() {
        if ( $this->httpClient != null ) {
            return;
        }

        @include_once( DOKU_INC . '/HTTPClient.php');
        $this->httpClient = new DokuHTTPClient();
    }
}

// vim:ts=4:sw=4:et:
