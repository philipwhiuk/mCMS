<?php

// This PHP module implements an agent for the University of Cambridge
// Web Authentication System
//
// See http://raven.cam.ac.uk/ for more details
//
// Copyright (c) 2004, 2005, 2007, 2008 University of Cambridge
//
// This module is free software; you can redistribute it and/or modify
// it under the terms of the GNU Lesser General Public License as
// published by the Free Software Foundation; either version 2.1 of the
// License, or (at your option) any later version.
//
// The module is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
// Lesser General Public License for more details.
//
// You should have received a copy of the GNU Lesser General Public
// License along with this toolkit; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307
// USA
//
// $Id: ucam_webauth.php,v 1.13 2008/06/18 12:02:29 jml4 Exp jml4 $
//
// See function module_version() below for current version number.

class Ucam_Webauth {

  var $DEFAULT_PROTOCOL_VERSION = '1';	// default protocol version
  var $SESSION_TICKET_VERSION = '1';
  var $DEFAULT_AUTH_SERVICE = 'https://raven.cam.ac.uk/auth/authenticate.html';
  var $DEFAULT_KEY_DIR = '/etc/httpd/conf/webauth_keys';
  var $DEFAULT_COOKIE_NAME = 'Ucam-WebAuth-Session';
  var $DEFAULT_TIMEOUT_MESSAGE = 'your logon to the site has expired';
  var $DEFAULT_DEBUG_LOGGING = 0;	// default debug logging level
  var $DEFAULT_HOSTNAME = NULL;         // must be supplied explicitly
  var $COMPLETE = 1;
  var $TESTSTRING = 'Test';

  // array index constants

  var $SESSION_TICKET_VER = 0;
  var $SESSION_TICKET_STATUS = 1;
  var $SESSION_TICKET_MSG = 2;
  var $SESSION_TICKET_ISSUE = 3;
  var $SESSION_TICKET_EXPIRE = 4;
  var $SESSION_TICKET_ID = 5;
  var $SESSION_TICKET_PRINCIPAL = 6;
  var $SESSION_TICKET_AUTH = 7;
  var $SESSION_TICKET_SSO = 8;
  var $SESSION_TICKET_PARAMS = 9;
  var $SESSION_TICKET_SIG = 10;

  var $WLS_TOKEN_VER = 0;
  var $WLS_TOKEN_STATUS = 1;
  var $WLS_TOKEN_MSG = 2;
  var $WLS_TOKEN_ISSUE = 3;
  var $WLS_TOKEN_ID = 4;
  var $WLS_TOKEN_URL = 5;
  var $WLS_TOKEN_PRINCIPAL = 6;
  var $WLS_TOKEN_AUTH = 7;
  var $WLS_TOKEN_SSO = 8;
  var $WLS_TOKEN_LIFE = 9;
  var $WLS_TOKEN_PARAMS = 10;
  var $WLS_TOKEN_KEYID = 11;
  var $WLS_TOKEN_SIG = 12;
  
  var $do_session;
  var $cookie_key;
  var $cookie_path;
  var $session_ticket;
  var $auth_service;
  var $description;
  var $response_timeout;
  var $clock_skew;
  var $hostname;
  var $key_dir;
  var $max_session_life;
  var $timeout_message;
  var $cookie_name;
  var $cookie_domain;
  var $fail;
  var $status;
  var $headers;

  var $error_message = array('200' => 'OK',
                             '410' => "Authentication cancelled at user's request",
                             '510' => 'No mutually acceptable types of authentication available',
                             '520' => 'Unsupported authentication protocol version',
                             '530' => 'Parameter error in authentication request',
                             '540' => 'Interaction with the user would be required',
                             '550' => 'Web server and authentication server clocks out of sync',
                             '560' => 'Web server not authorized to use the authentication service',
                             '570' => 'Operation declined by the authentication service');

