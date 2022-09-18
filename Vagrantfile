# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
    
    BOX_IMAGE = "ubuntu/jammy64"
    
    BOX_CHK_UPDATE = false
    SSH_INSERT_KEY = true
    PROXY_ENABLE = false
    VB_CHK_UPDATE = false

    PROXY_HTTP = "http://10.0.2.2:7777"
    PROXY_HTTPS = "http://10.0.2.2:7777"
    PROXY_EXCLUDE = "localhost,127.0.0.1"

    BASE_NETWORK = "10.10.20"
    WEB_INTENT_IP = "#{BASE_NETWORK}.10"
    DB_INTENT_IP = "#{BASE_NETWORK}.15"
    WEB_APACHE_FORWARD_PORT = 9080

    config.vm.define "web" do |subconfig|
        subconfig.vm.box = BOX_IMAGE

        if Vagrant.has_plugin?("vagrant-proxyconf") && PROXY_ENABLE == true
            subconfig.proxy.http = PROXY_HTTP
            subconfig.proxy.https = PROXY_HTTPS
            subconfig.proxy.no_proxy = PROXY_EXCLUDE
        end

        subconfig.vm.network "private_network",
            ip: WEB_INTENT_IP,
            virtualbox__intnet: true

        subconfig.vm.network "forwarded_port",
            guest: 80,
            host: WEB_APACHE_FORWARD_PORT

        subconfig.vm.hostname = "mmweb.cpt.local"

        subconfig.vm.provider "virtualbox" do |vb|
            vb.name = "MMWeb"
            vb.memory = "1024"
            vb.cpus = 1
        end

        subconfig.vm.box_check_update = BOX_CHK_UPDATE
        subconfig.ssh.insert_key = SSH_INSERT_KEY

        if Vagrant.has_plugin?("vagrant-vbguest")
            subconfig.vbguest.auto_update = VB_CHK_UPDATE
        end

        subconfig.vm.synced_folder ".", "/vagrant"
        subconfig.vm.provision "shell", inline: "cp -r /vagrant/www/ /var"

        # Provisioning
        subconfig.vm.provision "shell", path: "./scripts/provision_update.sh"
        subconfig.vm.provision "shell", path: "./scripts/provision_apache.sh"
        subconfig.vm.provision "shell", path: "./scripts/provision_php_mysql.sh"
    end
    
    config.vm.define "db" do |subconfig|
        subconfig.vm.box = BOX_IMAGE

        if Vagrant.has_plugin?("vagrant-proxyconf") && PROXY_ENABLE == true
            subconfig.proxy.http = PROXY_HTTP
            subconfig.proxy.https = PROXY_HTTPS
            subconfig.proxy.no_proxy = PROXY_EXCLUDE
        end

        subconfig.vm.network "private_network",
            ip: DB_INTENT_IP,
            virtualbox__intnet: true

        subconfig.vm.hostname = "mmdb.cpt.local"

        subconfig.vm.provider "virtualbox" do |vb|
            vb.name = "MMDb"
            vb.memory = "1024"
            vb.cpus = 1
        end

        subconfig.vm.box_check_update = BOX_CHK_UPDATE
        subconfig.ssh.insert_key = SSH_INSERT_KEY

        if Vagrant.has_plugin?("vagrant-vbguest")
            subconfig.vbguest.auto_update = VB_CHK_UPDATE
        end

        # Provisioning
        subconfig.vm.provision "shell", path: "./scripts/provision_update.sh"
        subconfig.vm.provision "shell", path: "./scripts/provision_mysql.sh"
    end
end