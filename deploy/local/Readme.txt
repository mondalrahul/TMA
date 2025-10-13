For WINDOWS users
Note: Need install wampserver: http://www.wampserver.com/en/
Install wampserver to D:/

1/ Edit the hosts file: c:\Windows\System32\drivers\etc\hosts
Insert this string => 127.0.0.1 tma.local

2/ Edit the vhosts file: c:\wamp64\bin\apache\apache2.4.23\conf\extra\httpd-vhosts.conf
Insert this string => IncludeOptional "d:/wamp64/www/tmaproject/deploy/local/tma_config.conf"

3/ Restart WampServer