  function Ucam_Webauth($args) {
    if (isset($args['auth_service'])) $this->auth_service = $args['auth_service'];
    else $this->auth_service = $this->DEFAULT_AUTH_SERVICE;

    if (isset($args['description'])) $this->description = $args['description'];

    if (isset($args['response_timeout'])) $this->response_timeout = $args['response_timeout'];
    else $this->response_timeout = 30;

    if (isset($args['clock_skew'])) $this->clock_skew = $args['clock_skew'];
    else $this->clock_skew = 5;

    if (isset($args['key_dir'])) $this->key_dir = $args['key_dir'];
    else $this->key_dir = $this->DEFAULT_KEY_DIR;

    if (isset($args['do_session'])) $this->do_session = $args['do_session'];
    else $this->do_session = TRUE;

    if (isset($args['max_session_life'])) $this->max_session_life = $args['max_session_life'];
    else $this->max_session_life = 2*60*60;

    if (isset($args['timeout_message'])) $this->timeout_message = $args['timeout_message'];
    else $this->timeout_message = $this->DEFAULT_TIMEOUT_MESSAGE;

    if (isset($args['cookie_key'])) $this->cookie_key = $args['cookie_key'];

    if (isset($args['cookie_name'])) $this->cookie_name = $args['cookie_name'];
    else $this->cookie_name = $this->DEFAULT_COOKIE_NAME;

    if (isset($args['cookie_path'])) $this->cookie_path = $args['cookie_path'];
    else $this->cookie_path = ''; // *** SHOULD BE PATH RELATIVE PATH TO SCRIPT BY DEFAULT ***

    if (isset($args['hostname'])) $this->hostname = $args['hostname'];
    else $this->hostname = $this->DEFAULT_HOSTNAME;

    // NB Although any protocol version can be set, protocol versions other
    // than 1 and 2 will not work unless they are supported by the
    // authentication server and also are sufficiently compatible at the
    // protocol level that this module can understand the responses. 
    //
    // Version 2 protocol is identical to version 1, but causes the
    // WLS response to include all query arguments that were present in the 
    // original request - though it does not force the authentication server
    // to send V2 responses, and at least for "user cancelled authentication",
    // a V1 response (with only the WLS-Response query argument) is sent.

    if (isset($args['protocol_version'])) $this->protocol_version = $args['protocol_version'];
    else $this->protocol_version = $this->DEFAULT_PROTOCOL_VERSION;

    if (isset($args['debug_logging'])) $this->debug_logging = $args['debug_logging'];
    else $this->debug_logging = $this->DEFAULT_DEBUG_LOGGING;

    // COOKIE PATH CAN BE NULL, DEFAULTS TO CURRENT DIRECTORY (TEST)
 
    if (isset($args['cookie_domain'])) $this->cookie_domain = $args['cookie_domain'];
    else $this->cookie_domain = '';
    
    if (isset($args['fail'])) $this->fail = $args['fail'];
    else $this->fail = '';
  }

  // Function to return this module's version number - added at version 0.61,
  // not found in prior versions (so if get_class_methods() can't find it, an
  // older version is being used.
  // 
  // Call as e.g. $version = Ucam_Webauth::module_version();

  function module_version() {
    return '0.62';
  }

  // get/set functions for agent attributes

  function auth_service($arg = NULL) {
    if (isset($arg)) $this->auth_service = $arg;
    return $this->auth_service;
  }

  function description($arg = NULL) {
    if (isset($arg)) $this->description = $arg;
    return $this->description;
  }

  function response_timeout($arg = NULL) {
    if (isset($arg)) $this->response_timeout = $arg;
    return $this->response_timeout;
  }

  function clock_skew($arg = NULL) {
    if (isset($arg)) $this->clock_skew = $arg;
    return $this->clock_skew;
  }

  function key_dir($arg = NULL) {
    if (isset($arg)) $this->key_dir = $arg;
    return $this->key_dir;
  }

  function do_session($arg = NULL) {
    if (isset($arg)) $this->do_session = $arg;
    return $this->do_session;
  }

  function max_session_life($arg = NULL) {
    if (isset($arg)) $this->max_session_life = $arg;
    return $this->max_session_life;
  }

  function timeout_message($arg = NULL) {
    if (isset($arg)) $this->timeout_message = $arg;
    return $this->timeout_message;
  }

  function cookie_key($arg = NULL) {
    if (isset($arg)) $this->cookie_key = $arg;
    return $this->cookie_key;
  }

  function cookie_name($arg = NULL) {
    if (isset($arg)) $this->cookie_name = $arg;
    return $this->cookie_name;
  }

