PHP II Notes -- January 2017

Q: Book on TCP/IP
A: "Internetworking with Tcp/ip Volume One (Edn 6)", By Douglas E. Comer
   https://www.amazon.com/Internetworking-Tcp-One-Douglas-Comer/dp/8120348672/ref=sr_1_fkmr1_3?s=books&ie=UTF8&qid=1485510354&sr=1-3-fkmr1&keywords=comer+stallings+tcp+ip


Errata
-------
Slide 139: DDL / DML defs mixed up

VM ISSUES
---------
SOAP extension is not installed
--  sudo apt-get install php7.1-soap
--  sudo service apache2 restart


---------------------------------------------------------------------------------
http://collabedit.com/uqudk
---------------------------------------------------------------------------------

// Monday 9 Jan 2017

```
<?php

class User
{
    public $firstName;
    public $lastName;
    public function __construct($firstName, $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;

    }
    /**
     * @return the $firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return the $lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param field_type $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @param field_type $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

}

<?php
include 'User.php';
$user = new User('Fred', 'Flintstone');
var_dump($user);

<?php
class DateFormatter
{
    public static $date;
    public static function dateFr()
    {
        return self::$date->format('d M Y');
    }
    public static function dateUs()
    {
        return self::$date->format('m/d/Y');
    }
}

<?php
include 'DateFormatter.php';
DateFormatter::$date = new DateTime();
echo DateFormatter::dateFr();
echo '<br>';
echo DateFormatter::dateUs();


// homework M3Ex1

// Alexandre Lepretre
<?php
// This class represents a customer service ticket
// created when a customer fills a contact form
class Ticket
{
    private $customerId;
    private $type;
    private $content;
    private $status;

    const DEFAULT_TYPE = 'other';
    const DEFAULT_OPEN = 'open';
    const DEFAULT_CLOSE = 'close';

    private static $types = array('shipping', 'item', 'website');

    public function __construct($customerId, $type, $content)
    {
        $this->setCustomerId($customerId);
        $this->setType($type);
        $this->setContent($content);
        $this->open();
    }

    public function setCustomerId($customerId)
    {
        $this->customerId = (int)$customerId;
    }

    public function getCustomerId()
    {
        return $this->customerId;
    }

    public function setType($type)
    {
        if (in_array($type, self::$types)) {
            $this->type = $type;
        } else {
            $this->type = self::DEFAULT_TYPE;
        }
    }

    public function getType()
    {
        return ucfirst($this->type);
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function open()
    {
        $this->status = self::DEFAULT_OPEN;
    }

    public function close()
    {
        $this->status = self::DEFAULT_CLOSE;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function printInfo()
    {
        $output = '';
        $output .= '<p>This ticket was created by customer #' . $this->getCustomerId() . '<br />'
            . 'It is categorised as "' . $this->getType() . '" and is currently ' . $this->getStatus() . '.';
        if ($this->getStatus() == 'open') {
            $output .= '<br /><strong>Content:</strong> ' . $this->getContent();
        }
        $output .= '</p>';
        return $output;
    }
}

$productTicket = new Ticket(123, 'product', 'I have question about this product.');
// Product is not a valid type and is defaulted to "other"
echo $productTicket->printInfo();

$websiteTicket = new Ticket(456, 'website', 'Your website looks broken.');
echo $websiteTicket->printInfo();
$websiteTicket->close();
// That method doesn't output the ticket content when it's closed
echo $websiteTicket->printInfo();
// End Alexandre Lepretre
```



---------------------------------------------------------------------------------
http://collabedit.com/92tvh
---------------------------------------------------------------------------------

// Wed 11 Jan 2017

// example of __call + __invoke + __toString

```
<?php
class Test
{
    protected $values;
    public function __call($name, $params)
    {
        if (strpos($name, 'set') === 0) {
            $this->values[substr($name, 3)] = $params[0];
        } elseif (strpos($name, 'get') === 0) {
            $key = substr($name, 3);
            return (isset($this->values[$key])) ? $this->values[$key] : NULL;
        }
    }
    public function __invoke()
    {
        return 'We are trying to use ' . __CLASS__ . ' as if it were a function.';
    }
    public function __toString()
    {
        return __CLASS__;
    }
}

$test = new Test();
$test->setWhatever('Whatever');
$test->setFirstName('Fred');
$test->setLastName('Flintstone');
echo $test->getFirstName() . ' ' . $test->getLastName();
echo '<br>';
echo $test();
echo '<br>';
echo 'We are trying to use ' . $test . ' as if it were a string.';
```



// M3Ex2 -- Chris / Jason
//Start Chris R.

```
<?php

class Dragon
{
    const _doNotMeddleWithDragons = "you are crunchy and taste good with ketchup!";
    public $color;
    public function __construct($color){
        $this->setcolor($color);
    }
    public function __call($name, $params){
        if (strpos($name, 'get') === 0){
            $key = substr($name, 3);
            if(property_exists($this, $key)){
                return $this->$key;
            } else{
                return null;
            }
        } elseif(strpos($name, 'set') === 0){
            $key = substr($name, 3);
            if(property_exists($this, $key)){
                $this->$key = $params[0];
                return true;
            } else {
                return false;
            }
        }
    }
}


// include 'Dragon.php';
class TypesDragon extends Dragon
{
    protected $breathWeapon;
    protected $alignment;
    protected $metallic;

    public function __construct($color, $breathWeapon, $alignment, $metallic){
        parent::__construct($color);
        $this->breathWeapon = $breathWeapon;
        $this->alignment = $alignment;
        $this->metallic = $metallic;
    }
    public function __call($name, $params){
        if (strpos($name, 'get') === 0){
            $key = substr($name, 3);
            if(property_exists($this, $key)){
                return $this->$key;
            } else{
                return null;
            }
        } elseif(strpos($name, 'set') === 0){
            $key = substr($name, 3);
            if(property_exists($this, $key)){
                $this->$key = $params[0];
                return true;
            } else {
                return false;
            }
        }
    }
}


// include 'TypesDragon.php';
$redDragon = new TypesDragon('Red', 'Fire', 'Chaotic Evil', 'No');
$blueDragon = new TypesDragon('Blue', 'Lightning', 'Lawful Evil', 'No');
$silverDragon = new TypesDragon('Silver', 'Cone of Cold', 'Lawful Good', 'Yes');
$GenericDragon = new Dragon('White');

echo "White Dragon's color is: " . $GenericDragon->getcolor();

echo "<br> Red Dragon Breath Weapon: " . $redDragon->getbreathWeapon();
echo "<br> Blue Dragon Alignment: " . $blueDragon->getalignment();
echo "<br> Silver Dragon Metallic: " . $silverDragon->getmetallic();
echo "<br><br>Do not meddle in the affairs of Dragons, for ";
echo Dragon::_doNotMeddleWithDragons;
// End Chris R.
```

