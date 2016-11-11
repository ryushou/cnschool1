<?php defined('COREPATH') or exit('No direct script access allowed'); ?>

ERROR - 2016-07-25 11:05:08 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: =?UTF-8?B?55Kw5pel5pys5rW35Zu96Zqb6LK/5piT5pyJ6ZmQ5YWs5Y+4?= &lt;chy22258@hotmail.com&gt;</Message>
  </Error>
  <RequestId>4648cd34-520c-11e6-adb5-0992ceb0921c</RequestId>
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
ERROR - 2016-07-25 11:05:08 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: =?UTF-8?B?55Kw5pel5pys5rW35Zu96Zqb6LK/5piT5pyJ6ZmQ5YWs5Y+4?= &lt;chy22258@hotmail.com&gt;</Message>
  </Error>
  <RequestId>46c2de6d-520c-11e6-ac72-6fea7f867a6e</RequestId>
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
ERROR - 2016-07-25 11:05:19 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: =?UTF-8?B?55Kw5pel5pys5rW35Zu96Zqb6LK/5piT5pyJ6ZmQ5YWs5Y+4?= &lt;chy22258@hotmail.com&gt;</Message>
  </Error>
  <RequestId>4d29354a-520c-11e6-8bec-15563db85369</RequestId>
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
ERROR - 2016-07-25 11:05:20 --> exception 'Fuel\Core\RequestStatusException' with message '<ErrorResponse xmlns="http://ses.amazonaws.com/doc/2010-12-01/">
  <Error>
    <Type>Sender</Type>
    <Code>MessageRejected</Code>
    <Message>Email address is not verified. The following identities failed the check in region US-WEST-2: =?UTF-8?B?55Kw5pel5pys5rW35Zu96Zqb6LK/5piT5pyJ6ZmQ5YWs5Y+4?= &lt;chy22258@hotmail.com&gt;</Message>
  </Error>
  <RequestId>4d9f9dce-520c-11e6-ac72-6fea7f867a6e</RequestId>
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
