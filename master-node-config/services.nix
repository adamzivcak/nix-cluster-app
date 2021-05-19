
# Configuration file for services runing on master node 

{ config, lib, pkgs, modulesPath, ... }:

{
  services = {

    # Enable DHCP server for cluster subnet
    # Assign fixed ip addresses by MAC
    dhcpd4 = {
      enable = true;
      interfaces = ["enp3s0"];
      extraConfig = ''
        option domain-name-servers 8.8.8.8, 8.8.4.4;
        option subnet-mask 255.255.255.0;
        option routers 10.10.0.1;

        default-lease-time 25920000;
        max-lease-time 25920000;
        
        subnet 10.10.0.0 netmask 255.255.255.0 {
          host node-1 {
            hardware ethernet dc:a6:32:b5:fe:9e;
            fixed-address 10.10.0.101;
          }
          host node-2 {
            hardware ethernet dc:a6:32:b5:fe:5e;
            fixed-address 10.10.0.102;
          }
          host node-3 {
            hardware ethernet dc:a6:32:b5:fe:25;
            fixed-address 10.10.0.103;
          }
          host node-4 {
            hardware ethernet dc:a6:32:b5:fe:6a;
            fixed-address 10.10.0.104;
          }    
          host node-5 {
           hardware ethernet dc:a6:32:b1:d0:30;
            fixed-address 10.10.0.105;
          }
          host node-6 {
            hardware ethernet dc:a6:32:b3:5b:0d;
            fixed-address 10.10.0.106;
          }
          host node-7 {
            hardware ethernet dc:a6:32:b3:64:49;
            fixed-address 10.10.0.107;
          }
          host node-8 {
            hardware ethernet dc:a6:32:b3:65:d2;
            fixed-address 10.10.0.108;
          }
          host node-9 {
            hardware ethernet dc:a6:32:b5:fa:c2;
            fixed-address 10.10.0.109;
          }
          host node-10 {
            hardware ethernet dc:a6:32:b5:fd:ad;
            fixed-address 10.10.0.110;
          }
          host node-11 {
            hardware ethernet dc:a6:32:b5:fe:2b;
            fixed-address 10.10.0.111;
          }
          host node-12 {
            hardware ethernet dc:a6:32:b5:fe:2e;
            fixed-address 10.10.0.112;
          }
          host node-13 {
            hardware ethernet dc:a6:32:b5:fe:37;
            fixed-address 10.10.0.113;
          }
          host node-14 {
            hardware ethernet dc:a6:32:b5:fe:43;
            fixed-address 10.10.0.114;
          }
          host node-15 {
            hardware ethernet dc:a6:32:b5:fe:52;
            fixed-address 10.10.0.115;
          }
          host node-16 {
            hardware ethernet dc:a6:32:b5:fe:55;
            fixed-address 10.10.0.116;
          }
          host node-17 {
            hardware ethernet dc:a6:32:b5:fe:58;
            fixed-address 10.10.0.117;
          }
          host node-18 {
            hardware ethernet dc:a6:32:b5:fe:7f;
            fixed-address 10.10.0.118;
          }
          host node-19 {
            hardware ethernet dc:a6:32:b5:fe:a1;
            fixed-address 10.10.0.119;
          }
          host node-20 {
            hardware ethernet dc:a6:32:b5:fe:be;
            fixed-address 10.10.0.120;
          }     
        }
      '';
      };

    # Enable the OpenSSH daemon
    openssh = {
      enable = true;
      allowSFTP = true;
      permitRootLogin = "yes";
    };

  }; #services

}