  function cookie_path($arg = NULL) {
    if (isset($arg)) $this->cookie_path = $arg;
    return $this->cookie_path;
  }

  function cookie_domain($arg = NULL) {
    if (isset($arg)) $this->cookie_domain = $arg;
    return $this->cookie_domain;
  }

  function fail($arg = NULL) {
    if (isset($arg)) $this->fail = $arg;
    return $this->fail;
  }

  function protocol_version($arg = NULL) {
    if (isset($arg)) $this->protocol_version = $arg;
    return $this->protocol_version;
  }

  function debug_logging($arg = NULL) {
    if (isset($arg)) $this->debug_logging = $arg;
    return $this->debug_logging;
  }

  function hostname($arg = NULL) {
    if (isset($arg)) $this->hostname = $arg;
    return $this->hostname;
  }

  // read-only functions to access the authentication state
 
  function status() {
    if (isset($this->session_ticket[$this->SESSION_TICKET_STATUS]))
      return $this->session_ticket[$this->SESSION_TICKET_STATUS];
    return NULL;
  }

  function success() {
    if (isset($this->session_ticket[$this->SESSION_TICKET_STATUS]))
      return ($this->session_ticket[$this->SESSION_TICKET_STATUS] == '200');
    return NULL;
  }

  function msg() {
    if (isset($this->session_ticket[$this->SESSION_TICKET_MSG]))
      return $this->session_ticket[$this->SESSION_TICKET_MSG];
    return NULL;
  }

  function issue() {
    if (isset($this->session_ticket[$this->SESSION_TICKET_ISSUE]))
      return $this->session_ticket[$this->SESSION_TICKET_ISSUE];
    return NULL;
  }

  function expire() {
    if (isset($this->session_ticket[$this->SESSION_TICKET_EXPIRE]))
      return $this->session_ticket[$this->SESSION_TICKET_EXPIRE];
    return NULL;
  }

  function id() {
    if (isset($this->session_ticket[$this->SESSION_TICKET_ID]))
      return $this->session_ticket[$this->SESSION_TICKET_ID];
    return NULL;
  }

  function principal() {
    if (isset($this->session_ticket[$this->SESSION_TICKET_PRINCIPAL]))
      return $this->session_ticket[$this->SESSION_TICKET_PRINCIPAL];
    return NULL;
  }

  function auth() {
    if (isset($this->session_ticket[$this->SESSION_TICKET_AUTH]))
      return $this->session_ticket[$this->SESSION_TICKET_AUTH];
    return NULL;
  }

  function sso() {
    if (isset($this->session_ticket[$this->SESSION_TICKET_SSO]))
      return $this->session_ticket[$this->SESSION_TICKET_SSO];
    return NULL;
  }

  function params() {
    if (isset($this->session_ticket[$this->SESSION_TICKET_PARAMS]))
      return $this->session_ticket[$this->SESSION_TICKET_PARAMS];
    return NULL;
  }

  // authentication functions

  function using_https() {
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on");
  }

  function load_key($key_id) {
    $key_filename = $this->key_dir . '/' . $key_id . '.crt';
    if (file_exists($key_filename)) {
      $key_file = fopen($key_filename, 'r');
      $key = fread($key_file, filesize($key_filename));
      fclose($key_file);
      return $key;
    }
    return NULL;
  }

  function check_sig($data, $sig, $key_id) {

    // **** TODO : remove trailing slash from key_dir

    $key_filename = $this->key_dir . '/' . $key_id . '.crt';
    $key_file = fopen($key_filename, 'r');
    // Band-aid test for the most obvious cause of error - whole
    // thing needs improvement
    if (!$key_file) {
      error_log('Failed to open key file ' . $key_filename,0);
      return false;
    }
    $key_str = fread($key_file, filesize($key_filename));
    $key = openssl_get_publickey($key_str);
    fclose($key_file);
    $result = openssl_verify($data, $this->wls_decode($sig), $key);
    openssl_free_key($key);
    return $result;
  }
    
  function hmac_sha1($key, $data) {
    $blocksize = 64;
    if (strlen($key) > $blocksize)
      $key = pack('H*', sha1($key));
    $key = str_pad($key, $blocksize, chr(0x00));
    $ipad = str_repeat(chr(0x36), $blocksize);
    $opad = str_repeat(chr(0x5c), $blocksize);
    $hmac = pack('H*', sha1(($key^$opad).pack('H*', sha1(($key^$ipad).$data))));
    return $this->wls_encode(bin2hex($hmac));
  }

