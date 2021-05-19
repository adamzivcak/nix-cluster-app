# Configuration file for deployment of single node using NixOps

{
  network = {
    description = "RPi Single Node";
    enableRollback = true;
  };

  rpi-node = { config, pkgs, modulesPath, ... }:

  with pkgs;
  let
    my-python-packages = python-packages: with python-packages; [
      mpi4py
    ]; 
    python-with-my-packages = python3.withPackages my-python-packages;
  in 
  { 
    nixpkgs.localSystem.system = "aarch64-linux";

    # specify taget ip adress
    deployment.targetHost = "10.10.0.10";

    # include hardware configuration 
    imports = [ ./hw-rpi4.nix ];

    networking = { 
      hostName = "rpi-single-node";

      useDHCP = true;
      interfaces.eth0.useDHCP = true;
      nameservers = ["8.8.8.8"];
    };

    services.openssh.enable = true;

    environment.systemPackages = with pkgs; [ 
      wget vim git libraspberrypi 
      python-with-my-packages 
    ];
    
    users = {
      mutableUsers = false;
      users.root = {
        passwordFile = "/path/to/file/with/user/password";
        openssh.authorizedKeysFiles = [
          "path/to/file/with/ssh/key"
        ];
      };
    }; #users

  };
}
