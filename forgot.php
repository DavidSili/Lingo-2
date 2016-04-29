<?php 
include 'config.php';
$changeform=0;
if (isset($_GET['forgot'])) {
	if ($_GET['forgot']==1) {
		$email=$_POST['email'];
		$email=stripslashes($email);
		$email=mysql_real_escape_string($email);
		if ($email!="") {
			$forgot=md5(uniqid(rand(), true));
		
			$sql = "SELECT * FROM users WHERE `email` = '$email'";
			$result = $mysqli->query($sql) or die;
			$row=$result->fetch_assoc();
			$user = $row['username'];
			if (mysql_num_rows($result)==1) {
			
				$query = "UPDATE users SET `forgot`='$forgot'";
				$mysqli->query($sql) or die;

				if($result){

				$to=$email;
				$subject="Zahtev za ponovno postavljanje šifre";
				$headers = "MIME-Version: 1.0\n";  
				$headers .= "Content-type: text/plain; charset=utf-8\n";  
				$headers .= "To: ".$user." <".$to.">\n";  
				$headers .= "From: Lingo 2.0 <no-reply@vodicbg.com>\n";  
				$headers .= "Reply-To: Lingo 2.0 <no-reply@vodicbg.com>\n";  
				$headers .= "Return-Path: Lingo 2.0 <no-reply@vodicbg.com>\n";
  				$message=$user.", ovo je vaš link za ponovno postavljanje nove šifre.\n";
				$message.="Kliknite na ovaj link da bi je resetovali:\n";
				$message.="http://bugarska-ruza.rs/lingo/forgot.php?forgot=2&user=$user&passkey=$forgot\n";
				$fifth = "-f no-reply@vodicbg.com";
				$sentmail = mail($to,$subject,$message,$headers,$fifth);
				}

				mysql_close();
				header("refresh: 5; url=login.php");
				echo '<div style="background:#fff;-moz-border-radius: 7px;border-radius: 7px;border: 2px #333 solid;padding:5px;text-align:center;font-weight:bold;color:#55d">Ukoliko ste ispravno uneli e-mail adresu, e-mail sa linkom za promenu šifre je poslat na vašu e-mail adresu</div>';
				
			}

		}
		
	}
	elseif ($_GET['forgot']==2) {
	
		$passkey=$_GET['passkey'];
		$user=$_GET['user'];
		$passkey=stripslashes($passkey);
		$passkey=$mysqli->real_escape_string($passkey);
		$user=stripslashes($user);
		$user=$mysqli->real_escape_string($user);
		
		$sql="SELECT * FROM users WHERE username ='$user'";
		$result = $mysqli->query($sql) or die;
		$num=mysqli_num_rows($result);
		if($num==1){
			$row=$result->fetch_assoc();
			$forgot=$row['forgot'];
			if ($forgot==$passkey) $changeform=1;
			else echo '<div style="background:#fff;-moz-border-radius: 7px;border-radius: 7px;border: 2px #333 solid;padding:5px;text-align:center;font-weight:bold;color:#d55">Pogrešan kod za izmenu</div>';
			
		}
		else echo '<div style="background:#fff;-moz-border-radius: 7px;border-radius: 7px;border: 2px #333 solid;padding:5px;text-align:center;font-weight:bold;color:#d55">Pogrešan kod za izmenu</div>';


	}
	elseif ($_GET['forgot']==3) {
	
		$passkey=$_GET['passkey'];
		$user=$_GET['user'];
		$passkey=stripslashes($passkey);
		$passkey=$mysqli->real_escape_string($passkey);
		$user=stripslashes($user);
		$user=$mysqli->real_escape_string($user);
		$passsent1=$_POST['password1'];
		$passsent2=$_POST['password2'];
		$passsent1=stripslashes($passsent1);
		$passsent2=stripslashes($passsent2);
		$passsent1=$mysqli->real_escape_string($passsent1);
		$passsent2=$mysqli->real_escape_string($passsent2);

		if ($passsent1!=$passsent2) {
			header("refresh: 5; url=forgot.php?forgot=2&user=$user&passkey=$passkey");
			echo '<div style="background:#fff;-moz-border-radius: 7px;border-radius: 7px;border: 2px #333 solid;padding:5px;text-align:center;font-weight:bold;color:#d55">Šifre se ne poklapaju. Ili kliknite na: <a href="forgot.php?forgot=2&user=$user&passkey=$passkey">this link</a> ili sačekajte 5 sekundi da budete preusmereni.</div>';
		}
		else {
		
			$sql="SELECT * FROM users WHERE username ='$user'";
			$result = $mysqli->query($sql) or die;
			$row=$result->fetch_assoc();
			$salt=$row['salt'];
			$forgot=$row['forgot'];
			$email=$row['email'];
			$num=mysqli_num_rows($result);
			if($num==1){
				if ($forgot==$passkey) {
					$hash = hash('sha256', $passsent1);
					$hash = hash('sha256', $salt . $hash);

					$sql="UPDATE users SET `password`='$hash',`forgot`='' WHERE `username`='$user'";
					$result = $mysqli->query($sql) or die;
					
					$to=$email;
					$subject="Vaša šifra je promenjena";
					$headers = "MIME-Version: 1.0\n";  
					$headers .= "Content-type: text/plain; charset=utf-8\n";  
					$headers .= "To: ".$user." <".$to.">\n";  
					$headers .= "From: Lingo 2.0 <no-reply@vodicbg.com>\n";  
					$headers .= "Reply-To: Lingo 2.0 <no-reply@vodicbg.com>\n";  
					$headers .= "Return-Path: Lingo 2.0 <no-reply@vodicbg.com>\n";
	  				$message=$user.", vaša šifra je promenjena\n";
					$message.="Ovde se možete prijaviti: http://bugarska-ruza.rs/lingo/login.php ili ukoliko imate bilo koja pitanja za administratora, možete poslati e-mail na ovu adresu: lingo@vodicbg.com";
					$fifth = "-f no-reply@vodicbg.com";
					$sentmail = mail($to,$subject,$message,$headers,$fifth);
					
					header("refresh: 5; url=login.php");
					echo '<div style="background:#fff;-moz-border-radius: 7px;border-radius: 7px;border: 2px #333 solid;padding:5px;text-align:center;font-weight:bold;color:#0a0">Uspešno ste promenili šifru</div>';
					
				}
				else echo '<div style="background:#fff;-moz-border-radius: 7px;border-radius: 7px;border: 2px #333 solid;padding:5px;text-align:center;font-weight:bold;color:#d55">Pogrešan kod za izmenu</div>';
				
			}
			else echo '<div style="background:#fff;-moz-border-radius: 7px;border-radius: 7px;border: 2px #333 solid;padding:5px;text-align:center;font-weight:bold;color:#d55">Pogrešan kod za izmenu</div>';

		}
		
	}

}

