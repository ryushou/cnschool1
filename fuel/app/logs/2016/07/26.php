<?php defined('COREPATH') or exit('No direct script access allowed'); ?>

ERROR - 2016-07-26 11:40:57 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>72b9dc4c-52da-11e6-ba5e-cb7831f2aecc</RequestId>
</ErrorResponse>
' in /var/www/html/gts/cos_cnschool1/fuel/core/classes/request/curl.php:178
Stack trace:
#0 /var/www/html/gts/cos_cnschool1/fuel/packages/email/classes/email/driver/ses.php(100): Fuel\Core\Request_Curl->execute(Array)
#1 /var/www/html/gts/cos_cnschool1/fuel/packages/email/classes/email/driver.php(884): Email_Driver_SES->_send()
#2 /var/www/html/gts/cos_cnschool1/fuel/app/tasks/mail.php(44): Email\Email_Driver->send()
#3 /var/www/html/gts/cos_cnschool1/fuel/app/tasks/mail.php(16): Fuel\Tasks\Mail->send_mail(Object(Model_Mail_Queue))
#4 /var/www/html/gts/cos_cnschool1/fuel/core/base.php(434): Fuel\Tasks\Mail->send()
#5 /var/www/html/gts/cos_cnschool1/fuel/packages/oil/classes/refine.php(106): call_fuel_func_array(Array, Array)
#6 [internal function]: Oil\Refine::run('mail:send', Array)
#7 /var/www/html/gts/cos_cnschool1/fuel/packages/oil/classes/command.php(125): call_user_func('Oil\\Refine::run', 'mail:send', Array)
#8 /var/www/html/gts/cos_cnschool1/oil(57): Oil\Command::init(Array)
#9 {main}
ERROR - 2016-07-26 11:41:08 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>791b7760-52da-11e6-ba5e-cb7831f2aecc</RequestId>
</ErrorResponse>
' in /var/www/html/gts/cos_cnschool1/fuel/core/classes/request/curl.php:178
Stack trace:
#0 /var/www/html/gts/cos_cnschool1/fuel/packages/email/classes/email/driver/ses.php(100): Fuel\Core\Request_Curl->execute(Array)
#1 /var/www/html/gts/cos_cnschool1/fuel/packages/email/classes/email/driver.php(884): Email_Driver_SES->_send()
#2 /var/www/html/gts/cos_cnschool1/fuel/app/tasks/mail.php(44): Email\Email_Driver->send()
#3 /var/www/html/gts/cos_cnschool1/fuel/app/tasks/mail.php(16): Fuel\Tasks\Mail->send_mail(Object(Model_Mail_Queue))
#4 /var/www/html/gts/cos_cnschool1/fuel/core/base.php(434): Fuel\Tasks\Mail->send()
#5 /var/www/html/gts/cos_cnschool1/fuel/packages/oil/classes/refine.php(106): call_fuel_func_array(Array, Array)
#6 [internal function]: Oil\Refine::run('mail:send', Array)
#7 /var/www/html/gts/cos_cnschool1/fuel/packages/oil/classes/command.php(125): call_user_func('Oil\\Refine::run', 'mail:send', Array)
#8 /var/www/html/gts/cos_cnschool1/oil(57): Oil\Command::init(Array)
#9 {main}
ERROR - 2016-07-26 11:42:48 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>b51af6a7-52da-11e6-9f6f-afa9194e6431</RequestId>
</ErrorResponse>
' in /var/www/html/gts/cos_cnschool1/fuel/core/classes/request/curl.php:178
Stack trace:
#0 /var/www/html/gts/cos_cnschool1/fuel/packages/email/classes/email/driver/ses.php(100): Fuel\Core\Request_Curl->execute(Array)
#1 /var/www/html/gts/cos_cnschool1/fuel/packages/email/classes/email/driver.php(884): Email_Driver_SES->_send()
#2 /var/www/html/gts/cos_cnschool1/fuel/app/tasks/mail.php(44): Email\Email_Driver->send()
#3 /var/www/html/gts/cos_cnschool1/fuel/app/tasks/mail.php(16): Fuel\Tasks\Mail->send_mail(Object(Model_Mail_Queue))
#4 /var/www/html/gts/cos_cnschool1/fuel/core/base.php(434): Fuel\Tasks\Mail->send()
#5 /var/www/html/gts/cos_cnschool1/fuel/packages/oil/classes/refine.php(106): call_fuel_func_array(Array, Array)
#6 [internal function]: Oil\Refine::run('mail:send', Array)
#7 /var/www/html/gts/cos_cnschool1/fuel/packages/oil/classes/command.php(125): call_user_func('Oil\\Refine::run', 'mail:send', Array)
#8 /var/www/html/gts/cos_cnschool1/oil(57): Oil\Command::init(Array)
#9 {main}
ERROR - 2016-07-26 11:43:05 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>bec74f7e-52da-11e6-971c-093f1d457b32</RequestId>
</ErrorResponse>
' in /var/www/html/gts/cos_cnschool1/fuel/core/classes/request/curl.php:178
Stack trace:
#0 /var/www/html/gts/cos_cnschool1/fuel/packages/email/classes/email/driver/ses.php(100): Fuel\Core\Request_Curl->execute(Array)
#1 /var/www/html/gts/cos_cnschool1/fuel/packages/email/classes/email/driver.php(884): Email_Driver_SES->_send()
#2 /var/www/html/gts/cos_cnschool1/fuel/app/tasks/mail.php(44): Email\Email_Driver->send()
#3 /var/www/html/gts/cos_cnschool1/fuel/app/tasks/mail.php(16): Fuel\Tasks\Mail->send_mail(Object(Model_Mail_Queue))
#4 /var/www/html/gts/cos_cnschool1/fuel/core/base.php(434): Fuel\Tasks\Mail->send()
#5 /var/www/html/gts/cos_cnschool1/fuel/packages/oil/classes/refine.php(106): call_fuel_func_array(Array, Array)
#6 [internal function]: Oil\Refine::run('mail:send', Array)
#7 /var/www/html/gts/cos_cnschool1/fuel/packages/oil/classes/command.php(125): call_user_func('Oil\\Refine::run', 'mail:send', Array)
#8 /var/www/html/gts/cos_cnschool1/oil(57): Oil\Command::init(Array)
#9 {main}
ERROR - 2016-07-26 11:45:47 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>1f6e5acd-52db-11e6-ab5a-9d57cc6ced31</RequestId>
</ErrorResponse>
' in /var/www/html/gts/cos_cnschool1/fuel/core/classes/request/curl.php:178
Stack trace:
#0 /var/www/html/gts/cos_cnschool1/fuel/packages/email/classes/email/driver/ses.php(100): Fuel\Core\Request_Curl->execute(Array)
#1 /var/www/html/gts/cos_cnschool1/fuel/packages/email/classes/email/driver.php(884): Email_Driver_SES->_send()
#2 /var/www/html/gts/cos_cnschool1/fuel/app/tasks/mail.php(44): Email\Email_Driver->send()
#3 /var/www/html/gts/cos_cnschool1/fuel/app/tasks/mail.php(16): Fuel\Tasks\Mail->send_mail(Object(Model_Mail_Queue))
#4 /var/www/html/gts/cos_cnschool1/fuel/core/base.php(434): Fuel\Tasks\Mail->send()
#5 /var/www/html/gts/cos_cnschool1/fuel/packages/oil/classes/refine.php(106): call_fuel_func_array(Array, Array)
#6 [internal function]: Oil\Refine::run('mail:send', Array)
#7 /var/www/html/gts/cos_cnschool1/fuel/packages/oil/classes/command.php(125): call_user_func('Oil\\Refine::run', 'mail:send', Array)
#8 /var/www/html/gts/cos_cnschool1/oil(57): Oil\Command::init(Array)
#9 {main}
ERROR - 2016-07-26 11:45:58 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>25c965c8-52db-11e6-b640-f79c6f8835e1</RequestId>
</ErrorResponse>
' in /var/www/html/gts/cos_cnschool1/fuel/core/classes/request/curl.php:178
Stack trace:
#0 /var/www/html/gts/cos_cnschool1/fuel/packages/email/classes/email/driver/ses.php(100): Fuel\Core\Request_Curl->execute(Array)
#1 /var/www/html/gts/cos_cnschool1/fuel/packages/email/classes/email/driver.php(884): Email_Driver_SES->_send()
#2 /var/www/html/gts/cos_cnschool1/fuel/app/tasks/mail.php(44): Email\Email_Driver->send()
#3 /var/www/html/gts/cos_cnschool1/fuel/app/tasks/mail.php(16): Fuel\Tasks\Mail->send_mail(Object(Model_Mail_Queue))
#4 /var/www/html/gts/cos_cnschool1/fuel/core/base.php(434): Fuel\Tasks\Mail->send()
#5 /var/www/html/gts/cos_cnschool1/fuel/packages/oil/classes/refine.php(106): call_fuel_func_array(Array, Array)
#6 [internal function]: Oil\Refine::run('mail:send', Array)
#7 /var/www/html/gts/cos_cnschool1/fuel/packages/oil/classes/command.php(125): call_user_func('Oil\\Refine::run', 'mail:send', Array)
#8 /var/www/html/gts/cos_cnschool1/oil(57): Oil\Command::init(Array)
#9 {main}
ERROR - 2016-07-26 11:48:53 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>8ea8a0c5-52db-11e6-8ee5-9782942805fc</RequestId>
</ErrorResponse>
' in /var/www/html/gts/cos_cnschool1/fuel/core/classes/request/curl.php:178
Stack trace:
#0 /var/www/html/gts/cos_cnschool1/fuel/packages/email/classes/email/driver/ses.php(100): Fuel\Core\Request_Curl->execute(Array)
#1 /var/www/html/gts/cos_cnschool1/fuel/packages/email/classes/email/driver.php(884): Email_Driver_SES->_send()
#2 /var/www/html/gts/cos_cnschool1/fuel/app/tasks/mail.php(44): Email\Email_Driver->send()
#3 /var/www/html/gts/cos_cnschool1/fuel/app/tasks/mail.php(16): Fuel\Tasks\Mail->send_mail(Object(Model_Mail_Queue))
#4 /var/www/html/gts/cos_cnschool1/fuel/core/base.php(434): Fuel\Tasks\Mail->send()
#5 /var/www/html/gts/cos_cnschool1/fuel/packages/oil/classes/refine.php(106): call_fuel_func_array(Array, Array)
#6 [internal function]: Oil\Refine::run('mail:send', Array)
#7 /var/www/html/gts/cos_cnschool1/fuel/packages/oil/classes/command.php(125): call_user_func('Oil\\Refine::run', 'mail:send', Array)
#8 /var/www/html/gts/cos_cnschool1/oil(57): Oil\Command::init(Array)
#9 {main}
ERROR - 2016-07-26 11:49:04 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>950ad84d-52db-11e6-8f08-319e5d0f5d4a</RequestId>
</ErrorResponse>
' in /var/www/html/gts/cos_cnschool1/fuel/core/classes/request/curl.php:178
Stack trace:
#0 /var/www/html/gts/cos_cnschool1/fuel/packages/email/classes/email/driver/ses.php(100): Fuel\Core\Request_Curl->execute(Array)
#1 /var/www/html/gts/cos_cnschool1/fuel/packages/email/classes/email/driver.php(884): Email_Driver_SES->_send()
#2 /var/www/html/gts/cos_cnschool1/fuel/app/tasks/mail.php(44): Email\Email_Driver->send()
#3 /var/www/html/gts/cos_cnschool1/fuel/app/tasks/mail.php(16): Fuel\Tasks\Mail->send_mail(Object(Model_Mail_Queue))
#4 /var/www/html/gts/cos_cnschool1/fuel/core/base.php(434): Fuel\Tasks\Mail->send()
#5 /var/www/html/gts/cos_cnschool1/fuel/packages/oil/classes/refine.php(106): call_fuel_func_array(Array, Array)
#6 [internal function]: Oil\Refine::run('mail:send', Array)
#7 /var/www/html/gts/cos_cnschool1/fuel/packages/oil/classes/command.php(125): call_user_func('Oil\\Refine::run', 'mail:send', Array)
#8 /var/www/html/gts/cos_cnschool1/oil(57): Oil\Command::init(Array)
#9 {main}
