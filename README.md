
	sudo apt-get install graphviz
	
	cd /home/salimane/htdocs
	git clone https://github.com/salimane/xhprof.git
	cd xhprof/extension
	phpize
	./configure
	make
	make test
	sudo make install
	
	sudo nano /etc/php5/conf.d/xhprof.ini
	
	extension=xhprof.so
	xhprof.output_dir=/tmp/ 
	
	sudo chmod -R 777 /home/salimane/htdocs/xhprof
	
	sudo gedit /etc/php5/cgi/php.ini
	sudo nano /etc/php5/fpm/php.ini
	sudo gedit /etc/php5/apache2/php.ini
	
	auto_prepend_file = /home/salimane/htdocs/xhprof/xhprof_html/header.php
	auto_append_file = /home/salimane/htdocs/xhprof/xhprof_html/footer.php
	
	or 
	
	# For apache XHPROF Profiling .htaccess
	  php_value auto_prepend_file /home/salimane/htdocs/xhprof/xhprof_html/header.php
	  php_value auto_append_file /home/salimane/htdocs/xhprof/xhprof_html/footer.php
	
	
	
	apache vhost
	
	<VirtualHost *:80>
		    ServerAdmin webmaster@localhost
		    ServerName xhprof.local
		    ServerAlias www.xhprof.local
		    UseCanonicalName Off
		    DocumentRoot /home/salimane/htdocs/xhprof
		    <Directory /home/salimane/htdocs/xhprof/>
		            Options Indexes FollowSymLinks MultiViews
		            AllowOverride All
		            Order allow,deny
		            allow from all
		    </Directory>
		    ErrorLog /var/log/apache2/xhprof.error.log
		    LogLevel debug
		    CustomLog /var/log/apache2/xhprof.access.log combined
		    php_value memory_limit 128M
	</VirtualHost>
	
	
	
	nginx vhost
	
	server {
	  client_max_body_size 4M;
	  listen   80;
	  server_name xhprof.local;
	  root /home/salimane/htdocs/xhprof/xhprof_html;
	  index index.php;
	  access_log  /var/log/nginx/xhprof.access.log;
	  error_log  /var/log/nginx/xhprof.error.log;
	  location ~* ^.+\.(jpg|jpeg|gif|css|png|js|ico)$ {
	  access_log off;
	  expires 1m;
	  }
	  if (!-e $request_filename) {
		rewrite ^(^\/*)/(.*)$ $1/index.php last;
	  }
	  location ~ ^(.+\.php)(.*)$ {
		fastcgi_pass php_backend;
		fastcgi_index index.php;
		include fastcgi_params;
	  }
	  location ~ /\.ht {
		deny all;
	  }
	}
	
	upstream php_backend {
	  server 127.0.0.1:9000;
	}

