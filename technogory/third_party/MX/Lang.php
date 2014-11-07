<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library extends the CodeIgniter CI_Language class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Lang.php
 *
 * @copyright	Copyright (c) 2011 Wiredesignz
 * @version 	5.4
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Lang extends CI_Lang
{


    /**************************************************
     configuration
    ***************************************************/
   
    // languages
    private $languages = array(
        'vi' => 'vietnamese',
        'en' => 'english',
        'fr' => 'fr',
        'nl' => 'nl'
    );
   
    // special URIs (not localized)
    private $special = array (
        "admin"
    );
    
    // where to redirect if no language in URI
    private $uri;
    private $default_uri;
    private $lang_code;
   
    /**************************************************/
    
    
    function MY_Lang()
    {
        parent::__construct();
        
        global $CFG;
        global $URI;
        global $RTR;
        
        $this->uri = $URI->uri_string();
        $this->default_uri = $RTR->default_controller;
        
        $uri_segment = $this->get_uri_lang($this->uri);
        $this->lang_code = $uri_segment['lang'] ;
        

        
        $url_ok = false;
        if ((!empty($this->lang_code)) && (array_key_exists($this->lang_code, $this->languages)))
        {
            $language = $this->languages[$this->lang_code];
            $CFG->set_item('language', $language);
            $url_ok = true;
        }
        
           if ((!$url_ok) && (!$this->is_special($uri_segment['parts'][0]))) // special URI -> no redirect
           {
               // set default language
               $CFG->set_item('language', $this->languages[$this->default_lang()]);
               
               $uri = (!empty($this->uri)) ? $this->uri: $this->default_uri;
               $uri = ($uri[0] != '/') ? '/'.$uri : $uri;
               $new_url = $CFG->config['base_url'].$this->default_lang().$uri;
               
               header("Location: " . $new_url, TRUE, 302);
               exit;
           }
           
           
    }

    
    
    // get current language
    // ex: return 'en' if language in CI config is 'english' 
    function lang()
    {
        global $CFG;        
        $CI = get_instance();
        $lang_code = $CI->session->userdata('lang_site');
        if($lang_code){
            $language = $lang_code;    
        }else{
            $language = 'vietnamese';
            $CI->session->set_userdata('lang_site','vietnamese');
            $CI->session->set_userdata('lang','vi');
            
        }
        $lang = array_search($language, $this->languages);
        if ($lang)
        {
            return $lang;
        }
        
        return NULL;    // this should not happen
    }
    
    
    function is_special($lang_code)
    {
        if ((!empty($lang_code)) && (in_array($lang_code, $this->special)))
            return TRUE;
           else
            return FALSE;
    }
   
   
    function switch_uri($lang)
        {
            if ((!empty($this->uri)) && (array_key_exists($lang, $this->languages)))
            {

                if ($uri_segment = $this->get_uri_lang($this->uri))
                {
                    $uri_segment['parts'][0] = $lang;
                    $uri = implode('/',$uri_segment['parts']);
                }
                else
                {
                    $uri = $lang.'/'.$this->uri;
                }
                
            }
            return $uri;
            
        }
    
    //check if the language exists
    //when true returns an array with lang abbreviation + rest
       function get_uri_lang($uri = '')
       {
           if (!empty($uri))
           {
               $uri = ($uri[0] == '/') ? substr($uri, 1): $uri;
               
               $uri_expl = explode('/', $uri, 2);
               $uri_segment['lang'] = NULL;
               $uri_segment['parts'] = $uri_expl;        
               
               if (array_key_exists($uri_expl[0], $this->languages))
               {
                   $uri_segment['lang'] = $uri_expl[0];
               }
               return $uri_segment;
           }
           else
               return FALSE;
       }

       
    // default language: first element of $this->languages
    function default_lang()
    {
        $browser_lang = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';
        $browser_lang = substr($browser_lang, 0,2);
        return (array_key_exists($browser_lang, $this->languages)) ? 'vi': 'en';
    }
    
    
    // add language segment to $uri (if appropriate)
    function localized($uri)
    {
        if (!empty($uri))
        {
            $uri_segment = $this->get_uri_lang($uri);
            if (!$uri_segment['lang'])
            {

                if ((!$this->is_special($uri_segment['parts'][0])) && (!preg_match('/(.+)\.[a-zA-Z0-9]{2,4}$/', $uri)))
                   {
                       $uri = $this->lang() . '/' . $uri;
                   }
               }
           }
        return $uri;
    }	
    
    public function load($langfile, $lang = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '', $_module = '')	{
		
		if (is_array($langfile)) {
			foreach($langfile as $_lang) $this->load($_lang);
			return $this->language;
		}
			
		$deft_lang = CI::$APP->config->item('language');
		$idiom = ($lang == '') ? $deft_lang : $lang;
	
		if (in_array($langfile.'_lang'.EXT, $this->is_loaded, TRUE))
			return $this->language;

		$_module OR $_module = CI::$APP->router->fetch_module();
		list($path, $_langfile) = Modules::find($langfile.'_lang', $_module, 'language/'.$idiom.'/');

		if ($path === FALSE) {
			
			if ($lang = parent::load($langfile, $lang, $return, $add_suffix, $alt_path)) return $lang;
		
		} else {

			if($lang = Modules::load_file($_langfile, $path, 'lang')) {
				if ($return) return $lang;
				$this->language = array_merge($this->language, $lang);
				$this->is_loaded[] = $langfile.'_lang'.EXT;
				unset($lang);
			}
		}
		
		return $this->language;
	}
}