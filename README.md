# Login Alert

Get notified whenever a Member logs into your site. Configure multiple Login Alerts using multiple criteria, such as Control Panel vs Front End, which user(s) and/or role(s) who login, and which portion of your site they log in to. 

Super handy for security, to know when a Member account gets compromised, and/or for auditing Member activity, all in one tool. Create multiple Alerts, with varying criteria, using different email notifications and delivered to multiple recipients. 

### Running Tests

To run the unit tests included, you'll need to have the [Unit Test](https://expressionengine.com/add-ons/unit-tests "Unit Test") Add-on installed as well as this Add-on. 

```php
php ee/eecli.php tests:run -a login_alert
```