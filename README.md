# ZerolineCSS Plugin for DokuWiki

Inlines CSS into the page

All documentation for this plugin can be found at
https://www.dokuwiki.org/plugin:zerolinecss

If you install this plugin manually, make sure it is installed in
lib/plugins/inlinedcss/ - if the folder is called different it
will not work!

Please refer to http://www.dokuwiki.org/plugins for additional info
on how to install plugins in DokuWiki.


## Usage

**Requires the metaheaders - plugin!**

In your template place the following script before the `tpl_metaheaders()` call:

    <?php
        global $headers, $clear, $updateVersion;

        $headers['link'][] = array(
            'rel' => 'zerolinecss',
            'type' => 'text/css',
            'href' => '/lib/exe/css.php?t=' . $conf['template'] . '&tseed=' . md5($updateVersion)
        );

        $clear[] = array ( 'rel' => 'stylesheet');
        $clear[] = array ( 'type' => 'text/javascript');
        $clear[] = array ( 'name' => 'generator');
        $clear[] = array ( 'name' => 'date');
        tpl_metaheaders();
    ?>

----
Copyright (C) i-net software / Gerry Weißbach <tools@inetsoftware.de>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; version 2 of the License

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

See the COPYING file in your DokuWiki folder for details
