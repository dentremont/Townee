<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Functions class
 */
class Tool
{
	var $CI;

	function __construct()
	{
		$this->CI =& get_instance();
		//parent::__construct();
	}

	function isLoggedIn()
	{
		if($this->CI->session->userdata('logged_in')) {
			return true;
		} else {
			return false;
		}
	}
	
	function validDomain()
	{
		$this->CI->db->where('subdomain', SUBDOMAIN); 
		$query = $this->CI->db->get_where('locations');
		
		if( ! $query->num_rows() > 0) {
			return false;
		}
		
		return array_shift($query->result());
	}
		
	function accountMenu()
	{
		$link = '<ul>';
		if($this->isLoggedIn()) {
			// print account links
			$link .= '<li><p><span class="userName"><a href="'.site_url("users/settings").'">'.$this->CI->session->userdata('username')."!</a></span>";
			$link .= ' Welcome to '. $this->CI->session->userdata('location') .'</p></li><li><a class="logout" href="'.site_url("users/logout").'">Logout</a></li>';
		} else {
			// print login link
			$link .= '<li><a class="logout" href="'.site_url("users/login").'">Login</a></li>';
			$link .= '<li><a class="TopSignUp" href="'.site_url("users/register").'">Sign Up</a></li>';
		}
		$link .= '</ul>';
		return $link;
	}
	/*
	function timeAgo($time, $format = null)
	{
	   if($format == "human") {
	   	$time = human_to_unix($time);
	   }
	   
	   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	   $lengths = array("60","60","24","7","4.35","12","10");
	
	   $now = time();
	
	       $difference     = $now - $time;
	       $tense         = "ago";
	
	   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
	       $difference /= $lengths[$j];
	   }
	
	   $difference = round($difference);
	
	   if($difference != 1) {
	       $periods[$j].= "s";
	   }
	
	   return "$difference $periods[$j] ago ";
	}
	*/
	function timeAgo($ptime) {
	    $ptime = strtotime($ptime);
	    //$ptime = human_to_unix($ptime);
	    $etime = time() - $ptime;
	    if ($etime < 1) {
	        return '0 seconds ago';
	    }
	    
	    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
	                30 * 24 * 60 * 60       =>  'month',
	                24 * 60 * 60            =>  'day',
	                60 * 60                 =>  'hour',
	                60                      =>  'minute',
	                1                       =>  'second'
	                );
	    
	    foreach ($a as $secs => $str) {
	        $d = $etime / $secs;
	        if ($d >= 1) {
	            $r = floor($d);
	            return $r . ' ' . $str . ($r > 1 ? 's ago' : ' ago');
	        }
	    }
	}
	
	function emailUser($recipient, $subject, $message)
	{
		$this->CI->load->library('email');
		
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;
		$this->CI->email->initialize($config);
		
		$output = '<html><head>
					<style>
						body {
							background-color: #CCFFFF;
							font-family: Georgia, "Times New Roman", Times, serif;
							color: #333;
						}
						#content {
							width: 540px;
							margin: 30px auto;
						}
					</style>
					</head><body>';
		$output .= '<div id="content"><img src="http://townee.pixelbrushstudios.com/images/form_logo.gif"/>' . $message . '</div>';
		$output .= '</body></html>';
		
		$this->CI->email->from('mailman@town.ee', 'Town.ee');
		$this->CI->email->to($recipient);
		$this->CI->email->subject($subject);
		$this->CI->email->message($output);
		if( ! $this->CI->email->send() ) {
			$this->CI->email->print_debugger();
		}
	}
	
	function print_navigation()
	{
		$uri1 = $this->CI->uri->segment(1);
		$uri2 = $this->CI->uri->segment(2);
		if($uri2) {
			$uri = $uri1 . '/' . $uri2;
		} else {
			$uri = $uri1;
		}
		
		$active1='inactive';
		$active2='inactive';
		$active3='inactive';
		$active4='inactive';
		$active5='inactive';
		$active6='inactive';
		$active7='inactive';
		$active8='inactive';
		
		switch($uri) {
			case 'dash': $active1 = 'active';
			break;
			case 'topic/food': $active2 = 'active';
			break;
			case 'topic/lifestyle': $active3 = 'active';
			break;
			case 'topic/entertainment': $active4 = 'active';
			break;
			case 'topic/business': $active5 = 'active';
			break;
			case 'topic/sports': $active6 = 'active';
			break;
			case 'topic/favorites': $active7 = 'active';
			break;
			case 'topic/recent': $active8 = 'active';
			break;
			default: $active1 = 'inactive';
		}
		
		$output = '
		<ul>
			<li><a class="'.$active1.'" href="'. site_url('dash') . '">My Dashboard</a></li>
			<li><a class="'.$active2.'" href="'. site_url('topic/food') . '">Food</a></li>
			<li><a class="'.$active3.'" href="'. site_url('topic/lifestyle') . '">Lifestyle</a></li>
			<li><a class="'.$active4.'" href="'. site_url('topic/entertainment') . '">Entertainment</a></li>
			<li><a class="'.$active5.'" href="'. site_url('topic/business') . '">Business</a></li>
			<li><a class="'.$active6.'" href="'. site_url('topic/sports') . '">Sports</a></li>
			<li><a class="'.$active7.'" href="'. site_url('topic/favorites') . '">Town Favs</a></li>
			<li><a class="'.$active8.'" href="'. site_url('topic/recent') . '">Recent</a></li>
		</ul>';
		return $output;
	}
	
	function set_location()
	{
		if( $domain = $this->validDomain() ) {
			$location = $domain->lid;
		} else {
			redirect('http://lafayette.town.ee');
		}	
		/*
		if($this->CI->session->userdata('selected_location')) {
			$location = $this->CI->session->userdata('selected_location');
		} else {
			$location = 2434560;
		}
		*/
		return $location;
	}
	
	
}