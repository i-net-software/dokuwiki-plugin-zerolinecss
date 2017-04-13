<?php
/**
 * DokuWiki Plugin inlinedcss (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  i-net software / Gerry Weißbach <tools@inetsoftware.de>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class action_plugin_inlinedcss extends DokuWiki_Action_Plugin {

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
        global $conf;
        if ( in_array( $conf['template'], explode(',', $this->getConf('templates')) ) ) {
            include_once( DOKU_INC . '/HTTPClient.php');
            $http = new DokuHTTPClient();

            
            foreach( $event->data['link'] as &$link ) {

                if ( $link['rel'] != 'stylesheet' && !empty($link['href']) ) continue;
                $data = $http->get( DOKU_URL . $link['href'] );

                if ( !empty($data) ) {
                    $event->data['style'][] = array(
                        'type' => $link['type'],
                        '_data' => '/* '.strtoupper($conf['template']).' */ ' . $data
                    );
                    
                    // empty
                    $link = array();
                }
            }
        }

    }
}

// vim:ts=4:sw=4:et:
