# nix-cluster-app


This repository provides system for deployment, management and monitoring of Raspberry Pi 4 cluster. 



Repository consists of 3 folders:
* `master-node-config` — configuration files for master node
* `picocluster-config` — examples of configuration files for cluster deployment
* `picoapp` — source code of web application


### Requirements to use 
This system has to be run on NixOS operating system. Deployment process assumes blank system without changes in system configuration files. 


## How to deploy and use web application 

Clone this repository:
```
git clone https://github.com/adamzivcak/nix-cluster-app.git 
```


Copy configuration files from folder `master-node-config` to `/etc/nixos/`. Be cautious about your current config files, mostly about `fileSystems` section, which might be overwritten. Backup them before copying. 
```
cp nix-cluster-app/master-node-config/* /etc/nixos
```


Edit `filesySystems` section in `hardware-configuration.nix` file according to your system setup and IP addresses in other config files to fit your subnet. Run rebuild of system:
```
nixos-rebuild switch
```


Copy `picoapp` folder to `/var/www/` and enter it:
```
cp -R nix-cluster-app/picoapp/ /var/www/
cd /var/www/picoapp
```


Create environment file `.env` and tune it for your system.



Run composer to install all dependencies:
```
composer install --optimize-autoloader --no-dev
```

Generate random key for web application:
```
php artisan key:generate
```

Run artisan command to seed application with default users: 
```
php artisan migrate:refresh --seed
```


Optimize route and view loading:
```
php artisan route:cache
php artisan view:cache
```

__Your web application for cluster deployment, management and monitoring should be now accessible at your IP address from any device in your subnet.__ 


Application is deployed with two default users: __admin__ and __monitor__. Passwords for these accounts are identical with usernames.

## Cluster configuration files

Folder `picocluster-config` contains 4 example files for Raspberry Pi 4 cluster deployment, which can be used in application.

File `rpi-single-node` is simple example for deploying only one node. It sets only basic parameters required for successful deployment. 

File `cluster.nix` is main configuration file of cluster deployment. It is logically divided into three parts: 
* configuration function for head-node
* configuration function for node
* default configuration common for both types of node