  function hmac_sha1_verify($key, $data, $sig) {
    return ($sig == $this->hmac_sha1($key, $data));
  }

  function hostnames_match()
  {
    // $_SERVER['HTTP_HOST'] is hostname or hostname:port; construct an 
    // equivalent for comparison using the configured hostname.

    $ourhost = strtolower($this->hostname);
    $ourport = $_SERVER{'SERVER_PORT'};
    if ($this->using_https()) {
      $protocol = 'https://';
      if ($ourport == '443') $port = '';
    } else {
      $protocol = 'http://';
      if ($ourport == '80') $port = '';
    }
    if ($ourport != '') $ourhost .= ":$ourport";
    return ! isset($_SERVER['HTTP_HOST']) or 
	$ourhost == strtolower($_SERVER['HTTP_HOST']);
  }

  function url() {
    $hostname = urlencode($this->hostname);
    $port = $_SERVER{'SERVER_PORT'};
    if ($this->using_https()) {
      $protocol = 'https://';
      if ($port == '443') $port = '';
    } else {
      $protocol = 'http://';
      if ($port == '80') $port = '';
    }
    $port = urlencode($port);           // should be redundant, of course
    $url = $protocol . $hostname;
    if ($port != '') $url .= ':' . $port;
    $url .= $_SERVER['SCRIPT_NAME'];
    if (isset($_SERVER['PATH_INFO'])) $url .= $_SERVER['PATH_INFO'];
    if (isset($_SERVER['QUERY_STRING']) and $_SERVER['QUERY_STRING'] != '')
    {
      $url .= '?' . $_SERVER['QUERY_STRING'];
    }
    return $url;
  }

  function full_cookie_name() {
    if ($this->using_https()) {
      return $this->cookie_name . '-S';
    }
    return $this->cookie_name;
  }

  function time2iso($t) {
    //return gmstrftime('%Y%m%d', $t).'T'.gmstrftime('%H%M%S', $t).'Z';
    return gmdate('Ymd\THis\Z', $t);
  }

  function iso2time($t) {
    return gmmktime(substr($t, 9, 2),
                    substr($t, 11, 2),
                    substr($t, 13, 2),
                    substr($t, 4, 2),
                    substr($t, 6, 2),
                    substr($t, 0, 4),
                    -1);
  }

  function wls_encode($str) {
    $result = base64_encode($str);
    $result = preg_replace(array('/\+/', '/\//', '/=/'), array('-', '.', '_'), $result);
    return $result;
  }

  function wls_decode($str) {
    $result = preg_replace(array('/-/', '/\./', '/_/'), array('+', '/', '='), $str);
    $result = base64_decode($result);
    return $result;
  }

  // validate_cookie() - if one of "our" session cookies exists, it is
  // validated and if valid, the content (including authentication status) 
  // is extracted and stored in the Ucam_Webauth object. 
  //
  // Returns true if the validation process succeeded, but that does not mean
  // a cookie was necessarily found, and even if a cookie was found it may 
  // have been invalid or the session may have expired.
  //
  // Before relying on any other values from the cookie, check the status 
  // code - for anything other than success, only the status and msg values
  // are likely to be set and/or meaningful.

