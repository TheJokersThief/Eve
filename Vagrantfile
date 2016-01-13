# -*- mode: ruby -*-
# vi: set ft=ruby :

project_name = "softwareproject"
ip_address = "172.22.22.26"

# Begin our configuration using V2 of the API
Vagrant.configure(2) do |config|
  
  config.vm.box = "Netsoc"
  config.vm.box_url = "https://netsoc.co/netsoc_boxes.json"
  config.vm.box_check_update = true

  # Configuration for our virtualisation provider
  config.vm.provider "VirtualBox" do |vb|
     # Memory (RAM) capped at 1024mb
    vb.customize ["modifyvm", :id, "--memory", "1024"]
  end

  # Give our new VM a fake IP Address and domain name
  # To utilise this, add the following to your /etc/hosts file
  #   172.22.22.22 netsoc.dev
  config.vm.define project_name do |node|
    node.vm.hostname = project_name + ".dev"
    node.vm.network :private_network, ip: ip_address
  end

  # Sync the containing folder to the web directory of the VM
  #   The sync will persist as you edit files, you won't have
  #   to destroy and re-up the VM each time you make a change
  #   
  config.vm.synced_folder "./", "/var/www", :owner=> 'www-data', :group=>'www-data'
  config.vm.synced_folder "./public", "/var/www/html", :owner=> 'www-data', :group=>'www-data'

  config.vm.provision "shell", inline: <<-SHELL
    sudo apt-get -y remove mysql-server
    sudo apt-get -y autoremove
    sudo apt-get -y install mysql-client-5.6 mysql-client-core-5.6
    sudo apt-get -y install mysql-server-5.6

    # Create our database and give root all permissions
    mysql -uroot -proot -e "CREATE DATABASE IF NOT EXISTS #{project_name};"
    mysql -uroot -proot -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'root';"
    sudo service mysql restart
    
    #Create swap space for composer's operations
    sudo /bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
    sudo /sbin/mkswap /var/swap.1
    sudo /sbin/swapon /var/swap.1

    # Update laravel and create all the DB tables
    sudo chmod +x /var/www/install/install.sh
    sudo /var/www/install/install.sh

  SHELL
end
