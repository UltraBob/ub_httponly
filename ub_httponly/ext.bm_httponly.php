<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * BM HttpOnly Cookies Extension
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Extension
 * @author		UltraBob
 * @link		
 */

class Bm_httponly_ext {
	
	public $settings 		= array();
	public $description		= 'Does one thing: enable HttpOnly cookies
All credit for this first version of this extension goes to Dom Stubbs of vayadesign.net he basically wrote it for me in a stackexchange answer.';
	public $docs_url		= 'https://github.com/UltraBob/bm_httponly';
	public $name			= 'BM HttpOnly Cookies';
	public $settings_exist	= 'n';
	public $version			= '1.0';
	
	private $EE;
	
	/**
	 * Constructor
	 *
	 * @param 	mixed	Settings array or empty string if none exist.
	 */
	public function __construct($settings = '')
	{
		$this->EE =& get_instance();
		$this->settings = $settings;
	}// ----------------------------------------------------------------------
	
	/**
	 * Activate Extension
	 *
	 * This function enters the extension into the exp_extensions table
	 *
	 * @see http://codeigniter.com/user_guide/database/index.html for
	 * more information on the db class.
	 *
	 * @return void
	 */
	public function activate_extension()
	{
		// Setup custom settings in this array.
		$this->settings = array();
		
		$data = array(
			'class'		=> __CLASS__,
			'method'	=> 'set_httponly_cookie',
			'hook'		=> 'set_cookie_end',
			'settings'	=> serialize($this->settings),
			'version'	=> $this->version,
			'enabled'	=> 'y'
		);

		$this->EE->db->insert('extensions', $data);			
		
	}	

	// ----------------------------------------------------------------------
	
	/**
	 * set_httponly_cookie
	 *
	 * @param 
	 * @return 
	 */
	public function set_httponly_cookie($data)
	{
        
		// Block EE's native setcookie() call
        $this->EE->extensions->end_script = TRUE; 

        // Set a HttpOnly cookie
		setcookie($data['prefix'].$data['name'], $data['value'], $data['expire'],
		                        $data['path'], $data['domain'], $data['secure_cookie'], TRUE);
		
	}

	// ----------------------------------------------------------------------

	/**
	 * Disable Extension
	 *
	 * This method removes information from the exp_extensions table
	 *
	 * @return void
	 */
	function disable_extension()
	{
		$this->EE->db->where('class', __CLASS__);
		$this->EE->db->delete('extensions');
	}

	// ----------------------------------------------------------------------

	/**
	 * Update Extension
	 *
	 * This function performs any necessary db updates when the extension
	 * page is visited
	 *
	 * @return 	mixed	void on update / false if none
	 */
	function update_extension($current = '')
	{
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
	}	
	
	// ----------------------------------------------------------------------
}

/* End of file ext.bm_httponly.php */
/* Location: /system/expressionengine/third_party/bm_httponly/ext.bm_httponly.php */