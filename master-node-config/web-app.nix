# Configuration file for deployment of web application 

{ config, pkgs, lib, ... }:
let
  # PHP with custom packages and tweaks
  php' = pkgs.php.buildEnv {
    extensions = { enabled, all }: with all; enabled ++ [ memcached ];
    extraConfig = ''
      memory_limit = 2000M
    '';
  };
in
{
  # Setup Apache HTTP server
  services.httpd.enable = true;
  services.httpd.extraModules = [ "proxy_fcgi" ];

  services.httpd.virtualHosts."picoclusterapp" = {
    documentRoot = "/var/www/picoclusterapp/public";
    
    extraConfig = ''
      # https://laravel.com/docs/8.x/deployment#nginx
      Header always append X-Frame-Options "SAMEORIGIN"
      Header always set X-XSS-Protection "1; mode=block"
      Header always set X-Content-Type-Options "nosniff"

      <Directory /var/www/picoclusterapp/public>
        AllowOverride all
        DirectoryIndex index.php

        <FilesMatch "\.php$">
          <If "-f %{REQUEST_FILENAME}">
            SetHandler "proxy:unix:${config.services.phpfpm.pools.picoapp.socket}|fcgi://localhost/"
          </If>
        </FilesMatch>
      </Directory>
    '';
  };

  services.mysql.enable = true;
  services.mysql.package = pkgs.mariadb;

  # PHP-fpm pool to run web application
  services.phpfpm.pools.picoapp = {
    user = "picoapp";
    group = "picoapp";
    phpPackage = php';
    phpEnv.PATH = with pkgs; lib.makeBinPath [ nixops python coreutils utillinux nix ];
    phpEnv.HOME = "/home/picoapp/data";
    settings = {
      "listen.owner" = config.services.httpd.user;
      "listen.group" = config.services.httpd.group;
      # fpm parameters
      "pm" = "dynamic";
      "pm.max_children" = 8;
      "pm.start_servers" = 2;
      "pm.min_spare_servers" = 2;
      "pm.max_spare_servers" = 4;
      "pm.max_requests" = 500;
      "request_terminate_timeout" = 300;
    };
  };

  # NixOps requires writable home folder
  systemd.services.phpfpm-picoapp.serviceConfig.ProtectHome = lib.mkForce false;

  # Laravel scheduler service 
  systemd.services.picoapp-laravel-scheduler = {
    description = "Picoapp laravel scheduler";
    startAt = "minutely";

    # Ensure this service doesn't run unless the app is properly installed
    unitConfig = {
      ConditionPathExists = "/var/www/picoclusterapp/.env";
      ConditionDirectoryNotEmpty = "/var/www/picoclusterapp/vendor";
    };

    serviceConfig = {
      Type = "oneshot";
      User = "picoapp";
      Group = "picoapp";
      SyslogIdentifier = "picoapp-laravel-scheduler";
      WorkingDirectory = "/var/www/picoclusterapp";
      ExecStart = "${php'}/bin/php artisan schedule:run -v";
      ProtectHome = lib.mkForce false;
    };
  };

  # User to run php 
  users.users.picoapp = {
    description = "User for laravel web application";
    isNormalUser = true;
    shell = pkgs.bash;

    extraGroups = [ "wheel" ];

    packages = [
      php'
      php'.packages.composer
      pkgs.nodejs
    ];

  };

  users.groups.picoapp = {};

  users.users.wwwrun.extraGroups = [
    "picoapp"
    "wheel"
  ];
}
