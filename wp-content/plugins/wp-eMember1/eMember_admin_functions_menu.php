<?php
include_once('eMember_db_access.php');

function wp_eMember_admin_functions_menu()
{
    echo '<div class="wrap">';
    echo '<h2>WP eMember - Admin Functions v'.WP_EMEMBER_VERSION.'</h2>';
	echo '<div id="poststuff"><div id="post-body">';
		
    if (isset($_POST['generate_registration_link']))
    {
    	$errorMsg = "";
    	$eMember_member_id = (string)$_POST["eMember_member_id"];
    	       
        $member_record = dbAccess::find(WP_EMEMBER_MEMBERS_TABLE_NAME, ' member_id=\'' . $eMember_member_id . '\'');
        if($member_record)
        {
        	$md5_code = md5($member_record->reg_code);
		    $separator='?';
			$url=get_option('eMember_registration_page');
			if(empty($url))
			{
				$errorMsg .= "<br />You need to specify the registration URL in the pages settings menu of this plugin.";
			}
			else
			{
				if(strpos($url,'?')!==false)
				{
					$separator='&';
				}
				$reg_url = $url.$separator.'member_id='.$eMember_member_id.'&code='.$md5_code;     
			}   	
        }  
        else
        {
        	$errorMsg .= "<br />Could not find the member ID in the database";
        }            
        
        $message="";
        if (!empty($errorMsg))
        {
        	$message = $errorMsg;
        }
        else
        {
        	$message = 'Registration Link Generated!';
        }
        echo '<div id="message" class="updated fade"><p><strong>';
        echo $message;
        echo '</strong></p></div>';  
    }
    if (isset($_POST['generate_and_send_registration_link']))
    {
    	$errorMsg = "";
    	$eMember_member_id = (string)$_POST["eMember_member_id"];
    	       
        $member_record = dbAccess::find(WP_EMEMBER_MEMBERS_TABLE_NAME, ' member_id=\'' . $eMember_member_id . '\'');
        if($member_record)
        {
        	$md5_code = md5($member_record->reg_code);
		    $separator='?';
			$url=get_option('eMember_registration_page');
			if(empty($url))
			{
				$errorMsg .= "<br />You need to specify the registration URL in the pages settings menu of this plugin.";
			}
			else
			{
				if(strpos($url,'?')!==false)
				{
					$separator='&';
				}
				$reg_url = $url.$separator.'member_id='.$eMember_member_id.'&code='.$md5_code;     
			} 
			
			$email = $member_record->email;	
	    	$subject = get_option('eMember_email_subject');
			$body = get_option('eMember_email_body');
			$from_address = get_option('senders_email_address');		
		    $tags = array("{first_name}","{last_name}","{reg_link}");
		    $vals = array($member_record->first_name,$member_record->last_name,$reg_url);
			$email_body    = str_replace($tags,$vals,$body);
		    $headers = 'From: '.$from_address . "\r\n";
	        wp_mail($email,$subject,$email_body,$headers);                			  	
        }  
        else
        {
        	$errorMsg .= "<br />Could not find the member ID in the database";
        }            
        

            
        $message="";
        if (!empty($errorMsg))
        {
        	$message = $errorMsg;
        }
        else
        {
        	$message = "Member registration completion email successfully sent to:".$email;
        }
        echo '<div id="message" class="updated fade"><p><strong>';
        echo $message;
        echo '</strong></p></div>';  
    }    
    if(isset($_POST['emem_to_wp'])){
		   global $wpdb;
           $member_table = WP_EMEMBER_MEMBERS_TABLE_NAME;    	
           $ret_member_db = $wpdb->get_results("SELECT * FROM $member_table ", OBJECT);           
           foreach($ret_member_db as $emember){
           	   
           	   if(!username_exists($emember->user_name)){
           	   	   $role_names = array(1=>'Administrator',2=>'Editor',3=>'Author',4=>'Contributor',5=>'Subscriber');  
			       $membership_level_resultset = dbAccess::find(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, " id='" .$emember->membership_level . "'" );						                	                    
                   $wp_user_info  = array();
                   $wp_user_info['user_nicename'] = implode('-', explode(' ', $emember->user_name));
                   $wp_user_info['display_name']  = $emember->user_name;
                   $wp_user_info['nickname']      = $emember->user_name;
                   $wp_user_info['first_name']    = $emember->first_name;
                   $wp_user_info['last_name']     = $emember->last_name;
	               $wp_user_info['role']            = $role_names[$membership_level_resultset->role];
    	           $wp_user_info['user_registered'] = date('Y-m-d H:i:s');                	
                   
                   $wp_user_id = wp_create_user($emember->user_name, 'changeme', $emember->email);                        
                   $wp_user_info['ID'] = $wp_user_id;
                   wp_update_user( $wp_user_info );
                   //$wpdb->query("UPDATE  $wpdb->users set user_pass = \'" . $emember->password . '\' WHERE ID = ' . $wp_user_id);
                   $user_info = get_userdata($wp_user_id);
                   $user_cap = is_array($user_info->wp_capabilities)?array_keys($user_info->wp_capabilities):array();

                   if(!in_array('administrator',$user_cap))                   
                       update_wp_user_Role($wp_user_id, $membership_level_resultset->role);           	   	           	   	   
           	   }
           }
           echo '<div id="message" class="updated fade"><p>WordPress user account creation complete!</p></div>';    	
    }
   
    ?>
	<div class="postbox">
	<h3><label for="title">Generate a Registration Completion link</label></h3>
	<div class="inside">
	You can manually generate a registration completion link here and give it to your customer if they have missed the email that was automatically sent out to them after the payment.<br />
    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">    
        
    <table width="100%" border="0" cellspacing="0" cellpadding="6">
    <tr valign="top"><td width="25%" align="right">
    <strong>Member ID: </strong>
    </td><td align="left">
    <input name="eMember_member_id" type="text" size="5" value="<?php echo $eMember_member_id; ?>" />
    <br /><i>(i) Enter the member ID (you can get the member ID from the members menu).</i><br /><br />
    </td></tr>
    
    <tr valign="top"><td width="25%" align="right">
    </td><td align="left">
    <input type="submit" name="generate_registration_link" value="<?php _e('Generate Link'); ?> &raquo;" />
    <br /><i>(ii) Hit the "Generate Link" button.</i><br /><br />
    </td></tr>    
    <tr valign="top"><td width="25%" align="right">
    <strong>Registration Link: </strong>
    </td><td align="left">
    <textarea name="wp_eStore_rego_link" rows="3" cols="80"><?php echo $reg_url; ?></textarea>
    <br /><i>This is the registration completion link.</i><br />
    </td></tr>
    </table>
    </form>
	</div></div>
	
	<div class="postbox">
	<h3><label for="title">Generate and Email the Registration Completion link</label></h3>
	<div class="inside">
	You can generate a registration completion link and email it to your customer in one go. This can be useful if they have missed the email that was automatically sent out to them after the payment.<br />
    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">    
        
    <table width="100%" border="0" cellspacing="0" cellpadding="6">
    <tr valign="top"><td width="25%" align="right">
    <strong>Member ID: </strong>
    </td><td align="left">
    <input name="eMember_member_id" type="text" size="5" value="<?php echo $eMember_member_id; ?>" />
    <br /><i>(i) Enter the member ID (you can get the member ID from the members menu).</i><br /><br />
    </td></tr>
    
    <tr valign="top"><td width="25%" align="right">
    </td><td align="left">
    <input type="submit" name="generate_and_send_registration_link" value="<?php _e('Generate & Email Link'); ?> &raquo;" />
    <br /><i>(ii) Hit the "Generate & Email Link" button.</i><br /><br />
    </td></tr>    

    </table>
    </form>
	</div></div>
		
	<div class="postbox">
	<h3><label for="title">Create WordPress User Account for the members that do not have one</label></h3>
	<div class="inside">
	<strong>If you have a lot of eMember members that do not have a corresponding WordPress user account and for some reason you wanted to create WordPress user account for them then use this option.</strong>
	<br /><br />
	&raquo; When you use this option the plugin will create wordpress user accounts for every eMember user that does not have a corresponding WordPress account already.
	<br />
	&raquo; The WordPress user accounts will be created with the same details from eMember but the password will be set to "changeme" (The user will have to change the password to their liking). 
	<br />
	&raquo; Why? The password is kept in the database using an one way encryption so nobody except the member knows what the real password is.
	<br /><br />
	    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
	    <input type="submit" name="emem_to_wp" value="<?php _e('Create WP account for eMember users'); ?> &raquo;" />
	    </form>	
	</div></div>	
    <?php
    echo '</div></div>';
    echo '</div>';
}
?>