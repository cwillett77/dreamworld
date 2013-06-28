<?php
require_once("/var/config.php");
require_once("./db/DbInterface.php");
require_once("./db/MysqlAdapter.php");
require_once("./classes/User.php");



if(isset($_POST['submit'])) {

	require_once("./classes/Validate.php");

	//assign post data to variables 
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$email = trim($_POST['email']);

	//start validating our form
	$v = new Validate();
	$v->validateStr($firstname, "first name", 3, 75);
	$v->validateStr($lastname, "last name", 3, 75);
	$v->validateEmail($email, "email");

	if(!$v->hasErrors()) {
		$data = array(
			"firstname"=>$firstname,
			"lastname"=>$lastname,
			"email"=>$email
		);
		$user = new User($db_config, $data);
		$user->insertData();
	} else {
		//set the number of errors message
		$message_text = $v->errorNumMessage();

		//store the errors list in a variable
		$errors = $v->displayErrors();
		
		//get the individual error messages
		$firstnameErr = $v->getError("firstname");
		$lastnameErr = $v->getError("lastname");
		$emailErr = $v->getError("email");
	}//end error check
} else {
	$user = new User($db_config);
}

$user->select("users");
$rows = $user->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Chris Willett's ORM Demo for Dreamworld</title>
<link type="text/css" href="styles.css" rel="stylesheet" />
</head>
<body>
	<div id="contact_form_wrap">
		<?php if(isset($errors)) echo $errors; ?>
		<?php if(isset($_POST['sent'])): ?><h2>Your info has been submitted</h2><?php endif; ?>
		<form id="contact_form" method="post" action=".">
			<p><label>First Name:<br />
			<input type="text" name="firstname" class="textfield" value="<?php if(isset($firstname)) echo htmlentities($firstname); ?>" />
			</label><br /><span class="errors"><?php if(isset($firstnameErr)) echo $firstnameErr; ?></span></p>
			
			<p><label>Last Name:<br />
			<input type="text" name="lastname" class="textfield" value="<?php if(isset($lastname)) echo htmlentities($lastname); ?>" />
			</label><br /><span class="errors"><?php if(isset($lastnameErr)) echo $lastnameErr; ?></span></p>
			
			<p><label>Email: <br />
			<input type="text" name="email" class="textfield" value="<?php if(isset($email)) echo htmlentities($email); ?>" />
			</label><br /><span class="errors"><?php if(isset($emailErr)) echo $emailErr ?></span></p>		  
			
			<p><input type="submit" name="submit" class="button" value="Submit" /></p>
		</form>
	</div>
	
	<?php if(!empty($rows)) {?>
		<table cellspacing="0" cellpadding="4">
			<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Date</th></th>
		<?php foreach($rows as $row) {?>
			<tr>
				<td><?php echo $row['id'];?></td>
				<td><?php echo $row['firstname'];?></td>
				<td><?php echo $row['lastname'];?></td>
				<td><?php echo $row['email'];?></td>
				<td><?php echo $row['date'];?></td>
			</tr>
		<?php }?>
		</table>
	<?php }?>
	
</body>
</html>


