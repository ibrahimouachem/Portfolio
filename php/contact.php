<?php
// declaration de nos variables
$array = array("firstname" => "", "name" => "", "email" => "", "phone" => "", "message" => "", "firstnameError" => "", "nameError" => "", "emailError" => "", "phoneError" => "", "messageError" => "", "isSuccess" => false);
	
	//adress email de reception
	$emailTo = "b.ouachem@live.fr";

	if ($_SERVER["REQUEST_METHOD"]=="POST"){
		
		$array["firstname"] = verifyinput($_POST["firstname"]);
		$array["name"] = verifyinput($_POST["name"]);
		$array["email"] = verifyinput($_POST["email"]);
		$array["phone"] = verifyinput($_POST["phone"]);
		$array["message"] = verifyinput($_POST["message"]);
		$array["isSuccess"] = true;
		$emailText = "";
	
		// si les chemps sont vide les msgs d'erreur
		
		if(empty($array["firstname"])){
			$array["firstnameError"] = "je veux connaitre ton prenom !";
			$array["isSuccess"] = false;
		}
		else{
			// le \n = <br>
			$emailText .= "Firstname: {$array["firstname"]}\n";
		}
		
		if(empty($array["name"])){
			$array["nameError"] = "Et oui je veux tout savoir. Meme ton nom !";
			$array["isSuccess"] = false;
		}
		else{
			$emailText .= "Name: {$array["name"]}\n";
		}
		
		if(!isEmail($array["email"])){
			$array["emailError"] = "C'est pas un email ça !";
			$array["isSuccess"] = false;
		}
		else{
			$emailText .= "email: {$array["email"]}\n";
		}
		
		if(!isPhone($array["phone"])){
			$array["phoneError"] = "Que des chiffres et des espaces";
			$array["isSuccess"] = false;
		}
		else{
			$emailText .= "Phone: {$array["phone"]}\n";
		}
		
		if(empty($array["message"])){
			$array["messageError"] = "Dis quelque chose !";
			$array["isSuccess"] = false;
		}
		else{
			$emailText .= "message: {$array["message"]}\n";
		}
		
		//succes et l'envoi de l'email
		
		if($array["isSuccess"]){
			$headers = "from: {$array["firstname"]} {$array["name"]} <{$array["email"]}>\r\nReply-to: {$array["email"]}";
			mail($emailTo, "Un message", $emailText, $headers);
			
			
		}
	//renvoyer le travail de php vers ajax
		   echo json_encode($array);
				
	}
//validation de num phone
function isPhone($var){
	return preg_match("/^[0-9 ]*$/", $var);
}

//validation d'email
	function isEmail($var){
		return filter_var($var, FILTER_VALIDATE_EMAIL);
	}

//cette fonction c'est pour netoyer le site des hakeurs ou parasites des hakeurs
	function verifyinput($var){
		$var = trim($var);
		$var = stripslashes($var);
		$var = htmlspecialchars($var);
		return $var;
	}
?>