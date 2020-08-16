# EasyValidator

It is a easy component for form validation.

**Usage**

```
use Suvarivaza\EV\EasyValidator; // use namespace Suvarivaza\EV\EasyValidator
```

Example:
```
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$password_again = $_REQUEST['password_again'];
$email = $_REQUEST['email'];

$validator = new EasyValidator(); // create an object of the EasyValidator class

//Pass the field name to the name method
//Pass the value to the value method
//Pass the validation rules to the rules method
$validator->name('username')->value($username)->rules(['required' => true, 'min' => 4, 'max'=> 12 ]);
$validator->name('password')->value($password)->rules(['required' => true, 'min' => 6, 'max'=> 12 ]);
$validator->name('password_again')->value($password_again)->rules(['required' => true, 'matches' => 'password', 'min' => 6, 'max'=> 12, ]);
$validator->name('email')->value($email)->rules(['required' => true, 'email' => true, 'unique' => true ]);

if ($validator->success()) {
    echo 'Validation success!';
} else {
    print_r($validator->getError()); //get the first error that occurs
    print_r($validator->getErrors()); //get all errors in the form of an associative array with the keys specified in the name() method
}

```

*To use the unique rule, it is necessary to implement the exists() method in the EasyValidator class, which will be used to check the desired value in the database.

