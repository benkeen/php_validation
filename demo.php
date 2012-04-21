<?php

$errors = array(); // set the errors array to empty, by default
$fields = array(); // stores the field values
$success_message = "";

if (isset($_POST['submit']))
{
  // import the validation library
  require_once("validation-2.3.3.php");

  $rules = array(); // stores the validation rules

  // standard form fields
  $rules[] = "required,user_name,This field is required.";
  $rules[] = "required,email,Please enter your email address.";
  $rules[] = "valid_email,email,Please enter a valid email address.";

  // date fields
  $rules[] = "valid_date,any_date_month,any_date_day,any_date_year,any_date,Please enter a valid date.";
  $rules[] = "valid_date,later_date_month,later_date_day,later_date_year,later_date,Please enter an date later than today.";

  // Numbers / alphanumeric fields
  $rules[] = "required,any_integer,Please enter an integer.";
  $rules[] = "digits_only,any_integer,This field may only contain digits.";
  $rules[] = "digits_only,number_range,This field may only contain digits.";
  $rules[] = "range=1-100,number_range,Please enter a number between 1 and 100.";
  $rules[] = "range>100,number_range_greater_than,Please enter a number greater than 100.";
  $rules[] = "range>=100,number_range_greater_than_or_equal,Please enter a number greater than or equal to 100.";
  $rules[] = "range<100,number_range_less_than,Please enter a number less than 100.";
  $rules[] = "range<=100,number_range_less_than_or_equal,Please enter a number less than or equal to 100.";
  $rules[] = "letters_only,letter_field,Please only enter letters (a-Z) in this field.";
  $rules[] = "required,alpha_field,Please enter an alphanumeric (0-9 a-Z) string.";
  $rules[] = "is_alpha,alpha_field,Please only enter alphanumeric characters (0-9 a-Z) in this field.";
  $rules[] = "custom_alpha,custom_alpha_field1,LLL-VVV,Please enter a string of form LLL-VVV - where L is an uppercase letter and V is an uppercase vowel.";
  $rules[] = "custom_alpha,custom_alpha_field2,DDxxx,Please enter a string of form DDxxx.";
  $rules[] = "custom_alpha,custom_alpha_field3,EEXX,Please enter a string of form EEXX.";
  $rules[] = "custom_alpha,custom_alpha_field4,VVvvllFF,Please enter a string of form VVvvllFF.";
  $rules[] = "custom_alpha,custom_alpha_field5,#XccccCCCC,Please enter a string of form #XccccCCCC.";
  $rules[] = "reg_exp,reg_exp_field1,^\\s*(red|orange|yellow|green|blue|indigo|violet|pink|white)\\s*$,Please enter your favourite colour in lowercase (e.g. \"red\" or \"blue\")";
  $rules[] = "required,reg_exp_field2,Please enter your favourite colour (e.g. \"red\" or \"blue\")";
  $rules[] = "reg_exp,reg_exp_field2,^\\s*(red|orange|yellow|green|blue|indigo|violet|pink|white)\\s*$,i,Please enter your favourite colour (e.g. \"red\" or \"blue\")";


  // Length of field input
  $rules[] = "length=2,char_length,Please enter a value that is exactly two characters long.";
  $rules[] = "length=3-5,char_length_range,Please enter a value that is between 3 and 5 characters in length.";
  $rules[] = "length>5,char_length_greater_than,Please enter a value that is over 5 characters long.";
  $rules[] = "length>=5,char_length_greater_than_or_equal,Please enter a value that is at least 5 characters long.";
  $rules[] = "length<5,char_length_less_than,Please enter a value that is less than 5 characters long.";
  $rules[] = "length<=5,char_length_less_than_or_equal,Please enter a value that is less than or equal to 5 characters.";

  // password fields
  $rules[] = "required,password,Please enter a password.";
  $rules[] = "same_as,password,password_2,Please ensure the passwords you enter are the same.";

  // conditional (if-else) fields
  $rules[] = "required,gender,Please enter your gender.";
  $rules[] = "if:gender=male,required,male_question,Please enter the name of your favourite Care Bear.";
  $rules[] = "if:gender=female,required,female_question,Please indicate what max weight you can bench.";

  $errors = validateFields($_POST, $rules);

  // if there were errors, re-populate the form fields
  if (!empty($errors))
  {
    $fields = $_POST;
  }

  // no errors! redirect the user to the thankyou page (or whatever)
  else
  {
    $message = "All fields have been validated successfully!";

    // here you would either email the form contents to someone or store it in a database.
    // To redirect to a "thankyou" page, you'd just do this:
    // header("Location: thanks.php");
  }
}


