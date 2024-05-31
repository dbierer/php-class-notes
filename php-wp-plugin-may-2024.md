# Class Notes: PHP WP Plugin

## TODO
* Path to apps is now `web/apps`
  * Add instruction after "Hello Dolly" installation to find plugins directory for this installation:
```
$ find -type d -name hello* -ls
```
* Missing an `add_action()`
  * Look at the completed code

* Add missing `wp` to this path: `wp-admin`
* Investigate `tools.php` to see if it's causing blockage
* Forgot to mention creating an `includes` folder under the new plugin structure
* Under `Activate the Widget` mention that WP_LINK_DIR is in the `secrets.sh` file
* Modify the access instructions and show them how to find the PHP user and assign permissions as needed
* In the 2nd lab, Security Features, you need to make it more clear where the security pieces fit
* At the end, add completed versions of the code files for student reference
* Duplicate name if you follow the lab exactly

* http://localhost:9999/#/1/87
  * Add "wp" to the wp-admin path
  * Same here: http://localhost:9999/#/1/88
  * Same here: http://localhost:9999/#/1/90

* Need to reset the nonce in the AJAX request