  function validate_cookie() {
    // check that someone defined cookie key and if we are doing session management

    if ($this->do_session and !isset($this->cookie_key)) {
      $this->session_ticket[$this->SESSION_TICKET_STATUS] = '600';
      $this->session_ticket[$this->SESSION_TICKET_MSG] = 'No key defined for session cookie';
      return TRUE;;
    }

    // Validating existing session is meaningless if not doing sessions...
    if (! $this->do_session)
    {
      $this->session_ticket[$this->SESSION_TICKET_STATUS] = '600';
      $this->session_ticket[$this->SESSION_TICKET_MSG] = 'No session management, so cannot validate session';
      return TRUE;
    }

    // Check that the hostname is set explicitly (since we cannot trust
    // the Host: header); if it returns false (i.e. not set), return TRUE
    // (meaning we've done all we can), since it will have set appropriate
    // error status and message text in $this.

    if (! $this->_check_hostname()) return TRUE;

    /* If we are doing session management then see if we already
     * have authentication data stored in a cookie. Note that if the
     * stored status isn't 200 (OK) then we destroy the cookie so that if
     * we come back through here again we will fall through and repeat
     * the authentication. We do this first so that replaying an old
     * authentication response won't trigger a 'stale authentication' error
     */

    if ($this->debug_logging > 0) {
	error_log('VALIDATING ANY EXISTING WLS SESSION COOKIE', 0);
    }

    $current_timeout_message = NULL;

    if ($this->do_session) {
      if ($this->debug_logging > 0) {
	error_log('session management ON', 0);
      }

      if (isset($_COOKIE[$this->full_cookie_name()]) and
          $_COOKIE[$this->full_cookie_name()] != $this->TESTSTRING) {

	if ($this->debug_logging > 0) {
          error_log('existing authentication cookie found', 0);
          error_log('cookie: ' . $_COOKIE[$this->full_cookie_name()]);
	}

        $old_cookie = explode(' ', rawurldecode($_COOKIE[$this->full_cookie_name()]));
        $this->session_ticket = explode('!', $_COOKIE[$this->full_cookie_name()]);
	foreach (array_keys($this->session_ticket) as $field) {
		$this->session_ticket[$field] = 
			rawurldecode($this->session_ticket[$field]);
	}

        $values_for_verify = $this->session_ticket;
        $sig = array_pop($values_for_verify);

        if ($this->hmac_sha1_verify($this->cookie_key,
                                    implode('!', array_map('rawurlencode',$values_for_verify)),
                                    $sig)) {

	  if ($this->debug_logging > 0) {
            error_log('existing authentication cookie verified', 0);
	  }

          $issue = $this->iso2time($this->session_ticket[$this->SESSION_TICKET_ISSUE]);
          $expire = $this->iso2time($this->session_ticket[$this->SESSION_TICKET_EXPIRE]);
          $now = time();

          if ($issue <= $now and $now < $expire) {
            if ($this->session_ticket[$this->SESSION_TICKET_STATUS] != '200') {
              setcookie($this->full_cookie_name(),
                        '',
                        1,
                        $this->cookie_path,
                        $this->cookie_domain,
                        $this->using_https());

            }
	    if ($this->debug_logging > 0) {
              error_log('AUTHENTICATION COMPLETE', 0);
	    }
            return TRUE;
          } else {
            $current_timeout_message = $this->timeout_message;
	    if ($this->debug_logging > 0) {
              error_log('local session cookie expired', 0);
              error_log('issue/now/expire: ' . $issue . '/' . $now . '/' . $expire);
	    }
          }
        } else {
	  if ($this->debug_logging > 0) {
            error_log('AUTHENTICATION FAILED, session cookie sig invalid', 0);
	  }
          $this->session_ticket[$this->SESSION_TICKET_STATUS] = '600';
          $this->session_ticket[$this->SESSION_TICKET_MSG] = 'Invalid session cookie';
          return TRUE;
        }
      }
    }


    return FALSE;
  }

