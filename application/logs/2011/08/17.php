<?php defined('SYSPATH') or die('No direct script access.'); ?>

2011-08-17 20:36:58 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL davyjones was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 87 ]
2011-08-17 20:36:58 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL davyjones was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 87 ]
--
#0 /var/www/davyjones/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 /var/www/davyjones/system/classes/kohana/request.php(1138): Kohana_Request_Client->execute(Object(Request))
#2 /var/www/davyjones/index.php(109): Kohana_Request->execute()
#3 {main}
2011-08-17 20:37:06 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL davyjones was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 87 ]
2011-08-17 20:37:06 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL davyjones was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 87 ]
--
#0 /var/www/davyjones/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 /var/www/davyjones/system/classes/kohana/request.php(1138): Kohana_Request_Client->execute(Object(Request))
#2 /var/www/davyjones/index.php(109): Kohana_Request->execute()
#3 {main}
2011-08-17 19:38:16 --- ERROR: ErrorException [ 1 ]: Call to undefined method Kohana::debug() ~ APPPATH/classes/controller/welcome.php [ 8 ]
2011-08-17 19:38:16 --- STRACE: ErrorException [ 1 ]: Call to undefined method Kohana::debug() ~ APPPATH/classes/controller/welcome.php [ 8 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2011-08-17 19:46:24 --- ERROR: ErrorException [ 1 ]: Call to undefined function read() ~ APPPATH/classes/controller/welcome.php [ 10 ]
2011-08-17 19:46:24 --- STRACE: ErrorException [ 1 ]: Call to undefined function read() ~ APPPATH/classes/controller/welcome.php [ 10 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2011-08-17 19:46:45 --- ERROR: ErrorException [ 1 ]: Call to undefined function read() ~ APPPATH/classes/controller/welcome.php [ 10 ]
2011-08-17 19:46:45 --- STRACE: ErrorException [ 1 ]: Call to undefined function read() ~ APPPATH/classes/controller/welcome.php [ 10 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2011-08-17 19:46:56 --- ERROR: ErrorException [ 1 ]: Call to undefined method Config::read() ~ APPPATH/classes/controller/welcome.php [ 10 ]
2011-08-17 19:46:56 --- STRACE: ErrorException [ 1 ]: Call to undefined method Config::read() ~ APPPATH/classes/controller/welcome.php [ 10 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2011-08-17 19:50:14 --- ERROR: ErrorException [ 1 ]: Call to undefined method Config::instance() ~ APPPATH/classes/controller/welcome.php [ 9 ]
2011-08-17 19:50:14 --- STRACE: ErrorException [ 1 ]: Call to undefined method Config::instance() ~ APPPATH/classes/controller/welcome.php [ 9 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2011-08-17 19:57:42 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_VARIABLE ~ APPPATH/classes/controller/welcome.php [ 13 ]
2011-08-17 19:57:42 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected T_VARIABLE ~ APPPATH/classes/controller/welcome.php [ 13 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2011-08-17 19:57:57 --- ERROR: ErrorException [ 1 ]: Call to undefined method Kohana::config() ~ APPPATH/classes/controller/welcome.php [ 10 ]
2011-08-17 19:57:57 --- STRACE: ErrorException [ 1 ]: Call to undefined method Kohana::config() ~ APPPATH/classes/controller/welcome.php [ 10 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2011-08-17 20:00:10 --- ERROR: ErrorException [ 8 ]: Undefined variable: name ~ APPPATH/classes/controller/welcome.php [ 10 ]
2011-08-17 20:00:10 --- STRACE: ErrorException [ 8 ]: Undefined variable: name ~ APPPATH/classes/controller/welcome.php [ 10 ]
--
#0 /var/www/davyjones/application/classes/controller/welcome.php(10): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/davyjo...', 10, Array)
#1 [internal function]: Controller_Welcome->action_index()
#2 /var/www/davyjones/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_Welcome))
#3 /var/www/davyjones/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#4 /var/www/davyjones/system/classes/kohana/request.php(1138): Kohana_Request_Client->execute(Object(Request))
#5 /var/www/davyjones/index.php(109): Kohana_Request->execute()
#6 {main}
2011-08-17 20:00:49 --- ERROR: ErrorException [ 8 ]: Undefined variable: type ~ APPPATH/classes/controller/welcome.php [ 10 ]
2011-08-17 20:00:49 --- STRACE: ErrorException [ 8 ]: Undefined variable: type ~ APPPATH/classes/controller/welcome.php [ 10 ]
--
#0 /var/www/davyjones/application/classes/controller/welcome.php(10): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/davyjo...', 10, Array)
#1 [internal function]: Controller_Welcome->action_index()
#2 /var/www/davyjones/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_Welcome))
#3 /var/www/davyjones/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#4 /var/www/davyjones/system/classes/kohana/request.php(1138): Kohana_Request_Client->execute(Object(Request))
#5 /var/www/davyjones/index.php(109): Kohana_Request->execute()
#6 {main}
2011-08-17 20:00:54 --- ERROR: ErrorException [ 8 ]: Undefined index:  type ~ APPPATH/classes/controller/welcome.php [ 10 ]
2011-08-17 20:00:54 --- STRACE: ErrorException [ 8 ]: Undefined index:  type ~ APPPATH/classes/controller/welcome.php [ 10 ]
--
#0 /var/www/davyjones/application/classes/controller/welcome.php(10): Kohana_Core::error_handler(8, 'Undefined index...', '/var/www/davyjo...', 10, Array)
#1 [internal function]: Controller_Welcome->action_index()
#2 /var/www/davyjones/system/classes/kohana/request/client/internal.php(118): ReflectionMethod->invoke(Object(Controller_Welcome))
#3 /var/www/davyjones/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#4 /var/www/davyjones/system/classes/kohana/request.php(1138): Kohana_Request_Client->execute(Object(Request))
#5 /var/www/davyjones/index.php(109): Kohana_Request->execute()
#6 {main}
2011-08-17 20:11:08 --- ERROR: ErrorException [ 8 ]: Undefined variable: header ~ APPPATH/views/main.php [ 12 ]
2011-08-17 20:11:08 --- STRACE: ErrorException [ 8 ]: Undefined variable: header ~ APPPATH/views/main.php [ 12 ]
--
#0 /var/www/davyjones/application/views/main.php(12): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/davyjo...', 12, Array)
#1 /var/www/davyjones/system/classes/kohana/view.php(61): include('/var/www/davyjo...')
#2 /var/www/davyjones/system/classes/kohana/view.php(343): Kohana_View::capture('/var/www/davyjo...', Array)
#3 /var/www/davyjones/system/classes/kohana/controller/template.php(44): Kohana_View->render()
#4 [internal function]: Kohana_Controller_Template->after()
#5 /var/www/davyjones/system/classes/kohana/request/client/internal.php(121): ReflectionMethod->invoke(Object(Controller_Welcome))
#6 /var/www/davyjones/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#7 /var/www/davyjones/system/classes/kohana/request.php(1138): Kohana_Request_Client->execute(Object(Request))
#8 /var/www/davyjones/index.php(109): Kohana_Request->execute()
#9 {main}
2011-08-17 20:21:07 --- ERROR: ErrorException [ 8 ]: Undefined variable: html_head ~ APPPATH/views/main.php [ 4 ]
2011-08-17 20:21:07 --- STRACE: ErrorException [ 8 ]: Undefined variable: html_head ~ APPPATH/views/main.php [ 4 ]
--
#0 /var/www/davyjones/application/views/main.php(4): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/davyjo...', 4, Array)
#1 /var/www/davyjones/system/classes/kohana/view.php(61): include('/var/www/davyjo...')
#2 /var/www/davyjones/system/classes/kohana/view.php(343): Kohana_View::capture('/var/www/davyjo...', Array)
#3 /var/www/davyjones/system/classes/kohana/controller/template.php(44): Kohana_View->render()
#4 [internal function]: Kohana_Controller_Template->after()
#5 /var/www/davyjones/system/classes/kohana/request/client/internal.php(121): ReflectionMethod->invoke(Object(Controller_Main))
#6 /var/www/davyjones/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#7 /var/www/davyjones/system/classes/kohana/request.php(1138): Kohana_Request_Client->execute(Object(Request))
#8 /var/www/davyjones/index.php(109): Kohana_Request->execute()
#9 {main}
2011-08-17 21:04:24 --- ERROR: ErrorException [ 8 ]: Undefined variable: menu ~ APPPATH/views/header.php [ 3 ]
2011-08-17 21:04:24 --- STRACE: ErrorException [ 8 ]: Undefined variable: menu ~ APPPATH/views/header.php [ 3 ]
--
#0 /var/www/davyjones/application/views/header.php(3): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/davyjo...', 3, Array)
#1 /var/www/davyjones/system/classes/kohana/view.php(61): include('/var/www/davyjo...')
#2 /var/www/davyjones/system/classes/kohana/view.php(343): Kohana_View::capture('/var/www/davyjo...', Array)
#3 /var/www/davyjones/system/classes/kohana/view.php(228): Kohana_View->render()
#4 /var/www/davyjones/application/views/main.php(8): Kohana_View->__toString()
#5 /var/www/davyjones/system/classes/kohana/view.php(61): include('/var/www/davyjo...')
#6 /var/www/davyjones/system/classes/kohana/view.php(343): Kohana_View::capture('/var/www/davyjo...', Array)
#7 /var/www/davyjones/system/classes/kohana/controller/template.php(44): Kohana_View->render()
#8 /var/www/davyjones/application/classes/controller/main.php(48): Kohana_Controller_Template->after()
#9 [internal function]: Controller_Main->after()
#10 /var/www/davyjones/system/classes/kohana/request/client/internal.php(121): ReflectionMethod->invoke(Object(Controller_Main))
#11 /var/www/davyjones/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#12 /var/www/davyjones/system/classes/kohana/request.php(1138): Kohana_Request_Client->execute(Object(Request))
#13 /var/www/davyjones/index.php(109): Kohana_Request->execute()
#14 {main}
2011-08-17 23:17:35 --- ERROR: ErrorException [ 1 ]: Class 'Mainmenu' not found ~ APPPATH/views/header.php [ 3 ]
2011-08-17 23:17:35 --- STRACE: ErrorException [ 1 ]: Class 'Mainmenu' not found ~ APPPATH/views/header.php [ 3 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2011-08-17 23:23:00 --- ERROR: ErrorException [ 1 ]: Class 'Mainmenu' not found ~ APPPATH/views/header.php [ 3 ]
2011-08-17 23:23:00 --- STRACE: ErrorException [ 1 ]: Class 'Mainmenu' not found ~ APPPATH/views/header.php [ 3 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2011-08-17 23:23:00 --- ERROR: ErrorException [ 1 ]: Class 'Mainmenu' not found ~ APPPATH/views/header.php [ 3 ]
2011-08-17 23:23:00 --- STRACE: ErrorException [ 1 ]: Class 'Mainmenu' not found ~ APPPATH/views/header.php [ 3 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2011-08-17 23:42:04 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL register was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 87 ]
2011-08-17 23:42:04 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL register was not found on this server. ~ SYSPATH/classes/kohana/request/client/internal.php [ 87 ]
--
#0 /var/www/davyjones/system/classes/kohana/request/client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 /var/www/davyjones/system/classes/kohana/request.php(1138): Kohana_Request_Client->execute(Object(Request))
#2 /var/www/davyjones/index.php(109): Kohana_Request->execute()
#3 {main}