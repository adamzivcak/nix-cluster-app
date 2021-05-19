# Configuration file for networking of master node

{ config, lib, pkgs, modulesPath, ... }:

{
  networking = {
    firewall = {
      enable = true;
      allowPing = true;
      allowedTCPPorts = [ 22 80 443 ];
    };

    hostName = "master-node";

    nameservers = ["8.8.8.8"];

    extraHosts = ''
      10.10.0.101 node-1
      10.10.0.102 node-2
      10.10.0.103 node-3
      10.10.0.104 node-4
      10.10.0.105 node-5
      10.10.0.106 node-6
      10.10.0.107 node-7
      10.10.0.108 node-8
      10.10.0.109 node-9
      10.10.0.110 node-10
      10.10.0.111 node-11
      10.10.0.112 node-12
      10.10.0.113 node-13
      10.10.0.114 node-14
      10.10.0.115 node-15
      10.10.0.116 node-16
      10.10.0.117 node-17
      10.10.0.118 node-18
      10.10.0.119 node-19
      10.10.0.120 node-20
    '';

    useDHCP = false;

    interfaces = {
      # interface for communication with cluster nodes
      enp3s0 = {
	      ipv4.addresses = [{ address = "10.10.0.1"; prefixLength = 24; }];
      };
      # interface with access to internat network
      wlp4s0.useDHCP = true;
    };

    # enable NAT for nodes in cluster
    nat = {
      enable = true;
      externalInterface = "wlp4s0";
      internalInterfaces = ["enp3s0"];
    };

    # set wireless network
    wireless = {
      enable = true;
      networks = {
        "your_SSID" = {
          psk = "your_wifi_password";
        };
      };       
    }; 
  };

  # required by NAT
  boot.kernel.sysctl = {
    "net.ipv4.ip_forward" = 1;
  };

}