// M3Ex3 -- Daniel

// Form.php

```
class Form {

    const SIGNIN = 'signin';
    static public $pages = [self::SIGNIN => 'signin'];

    // Form elements
    protected $elements = [];

    function __construct($config)
    {
        $this->elements = $config;
    }

    /**
     * Output form elements
     * @return string
     */
    function __toString()
    {
    }
}

// LoginForm.php
class LoginForm extends Form {

    function __toString()
    {
        $html = "Paste this code into your " . parent::SIGNIN . " page:<br>";
        $html .= "<textarea cols='32'; rows='8';>";
        $html .= "<form>\n<fieldset>\n<legend> " . parent::SIGNIN . "</legend>\n";
        if ($this->elements) {
            foreach ($this->elements as $input => $field) {
                if ($field['type'] === 'submit') {
                    $html .= "<input type = \"{$field['type']}\">\n";
                } else {
                    $html .= "{$field['label']} <input type = \"{$field['type']}\">\n";
                }
            }
            $html .= "</fieldset>\n</form>";
        }
        $html .= "</textarea><br>";
        $html .= "<a href='' download>get PHP files</a>";
        return $html;
    }
}

// config.php
$config = [
    'form' =>
        [
            'signin' =>
                [
                    'elements' =>
                        [
                            'input' =>
                                [
                                    'email'    =>
                                        [
                                            'label' => 'email',
                                            'type'  => 'email'
                                        ],
                                    'password' =>
                                        [
                                            'label' => 'password',
                                            'type'  => 'password'
                                        ],
                                    'submit'   =>
                                        [
                                            'label' => '',
                                            'type'  => 'submit'
                                        ]


                                ]
                        ]
                ]
        ]

];

// index.php
include 'Form.php';
include 'LoginForm.php';
include 'config.php';

// Generate form
$login = new LoginForm($config['form']['signin']['elements']['input']);
echo $login;
```

// M3Ex4 -- Geoffrey

//index.php

```
<?php

    include 'Well.php';
    include 'Horizontal.php';


    $wellA = new Well("100/00-00-000-00W0-00", "A", "100.00", "50.00", "1500", "Water");
    $wellB = new Horizontal("999/00-00-000-00W0-00", "B", 90.00, 40.00, 1400, "Invert", 2000, 95.00, 45.00);

    echo $wellA;

    $wellB();

    $wellB->setid("999/99-99-999-99W9-99");

    echo $wellB;



//Well.php
<?php

class Well
{
    protected $id;
    protected $wellName;
    protected $wellHeadLat;
    protected $wellHeadLong;
    protected $verticalDepth;
    protected $mudType;


    public function __construct($id, $wellName, $wellHeadLat, $wellHeadLong, $verticalDepth, $mudType)
    {
        $this->id = $id;
        $this->wellName = $wellName;
        $this->wellHeadLat = $wellHeadLat;
        $this->wellHeadLong = $wellHeadLong;
        $this->verticalDepth = $verticalDepth;
        $this->mudType = $mudType;
    }

    public function __call($method, $params)
    {

        $property = lcfirst(substr($method, 3));

        if (strncasecmp($method, "get", 3) === 0) {
            return $this->$property;
        }
        if (strncasecmp($method, "set", 3) === 0) {
            $this->$property = $params[0];
        }
    }

    public function __toString()
    {
       $wellString = "<br><br>Well ID: " . $this->id . "<br>Well Name: " . $this->wellName .
       "<br> Well Location: " . $this->wellHeadLat . ", " . $this->wellHeadLong . "<br>Vertical Depth: "
           . $this->verticalDepth . "<br>Mud Type: " . $this->mudType;

       return $wellString;

    }

    public function __invoke()
    {
        echo "<br><br>You tried to call the following well as a function." . $this;
    }

}




//Horizontal.php
<?php

class Horizontal extends Well
{
    protected $lateralDepth;
    protected $wellTailLat;
    protected $wellTailLong;

    public function __construct($id,
                                $wellName,
                                $wellHeadLat,
                                $wellHeadLong,
                                $verticalDepth,
                                $mudType,
                                $lateralDepth,
                                $wellTailLat,
                                $wellTailLong)
    {

        parent::__construct($id, $wellName, $wellHeadLat, $wellHeadLong, $verticalDepth, $mudType);
        $this->lateralDepth = $lateralDepth;
        $this->wellTailLat = $wellTailLat;
        $this->wellTailLong = $wellTailLong;

    }

    public function __toString()
    {
        $wellString = parent::__toString() . "<br>Lateral Depth: " . $this->lateralDepth .
        "<br>Well Tail Location: " . $this->wellTailLat . ", " . $this->wellTailLong;

        return $wellString;
    }
}
```

---------------------------------------------------------------------------------
http://collabedit.com/4324f
---------------------------------------------------------------------------------

// Friday 13 Jan 2017

```
<?php

$callback = function ($a, $b) { return $a * $b; };

class Test
{
    protected $op1;
    protected $op2;
    protected $result;
    public function __construct($op1, $op2, callable $callback)
    {
        $this->op1 = $op1;
        $this->op2 = $op2;
        $this->result = $callback($op1, $op2);
    }
    public function getResult()
    {
        return $this->result;
    }
}

$test = new Test(2, 3, $callback);
echo $test->getResult();

// strict types
<?php
declare(strict_types=1);

$callback = function ($a, $b) { return $a * $b; };

class Test
{
    protected $op1;
    protected $op2;
    protected $result;
    public function __construct(int $op1, int $op2, callable $callback)
    {
        $this->op1 = $op1;
        $this->op2 = $op2;
        $this->result = $callback($op1, $op2);
    }
    public function getResult()
    {
        return $this->result;
    }
}

$test = new Test(2, 3, $callback);
echo $test->getResult();

$test = new Test(2.9, '3', $callback);
echo $test->getResult();
```




// Homework for Monday

