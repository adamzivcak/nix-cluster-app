# Main configuration file of master node with x86 arch. 

{ config, pkgs, ... }:

{
  imports = [ 
    ./hardware-configuration.nix
    ./networking.nix
    ./services.nix
    ./web-app.nix
  ];

  # set timezone
  time.timeZone = "Europe/Prague";

  # set password with ‘passwd’ for user
  users.users.admin = {
    isNormalUser = true;
    extraGroups = [ "wheel" ]; # Enable ‘sudo’ for the user.
  };

  # allow proprietary packages 
  nixpkgs.config.allowUnfree = true;
  # allow unsuported packages - for crosscompilation
  nixpkgs.config.allowUnsupportedSystem = true;

  # install system packages
  environment.systemPackages = with pkgs; [
    wget  vim
    nixops
    networkmanager
  ];

  # set system state version
  system.stateVersion = "20.09"; 

}