  function validate_response() {

    /* Look to see if we are being invoked as the callback from
     * this WLS. If so, validate the response. If we are not doing session
     * management then we can then just return. If we are doing session
     * management, check that the session cookie already exists with a
     * test value (because otherwise we probably don't have cookies
     * enabled), set it, and redirect back to the original URL to clear
     * the browser's location bar of the WLS response.
     */

    if ($this->debug_logging > 0) {
      error_log('VALIDATING WLS RESPONSE');
    }

    // Check that the hostname is set explicitly (since we cannot trust
    // the Host: header); if it returns false (i.e. not set), return TRUE
    // (meaning we've done all we can), since it will have set appropriate
    // error status and message text in $this.

    if (! $this->_check_hostname()) return TRUE;

    $token = NULL;

    if (isset($_GET['WLS-Response'])) {    
      if ($this->debug_logging > 0) {
        error_log('WLS response: ' . $_GET['WLS-Response'], 0);
      }

      $token = explode('!', $_GET['WLS-Response']);
      $rawtoken = $token;
      foreach (array_keys($token) as $field) {
        $token[$field] = rawurldecode($token[$field]);
      }
      $this->session_ticket[$this->SESSION_TICKET_STATUS] = '200';
      $this->session_ticket[$this->SESSION_TICKET_MSG] = '';
      /*
      $key = $this->load_key($token[$this->WLS_TOKEN_KEYID]);

      if ($key == NULL) {
        $this->session_ticket[$this->SESSION_TICKET_MSG] = 'Failed to load '.$this->key_dir . '/' . $token[$this->WLS_TOKEN_KEYID] . '.crt';
        $this->session_ticket[$this->SESSION_TICKET_STATUS] = '600';
        return $this->COMPLETE;
      }
      */
      //echo '<p>' . implode('!', $token) . '</p>';
      $sig = array_pop($rawtoken);
      $key_id = array_pop($rawtoken);
      array_pop($token);		// lose signature
      array_pop($token);		// lose key ID

      if ($token[$this->WLS_TOKEN_VER] > $this->protocol_version) {
        $this->session_ticket[$this->SESSION_TICKET_MSG] = 'Wrong protocol version in authentication service reply';
        $this->session_ticket[$this->SESSION_TICKET_STATUS] = '600';
      } else if ($token[$this->WLS_TOKEN_STATUS] != '200') {
        $this->session_ticket[$this->SESSION_TICKET_MSG] = $this->error_message[$token[$this->WLS_TOKEN_STATUS]];
        if (isset($token[$this->WLS_TOKEN_MSG])) $this->session_ticket[$this->SESSION_TICKET_MSG] .= $token[$this->WLS_TOKEN_MSG];
        $this->session_ticket[$this->SESSION_TICKET_STATUS] = $token[$this->WLS_TOKEN_STATUS];
      } else if ($this->check_sig(implode('!', $rawtoken), $sig, $key_id) != 1) {
        $this->session_ticket[$this->SESSION_TICKET_MSG] = 'Invalid WLS token signature';
        $this->session_ticket[$this->SESSION_TICKET_STATUS] = '600';
        return TRUE;
      } else {
        $now = time();
        $issue = $this->iso2time($token[$this->WLS_TOKEN_ISSUE]);

        if (!isset($issue)) {
          $this->session_ticket[$this->SESSION_TICKET_MSG] = 'Unable to read issue time in authentication service reply';
          $this->session_ticket[$this->SESSION_TICKET_STATUS] = '600';
        } else if ($issue > $now + $this->clock_skew + 1) {
          $this->session_ticket[$this->SESSION_TICKET_MSG] = 'Authentication service reply apparently issued in the future: ' . $token[$this->WLS_TOKEN_ISSUE];
          $this->session_ticket[$this->SESSION_TICKET_STATUS] = '600';
        } else if ($now - $this->clock_skew - 1 > $issue + $this->response_timeout) {
          $this->session_ticket[$this->SESSION_TICKET_MSG] = 'Stale authentication service reply issue at ' . $token[$this->WLS_TOKEN_ISSUE];
          $this->session_ticket[$this->SESSION_TICKET_STATUS] = '600';
        }

        $response_url = $token[$this->WLS_TOKEN_URL];
        $response_url = preg_replace('/\?.*$/', '', $response_url);
        $this_url = preg_replace('/\?.+$/', '', $this->url());

        if ($this_url != $response_url) {
	  if ($this->debug_logging > 0) {
	    error_log("webauth request and response URLs don't match");
	   }
          $this->session_ticket[$this->SESSION_TICKET_MSG] = 'URL in response ticket doesn\'t match this URL: ' . $response_url . ' != ' . $this_url;
          $this->session_ticket[$this->SESSION_TICKET_STATUS] = '600';
        }
      }
      
      // work out session expiry time

      $expiry = $this->max_session_life;
      if (isset($token[$this->WLS_TOKEN_LIFE]) and $token[$this->WLS_TOKEN_LIFE] > 0 and $token[$this->WLS_TOKEN_LIFE] < $expiry) $expiry = $token[$this->WLS_TOKEN_LIFE];
      
      // populate session ticket with information collected so far
      
      $this->session_ticket[$this->SESSION_TICKET_ISSUE] = $this->time2iso(time());
      $this->session_ticket[$this->SESSION_TICKET_EXPIRE] = $this->time2iso(time() + $expiry);
      $this->session_ticket[$this->SESSION_TICKET_ID] = $token[$this->WLS_TOKEN_ID];
      $this->session_ticket[$this->SESSION_TICKET_PRINCIPAL] = $token[$this->WLS_TOKEN_PRINCIPAL];
      $this->session_ticket[$this->SESSION_TICKET_AUTH] = $token[$this->WLS_TOKEN_AUTH];
      $this->session_ticket[$this->SESSION_TICKET_SSO] = $token[$this->WLS_TOKEN_SSO];
      $this->session_ticket[$this->SESSION_TICKET_PARAMS] = $token[$this->WLS_TOKEN_PARAMS];

      // return complete if we are not doing session management
      
      if (!$this->do_session) return TRUE;
      
      // otherwise establish a session cookie to maintain the
      // session ticket. First check that the cookie actually exists
      // with a test value, because it should have been created
      // previously and if its not there we'll probably end up in
      // a redirect loop.
      
      if (!isset($_COOKIE[$this->full_cookie_name()]) or
          $_COOKIE[$this->full_cookie_name()] != $this->TESTSTRING) {
        $this->session_ticket[$this->SESSION_TICKET_STATUS] = '610';
        $this->session_ticket[$this->SESSION_TICKET_MSG] = 'Browser is not accepting session cookie';
        return TRUE;
      }

      $this->session_ticket[$this->SESSION_TICKET_VER] = $this->SESSION_TICKET_VERSION;
      
      // This used to use ksort and implode, but appeared to produce
      // broken results from time to time. This does the work the hard
      // way.

      $cookie = '';
      for ($i=0; $i<$this->SESSION_TICKET_PARAMS; $i++) {
        if (isset($this->session_ticket[$i])) 
          $cookie .= rawurlencode($this->session_ticket[$i]);
        $cookie .= '!';
      }

      if (isset($this->session_ticket[$this->SESSION_TICKET_PARAMS])) 
        $cookie .= rawurlencode($this->session_ticket[$this->SESSION_TICKET_PARAMS]);

      $sig = $this->hmac_sha1($this->cookie_key, $cookie);
      $cookie .= '!' . $sig;
      if ($this->debug_logging > 0) {
        error_log('new cookie: ' . $cookie); 
      }

      // End

      setcookie($this->full_cookie_name(),
                $cookie,
                0,
                $this->cookie_path,
                $this->cookie_domain,
                $this->using_https());

      if ($this->debug_logging > 0) {
        error_log('session cookie established, redirecting...', 0);
      }
      
      header('Location: ' . $token[$this->WLS_TOKEN_URL]);
      
      return TRUE;
    }

    return FALSE;                       // no WLS response query argument
  }  