// M3Ex5 -- Jason
```
<?php

interface DeviceInterface
{
    public function add();
    public function update();
    public function remove();
}

abstract class Device implements DeviceInterface
{
    protected $name;

    public function add(){
        # Some code that adds the device to Cisco Unified Communications Manager
        echo "$this->name has been Added.";
    }

    public function update(){
        # Some code that updates the device in Cisco Unified Communications Manager
        echo "$this->name has been Updated.";
    }

    public function remove(){
        # Some code that removes the device from Cisco Unified Communications Manager
        echo "$this->name has been Removed.";
    }

    public function __Construct($name){
        $this->name = $name;
    }

    public function __Call($funcName,$args){
        if(stripos($funcName,'get') === 0){
            $prop = strtolower(substr($funcName,3));
            if(property_exists($this,$prop)){
                return $this->$prop;
            }else{
                return null;
            }
        }elseif(stripos($funcName,'set') === 0){
            $prop = strtolower(substr($funcName,3));
            if(property_exists($this,$prop)){
                $this->$prop = $args[0];
                return true;
            }else{
                return false;
            }
        }
    }
}

class Phone extends Device
{
    protected $model;
    protected $mac;

    public function __Construct($name,$model,$mac=null){
        parent::__Construct($name);
        $this->setModel($model);
        if(!$mac == null) $this->setMac($mac);
    }
}

class SoftPhone extends Device
{
    protected $type;

    public function __Construct($name,$type){
        parent::__Construct($name);
        $this->setType($type);
    }
}

$phone      = new Phone     ('SEP123456789012','Cisco 7941G-GE');
$csfPhone   = new SoftPhone ('CSFSMURF','Cisco Client Services Framework');

echo "<pre>";
echo "Phone Object Created: {$phone->getName()} - model: {$phone->getModel()}";
echo "<br />";
$phone->add();
echo "<br />";
echo "Soft Phone Object Created: {$csfPhone->getName()} - type: {$csfPhone->getType()}";
echo "<br />";
$csfPhone->add();
echo "</pre>";

?>
```

// M3Ex7 -- Koen
    // index.php:
```
          require_once 'TrackParcel.php'; // Load the superclass TrackParcel
          require_once 'TrackParcelProcessData.php'; // Load the subclass TrackParcelProcessData

          //creating new object:
            $parcel_X = new TrackParcelProcessData(
                array(
                'tracking_id' => 'jd982v',
                'status' => 'Delivered',
                'current_location' => 'Breda',
                'estimated_delivery' => '3 jan 2016 08:30',
                'last_update' => '3 jan 2016 08:02',
                'event_history' => array( 'Delivered', 'In network' )
                )
                , true );

              // inform the user if their parcel is delayed:
                echo $parcel_X->tooLate(array(
                'status' => 'delayed',
                ));

//TrackParcel.php // parent class
include 'trackingInterface.php';

// Class definition (superclass)
abstract class TrackParcel implements TrackingInterface {
    // Set variables (protected)
    protected $data; // Data array
    protected $values = NULL; // Predefine $values (to prevent undefined property errors when zero values are set but a get is used)

    const ERROR_OPERATION   = 'Operation not allowed'; // Error message: 'Operation not allowed'
    const ERROR_SET_GET     = 'Setting or Getting option not allowed:'; // Error message: 'Setting or Getting option not allowed:'
    const ERROR_INVALID_INPUT = 'Please provide valid data.';
    const YAY = 'Everything is fine!'; // Success message
    const DELAYED = 'Your parcel is delayed. Sorry about that.';

    protected static $options = array(
        'tracking_id'           => 'Tracking ID',
        'status'                => 'Status',
        'current_location'      => 'Current Location',
        'estimated_delivery'    => 'Estimated Delivery',
        'last_update'           => 'Last Update',
        'event_history'         => 'Event History'
    ); // Define allowed options (to set/get)

    // Construct, setup all the data for use in the class
    public function __construct( $data ) {
        $this->setAll( $data ); // Setup all available data
    }

    // Generic setter/getter
    public function setGet( $set_get_data ) {
        try { // Error handling
            extract( $set_get_data );

            if( array_key_exists( $type, static::$options ) ) { // Used static:: to allow subclasses to change the allowed types array that can be set
                if( $action === 'set' ) { // if the setter is called,
                    $this->values[$type] = $params;  // set the types as parameters
                } elseif ( $action === 'get' ) { // if the getter is called, retrieve those values
                    $option = $this->values[$type]; //retrieve those values
                    return ( isset($option) ) ? $option : NULL; //check if values are set, if not, set them to null
                } else {
                    throw new Exception( self::ERROR_OPERATION ); // else, throw an error
                }
            } else { // if key does not exist, throw an exception
                throw new Exception(  self::ERROR_SET_GET . ' ' . $type );
            }
        }

        catch( Exception $e ){ // Display error messages (if any are thrown)
            echo '<strong>Error on line ' . $e->getLine() . ': ' . $e->getMessage() . '</strong><br>';
        }
    }

    // Set all items
    public function setAll( $set_data ) {
        foreach( $set_data as $item => $item_value ) { // Used static to allow subclasses to change the allowed types that can be set
            $this->setGet( array(
                'action'    => 'set',
                'type'      => $item,
                'params'    => $set_data[$item]
            ) );
        }
    }

    // Get all items
    public function getAll() {
        $data = array();
                                // key      value
        foreach( $this->values as $item => $item_value ) {
            $data[$item] = $item_value; // populate the data array with the key value pairs
        }

        return $data;
    }

    // Get allowed types to get/set
    public static function getAllowedTypes(){
        return static::$options;
    }

    // var_dump all available data when the class is called as a function
    public function __invoke() {
        var_dump( $this->values );
    }

    //M3EX5 Implementing an Interface:
    public function validateLocation( array $data_array)
    {
        $string = $data_array['current_location'];

        if(preg_match('#[0-9]#',$string)){
            return self::ERROR_INVALID_INPUT;
        }
        else{
            return self::YAY;
        }
    }

    public function validateOrderID(array $data_array)
    {
        $string2 = $data_array['tracking_id'];

        if(!is_numeric($string2)){
            return self::ERROR_INVALID_INPUT;
        }
        else{
            return self::YAY;
        }

    }
}

// TrackParcelProcessData.php // subclass
                        // This class is build to get the status of a parcel (by tracking ID/number). In the future // the information/status of a parcel could be queried from a database (and updated to the database as well)
                        // namespace Tracking;
                        // use MyUsers as UserSpace;

                         include 'trait1.php';
                         include 'trait2.php';


                        // Class definition (subclass)
                        class TrackParcelProcessData extends TrackParcel {

                            //M3EX7:
                            use status, track {
                                status::tooLate insteadof track;
                            }

                            protected $data; // Data array
                            protected $mail_notifications; // Mail notification (true/false)

                            protected static $options = array(
                                'tracking_id'           => 'Tracking ID',
                                'status'                => 'Status',
                                'current_location'      => 'Current Location',
                                'estimated_delivery'    => 'Estimated Delivery',
                                'last_update'           => 'Last Update',
                                'event_history'         => 'Event History',
                                'mail_notifications'    => 'Mail notifications'
                            ); // Define allowed options (to set/get)

                            const DEFAULT_MAIL_NOTIFCATIONS = false;
                            const TO_STRING_MESSAGE = 'Tracking information for';
                            const CONTACT = 'Your parcel is delayed. Please call our head office for further information.';

                            // constructor method of subclass, receiving $data from the parent class and having own property $mail_notifications
                            public function __construct( $data, $mail_notifications = self::DEFAULT_MAIL_NOTIFCATIONS ) {
                                parent::__construct( $data );

                                $this->setGet( array( //setting the mail notifications to the right type and parameter
                                    'action'    => 'set',
                                    'type'      => 'mail_notifications',
                                    'params'    => $mail_notifications
                                ) );
                            }

                            public function getAllInfoHtml() {
                                // Get all available data from the getAllInfo method and process that data
                                $data = $this->getAll();
                                $output = '';

                                // Open UL (adding to the $output string)
                                $output .= '<ul>';

                                // Loop through all items in the $data array
                                foreach( $data as $item => $value ){
                                    if( $item === 'event_history' ){ // Process the Event History items
                                        $output .= '<li>' . $item . ' <ul>';

                                        foreach( $value as $child_item => $child_value ){
                                            $output .= '<li>' . $child_value . '</li>';
                                        }

                                        $output .= '</ul></li>';
                                    } else { // Process the other items
                                        $output .= '<li>' . $item . ': ' . $value . '</li>';
                                    }
                                }

                                // Close UL
                                $output .= '</ul>';

                                // Return the output
                                return $output;
                            }

                            public function checkMailNotificationStatus(){
                                $checked = array(
                                    'current_status'    => $this->setGet( array(
                                        'action'        => 'get',
                                        'type'          => 'mail_notifications'
                                    ) ),
                                    'default_status'    => self::DEFAULT_MAIL_NOTIFCATIONS
                                );

                                return $checked;
                            }

                            public function __toString() {
                                $tracking_id = $this->setGet( array( 'action' => 'get', 'type' => 'tracking_id' ) );
                                $status = $this->setGet( array( 'action' => 'get', 'type' => 'status' ) );

                                $message = self::TO_STRING_MESSAGE . ' ' . $tracking_id . ' - ' . $status; // Used a constant to display a short message + get the tracking ID and status (and combine that data into a string to return)

                                return $message;
                            }
                        }

//trait1.php
trait track {

    public $haystack;
    public $needle;
    public $haystack2;
    public $needle2;

    // inform the user if their parcel is delayed:
    public function tooLate($haystack)
    {
        $needle = 'delay';

        if(in_array($needle, $haystack) == false){
            return TrackParcelProcessData::CONTACT;
        }
    }

    // inform the user if their parcel is too bulky:
    public function tooBulky($haystack2)
    {
        $needle2 = 'bulky';

        if(in_array($needle2, $haystack2) == false){
            return TrackParcel::YAY;
        }
    }
}

//trait2.php
trait status
{
    public $haystack3;
    public $needle3;
    public $haystack4;
    public $needle4;

    // inform the user if their parcel is delayed:
    public function tooLate($haystack3)
    {
        $needle3 = 'delay';

        if(in_array($needle3, $haystack3) == false){
            return TrackParcel::DELAYED;
        }
    }

    // inform the user if their parcel is damaged:
    public function damaged($haystack4)
    {
        $needle4 = '@';

        if(in_array($needle4, $haystack4) == false){
            return TrackParcel::ERROR_INVALID_INPUT;
        }
    }
}


interface TrackingInterface
{
    public function validateLocation( array $data_array);
    public function validateOrderID(array $data_array);
}
```



