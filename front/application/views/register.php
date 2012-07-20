<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $page_title; ?></title>
<link href="<?php echo base_url(); ?>styles/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-21124488-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>

<body class="<?php echo $body_classes; ?>">

<div id="top">

<div id="register">
		
        <h2><a href="<?php echo base_url(); ?>" class="formLogo">Town.ee Real time town buzz</a></h2>
       
		<form action="<?php echo site_url('users/register');?>" method="post" class="register">
        
      
       
       <p>Register for free!</p>
       <?php echo validation_errors(); ?>
       <ol>
       
       <li> 
       <label>Username</label>
        <input type="text" name="username" value="" placeholder="username" id="username" autofocus>
        </li>
        
   <li>
    <label>Password</label>
    <input type="password" name="password" value="" placeholder="password" id="password">
    </li>
 
        <li>
        <label>E-mail Address</label>
    <input type="text" name="email" value="" placeholder="example@domain.com" id="email">
    </li>
   
   
 
    
    
 <li>
    <label>Select Your City</label>
    <select name="location">
<?php foreach($locations as $town) : ?>
<option value="<?php echo $town->lid; ?>"><?php echo $town->name; ?></option>
<?php endforeach; ?>
</select>
</li>

<li>
<input type="submit" name="register" value="Register" class="submit">
</li>


</ol>






</form>	</div>

</div>

</body>
</html>