// don't worry about these. This is just for illustration purposes: it sets a DEFAULT value to some
// fields, which is overwritten when the user fills it in
if (!isset($fields["custom_alpha_field1"])) $fields["custom_alpha_field1"] = "BCD-AEI";
if (!isset($fields["custom_alpha_field2"])) $fields["custom_alpha_field2"] = "aB012";
if (!isset($fields["custom_alpha_field3"])) $fields["custom_alpha_field3"] = "bB34";
if (!isset($fields["custom_alpha_field4"])) $fields["custom_alpha_field4"] = "OUoucgAa";
if (!isset($fields["custom_alpha_field5"])) $fields["custom_alpha_field5"] = "#8rtyhWRGS";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>PHP Validation Demo</title>

<style type="text/css">
<!--
body,p,table,td,input,select {
  font-family: verdana, tahoma;
	font-size: 8pt;
  line-height: 14pt;
}
.demoTable {
  background-color: #efefef;
  width: 100%;
}
.title { font-family: arial; font-size: 16pt; }
.section { font-size: 11pt; color: #3366cc; }
.error {
  border: 1px solid red;
  background-color: #ffffee;
  color: #660000;
  width: 400px;
  padding: 5px;
}
.notify {
  border: 1px solid #336699;
  background-color: #ffffee;
  color: #336699;
  width: 400px;
  padding: 5px;
}
-->
</style>

</head>
<body>

<table cellspacing="0" width="600" align="center">
<tr>
  <td>

    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">

    <p class="title">PHP Validation Demo</p>

    <p>
      This form contains all the validation options that are offered by the
      <a href="index.php">PHP Validation library</a>. To see how this works, <a href="php_validation.zip">download
    	the zip file</a>. Since the <b>custom_alpha</b> options are quite advanced
    	and unlikely to be used that often (and because it's a pain figuring out a match
      for all of the cases!) I've filled in matching strings for those fields.
    </p>

    <br />

    <?php

    // if $errors is not empty, the form must have failed one or more validation
    // tests. Loop through each and display them on the page for the user
    if (!empty($errors))
    {
      echo "<div class='error' style='width:100%;'>Please fix the following errors:\n<ul>";
      foreach ($errors as $error)
        echo "<li>$error</li>\n";

      echo "</ul></div>";
    }

    if (!empty($message))
    {
      echo "<div class='notify'>$success_message</div>";
    }
    ?>

    <p class="section">Standard form fields</p>

    <table class="demoTable">
    <tr>
      <td>Required field:</td>
    	<td><input type="text" name="user_name" value="<?=$fields['user_name']?>" /></td>
    </tr>
    <tr>
      <td>Email:</td>
    	<td><input type="text" name="email" value="<?=$fields['email']?>" /></td>
    </tr>
    </table>

    <p class="section">Date fields</p>

    <table class="demoTable">
    <tr>
      <td>Any (valid) date</td>
    	<td>
        <select name="any_date_month">
        	<option value="">mm</option>
        	<?php
    			for ($i=1; $i<=12; $i++)
          {
            echo "<option value='$i'";
            if ($fields["any_date_month"] == $i)
              echo " selected";
            echo ">$i</option>";
          }
          ?>
        </select>
        <select name="any_date_day">
        	<option value="">dd</option>
        	<?php
    			for ($i=1; $i<=31; $i++)
          {
            echo "<option value='$i'";
            if ($fields["any_date_day"] == $i)
              echo " selected";
            echo ">$i</option>";
          }
          ?>
        </select>
        <select name="any_date_year">
        	<option value="">yyyy</option>
        	<?php
    			for ($i=2005; $i>=1900; $i--)
          {
            echo "<option value='$i'";
            if ($fields["any_date_year"] == $i)
              echo " selected";
            echo ">$i</option>";
          }
          ?>
        </select>
    	</td>
    </tr>
    <tr>
      <td>Any later date:</td>
    	<td>
        <select name="later_date_month">
        	<option value="">mm</option>
        	<?php
    			for ($i=1; $i<=12; $i++)
          {
            echo "<option value='$i'";
            if ($fields["later_date_month"] == $i)
              echo " selected";
            echo ">$i</option>";
          }
          ?>
        </select>
        <select name="later_date_day">
        	<option value="">dd</option>
        	<?php
    			for ($i=1; $i<=31; $i++)
          {
            echo "<option value='$i'";
            if ($fields["later_date_day"] == $i)
              echo " selected";
            echo ">$i</option>";
          }
          ?>
        </select>
        <select name="later_date_year">
        	<option value="">yyyy</option>
        	<?php
    			for ($i=2010; $i>=1900; $i--)
          {
            echo "<option value='$i'";
            if ($fields["later_date_year"] == $i)
              echo " selected";
            echo ">$i</option>";
          }
          ?>
        </select>
    	</td>
    </tr>
    </table>


    <p class="section">Numbers / alphanumeric fields</p>

    <table class="demoTable">
    <tr>
      <td width="230">Any integer:</td>
    	<td width="350"><input type="text" name="any_integer" value="<?=$fields['any_integer']?>" /></td>
    </tr>
    <tr>
      <td>Enter a number from 1-100:</td>
    	<td><input type="text" name="number_range" value="<?=$fields['number_range']?>" /></td>
    </tr>
    <tr>
      <td>Enter a number greater than 100:</td>
    	<td><input type="text" name="number_range_greater_than" value="<?=$fields['number_range_greater_than']?>" /></td>
    </tr>
    <tr>
      <td>Enter a number greater than or equal to 100:</td>
    	<td><input type="text" name="number_range_greater_than_or_equal" value="<?=$fields['number_range_greater_than_or_equal']?>" /></td>
    </tr>
    <tr>
      <td>Enter a number less than 100:</td>
    	<td><input type="text" name="number_range_less_than" value="<?=$fields['number_range_less_than']?>" /></td>
    </tr>
    <tr>
      <td>Enter a number less than or equal to 100:</td>
    	<td><input type="text" name="number_range_less_than_or_equal" value="<?=$fields['number_range_less_than_or_equal']?>" /></td>
    </tr>
    <tr>
      <td>Enter any letter:</td>
    	<td><input type="text" name="letter_field" value="<?=$fields['letter_field']?>" /> (optional)</td>
    </tr>
    <tr>
      <td>Enter any alphanumeric characters:</td>
    	<td><input type="text" name="alpha_field" value="<?=$fields['alpha_field']?>" /> (required)</td>
    </tr>
    <tr>
      <td>Enter strings in the fields according to the following legend:</td>
    	<td>

    	  <table cellspacing="0" style="background-color: #ffffcc; border: 1px solid #555555; width:100%">
    	  <tr>
    	    <th width="20">L</th>
    	    <td>An uppercase letter.</td>
    	    <th width="20">V</th>
    	    <td>An uppercase vowel.</td>
    	  </tr>
    	  <tr>
    	    <th>l</th>
    	    <td>A lowercase letter.</td>
    	    <th>v</th>
    	    <td>A lowercase vowel.</td>
    	  </tr>
    	  <tr>
    	    <th>D</th>
    	    <td>A letter (upper or lower)</td>
    	    <th>F</th>
    	    <td>A vowel (upper or lower)</td>
    	  </tr>
    	  <tr>
    	    <th>C</th>
    	    <td>An uppercase Consonant</td>
    	    <th>x</th>
    	    <td>Any number, 0-9</td>
    	  </tr>
    	  <tr>
    	    <th>c</th>
    	    <td>A lowercase consonant</td>
    	    <th>X</th>
    	    <td>Any number, 1-9</td>
    	  </tr>
    	  <tr>
    	    <th>E</th>
    	    <td colspan="3">A consonant (upper or lower)</td>
    	  </tr>
    	  </table>

        <table cellspacing="0">
        <tr>
          <td><input type="text" name="custom_alpha_field1" value="<?=$fields['custom_alpha_field1']?>" /> LLL-VVV</td>
        </tr>
        <tr>
          <td><input type="text" name="custom_alpha_field2" value="<?=$fields['custom_alpha_field2']?>" /> DDxxx</td>
        </tr>
        <tr>
          <td><input type="text" name="custom_alpha_field3" value="<?=$fields['custom_alpha_field3']?>" /> EEXX</td>
        </tr>
        <tr>
          <td><input type="text" name="custom_alpha_field4" value="<?=$fields['custom_alpha_field4']?>" /> VVvvllFF</td>
        </tr>
        <tr>
          <td><input type="text" name="custom_alpha_field5" value="<?=$fields['custom_alpha_field5']?>" /> #XccccCCCC</td>
        </tr>
        </table>

        <br />

      </td>
    </tr>
    <tr>
      <td>Enter your favourite colour:</td>
    	<td><input type="text" name="reg_exp_field1" value="<?=$fields['reg_exp_field1']?>" /> (lowercase, optional)</td>
    </tr>
    <tr>
      <td>Enter your favourite colour:</td>
    	<td><input type="text" name="reg_exp_field2" value="<?=$fields['reg_exp_field2']?>" /> (case-insensitive, required)</td>
    </tr>
    </table>

    <p class="section">Length of field input</p>

    <table class="demoTable">
    <tr>
      <td>Enter 2 characters:</td>
    	<td><input type="text" name="char_length" value="<?=$fields['char_length']?>" /></td>
    </tr>
    <tr>
      <td>Enter between 3 and 5 chars:</td>
    	<td><input type="text" name="char_length_range" value="<?=$fields['char_length_range']?>" /></td>
    </tr>
    <tr>
      <td>Enter over 5 characters:</td>
    	<td><input type="text" name="char_length_greater_than" value="<?=$fields['char_length_greater_than']?>" /></td>
    </tr>
    <tr>
      <td>Enter at least 5 characters:</td>
    	<td><input type="text" name="char_length_greater_than_or_equal" value="<?=$fields['char_length_greater_than_or_equal']?>" /></td>
    </tr>
    <tr>
      <td>Enter less than 5 characters:</td>
    	<td><input type="text" name="char_length_less_than" value="<?=$fields['char_length_less_than']?>" /></td>
    </tr>
    <tr>
      <td>Enter less than or equal to 5 characters:</td>
    	<td><input type="text" name="char_length_less_than_or_equal" value="<?=$fields['char_length_less_than_or_equal']?>" /></td>
    </tr>
    </table>

    <p class="section">Password fields</p>

    <table class="demoTable">
    <tr>
      <td>Enter a password:</td>
    	<td><input type="password" name="password" value="<?=$fields['password']?>" /></td>
    </tr>
    <tr>
      <td>Enter a password (re-enter):</td>
    	<td><input type="password" name="password_2" value="<?=$fields['password_2']?>" /></td>
    </tr>
    </table>

    <p class="section">Conditional (if-else) fields</p>

    <table class="demoTable">
    <tr>
      <td>Your gender:</td>
    	<td>
    	  <input type="radio" name="gender" value="male" <?php if ($fields['gender'] == 'male') echo 'checked'; ?> />Male
    		<input type="radio" name="gender" value="female" <?php if ($fields['gender'] == 'female') echo 'checked'; ?> />Female
    	</td>
    </tr>
    <tr>
      <td>Who's your favourite Care Bear? (Men):</td>
    	<td><input type="text" name="male_question" value="<?=$fields['male_question']?>" /></td>
    </tr>
    <tr>
      <td>How much can you bench (Women):</td>
    	<td><input type="text" name="female_question" value="<?=$fields['female_question']?>" /></td>
    </tr>
    </table>

    <p><input type="submit" name="submit" value="SUBMIT" /></p>

    </form>

    <br />

  </td>
</tr>
</table>

</body>
</html>