// M3Ex8 -- Petros4
```
<?php


namespace namespaceA
{
    class SameClassName
    {
        private $_options;
        private $_name;

        function __construct($options = array())
        {
            if(isset($options)) $this->_options = $options;
        }

        public function setName($name)
        {
            $this->_name = $name;
        }

        public function getName()
        {
            return $this->_name;
        }
    }
}
namespace namespaceB
{
    class SameClassName
    {
        private $_options;
        private $_name;

        function __construct($options = array())
        {
            if(isset($options)) $this->_options = $options;
        }

        public function setName($name)
        {
            $this->_name = $name;
        }

        public function getName()
        {
            return $this->_name;
        }
    }
}

namespace
{

    use namespaceA\SameClassName as A;
    use namespaceB\SameClassName as B;

    $a = new A();
    $b = new B();

    $a->setName('just a example script with: classes,namespaces and a alias');
    $b->setName('@Petros');
    echo $a->getName() .PHP_EOL. $b->getName();

}
```

---------------------------------------------------------------------------------
http://collabedit.com/689vf
---------------------------------------------------------------------------------

// Mon 16 Jan 2017

```
<?php
function __autoload($className)
{
    $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
    if (!file_exists($fileName)) {
        throw new Exception('Unable autoload this class ' . $className);
    }
    require_once($fileName);
}

use A\SameClassName as A;
use B\SameClassName as B;

$a = new A();
$b = new B();

$a->setName('just a example script with: classes,namespaces and a alias');
$b->setName('@Petros');
echo $a->getName() .PHP_EOL. $b->getName();
```

// based on example from petros from Friday


// EXCEPTION example
```
<?php
try {
    $pdo = new PDO('', 'zend', 'password');
} catch (Exception $e) {
    echo __LINE__ . ':' . get_class($e) . ':' . $e->getMessage();
    // normally: log it!
    error_log($e->getMessage());
} catch (PDOException $e) {
    echo __LINE__ . ':' . get_class($e) . ':'  . $e->getMessage();
    // normally: log it!
    error_log($e->getMessage());
}

// PHP 7 Error / Throwable
<?php
class Test
{
    public function doSomething($obj) {
        $obj->nope();
    }
    public function __destruct()
    {
        echo "Destroy called\n";
    }
}
try {
    $a = new Test();
    $a->doSomething(NULL);
} catch (\Error $e) {
    echo "Error: {$e->getMessage()}\n";
} finally {
    echo "Finally is called\n";
}
```

// M3Ex9 -- Alexandre

```
<?php
class NiceException extends Exception
{
    // This should probably come from a config file instead!
    const EXCEPTION_FILE = '/var/tmp/php-exceptions.php';

    public function __construct($message = null, $code = null, $previous = null)
    {
        // Let's log every exception to a dedicated file
        $this->log($message, $code);
        parent::__construct($message, $code, $previous);
    }

    protected function log($message, $code)
    {
        $formattedMessage = (new DateTime())->format('Y-m-d H:i:s');
        $formattedMessage .= ' (' . (int)$code . '): ';
        $formattedMessage .= $message . PHP_EOL;
        error_log($formattedMessage, 3, self::EXCEPTION_FILE);
    }
}

try {
    throw new NiceException('Oh no, something broke!', 500);
} catch (NiceException $exception) {
    echo $exception->getMessage();
} catch (Exception $exception) {
    echo $exception->getMessage();
} finally {
    // Logging backtrace for posterity
    $message = 'End of execution:' . PHP_EOL . print_r(debug_backtrace(), true);
    error_log($message);
}
```

// Order app, attempt to add autoloader and namespaces :D
https://github.com/AlexandreLepretre/orderapp
// It doesn't work like I wanted, I'm stuck on Core\Service\Services::setModel


