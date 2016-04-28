![XinteGrocore](http://i.imgur.com/Pmsy8DG.png)


XinteGrocore is a self-hosted open source application for managing your invoices, clients and payments.    
For more information visit __[xintegro.de](https://xintegro.de)__ or take a look at the __[demo](https://demo.xintegro.de)__

### Quick Installation

1. Download the [latest version](http://xintegro.de/downloads)
2. Extract the package and copy all files to your webserver / webspace.
3. Open `http://your-XinteGrocore-domain.com/index.php/setup` and follow the instructions.

#### Remove `index.php` from the URL

1. Make sure that [mod_rewrite](https://go.xintegro.de/apachemodrewrite) is enabled on your web server.
2. Remove `index.php` from `$config['index_page'] = 'index.php';` in the file `/application/config/config.php`
3. Rename the `htaccess` file to `.htaccess`

If you want to install XinteGrocore in a subfolder (e.g. `http://your-XinteGrocore-domain.com/invoices/`) you have to change the .htaccess file. The instructions can be found within the file.

### Support / Development / Chat

[![Wiki](https://img.shields.io/badge/Help%3A-Official%20Wiki-429ae1.svg)](https://wiki.xintegro.de/)    
[![Community Forums](https://img.shields.io/badge/Help%3A-Community%20Forums-429ae1.svg)](https://community.xintegro.de/)    
[![Issue Tracker](https://img.shields.io/badge/Development%3A-Issue%20Tracker-429ae1.svg)](https://development.xintegro.de/)    
[![Roadmap](https://img.shields.io/badge/Development%3A-Roadmap-429ae1.svg)](https://go.xintegro.de/roadmapv1)    
[![Gitter chat](https://img.shields.io/badge/Chat%3A-Gitter-green.svg)](https://gitter.im/XinteGrocore/XinteGrocore)    
[![Freenode](https://img.shields.io/badge/Chat%3A-Freenode%20IRC-green.svg)](https://go.xintegro.de/irc)    

---
  
*The name 'XinteGrocore' and the XinteGrocore logo are both copyright by Kovah.de and xintegro.de
and their usage is restricted! For more information visit xintegro.de/license-copyright*

