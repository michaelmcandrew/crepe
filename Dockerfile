FROM michaelmcandrew/civicrm-drupal

COPY apache-vhost.conf /etc/apache2/sites-enabled/crepe.conf

WORKDIR /var/www/crepe