  // Invoke WLS to authenticate the user, regardless of the existing 
  // authentication state (i.e. even if there's a valid WLS session cookie
  // or a valid unprocessed WLS response), for use in cases where you 
  // really, really want to refresh the authentication (and maybe, via 
  // $interact, force a password dialogue).

  function invoke_wls($aauth = NULL, $interact = NULL, $fail = NULL, $parameters = NULL) {

    // Check that the hostname is set explicitly (since we cannot trust
    // the Host: header); if it returns false (i.e. not set), return TRUE
    // (meaning we've done all we can), since it will have set appropriate
    // error status and message text in $this.

    if (! $this->_check_hostname()) return TRUE;

    // log a warning if being used to authenticate POST requests

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      error_log('Ucam_WebAuth PHP Agent invoked for POST request, which it does\'nt really support', 0);
    }

    /* Send a request to the WLS. If we are doing session
     * management then set a test value cookie so we can test that
     * it's still available when we get back.
     */

    if ($this->debug_logging > 0) {    
      error_log('REDIRECTING to WLS FOR AUTHENTICATION', 0);
    }
    
    if ($this->do_session) {
      // If the hostname from the request (Host: header) does not match the
      // server's preferred name for itself (which should be what's configured
      // as hostname), cookies are likely to break "randomly" (or more
      // accurately, the cookie may not be sent by the browser since it's for
      // a different hostname) as a result of following links that use the
      // preferred name, or server-level redirects e.g. to fix "directory"
      // URLs lacking the trailing "/". Attempt to avoid that by redirecting
      // to an equivalent URL using the configured hostname.

      if (! $this->hostnames_match())
      {
          header('Location: ' . $this->url());
          return FALSE;
      }
      
      error_log('setting pre-session cookie', 0);
      setcookie($this->full_cookie_name(),
                $this->TESTSTRING,
                0,
                $this->cookie_path,
                $this->cookie_domain,
                $this->using_https());
    }
    
