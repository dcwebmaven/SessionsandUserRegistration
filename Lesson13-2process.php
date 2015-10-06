<?php

#start the session before any output
session_start();

$customer_name = $_SESSION['name'];
if (!($customer_name)) {
   $customer_name = $_GET['name'];
}
$customer_email = $_SESSION['email'];
if (!($customer_email)) {
   $customer_email = $_GET['email'];
}


#Remember, if you place any output before a header() call, you'll get an error.
#We used the superglobal $_GET here 
if (!($customer_name && $customer_email )) {

   #with the header() function, no output can come before it.
   #echo "Please make sure you've filled in all required information.";

   $query_string = $_SERVER['QUERY_STRING'];
   #add a flag called "error" to tell contact_form.php that something needs fixing
   $url = "http://".$_SERVER['HTTP_HOST']."/downloadInputForm2.php?".$query_string."&error=1";
   header("Location: ".$url);
   exit();  //stop the rest of the program from happening
   
}

/* I was going to use this method to calculate the expiration date but I found a better way
#we want a deadline 7 days after the cookie date.
   $deadline_array = getdate();
   $deadline_day = $deadline_array['mday'] + 7;

   $deadline_stamp = mktime($deadline_array['hours'],$deadline_array['minutes'],$deadline_array['seconds'],
       $deadline_array['mon'],$deadline_day,$deadline_array['year']);
   $deadline_str = date("F d, Y", $deadline_stamp);
*/


if (isset($_GET['remember'])) {
   #the customer wants us to remember him/her for next time
   $_SESSION['name'] = $customer_name;
   $_SESSION['email'] = $customer_email;
}

//pull the value of the filename variable in so we can use it in the if statement
$filename = ($_GET['redirect']);
echo $filename; 

if ($customer_name && $customer_email && $filename) { 

include($_SERVER['DOCUMENT_ROOT'].$filename);
  
} else {
  echo "This is what happens when you don't follow instructions!";
 
}

/* Here's where I'll have the if then statement to stop them downloading it until 7 days have passed

if ($deadline_day < 7) {
     #if they already downloaded the software then they will get an error message as follows
     echo "Hello, ".$customer_name.". I'm sorry, but you can only download this software once every 7 days.  Please try again after ".$deadline_str.".";

} else if ($deadline_day > 7) {
    include($_SERVER['DOCUMENT_ROOT']."downloadWin-FF.html"); 
}

*/


?>