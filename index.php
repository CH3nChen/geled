<html>
<head>
<title>Hack Factory LED Light control server</title>
</head>
<h1>Hack Factory LED Light control server</h1>
<body>
<?php

require_once 'HTML/QuickForm2.php';
$form = new HTML_QuickForm2('LEDControl');

$init =    $form->addElement('submit', 'init', array('value' => 'Init'));
$clear =   $form->addElement('submit', 'clear', array('value' => 'Clear'));
$chase =   $form->addElement('submit', 'chase', array('value' => 'Chase'));
$reset =   $form->addElement('submit', 'reset', array('value' => 'Reset'));

$str =    $form->addElement('text', 'str', array('size' => 5, 'maxlength' => 5));
$str->setLabel('Enter String Number, or range separated by dash');

$addr =    $form->addElement('text', 'addr', array('size' => 5, 'maxlength' => 5));
$addr->setLabel('Enter Bulb Address, or range separated by dash');

$bright =    $form->addElement('text', 'bright', array('size' => 3, 'maxlength' => 3));
$bright->setLabel('Enter Brightness, max 204');

$red =    $form->addElement('text', 'red', array('size' => 5, 'maxlength' => 5));
$red ->setLabel('Enter red, or range separated by dash');

$green =    $form->addElement('text', 'green', array('size' => 5, 'maxlength' => 5));
$green ->setLabel('Enter green, or range separated by dash');

$blue =    $form->addElement('text', 'blue', array('size' => 5, 'maxlength' => 5));
$blue ->setLabel('Enter blue, or range separated by dash');

$delay =    $form->addElement('text', 'delay', array('size' => 10, 'maxlength' => 10));
$delay ->setLabel('Enter delay in microseconds between instructions');

$bulb = $form->addElement('submit', 'bulb', array('value' => 'Set lights!'));


$display = $form->addElement('submit', 'display', array('value' => 'Toggle Display'));

$message = $form->addElement('text', 'message', array('size' => 50, 'maxlength' => 255));
$change_message = $form->addElement('submit', 'change_message', array('value' => 'Change Message'));


if (strlen($message->getValue()) > 0 && $change_message->getValue() == 'Change Message')
{
    echo "<p>Changing Message to " . $message->getValue() . "</p>";
    echo "<pre>\n";
    $cmd = "rm message.h";
    echo $cmd . ":\n";
    system($cmd);
    $cmd = "MESSAGE=" . escapeshellarg($message->getValue()) . " make";
    echo $cmd . ":\n";
    system($cmd);
    $cmd = "make upload";
    echo $cmd . ":\n";
    system($cmd);
    echo "</pre><p>...done.</p>";
}

$cmd = "./drive ";
if (strlen($str->getValue()) > 0)
    $cmd .= "--string=" . $str->getValue() . " ";

if (strlen($addr->getValue()) > 0)
    $cmd .= "--addr=" . $addr->getValue() . " ";

if (strlen($bright->getValue()) > 0)
    $cmd .= "--bright=" . $bright->getValue() . " ";

if (strlen($red->getValue()) > 0)
    $cmd .= "--red=" . $red->getValue() . " ";

if (strlen($green->getValue()) > 0)
    $cmd .= "--green=" . $green->getValue() . " ";

if (strlen($blue->getValue()) > 0)
    $cmd .= "--blue=" . $blue->getValue() . " ";

if (strlen($delay->getValue()) > 0)
    $cmd .= "--delay=" . $delay->getValue() . " ";


$description = NULL;
if ($init->getValue() == "Init")
{
    $description = "Initializing LEDs";
    $cmd .= "init";
}

else if ($clear->getValue() == "Clear")
{
    $description = "Turnning off LEDs";
    $cmd .= "clear";
}
else if ($chase->getValue() == "Chase")
{
    $description = "Running chase from 0-49 across LEDs";
    $cmd .= "chase";
}
else if ($reset->getValue() == "Reset")
{
    $description = "Running make reset";
    $cmd = "make reset";
}
else if ($display->getValue() == "Toggle Display")
{
    $description = "Toggle display of message";
    $cmd .= "display";
}
else if ($bulb->getValue() == "Set lights!")
{
    $description = "Set the lights on";
    $cmd .= "bulb";
}




if ($description)
{
    echo "<p>" . $description . "...<br>";
    echo "<pre>\n";
    echo $cmd . ":\n";
    system($cmd);
    echo "</pre><p>...done.</p>";
}
else
{
    echo "<h2>\n";
    system("./drive status");
    echo "</h2>\n";
}

$form2 = new HTML_QuickForm2('LEDControl');

/*
$rc = $form2->validate(); 
if ($rc)
    echo "<p> true</p>";
else
    echo "<p> false</p>";

{
    echo "<p>validate returns ";
    print_r($rc);
    echo "</p>";
//echo '<h1>Hello, ' . htmlspecialchars($name->getValue()) . '!</h1>';
//exit;
}

*/

// Output the form
echo $form;
echo $form2;

?>
</body>
</html>