?>
<html>
<head profile="http://www.w3.org/2005/20/profile">
<link rel="icon"
	  type="image/png"
	  href="images/favicon.gif">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title id="Timerhead">Lingo 2.0 - Zaboravljeno korisničko ime/šifra</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<script src="js/jquery.min.js"></script>
<meta name="robots" content="noindex">
</head>
<body onload="setdis()">

<div id="logform">
<div style="text-align:center;margin:10px 0 20px;font-size:16px"><b>Zaboravljeno<br/>korisničko ime/šifra</b></div>
<?php
if ($changeform==1) {
?>
	<form name="form1" method="post" action="?forgot=3&passkey=<?php echo $passkey.'&user='.$user; ?>">
		<div><div class="loglcol">šifra: </div><input name="password1" id="sifra1" type="password" value="" onchange="check(),icheck1()"/>*</div>
		<div><div class="loglcol" style="margin:0">ponoviti šifru: </div><input name="password2" id="sifra2" type="password" value="" onchange="check(),icheck2()" />*</div>
		<div style="margin-top:10px;text-align:center"><input type="submit" name="submit1" id="submit1" value="Promeni šifru" /></div>
	</form>
<?php			
}
else {
?>
	<form name="form1" method="post" action="?forgot=1">
		<div><div class="loglcol">vaš email: </div><input name="email" type="text" />*</div>
		<div style="margin-top:10px;text-align:center"><input type="submit" name="submit2" value="Pošalji" /></div>
		<div id="blacklink" style="line-height:20px"><a href="login.php">Prijava</a><br/><a href="register.php">Registracija</a></div>
	</form>
<?php
}
?>
</div>
<script type="text/javascript">

