<?php

require __DIR__ . '/Lab/AutoLoader/Loader.php';
$autoLoader = new \Lab\AutoLoader\Loader(__DIR__);

use Lab\Db\ { Connection, CustomerTable };
use Lab\Login\ { FormGen, FormValidator };

$message = '';
$config = include __DIR__ . '/login_form_lab_config.php';

// setup form object
$form = new FormGen($config['form']);

// check for post
if (isset($_POST['submit'])) {

    $validator = new FormValidator($config['validator']);
    if ($validator->validate($_POST, $form)) {
        // do database lookup
        $table = new CustomerTable(new Connection($config['database']));
        $message = 'Form is Valid';
    } else {
        $form->setErrors($validator->getErrors());
        $message = 'Form is NOT Valid';
    }
}
if ($message) {
    echo '<h1>' . $message . '</h1>';
}
echo '<hr>Enter your login name (1st letter of your first name, and entire last name)<hr>';
echo $form->theWholeForm();

