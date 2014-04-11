*Plugin originally created by @JohnDoh. This is a fork.* **I don't maintain this repo!**

**Current version doesn't work with RoundCube 1.0!**


Roundcube Webmail ThreeCol
==========================

This plugin adds an option to the mailbox settings to enable the user to
display the preview pane either to the right had side of the message list or
below it.

Jaime_Pomales created a patch to give the default skin a three column layout
this patch was the inspiration for the plugin and also provided some of the
changes which need to be made to the default skin


License
=======

This plugin is released under the GNU General Public License Version 3
(http://www.gnu.org/licenses/gpl-3.0.html).

Even if skins might contain some programming work, they are not considered
as a linked part of the plugin and therefore skins DO NOT fall under the
provisions of the GPL license. See the README file located in the core skins
folder for details on the skin license.


Install
=======

* Place this plugin folder into plugins directory of Roundcube
* Add threecol to $rcmail_config['plugins'] in your Roundcube config


Config
======

To make enable the three column layout as default for all users set
$rcmail_config['previewpane_layout'] = 'right';
in the main config file. To prevent users form changing this setting add
`previewpane_layout` to the `dont_override` config option