    $dest = 'Location: ' . $this->auth_service .
      '?ver=' . $this->protocol_version .
      '&url=' . rawurlencode($this->url());
    if (isset($this->description)) $dest .= '&desc=' . rawurlencode($this->description);
    if (isset($aauth)) $dest .= '&aauth=' . rawurlencode($aauth);
    if (isset($interact)) $dest .= '&iact=' . rawurlencode($interact);
    if (isset($parameters)) $dest .= '&params=' . rawurlencode($parameters);
    if (isset($current_timeout_message)) $dest .= '&msg=' . rawurlencode($current_timeout_message);
    if (isset($this->clock_skew)) {
      $dest .= '&date=' . rawurlencode($this->time2iso(time())) .
        '&skew=' . rawurlencode($this->clock_skew);
    }
    if (!isset($fail) and isset($this->fail)) $fail = $this->fail;
    if ($fail) $dest .= '&fail=yes';
    
    if ($this->debug_logging > 0) {
      error_log('redirecting...', 0);
    }
    
    header($dest);
    
    return FALSE;
  }

  // authenticate() will 
  //  * check for a valid/current session cookie, and return success if found
  //  * process an authentication response (URL with WLS-Response query 
  //    argument), if present
  //  * request authentication, if neither of the above applies

  function authenticate($aauth = NULL, $interact = NULL, $fail = NULL, $parameters = NULL) {
    // check that someone defined cookie key and if we are doing session management

    if ($this->do_session and !isset($this->cookie_key)) {
      $session_ticket['status'] = '600';
      $session_ticket['msg'] = 'No key defined for session cookie';
      return TRUE;;
    }

    IF ($this->validate_cookie()) return TRUE;

    IF ($this->validate_response()) return TRUE;

    return $this->invoke_wls($aauth, $interact, $fail, $parameters);

  }

  // logout() makes a "best efforts" attempt to log the user out of a
  // Ucam_Webauth cookie-based session. It will do nothing if Ucam_Webauth
  // session cookies are not enabled, and does not return a result (since to
  // do so would be misleading - it has no way of knowing if the cookie 
  // deletion needed to effect logout actually succeeds).
  // 
  // It relies on the browser to delete the cookie in response to a redirection
  // to the current page (with a header indicating the cookie should be 
  // deleted), and that could be ignored by the browser - working for many 
  // browsers is no guarantee it will work for all browsers.
  //
  // ALSO NOTE that this does not affect the Raven authentication state for
  // other servers to which the user has authenticated, or log out any
  // Raven single sign-on session. It only affects authentication on the 
  // server requesting the logout - or more specifically, authentication on 
  // that server using the session cookie named in the Ucam_Webauth object.

  function logout() {
    if ($this->do_session) {
      if ($this->debug_logging > 0) {
        error_log('CLEARING WLS SESSION COOKIE', 0);
      }
      setcookie($this->full_cookie_name(),
        '',				// null value
        0,				// expired long ago
        $this->cookie_path,
        $this->cookie_domain,
        $this->using_https());
      $dest = 'Location: ' . $this->url();
      header($dest);
    }
  }

  // _check_hostname() checks that the hostname option has been set, since it
  // it is mandatory. If set (value itself is not checked), TRUE is returned.
  // Otherwise, false is returned after setting an appropriate error status
  // and message text.

  private function _check_hostname()
  {
    if ($this->hostname != '') return TRUE;

    $this->session_ticket[$this->SESSION_TICKET_MSG] = 
	'Ucam_Webauth configuration error - mandatory hostname not defined';
    $this->session_ticket[$this->SESSION_TICKET_STATUS] = '600';
    error_log('hostname not set in Ucam_Webauth object, but is mandatory');
    return FALSE;
  }
}

?>
