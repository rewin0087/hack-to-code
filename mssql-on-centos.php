rpm -ivh http://dag.wieers.com/rpm/packages/rpmforge-release/rpmforge-release-0.5.2-2.el6.rf.x86_64.rpm
 
cd /etc/yum.repos.d/
wget http://rpms.famillecollet.com/enterprise/remi.repo
 
yum install freetds
yum install freetds-devel
yum install --enablerepo=remi php-mssql