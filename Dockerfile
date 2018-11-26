FROM centos:latest

RUN yum -y update && yum -y install \
    httpd   \
    php     \
    mysql   

RUN mkdir -p /var/www/html/logs

RUN htpasswd -cb /etc/httpd/.htpasswd admin admin

COPY apache.conf    /etc/httpd/conf.d/
COPY app            /var/www/html/

CMD /usr/sbin/httpd -DFOREGROUND

EXPOSE 80