---------------------------------------------------------------------------------
http://collabedit.com/yb555
---------------------------------------------------------------------------------

// Wed 18 Jan 2017

// M6Ex1 -- Chris
//This is extremely simple, but the fire I had the other day cost me a day and a half of work this week.

```
<?php
define('ERROR_PDO', 'An error occured creating a new PDO object at %s.<br><br>%s');
define('ERROR_CUSTOMERS', 'An error occurred retrieving all records from the customers table at %s.<br><br>%s');

//Set the current datetime
$date = new DateTime("",new DateTimeZone('America/New_York'));
$today = $date->format('Y-m-d H:i:s');

try {

    $pdo = new PDO ('mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=course', 'root', 'vagrant');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare('INSERT INTO customers (firstname, lastname) VALUES (:firstname, :lastname)');

    $fname = 'Big';
    $lname = 'Bird';

    $stmt->bindParam(':firstname', $fname);
    $stmt->bindParam(':lastname', $lname);

    $stmt->execute();

} catch(PDOException $e) {

    //should return data, but this will work for class today.
    printf(ERROR_PDO, $today, $e);

}

try {

    $stmt = $pdo->query('SELECT * FROM customers');

    $result = $stmt->fetchALL(PDO::FETCH_ASSOC);

    //should return data, but this will work for class today.
    echo "<pre>";
    print_r($result);
    echo "</pre>";

} catch(PDOException $e) {

    //should return data, but this will work for class today.
    printf(ERROR_CUSTOMERS, $today, $e);

}
```

---------------------------------------------------------------------------------
http://collabedit.com/599va
---------------------------------------------------------------------------------

// Fri 20 Jan 2017

// M6Ex2 - Jeroen

/*I made the SP in MSSQL because i was having issues with my virtual machine
and this was the only language i had debugging acces to*/

/*Creating the procedure with 1 parameter */
```
CREATE PROCEDURE [dbo].[RowCount] @TABLENAME varchar(max) AS

SELECT
    Convert(varchar(30),sysobjects.Name) as name,
    Convert(varchar(10),sysindexes.Rows) as rows
FROM
    sysobjects
    INNER JOIN sysindexes ON sysobjects.id = sysindexes.id
WHERE
    type = 'U'
    AND sysindexes.Rows > 0
    AND sysobjects.Name LIKE '%'+@TABLENAME+'%'
ORDER BY
    sysobjects.Name
```

/*Executing the procedure*/
/*this will return the row counts for all the tables containing 'cust' in their name*/
```
exec [dbo].[RowCount] 'cust'
```

// M6Ex3 -- Koen

//random data array:
```
<?php
$data = array(
    array("title"=>"Sloane"),
    array("title"=>"Winter"),
    array("title"=>"Frances"),
    array("title"=>"Carson"),
    array("title"=>"Lysandra"),
    array("title"=>"Willa"),
    array("title"=>"Buckminster"),
    array("title"=>"Austin"),
    array("title"=>"Lee"),
    array("title"=>"Claudia"),
    array("title"=>"Carl"),
    array("title"=>"Carol"),
    array("title"=>"Hedda"),
    array("title"=>"Cecilia"),
    array("title"=>"Kaye"),
    array("title"=>"Salvador"),
    array("title"=>"Asher"),
    array("title"=>"Hector"),
    array("title"=>"Quinlan"),
    array("title"=>"Joy"),
    array("title"=>"Castor"),
    array("title"=>"Hedwig"),
    array("title"=>"Alan"),
    array("title"=>"Sydney"),
    array("title"=>"Anne"),
    array("title"=>"Ifeoma"),
    array("title"=>"Colton"),
    array("title"=>"Norman"),
    array("title"=>"Pandora"),
    array("title"=>"Nina"),
    array("title"=>"Amaya"),
    array("title"=>"Maggie"),
    array("title"=>"Lillith"),
    array("title"=>"Beatrice"),
    array("title"=>"Kevin"),
    array("title"=>"Morgan"),
    array("title"=>"Halee"),
    array("title"=>"Aphrodite"),
    array("title"=>"Haley"),
    array("title"=>"Gillian"),
    array("title"=>"Ivy"),
    array("title"=>"Edward"),
    array("title"=>"Flynn"),
    array("title"=>"Amanda"),
    array("title"=>"Wang"),
    array("title"=>"Sheila"),
    array("title"=>"Maile"),
    array("title"=>"Quamar"),
    array("title"=>"Yoshi"),
    array("title"=>"Zelda"),
    array("title"=>"Sydnee"),
    array("title"=>"Alice"),
    array("title"=>"Mari"),
    array("title"=>"Halla"),
    array("title"=>"Zephr"),
    array("title"=>"Zenia"),
    array("title"=>"Audrey"),
    array("title"=>"Rooney"),
    array("title"=>"Abraham"),
    array("title"=>"Tate"),
    array("title"=>"Martin"),
    array("title"=>"Mufutau"),
    array("title"=>"Brenna"),
    array("title"=>"Selma"),
    array("title"=>"Robert"),
    array("title"=>"Madison"),
    array("title"=>"Alika"),
    array("title"=>"Cara"),
    array("title"=>"Raymond"),
    array("title"=>"Keefe"),
    array("title"=>"Vance"),
    array("title"=>"Abraham"),
    array("title"=>"Alisa"),
    array("title"=>"Arsenio"),
    array("title"=>"Brody"),
    array("title"=>"Kay"),
    array("title"=>"Damon"),
    array("title"=>"Jonah"),
    array("title"=>"Hiram"),
    array("title"=>"Neville"),
    array("title"=>"Lionel"),
    array("title"=>"Yvonne"),
    array("title"=>"Mari"),
    array("title"=>"Remedios"),
    array("title"=>"Stewart"),
    array("title"=>"Rhoda"),
    array("title"=>"Paula"),
    array("title"=>"Vance"),
    array("title"=>"Wilma"),
    array("title"=>"Katelyn"),
    array("title"=>"Margaret"),
    array("title"=>"Kieran"),
    array("title"=>"Hedwig"),
    array("title"=>"Carly"),
    array("title"=>"Stewart"),
    array("title"=>"Dante"),
    array("title"=>"Damon"),
    array("title"=>"Forrest"),
    array("title"=>"Althea"),
    array("title"=>"Hasad")
);

try{
    // establish DB connection:
    $pdo = new PDO ('mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=course', 'root', 'vagrant');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->beginTransaction();

    $stmt1 = $pdo->prepare('INSERT INTO customers (firstname, lastname) VALUES (?, ?)');
    echo '<pre>';

    // loop through random data array and try to run an update for the first name and lastname on every iteration
    for ($x = 0; $x < count($data); $x +=2){

        echo $data[$x]['title'] . ' '. $data[$x + 1]['title'] . PHP_EOL;
        $stmt1->execute([$data[$x]['title'], $data[$x + 1]['title'] ?? 'Default']);

        // simulates an error condition to test the rollback()
        //if ($x == 20) {
        //    $stmt1 = NULL;
        //}
    }

    $pdo->commit();

    $stmt2 = $pdo->query('SELECT * FROM customers');
    var_dump($stmt2->fetchAll(PDO::FETCH_ASSOC));
    echo '</pre>';

} catch(PDOException | Throwable $e) {
    echo $e->getMessage();
    $pdo->rollBack();
}
```


