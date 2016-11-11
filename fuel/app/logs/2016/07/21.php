<?php defined('COREPATH') or exit('No direct script access allowed'); ?>

ERROR - 2016-07-21 19:39:08 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: chenyang@newcon.co.jp...</Message>
  </Error>
  <RequestId>67e66bb6-4f2f-11e6-b413-19297b550958</RequestId>
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
ERROR - 2016-07-21 19:39:19 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: chenyang@newcon.co.jp...</Message>
  </Error>
  <RequestId>6e65ef50-4f2f-11e6-8ee5-9782942805fc</RequestId>
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
ERROR - 2016-07-21 19:43:27 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: chenyang@newcon.co.jp...</Message>
  </Error>
  <RequestId>0263d3c4-4f30-11e6-9f6f-afa9194e6431</RequestId>
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
ERROR - 2016-07-21 19:43:38 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: chenyang@newcon.co.jp...</Message>
  </Error>
  <RequestId>08cf813c-4f30-11e6-b537-8b45df4c2ef7</RequestId>
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
ERROR - 2016-07-21 19:51:47 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: chenyang@newcon.co.jp...</Message>
  </Error>
  <RequestId>2ca34c7f-4f31-11e6-8725-d3fee296541d</RequestId>
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
ERROR - 2016-07-21 19:51:58 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: chenyang@newcon.co.jp...</Message>
  </Error>
  <RequestId>331c8e81-4f31-11e6-9521-b1e49c426eb9</RequestId>
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
ERROR - 2016-07-21 20:03:47 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: chenyang@newcon.co.jp...</Message>
  </Error>
  <RequestId>d9737384-4f32-11e6-971c-093f1d457b32</RequestId>
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
ERROR - 2016-07-21 20:03:58 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: chenyang@newcon.co.jp...</Message>
  </Error>
  <RequestId>dfe9813c-4f32-11e6-ba0e-511960a98741</RequestId>
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
ERROR - 2016-07-21 20:12:17 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>09eb2de4-4f34-11e6-8f08-319e5d0f5d4a</RequestId>
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
ERROR - 2016-07-21 20:12:28 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>104a7eef-4f34-11e6-8d22-8573d17cd1b7</RequestId>
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
ERROR - 2016-07-21 21:30:17 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>ef7fde0f-4f3e-11e6-901f-41baa6049cff</RequestId>
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
ERROR - 2016-07-21 21:30:28 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>f5db8612-4f3e-11e6-971c-093f1d457b32</RequestId>
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
ERROR - 2016-07-21 21:33:54 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>709a67dc-4f3f-11e6-8f08-319e5d0f5d4a</RequestId>
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
ERROR - 2016-07-21 21:34:05 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>76f04342-4f3f-11e6-b2e6-85b7ef0ffaea</RequestId>
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
ERROR - 2016-07-21 21:49:17 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: chenyang@newcon.co.jp</Message>
  </Error>
  <RequestId>96e88c84-4f41-11e6-9f6f-afa9194e6431</RequestId>
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
ERROR - 2016-07-21 21:49:28 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: chenyang@newcon.co.jp</Message>
  </Error>
  <RequestId>9d5c01c5-4f41-11e6-adb5-0992ceb0921c</RequestId>
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
ERROR - 2016-07-21 21:51:27 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>e478cfd9-4f41-11e6-8725-d3fee296541d</RequestId>
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
ERROR - 2016-07-21 21:51:38 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>eadcb465-4f41-11e6-ba5e-cb7831f2aecc</RequestId>
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
ERROR - 2016-07-21 21:53:09 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>20e78be3-4f42-11e6-ac72-6fea7f867a6e</RequestId>
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
ERROR - 2016-07-21 21:53:19 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>273e780d-4f42-11e6-ba5e-cb7831f2aecc</RequestId>
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
