# 步骤1： 更新代码
cd /home/www/dian_pos/new_pos/pos
git reset --hard HEAD
git clean -df
git pull origin master




cd /home/www/dian_pos/
chmod -R 770 *
chown www.www -R *  

cd /home/www/dian_pos/new_pos/pos