// M6Ex4 -- Jason
// I didn't create a database - that may need to be done?
// Plenty of things I would change or have done differently but time constraints (30 mins) prevented it
// NOTE: modifications made in class ... still needs to be tested!!!

```
<?php

abstract class Device
{
    protected $name;

    public function add($PDO, $values=null){
        if(is_array($values)){
            $pdoColumns = implode(',',array_keys($values));
        }elseif(is_object($values)){
            $values     = get_object_vars($values);
            $pdoColumns = implode(',',array_keys($values));
        }elseif($values == null){
            $values     = get_object_vars($this);
            $pdoColumns = implode(',',array_keys($values));
        }
        try{
            //Should have used prepared statement
            $sql = "INSERT INTO phones ($pdoColumns) VALUES (";
            foreach ($values as $item) {
                $sql .= '?,';
            }
            $sql = substr($sql, 0, -1) . ')';
            $stmt = $PDO->prepare($sql);
            $stmt->execute(array_values($values));
        } catch (Exception $e){
            echo "<br /><pre>";
            echo "Exception occurred:<br />";
            var_dump($e);
            die("<br />Exiting on exception.");
        }
        echo "$this->name has been Added.";
    }

    public function update($PDO){
        # Not Implemented
        echo "$this->name has been Updated.";
    }

    public function remove($PDO){
        # Not Implemented
        echo "$this->name has been Removed.";
    }

    public static function list($PDO){
        $select = $PDO->query("SELECT * FROM phones");

        return $select->fetchall(PDO::FETCH_ASSOC);
    }

    public function __Construct($name){
        $this->name = $name;
    }

    public function __Call($funcName,$args){
        if(stripos($funcName,'get') === 0){
            $prop = strtolower(substr($funcName,3));
            if(property_exists($this,$prop)){
                return $this->$prop;
            }else{
                return null;
            }
        }elseif(stripos($funcName,'set') === 0){
            $prop = strtolower(substr($funcName,3));
            if(property_exists($this,$prop)){
                $this->$prop = $args[0];
                return true;
            }else{
                return false;
            }
        }
    }
}

class Phone extends Device
{
    protected $model;
    protected $mac;

    public function __Construct($name,$model,$mac=null){
        parent::__Construct($name);
        $this->setModel($model);
        if(!$mac == null) $this->setMac($mac);
    }
}

class SoftPhone extends Device
{
    protected $type;

    public function __Construct($name,$type){
        parent::__Construct($name);
        $this->setType($type);
    }
}

$dsn  = 'mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=course';
$user = 'root';
$pass = 'vagrant';

$PDO = new PDO($dsn,$user,$pass);

$createTableSql = "
    CREATE TABLE phones
        (pkid INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(50) NOT NULL,
        model VARCHAR(50) NULL,
        mac VARCHAR(50) NULL,
        type VARCHAR(50) NULL,
        PRIMARY KEY (pkid)
    );";

$PDO->exec($createTableSql);

$phone      = new Phone     ('SEP123456789012','123456789012','Cisco 7941G-GE');
$phone->add($PDO);
$csfPhone   = new SoftPhone ('CSFSMURF','Cisco Client Services Framework');

echo "<pre>";
echo "Phone Object Created: {$phone->getName()} - model: {$phone->getModel()}";
echo "<br />";
$phone->add($PDO);
echo "<br />";
echo "Soft Phone Object Created: {$csfPhone->getName()} - type: {$csfPhone->getType()}";
echo "<br />";
$csfPhone->add($PDO);
echo "<br />";

echo "Listing all devices";
$allPhones = Device::list($PDO);
foreach($allPhones as $dev){
    echo "<br />";
    var_dump($dev);
}

echo "</pre>";

?>
```


// M7Ex1 -- Daniel (form)

```
$config = [
    'form' =>
        [
            'signin' =>
                [
                    'elements' =>
                        [
                            'input' =>
                                [
                                    'text'     =>
                                        [
                                            'label' => 'username',
                                            'type'  => 'text',
                                            'name'  => 'username',

                                        ],
                                    'password' =>
                                        [
                                            'label' => 'password',
                                            'type'  => 'password',
                                            'name'  => 'password',
                                        ],
                                    'submit'   =>
                                        [
                                            'label' => '',
                                            'name'  => 'submit',
                                            'type'  => 'submit',
                                            'value' => 'log in'
                                        ]


                                ]
                        ]
                ]
        ]

];

session_start();
$_SESSION['message'] = 'please login';

// Generate form
$config = $config['form']['signin']['elements']['input'];

isset($_GET['preview'])
    ? $login = new LoginFormGenerator($config, $_GET['preview'])
    : $login = new LoginFormGenerator($config, $preview = true);

echo $login;

if (isset($_POST['submit'])) {
    $username = ctype_alnum($_POST['username']);
    $password = ctype_alnum($_POST['password']);
    $login->validateLogin($username, $password);
}

if ($_SESSION['message']) {
    echo "<hr>";
    echo $_SESSION['message'];
    session_destroy();
}

interface ValidateInput {

    public function validateLogin($username, $password);

}

abstract class Form implements ValidateInput {

    // HTML elements
    protected $elements = [];

    function __construct($config)
    {
        $this->elements = $config;
    }
}

class LoginFormGenerator extends Form {

    protected $elements = [];
    protected $preview;
    protected $user = ['username' => 'root', 'password' => 'secret'];

    function __construct($config, $preview)
    {
        $this->elements = $config;
        $this->preview = $preview;
    }

    public function validateLogin($username, $password)
    {
        if ($username === $this->user['username']
        && $password === $this->user['password']) {
            $_SESSION['message'] = 'logged in';
        } else {
            $_SESSION['message'] = 'not logged in';
        }

    }

    function __toString()
    {
        switch ($this->preview) {
            case false:
                $html = "<html><textarea cols='48'; rows='6';>";
                $html .= "<form action='index.php' method='post'>\n";
                if ($this->elements) {
                    foreach ($this->elements as $input => $field) {
                        if ($field['type'] === 'submit') {
                            $html .= "<input type = \"{$field['type']}\" name=\"{$field['name']}\">\n";
                        } else {
                            $html .= "{$field['label']} <input type = \"{$field['type']}\" name=\"{$field['name']}\">\n";
                        }
                    }
                    $html .= "</fieldset>\n</form>";
                }
                $html .= "</textarea><br></html>";
                $html .= "<a href=\"index.php?preview=1\">preview</a>";
                break;
            case true :
                $html = "<html><form action='index.php' method='post'>\n";
                if ($this->elements) {
                    foreach ($this->elements as $input => $field) {
                        if ($field['type'] === 'submit') {
                            $html .= "<input type = \"{$field['type']}\" name=\"{$field['name']}\"value=\"{$field['value']}\">\n";
                        } else {
                            $html .= "{$field['label']} <input type = \"{$field['type']}\" name=\"{$field['name']}\">\n";
                        }
                    }
                    $html .= "</fieldset>\n</form></html>";
                    $html .= "<a href=\"index.php?preview=0\">close preview</a>";
                    break;
                }
        }
        return $html;
    }
}
```

