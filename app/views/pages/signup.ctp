<?php
echo $form->create('User',array('url' => array('controller' => 'pages','action' => 'signup')));
echo $form->input("username");
echo $form->input("password");
echo $form->input("fname");
echo $form->input("lname");
echo $form->input("phonenum");
echo $form->input("company");
echo $form->end("zakhire kon");
?>