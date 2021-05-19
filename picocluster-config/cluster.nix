# Main configuration file for cluster deployment using NixOps

let
  nodesConfiguration = import ./nodes-config.nix;

  # Function for head node configuration
  head-node = hostName: (
    { config, pkgs, modulesPath, ... }:
    with pkgs;
    let
      nodeConfig = nodesConfiguration.nodes."${hostName}";
      my-python-packages = python-packages: with python-packages; [ mpi4py ]; 
      python-with-my-packages = python3.withPackages my-python-packages;
    in 
    {
      nixpkgs.localSystem.system = "aarch64-linux";
      nixpkgs.system = "aarch64-linux";

      deployment.targetHost = nodeConfig.ip;

      imports = [ ./hw-rpi4.nix ];

      environment.systemPackages = with pkgs; [
        libraspberrypi
        wget  vim  git          
        k3s 
        hpl  openmpi  
        python-with-my-packages
      ];

      networking = {
        hostName = nodeConfig.hostName;
        useDHCP = false;
        interfaces.eth0.useDHCP = true;
        networkmanager.enable = true;
        nameservers = ["8.8.8.8"];
        firewall.enable = false;
      }; #networking

      services = { 
        grafana = {
          enable = true;
          port = 2342;  
          addr = nodeConfig.ip;  
          auth.anonymous.enable = true;
          extraOptions.SECURITY_ALLOW_EMBEDDING = "true";
        }; #grafana

        k3s = {
          enable = true;
          role = "server";
          # disableAgent = true;  # run only server 
        }; #k3s

        prometheus = {
          enable = true;
          port = 9001;

          exporters = {
            node = {
              enable = true;
              enabledCollectors = [ "systemd" ];
              port = 9002;
            };
          }; #exporters

          scrapeConfigs = [{
            job_name = "node";
            static_configs = [{
              targets = [ 
                 "node-1:9002"  "node-2:9002"  "node-3:9002"  "node-4:9002"  "node-5:9002" 
                 "node-6:9002"  "node-7:9002"  "node-8:9002"  "node-9:9002" "node-10:9002" 
                "node-11:9002" "node-12:9002" "node-13:9002" "node-14:9002" "node-15:9002" 
                "node-16:9002" "node-17:9002" "node-18:9002" "node-19:9002" "node-20:9002" 
              ];
            }];
          }];
        }; #prometheus
      }; #services

      systemd.services.grafana = {
        after = [ "network-interfaces.target" ];
        wants = [ "network-interfaces.target" ];
      };

    }
  ); #head-node function

  # Function for node configuration
  node = hostName: (
    { config, pkgs, modulesPath, ... }:
    with pkgs;
    let
      nodeConfig = nodesConfiguration.nodes."${hostName}";
      my-python-packages = python-packages: with python-packages; [ mpi4py ]; 
      python-with-my-packages = python3.withPackages my-python-packages;
    in 
    {
      nixpkgs.localSystem.system = "aarch64-linux";
      nixpkgs.system = "aarch64-linux";

      deployment.targetHost = nodeConfig.ip;

      imports = [ ./hw-rpi4.nix ];

      environment.systemPackages = with pkgs; [ 
        libraspberrypi
        wget  vim  git          
        k3s 
        hpl  openmpi  
        python-with-my-packages
      ];

      networking = {
        hostName = nodeConfig.hostName;
        useDHCP = false;
        interfaces.eth0.useDHCP = true;
        networkmanager.enable = true;
        nameservers = ["8.8.8.8"];
        firewall.enable = false;
      }; #networking

      services = {
        k3s = {
          enable = true;
          role = "agent";
          serverAddr = "https://10.10.0.101:6443";
          # get token from file /var/lib/rancher/k3s/server/node-token from k3s server
          # token = "...";
        };

        prometheus = {
          enable = true;
          port = 9001;

          exporters = {
            node = {
              enable = true;
              enabledCollectors = [ "systemd" ];
              port = 9002;
            };
          }; #expoters
        }; #prometheus
      };#services
    }
  ); #node function
in 
{
  network = {
    description = "PicoCluster - Raspberry Pi 4 cluster.";
    enableRollback = true;
  };

  # Specify nodes in cluster
  node-1 = head-node "node-1";
  node-2 = node "node-2";
  node-3 = node "node-3";
  node-4 = node "node-4";
  node-5 = node "node-5";
  node-6 = node "node-6";
  node-7 = node "node-7";
  node-8 = node "node-8";
  node-9 = node "node-9";
  node-10 = node "node-10";
  node-11 = node "node-11";
  node-12 = node "node-12";
  node-13 = node "node-13";
  node-14 = node "node-14";
  node-15 = node "node-15";
  node-16 = node "node-16";
  node-17 = node "node-17";
  node-18 = node "node-18";
  node-19 = node "node-19";
  node-20 = node "node-20";

  # Default configuration applicable to all machines (nodes)
  defaults = {

    networking.extraHosts = ''
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

    # Set time.
    time.timeZone = "Europe/Prague";

    services = {
      openssh = { 
        enable = true;
        allowSFTP = true;
        permitRootLogin = "yes";
      }; #openssh
    }; #services

    users = {
      mutableUsers = false;

      extraUsers.root.openssh.authorizedKeysFiles = [
        "path/to/file/with/public/ssh/key/of/cluster-head-node"
        "path/to/file/with/public/ssh/key/of/cluster-node"
      ];

      users.root = {
        passwordFile = "/path/to/file/with/user/password";
      };
    }; #users
  }; #defaults
}