// M7Ex2 -- David (cookies)


```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Command Executer on Cookie Expiration</title>
</head>
<body>
<form method="post">
    <h1>Input</h1>
    <table>
        <tr>
            <td>
                <label>Choose a Name </label>
            </td>
            <td>
                <input type="text" name="name" placeholder="Your Name"><br/>
            </td>
        </tr>
        <tr>
            <td>
                <label>How long you want to stay? </label>
            </td>
            <td>
                <input type="number" name="time">
                <select name="timeList">
                    <option value="seconds">Seconds</option>
                    <option value="minutes" selected="selected">Minutes</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label>Code to execute on expiration of Cookie (shell_exec): </label>
            </td>
            <td>
                <input type="text" name="executeOnExpiration" placeholder="php -v"><br/>
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit">
            </td>
        </tr>
    </table>
</form>
</body>
</html>
<?php

function checkForm_setCookie()
{
    if (isset($_POST['name']) && $_POST['time'] && $_POST['executeOnExpiration']) {
        // Check if form is set
        $cookie_name = "timedlogin";
        $cookie_value = $_POST['name'];

        if (ctype_digit($_POST['time']) == 1) {
            // check if posted time is a numeric value
            switch ($_POST['timeList']) {
                // switch case for the SelectBox timeList with values seconds, minutes
                case 'seconds':
                    $cookie_time = $_POST['time'];
                    break;
                case 'minutes':
                    $cookie_time = $_POST['time'] * 60;
                    break;
                default:
                    $cookie_time = 0;
            }

            // Add time() (epoch) to generated seconds
            // Use Result for Token Expiration
            $cookie_time_epoch = time() + $cookie_time;
            $cookie_value .= '###' . $cookie_time_epoch;  // Add expiration date to cookie value for logged-in Timer. Because the cookie Expiration value is write only.
            setcookie($cookie_name, $cookie_value, $cookie_time_epoch, '/');

            // Create a File with command to execute and timestamp
            $file = fopen("file.txt", "w") or die("Unable to open file!");
            $text = $_POST['executeOnExpiration'] . "###" . $cookie_time_epoch;
            fwrite($file, $text);
            fclose($file);

        } else {
            return "Use numbers for time";
        }
    } else {
        //echo "Try to fill the form next time :)";
    }
}

function checkLogin($output)
    // Checks if Cookie is set.
    // When Output is true, return html. Else use true and false
{
    if (isset($_COOKIE['timedlogin'])) {
        // Check if Cookie 'timedlogin' is available

        if ($output == true) {
            $cookie_data = getCookieValue();
            // GetCookieData: [0] = Name; [1] = Timeleft
            $cookie_data[1] = round($cookie_data[1], 1);
            return "<h2 style=\"color:cornflowerblue\">Your Name is $cookie_data[0] <br/> And you will stay logged in for $cookie_data[1] Minutes</h2>";
        } else {
            return true;
        }
    } else {
        if ($output == true) {
            return "<h2 style=\"color:cornflowerblue\">Cookie isn't set</h2>";
        } else {
            return false;
        }
    }
}

function getCookieValue()
{
    // Get Data from Cookie Value with Explode function, I use the Delimiter '###'
    $explode = explode("###", $_COOKIE['timedlogin']);
    // Cookie Value #1, Username
    $cookie_data[] = $explode[0];
    // Time in Minutes (cookie expiration epoch - epoch; divided by 60)
    $cookie_data[] = ($explode[1] - time()) / 60;
    return $cookie_data;
}

function execute()
    // Execute Command and return Output
    ///////// It's needed for this step to use a file or a DB.
    ///////// For Example: if the command is saved inside the Cookies Value it gets deleted and can't be executed after it's lifetime.
{
    // Get the command to execute and the timestamp, saved in checkForm_setCookies
    $file = fopen("file.txt", "r") or die("Unable to open file!");
    $file_content = fread($file, filesize("file.txt"));
    $explode = explode("###", $file_content);
    $command = $explode[0];
    $time_to_execute = $explode[1];

    // After the Cookie Expiration execute the Command (you have to refresh the page..)
    if ($time_to_execute < time())
    {
        return "<h3 style=\"color:red\">Command Executed: " . $command . "</h3>" . shell_exec($command);
    } else {
        return false;
    }
}

checkForm_setCookie();
echo checkLogin(true);      // Output to Page /
echo execute();             // Command Output

phpinfo(INFO_VARIABLES);
```


---------------------------------------------------------------------------------
http://collabedit.com/kr8h8
---------------------------------------------------------------------------------

// Mon 23 Jan 2016

// M7Ex3 - Alexandre (database / auth from login form)

// Run this SQL first:
/*
USE course;
ALTER TABLE customers ADD COLUMN password_hash VARCHAR(255);
UPDATE customers SET password_hash = 'f52fbd32b2b3b86ff88ef6c490628285f482af15ddcb29541f94bcf526a3f6c7' WHERE id = 1; -- George Stevenson / hunter2
UPDATE customers SET password_hash = '1c8bfe8f801d79745c4631d09fff36c82aa37fc4cce4fc946683d7b336b63032' WHERE id = 2; -- Janet Levitz / letmein
UPDATE customers SET password_hash = '64282ca3a22b9fd63ebb2d6a85997c58cdeef549dab9b6b0a3eeae80305b926e' WHERE id = 3; -- Jason Flores / AnotherTerriblePwd
UPDATE customers SET password_hash = '4f8b8959496b66484ac96557408c385770e0c7e303e583b9a2f32a08b29ea078' WHERE id = 4; -- Susan Chu / PhpLab7
UPDATE customers SET password_hash = 'b0723adb59ca5ae0acd94895291755b5c6f9301a6d7906d8230d0942d62aa797' WHERE id = 5; -- Thomas White / 0ut0f1d34s
*/
// I'm assigning hashed passwords to all customers of the orderapp so they can log-in themselves, I've put in comment the corresponding (terrible) passwords

