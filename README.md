# Evil Twin

Learn how to set up a fake authentication web page on a fake WiFi network.

Read the comments in these two files to get a better understanding on how all of it works:

* [index.php](https://github.com/ivan-sincek/evil-twin/blob/master/src/evil-twin/index.php)
* [MyPortal.php](https://github.com/ivan-sincek/evil-twin/blob/master/src/evil-twin/MyPortal.php)

You can modify and expand this project to your liking. You have everything that needs to get you started.

You can make it look like Starbucks, Facebook or something else entirely.

Tested on WiFi Pineapple NANO with firmware v2.7.0 and modules Evil Portal v3.2 and Cabinet v1.1.

Additional set up and testing was done on Windows 10 Enterprise OS (64-bit) and Kali Linux v2020.3 (64-bit).

Made for educational purposes. I hope it will help!

In this project I wanted to show you how to install and use WiFi Pineapple's modules with a GUI, for more console attacks check my [WiFi penetration testing cheat sheet](https://github.com/ivan-sincek/wifi-penetration-testing-cheat-sheet).

## How to Set up a WiFi Pineapple

### Windows OS

Follow the instructions below:

1. [Install the Network Driver](https://www.techspot.com/drivers/driver/file/information/17792)

2. [Setup Basics](https://docs.hak5.org/hc/en-us/articles/360010555313-Setup-Basics)

3. [Windows Setup](https://docs.hak5.org/hc/en-us/articles/360010471434-WiFi-Pineapple-NANO-Windows-Setup)

### Kali Linux

Download and run the following script (credits to the author):

```bash
wget https://raw.githubusercontent.com/hak5darren/wp6/master/wp6.sh && chmod +x wp6.sh && ./wp6.sh
```

## How to Run

In the WiFi Pineapple's dashboard go to `Modules -> Manage Modules -> Get Modules from Hak5 Community Repositories` and install `Evil Portal` and `Cabinet` module, preferably to an SD card storage.

Copy all the content from [\\src\\](https://github.com/ivan-sincek/evil-twin/tree/master/src) to the WiFi Pineapple's `/sd/portals/` (preferred) or `/root/portals/` directory:

```fundamental
scp -r evil-twin root@172.16.42.1:/sd/portals/

scp -r evil-twin root@172.16.42.1:/root/portals/
```

In the WiFi Pineapple's dashboard go to `Networking` and change the `Open SSID` to your desired name, then, connect your WiFi Pineapple to a real working WiFi network in the `WiFi Client Mode` section to tunnel network traffic back and forth from the Internet.

In the WiFi Pineapple's dashboard go to `Modules -> Evil Portal` and activate the `evil-twin` portal, then, start the `Captive Portal`.

In the WiFi Pineapple's dashboard go to `Modules -> Cabinet`, navigate to `/sd/logs/` or `/root/logs/` directory and click "Edit" on the `evil_twin.log` to view the captured credentials.

Or, download the log file through SSH:

```fundamental
scp root@172.16.42.1:/sd/logs/evil_twin.log ./

scp root@172.16.42.1:/root/logs/evil_twin.log ./
```

## [Additional] Search for WiFi Networks Within Your Range

Search for WiFi networks within your range, as well as fetch the information and MAC address of access points.

On your WiFi Pineapple, install the Kismet's remote capturing tool (to an SD card storage):

```bash
opkg update && opkg -d sd install kismet-remotecap-hak5
```

Then, after the installation, create the missing symbolic links:

```fundamental
ln -s /sd/usr/lib/libgpg-error.so.0.27.0 /usr/lib/libgpg-error.so.0

ln -s /sd/usr/lib/libgcrypt.so.20.2.5 /usr/lib/libgcrypt.so.20

ln -s /sd/usr/lib/libgnutls.so.30.28.1 /usr/lib/libgnutls.so.30

ln -s /sd/usr/lib/libmicrohttpd.so.12.49.0 /usr/lib/libmicrohttpd.so

ln -s /sd/usr/lib/libmicrohttpd.so.12.49.0 /usr/lib/libmicrohttpd.so.12

ln -s /sd/usr/lib/libcap.so.2 /usr/lib/libcap.so

ln -s /sd/usr/lib/libcap.so.2.27 /usr/lib/libcap.so.2

ln -s /sd/usr/lib/libprotobuf-c.so.1.0.0 /usr/lib/libprotobuf-c.so.1

ln -s /sd/usr/lib/libdw-0.177.so /usr/lib/libdw.so.1
```

On your Kali Linux, go to `/etc/kismet/kismet.config` and set `remote_capture_listen` to `0.0.0.0`.

Next, run the Kismet's server:

```fundamental
kismet
```

On your WiFi Pineapple, set a network interface to the monitoring mode:

```fundamental
airmon-ng start wlan0
```

Finally, connect the Kismet's remote capturing tool to the Kismet's server:

```fundamental
kismet_cap_linux_wifi --connect 192.168.5.10:3501 --source wlan0mon
```

On your Kali Linux, navigate to the Kismet's dashboard with your preferred web browser.

## [Additional] Crack WPS PIN

In the WiFi Pineapple's dashboard go to `Modules -> Manage Modules -> Get Modules from Hak5 Community Repositories` and install `wps` module (to an SD card storage).

On your WiFi Pineapple, install required packages (to the internal storage):

```bash
opkg update && opkg install libpcap
```

In the WiFi Pineapple's dashboard go to `Modules -> wps`, install the required dependencies (to an SD card storage) and start cracking.

## [Additional] Sniff WiFi Network Traffic

Once you get an access to a WiFi network, start capturing network packets.

In the WiFi Pineapple's dashboard go to `Modules -> Manage Modules -> Get Modules from Hak5 Community Repositories` and install `tcpdump` module (to an SD card storage).

In the WiFi Pineapple's dashboard go to `Modules -> tcpdump`, install the required dependencies (to an SD card storage) and start capturing packets.

You can download PCAP files from the `History` section.

You can also pipe the `tcpdump` directly into the Wireshark:

```bash
ssh root@172.16.42.1 tcpdump -U -i wlan0mon -w - | wireshark -k -i -
```

On Windows OS you might need to specify a full path to the Wireshark executable.

## Images

<p align="center"><img src="https://github.com/ivan-sincek/evil-twin/blob/master/img/landing_page_mobile.jpg" alt="Landing Page (Mobile)"></p>

<p align="center">Figure 1 - Landing Page (Mobile)</p>

<p align="center"><img src="https://github.com/ivan-sincek/evil-twin/blob/master/img/landing_page_pc.jpg" alt="Landing Page (PC)"></p>

<p align="center">Figure 2 - Landing Page (PC)</p>

<p align="center"><img src="https://github.com/ivan-sincek/evil-twin/blob/master/img/log.jpg" alt="Log"></p>

<p align="center">Figure 3 - Log</p>
