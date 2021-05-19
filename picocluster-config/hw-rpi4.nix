# File with hardware configuration of Raspberry Pi 4 node

{ config, lib, pkgs, modulesPath, ... }:

{
  imports = [ (modulesPath + "/installer/scan/not-detected.nix") ];
  
  boot.extraModulePackages = [ ];

  boot.initrd.availableKernelModules = [ "usbhid" ];
  boot.initrd.kernelModules = [ ];

  boot.kernelModules = [ ];
  
  boot.kernelPackages = pkgs.linuxPackages_rpi4;

  boot.loader.grub.enable = false;
  boot.loader.generic-extlinux-compatible.enable = true;
  boot.loader.raspberryPi = {
    enable = true;
    version = 4;

    # parameters required by kubernetes
    firmwareConfig = ''
      cgroup_enable=cpuset
      cgroup_memory=1 
      cgroup_enable=memory
    '';
  };

  fileSystems."/" = {
    device = "/dev/disk/by-label/NIXOS_SD";
    fsType = "ext4";
  };

  powerManagement.cpuFreqGovernor = lib.mkDefault "ondemand";
}