// Now for the PHP part:
```
<?php
class SessionLabApp
{
    const LOGGED_OUT_CONTEXT_EXCEPTION = 'Called logged in method in logged out context';

    public static $currentUser;
    public static $config;

    public static function setConfig($config)
    {
        self::$config = $config;
    }

    public static function login($username, $password)
    {
        if (self::$currentUser = (new User())->getByUsernameAndPass($username, $password)) {
            $_SESSION['user_id'] = self::$currentUser->getId();
        }
    }

    public static function isLoggedIn()
    {
        return !empty($_SESSION['user_id']);
    }

    public static function getCurrentUser()
    {
        if (!self::isLoggedIn()) {
            throw new Exception(self::LOGGED_OUT_CONTEXT_EXCEPTION);
        }
        if (empty(self::$currentUser)) {
            self::$currentUser = new User($_SESSION['user_id']);
        }
        return self::$currentUser;
    }

    // NOTE: this could possibly go into yet another Connection class
    //       used by both the existing classes
    public static function getPdo()
    {
        try {
            $pdo = new PDO(self::$config['dsn'], self::$config['username'], self::$config['password']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            // log the message
            error_log(__METHOD__ . ':' . $e->getMessage());
            return false;
        }
    }
}

class User
{
    protected $id;
    protected $firstName;
    protected $lastName;

    public function __construct($id = null)
    {
        if ($id) {
            $this->load($id);
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function load($id)
    {
        try {
            $statement = SessionLabApp::getPdo()->prepare('
                SELECT id, firstname, lastname
                FROM customers
                WHERE id = ?
                LIMIT 1'
            );
            $id = (int)$id;
            $statement->bindParam(1, $id);
            $statement->execute();
            if ($row = $statement->fetch()) {
                $this->populateFromRow($row);
            } else {
                return null;
            }
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            return null;
        }

        return $this;
    }

    public function getByUsernameAndPass($username, $password)
    {
        try {
            $statement = SessionLabApp::getPdo()->prepare('
                SELECT id, firstname, lastname
                FROM customers
                WHERE CONCAT(firstname, " ", lastname) = ?
                AND password_hash = ?
                LIMIT 1');
            // Hash the posted password to match against the ones we have in DB
            // NOTE: use password_hash() which uses BCRYPT ... much more secure!!!
            $passwordHash = hash('sha256', $password);
            $statement->bindParam(1, $username);
            $statement->bindParam(2, $passwordHash);
            $statement->execute();
            if ($row = $statement->fetch()) {
                $this->populateFromRow($row);
            } else {
                return null;
            }
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            return null;
        }

        return $this;
    }

    protected function populateFromRow($row)
    {
        $this->id = $row['id'];
        $this->firstName = $row['firstname'];
        $this->lastName = $row['lastname'];
    }
}

session_start();

// config array
// normally in a separate file which is included
$config = [
    'dsn' => 'mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=course',
    'username' => 'root',
    'password' => 'vagrant'
];

SessionLabApp::setConfig($config);

// Logout functionality
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
// Login functionality
} elseif (!empty($_POST['username']) && !empty($_POST['password'])) {
    SessionLabApp::login($_POST['username'], $_POST['password']);
}
?>

<?php if (SessionLabApp::isLoggedIn()): ?>
    <p>
        You are logged in as <?= SessionLabApp::getCurrentUser()->getUsername() ?>!
        <a href="?logout">Log out</a>
    </p>
<?php else: ?>
    <form method="post" action="?login">
        <label for="username">Username: </label>
        <input type="text" id="username" name="username" />
        <label for="password">Password: </label>
        <input type="password" id="password" name="password" />
        <input type="submit" value="Log in!" />
    </form>
<?php endif ?>
```


---------------------------------------------------------------------------------
http://collabedit.com/5uxfy
---------------------------------------------------------------------------------

// Wed 25 jan 2017

// M9Ex1 -- Chris (REST request)
```
<?php
$json = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=38+sky+place+Lynchburg,+VA&sensor=false');
$resultsObj = json_decode($json);

$resultsArr = json_decode($json, true);

//$xml = file_get_contents('http://maps.googleapis.com/maps/api/geocode/xml?address=38+sky+place+Lynchburg,+VA&sensor=false');

//$smplxml = simplexml_load_string($xml);

echo "<pre>";
print_r($resultsArr);
echo "</pre>";
```

// M9Ex1 -- Koen
//Get a client instance: 
```
<?php
include __DIR__ . '/../vendor/autoload.php';
$client = new GuzzleHttp\Client();

//Make the Request:
$response = $client->request('GET',
    'http://maps.googleapis.com/maps/api/geocode/json', [
        'query' => [
            'address' => '350+5th+Avenue+New+York,+NY',
            'sensor' => false
        ]
    ]);

        // Test for return status:
        if($response->getStatusCode() === 200){
            //Output the JSON directly
         //   echo $response->getBody();
            //Output PHP array:
            $guzzle_output = json_decode($response->getBody());
            
            echo '<pre>';
            print_r($guzzle_output);
            echo '</pre>';
?>          

   <?php         
        }else{
            echo "Failed to make Guzzle Request";
        }
?>^
```


// REGEX Examples

```
<?php 
// matching a Canadian Postal Code
// rules: see: https://en.wikipedia.org/wiki/Postal_codes_in_Canada
$data = ['A1A 1A1', 'BAD A1A 1A1', 'a1a 1a1', 'B2C 3T4X', 'B2C3T4', 'B2C 3T4', ' B2C 3T4X BAD BAD BAD', '12345', 'ABCDE', 'AAA 111'];
$pattern = '/^[A-Z]\d[A-Z] \d[A-Z]\d$/';

echo '<pre>';
foreach ($data as $code) {
    echo $code . ' : ';
    echo (preg_match($pattern, $code, $matches)) ? 'MATCH' : 'NO MATCH';
    var_dump($matches);
    echo PHP_EOL;
}
echo '</pre>';
```

// example using preg_replace() and preg_match() with 3rd argument + sub-patterns
```
<?php 
// matching phone numbers
$data = ['0043 660 7644831', '0900 0909', '06 15879452', '202-704-3435', '+66 824 458 938', '(716) 482-2783',
         '18056370290', '018056370290', '+1 (805)-637 0290', 'XXXXXXXX' ];
$pattern = '/^\d{10,}$/';

echo '<pre>';
foreach ($data as $number) {
    // strips off non-digits
    $test = preg_replace(['/\D/'], '', $number);
    // NOTE: we could also use substr() to locate strings which start with "0"
    // separates leading 0 from rest of string
    preg_match('/^(0)(\d+)$/', $test, $matches);
    if (isset($matches[1]) && $matches[1] === '0') {
        $test = $matches[2] ?? '';
    }
    echo $number. ' : ' . $test . ' : ';
    echo (preg_match($pattern, $test, $matches)) ? 'MATCH' : 'NO MATCH';
    echo PHP_EOL;
}
echo '</pre>';
```

