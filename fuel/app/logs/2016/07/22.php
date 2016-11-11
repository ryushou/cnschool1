<?php defined('COREPATH') or exit('No direct script access allowed'); ?>

ERROR - 2016-07-22 09:55:07 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>fd08173e-4fa6-11e6-ba0e-511960a98741</RequestId>
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
ERROR - 2016-07-22 09:55:18 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>035cb9f1-4fa7-11e6-bbc7-29a1d81f5964</RequestId>
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
ERROR - 2016-07-22 10:02:07 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>f78722d3-4fa7-11e6-b00c-011b0778e571</RequestId>
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
ERROR - 2016-07-22 10:02:18 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>fde75eae-4fa7-11e6-b00c-011b0778e571</RequestId>
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
ERROR - 2016-07-22 10:07:47 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: =?ISO-2022-JP?B?GyRCNERGfEtcMyQ5cTpdS0cwV00tOEI4eDtKGyhC?= &lt;chy22258@hotmail.com&gt;</Message>
  </Error>
  <RequestId>c1b456de-4fa8-11e6-b537-8b45df4c2ef7</RequestId>
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
ERROR - 2016-07-22 10:07:57 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: =?ISO-2022-JP?B?GyRCNERGfEtcMyQ5cTpdS0cwV00tOEI4eDtKGyhC?= &lt;chy22258@hotmail.com&gt;</Message>
  </Error>
  <RequestId>c81ad385-4fa8-11e6-adb5-0992ceb0921c</RequestId>
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
ERROR - 2016-07-22 11:17:37 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: chenyang@newcon.co.jp</Message>
  </Error>
  <RequestId>83a46273-4fb2-11e6-901f-41baa6049cff</RequestId>
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
ERROR - 2016-07-22 11:17:48 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: chenyang@newcon.co.jp</Message>
  </Error>
  <RequestId>8a162a26-4fb2-11e6-ba0e-511960a98741</RequestId>
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
ERROR - 2016-07-22 11:20:36 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: chy &lt;chy22258@hotmail.com&gt;</Message>
  </Error>
  <RequestId>ee5fb01f-4fb2-11e6-8ee5-9782942805fc</RequestId>
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
ERROR - 2016-07-22 11:20:47 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: chy &lt;chy22258@hotmail.com&gt;</Message>
  </Error>
  <RequestId>f4c89e42-4fb2-11e6-86ff-4f88df53fc8a</RequestId>
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
ERROR - 2016-07-22 13:11:57 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: =?ISO-2022-JP?B?GyRCNERGfEtcMyQ5cTpdS0cwV00tOEI4eDtKGyhC?= &lt;chy22258@hotmail.com&gt;</Message>
  </Error>
  <RequestId>7c7c281a-4fc2-11e6-9521-b1e49c426eb9</RequestId>
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
ERROR - 2016-07-22 13:12:08 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: =?ISO-2022-JP?B?GyRCNERGfEtcMyQ5cTpdS0cwV00tOEI4eDtKGyhC?= &lt;chy22258@hotmail.com&gt;</Message>
  </Error>
  <RequestId>82ec909f-4fc2-11e6-9521-b1e49c426eb9</RequestId>
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
ERROR - 2016-07-22 13:40:57 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>89baacab-4fc6-11e6-ac3e-0ffdabcaf893</RequestId>
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
ERROR - 2016-07-22 13:41:08 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>901b0f18-4fc6-11e6-93bf-eb23b11e1c8e</RequestId>
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
ERROR - 2016-07-22 13:44:04 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>f90175d3-4fc6-11e6-93bf-eb23b11e1c8e</RequestId>
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
ERROR - 2016-07-22 13:44:15 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>SignatureDoesNotMatch</Code>
    <Message>The request signature we calculated does not match the signature you provided. Check your AWS Secret Access Key and signing method. Consult the service documentation for details.</Message>
  </Error>
  <RequestId>ff635f34-4fc6-11e6-901f-41baa6049cff</RequestId>
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
