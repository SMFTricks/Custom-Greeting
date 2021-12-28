<?php

/**
 * @package Custom Greeting
 * @version 3.0
 * @author Diego Andrés <diegoandres_cortes@outlook.com>
 * @copyright Copyright (c) 2021, SMF Tricks
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

if (!defined('SMF'))
	die('No direct access...');

class CustomGreeting
{
	/**
	 * @var string The greeting message
	 */
	private  $_greet;

	/**
	 * @var string The user's current date/time
	 */
	private $_date;

	/**
	 * CustomGreeting::__construct()
	 *
	 * Load the user current time (H)
	 *
	 * @return void
	 */
	public function __construct()
	{
		// Date
		$this->_date = date('H', time());
	}

	/**
	 * CustomGreeting::buffer()
	 *
	 * Inserts the custom greeting in the user menu, only if the mod is enabled
	 *
	 * @param string $buffer The current content
	 * @return string $buffer The changed content
	 */
	public function buffer($buffer)
	{
		global $modSettings;

		// Is the mod enabled?
		if (!empty($modSettings['cgdt_enable']))
		{
			// Greet
			$this->greet();

			// Add the greeting
			$buffer = preg_replace(
				'~(<span class="profile_username">)~',
				"$1 " . $this->_greet ,
				$buffer
			);
		}

		return $buffer;
	}

	/**
	 * CustomGreeting::greet()
	 *
	 * Set the adecuate greet message
	 *
	 * @return void
	 */
	private function greet()
	{
		global $modSettings, $txt;

		// Language
		loadLanguage('CustomGreeting/');

		// Set the greet message
		if ($this->_date < 5)
			$this->_greet = !empty($modSettings['cgdt_message1']) ? $modSettings['cgdt_message1'] : $txt['cgdt_up_late'];
		elseif ($this->_date < 8)
			$this->_greet = !empty($modSettings['cgdt_message2']) ? $modSettings['cgdt_message2'] : $txt['cgdt_early_bird'];
		elseif ($this->_date < 12)
			$this->_greet = !empty($modSettings['cgdt_message3']) ? $modSettings['cgdt_message3'] : $txt['cgdt_morning'];
		elseif ($this->_date < 18)
			$this->_greet = !empty($modSettings['cgdt_message4']) ? $modSettings['cgdt_message4'] : $txt['cgdt_afternoon'];
		elseif ($this->_date < 21)
			$this->_greet = !empty($modSettings['cgdt_message5']) ? $modSettings['cgdt_message5'] : $txt['cgdt_evening'];
		elseif ($this->_date < 1 || $this->_date >=21)
			$this->_greet = !empty($modSettings['cgdt_message6']) ? $modSettings['cgdt_message6'] : $txt['cgdt_bed_soon'];

		// Format the greet
		$this->_greet = '<span style="display: block; font-size: 0.9rem;">' . $this->_greet . ', </span>';
	}

	/**
	 * CustomGreeting::settings()
	 *
	 * Add the custom greeting settings
	 *
	 * @param array $config_vars The mods general settings
	 * @return void
	 */
	public static function settings(&$config_vars)
	{
		// Language
		loadLanguage('CustomGreeting/');

		$config_vars []= ['title', 'cgdt_title'];
		$config_vars []= ['check', 'cgdt_enable'];
		$config_vars []= ['text', 'cgdt_message1'];
		$config_vars []= ['text', 'cgdt_message2'];
		$config_vars []= ['text', 'cgdt_message3'];
		$config_vars []= ['text', 'cgdt_message4'];
		$config_vars []= ['text', 'cgdt_message5'];
		$config_vars []= ['text', 'cgdt_message6'];
	}
}