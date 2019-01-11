<?php
/**
 * moosh - Moodle Shell
 *
 * @copyright  2012 onwards Tomasz Muras
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     Laurent David <laurent@call-learning.fr>
 */


namespace Moosh\Command\Generic\Plugin;

use Moosh\MooshCommand;

/**
 * Class PluginForceVersion
 * Show config values and changes from base install (i.e. changes from default values)
 * @package Moosh\Command\Generic\Tools
 */
class PluginForceVersion extends MooshCommand {
    public function __construct() {
        parent::__construct('forceversion', 'plugin');
    
        $this->addArgument('plugin_name');
        $this->addArgument('plugin_version');
        
    }
    public function execute() {
        global $CFG, $DB;
        require_once($CFG->libdir . '/adminlib.php');
    
        $pluginname     = $this->arguments[0];
        $pluginversion  = $this->arguments[1];
    
        $DB->set_field('config_plugins','value',$pluginversion, array ('plugin'=>$pluginname, 'name'=>'version'));
    }
    
    
}