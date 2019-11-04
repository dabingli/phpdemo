yum -y install gcc
yum -y install gcc-c++
groupadd www
useradd -g www www
yum -y install zlib zlib-devel openssl openssl--devel pcre pcre-devel
yum -y install openssl openssl-devel
yum -y install libxml2 libxml2-dev
yum -y install libxslt-devel
yum install -y zlib-devel
yum -y install gcc-c++ autoconf automake
yum -y install gd-devel
mkdir -p /usr/local/src/httpd/apr
cd /usr/local/src/httpd/apr
wget http://zhoucheng.oss-cn-shenzhen.aliyuncs.com/httpd_install/apr-1.6.5.tar.gz
tar -zxf apr-1.6.5.tar.gz
cd apr-1.6.5
./configure --prefix=/usr/local/apr && make && make install
echo $? #来判断以上操作是否又报错，非0则不成功，若没有继续安装下一个包
mkdir -p /usr/local/src/httpd/apr-util
cd /usr/local/src/httpd/apr-util
wget http://zhoucheng.oss-cn-shenzhen.aliyuncs.com/httpd_install/apr-util-1.6.1.tar.gz
tar -zxf apr-util-1.6.1.tar.gz
cd apr-util-1.6.1
./configure --prefix=/usr/local/apr-util --with-apr=/usr/local/apr
make && make install
wget http://zhoucheng.oss-cn-shenzhen.aliyuncs.com/httpd_install/httpd-2.4.38.tar.gz
tar -zxf httpd-2.4.38.tar.gz
cd httpd-2.4.38
./configure --prefix=/usr/local/httpd \
--enable-so \
--enable-rewrite \
--enable-ssl \
--with-ssl \
--enable-cgi \
--enable-modules=all \
--enable-mods-shared=all \
--enable-mpms-shared=all \
--with-mpm=event \
--with-zlib \
--with-pcre \
--with-apr=/usr/local/apr \
--with-apr-util=/usr/local/apr-util \
--enable-expires \
--enable-forward \
--enable-speling \
--enable-vhost-alias \
--enable-deflate
make -j 4 && make install -j 4
ln -s /usr/local/httpd/bin/* /usr/local/bin/
cd /usr/local/httpd/bin/
cp apachectl /etc/init.d/httpd
cp -rf /usr/local/httpd/bin/apachectl /etc/rc.d/init.d/httpd
ln -s /etc/rc.d/init.d/httpd  /etc/rc.d/rc3.d/S61httpd
chkconfig --add httpd
chkconfig httpd on
yum -y install curl curl-devel
yum -y install libmcrypt libmcrypt-devel
cd /usr/local/src
mkdir php
cd php
wget "http://zhoucheng.oss-cn-shenzhen.aliyuncs.com/httpd_install/php-7.3.3.tar.gz"
tar -zxf php-7.3.3.tar.gz
cd php-7.3.3
cd /usr/local/src/php
#参考http://www.php.cn/php-weizijiaocheng-414091.html
wget http://zhoucheng.oss-cn-shenzhen.aliyuncs.com/httpd_install/libzip-1.2.0.tar.gz
tar -zxvf libzip-1.2.0.tar.gz
cd libzip-1.2.0
./configure
make && make install
cd /usr/local/src/php/php-7.3.3
yum install -y cmake
#添加搜索路径到配置文件
echo '/usr/local/lib64
/usr/local/lib
/usr/lib
/usr/lib64'>>/etc/ld.so.conf
#然后 更新配置
ldconfig -v
cp /usr/local/lib/libzip/include/zipconf.h /usr/local/include/zipconf.h
./configure --prefix=/usr/local/php/ \
--with-apxs2=/usr/local/httpd/bin/apxs \
--enable-mbstring \
--with-curl \
--with-freetype-dir \
--with-gettext \
--enable-mysqlnd \
--with-config-file-path=/usr/local/php/etc/ \
--with-mysql-sock=/var/lib/mysql/mysql.sock \
--with-iconv-dir \
--with-kerberos \
--with-libdir=lib64 \
--with-libxml-dir \
--with-mysqli \
--with-openssl \
--with-pcre-regex \
--with-pdo-mysql \
--with-pdo-sqlite \
--with-pear \
--with-png-dir \
--with-xmlrpc \
--with-xsl \
--with-zlib \
--enable-bcmath \
--enable-libxml \
--enable-inline-optimization \
--enable-mbregex \
--enable-opcache \
--enable-pcntl \
--enable-shmop \
--enable-soap \
--enable-sockets \
--enable-sysvsem \
--enable-xml \
--enable-zip \
--with-gd \
--with-jpeg-dir \
--enable-gd-jis-conv
make -j 4 && make install -j 4
cp php.ini-development /usr/local/php/etc/php.ini
ln -s /usr/local/php/bin/php /usr/local/bin