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
 * Class ToolsCheckNeedsUpgrade
 * Return 0 if no upgrade is need or 1 if an upgrade is needed
 * @package Moosh\Command\Generic\Tools
 */
class ToolsCheckNeedsUpgrade extends MooshCommand {
	public function __construct() {
		parent::__construct( 'check-needsupgrade' );
	}
	
	public function execute() {
		global $CFG;
		require_once( $CFG->libdir . '/adminlib.php' );
		require_once( $CFG->libdir . '/upgradelib.php' );     // general upgrade/install related functions
		require_once( $CFG->libdir . '/environmentlib.php' );
		$moodleneedsupgrade = intval(moodle_needs_upgrading());
		echo "$moodleneedsupgrade\n";
	}
}