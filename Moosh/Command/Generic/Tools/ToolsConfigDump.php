<?php
/**
 * moosh - Moodle Shell
 *
 * @copyright  2012 onwards Tomasz Muras
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     Laurent David <laurent@call-learning.fr>
 */


namespace Moosh\Command\Generic\Tools;

use Moosh\MooshCommand;

/**
 * Class ToolsConfigDump
 * Show config values and changes from base install (i.e. changes from default values)
 * @package Moosh\Command\Generic\Tools
 */
class ToolsConfigDump extends MooshCommand {
    public function __construct() {
        parent::__construct('config-dump');
        $this->addOption('c|changes-only', 'Only print values that different from the default value', false);
    }
    
    public function execute() {
        global $CFG;
        require_once($CFG->libdir . '/adminlib.php');
        $adminroot = admin_get_root(true, true); // settings not required for external pages
        $onlydiff = false;
        $options = $this->expandedOptions;
        if (!empty($options['changes-only']) && $options['changes-only'] == true) {
            $onlydiff = true;
        }
        $this->print_default_settings($adminroot,$onlydiff); // Recursively walk the tree and display settings
    }
    
    /**
     * Recursively walk the tree and display default settings if they exist
     * (from admin_apply_default_settings / adminlib.php )
     * @param null $node
     */
    protected function print_default_settings($node = NULL,$onlydiff = true) {
        global $CFG;
        require_once($CFG->libdir . '/adminlib.php');
        if ( $node instanceof \admin_category || $node instanceof \admin_root  ) {
            $entries = array_keys($node->children);
            foreach ($entries as $entry) {
                $this->print_default_settings($node->children[$entry], $onlydiff);
            }
            
        } else if ($node instanceof \admin_settingpage) {
            foreach ($node->settings as $setting) {
                $printablesetting = "";
                if ($setting->plugin) {
                    $printablesetting .= $setting->plugin . "/";
                }
                $printablesetting .= $setting->name . ":";
                
                $defaultsetting = $setting->get_defaultsetting();
                $defaultvalue = "undefined";
                if (!is_null($defaultsetting)) {
                    
                    $defaultvalue = $defaultsetting;
                }
                $currentvalue = $setting->get_setting();
                $printablesetting .= json_encode($currentvalue) . " (".json_encode($defaultvalue).")";
                if (!$onlydiff || ($currentvalue != $defaultsetting)  ) {
                    echo "{$printablesetting}\n";
                }
            }
        }
        
    }
}