function setdis() {
if(!document.getElementById("submit1")) {
	var submit1=document.getElementById("submit1");
	submit1.disabled=true;
}
}

/*
	Password Validator 0.1
	(c) 2007 Steven Levithan <stevenlevithan.com>
	MIT License
*/

function validatePassword (pw, options) {
	// default options (allows any password)
	var o = {
		lower:    0,
		upper:    0,
		alpha:    0, /* lower + upper */
		numeric:  0,
		special:  0,
		length:   [1, Infinity],
		custom:   [ /* regexes and/or functions */ ],
		badWords: [" "],
		badSequenceLength: 0,
		noQwertySequences: false,
		noSequential:      false
	};

	for (var property in options)
		o[property] = options[property];

	var	re = {
			lower:   /[a-z]/g,
			upper:   /[A-Z]/g,
			alpha:   /[A-Z]/gi,
			numeric: /[0-9]/g,
			special: /[\W_]/g
		},
		rule, i;

	// enforce min/max length
	if (pw.length < o.length[0] || pw.length > o.length[1])
		return false;

	// enforce lower/upper/alpha/numeric/special rules
	for (rule in re) {
		if ((pw.match(re[rule]) || []).length < o[rule])
			return false;
	}

	// enforce word ban (case insensitive)
	for (i = 0; i < o.badWords.length; i++) {
		if (pw.toLowerCase().indexOf(o.badWords[i].toLowerCase()) > -1)
			return false;
	}

	// enforce the no sequential, identical characters rule
	if (o.noSequential && /([\S\s])\1/.test(pw))
		return false;

	// enforce alphanumeric/qwerty sequence ban rules
	if (o.badSequenceLength) {
		var	lower   = "abcdefghijklmnopqrstuvwxyz",
			upper   = lower.toUpperCase(),
			numbers = "0123456789",
			qwerty  = "qwertyuiopasdfghjklzxcvbnm",
			start   = o.badSequenceLength - 1,
			seq     = "_" + pw.slice(0, start);
		for (i = start; i < pw.length; i++) {
			seq = seq.slice(1) + pw.charAt(i);
			if (
				lower.indexOf(seq)   > -1 ||
				upper.indexOf(seq)   > -1 ||
				numbers.indexOf(seq) > -1 ||
				(o.noQwertySequences && qwerty.indexOf(seq) > -1)
			) {
				return false;
			}
		}
	}

	// enforce custom regex/function rules
	for (i = 0; i < o.custom.length; i++) {
		rule = o.custom[i];
		if (rule instanceof RegExp) {
			if (!rule.test(pw))
				return false;
		} else if (rule instanceof Function) {
			if (!rule(pw))
				return false;
		}
	}

	// great success!
	return true;
}
function icheck1() {
var sifra1=document.getElementById("sifra1");
if (validatePassword(sifra1.value,{length:[6,14],lower:1,upper:1,numeric:1})==true)
{
sifra1.style.border="2px inset #0a0";
return true;
}
else
{
sifra1.style.border="2px inset #c00";
return false;
}
}
function icheck2() {
var sifra1=document.getElementById("sifra1");
var sifra2=document.getElementById("sifra2");
if ((sifra1.value==sifra2.value) && icheck1()==true )
{
sifra2.style.border="2px inset #0a0";
}
else
{
sifra2.style.border="2px inset #c00";
}
}
function check() {
var submit1=document.getElementById("submit1");
var sifra1=document.getElementById("sifra1").value;
var sifra2=document.getElementById("sifra2").value;

	if (validatePassword(sifra1,{length:[6,14],lower:1,upper:1,numeric:1})==true && (sifra1==sifra2))
	{
		submit1.disabled=false;
	}
	else {
		submit1.disabled=true;
	}

}

</script>
</body>
</html>