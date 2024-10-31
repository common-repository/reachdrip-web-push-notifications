=== ReachDrip - Web Push Notifications ===
Contributors: reachdrip
Donate link: https://reachdrip.com/
Tags: chrome push notifications, push notification, Web push notification, push notifications, safari push notification, firefox push notifications, web push subscribe, mobile push, mobile notification, mobile notifications, WordPress notifications, WooCommerce notifications, android notification, android notifications, android push, desktop notification, desktop notifications, push messages, push alerts, push messages, automatic push notifications, offline notifications, WP push notifications, chrome notifications, chrome notification, firefox notifications, firefox notification, push notification for chrome,  push notification for firefox,  push notification for safari, notifications, notification, push, WordPress push notifications, WordPress push notification, WordPress notification, chrome, forefox, safari, firefox push, chrome push, notify, web push, safari push, gcm notification, gcm notifications, browser notification, browser notifications
Requires at least: 4.1.5
Tested up to: 5.2.2
Stable tag: 5.2.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Drive repeat traffic with Unlimited Free web push notifications. Send automated web push messages for every new post, both on mobile and desktop.

== Description ==

Web push notifications are messages that come from a website. You get them on your desktop or device even when the concerned web page is not open in your browser. They are a brand new/ nascent marketing channel to re engage your visitors without knowing their email or other contact details.

ReachDrip is a dead simple [Web Push Notifications platform](https://reachdrip.com) for WordPress sites, mobile and desktops that helps you build loyal customers, boosts engagement and drives traffic by re-engaging dormant users & website subscribers. It allows your website to re-engage your most loyal customers with targeted web push notifications.

ReachDrip allows websites to send instant notifications, similar to those found on your smartphone to your subscribers devices. This helps marketers to reach their audience about news, sales, order status, special offers, empty shopping cart links, new content, events or any type of engaging an promotional activities that are going on.

After installation, open the plugin and create your FREE account, all the required libraries will be automatically setup. After setup, your visitors can opt-in to receive push notifications when you publish a new post, add new content, have a special sale and visitors receive these notifications even after they've left your website and forgotten about you. All the major functionalities, dashboard, metrics are available under WordPress Admin Panel. 

Push notifications are an incredibly user-friendly communication channel, has a higher opt-in rate and click-through rate in the range of 10-22%, which is dramatically better than other channels, such as email or Twitter.

= Features =

* **Instant notifications**: Notifications appear as message alerts and even sound alerts depending upon OS.
* **Powerful APIs**: Provides easy to use REST APIs, available via secure HTTPS to send and receive data.
* **Segments**: Automatically groups subscribers information with smart logic.
* **HTTP/HTTPS**: It works for both HTTP or HTTPS WordPress websites.
* **Schedule Notifications**: Schedule marketing notification campaigns from ReachDrip control account Panel.
* **Automatic**: Automatically send notifications when a new post is published.
* **Large Image**: Allows large images for web push notification.

= Who Is This Plugin For? =

This plugin is primarily intended for WordPress site owners, marketers  who do not want to develop their own server-side back-end since it's a complicated and time consuming thing. This plugin handles all and lets you focus on your marketing efforts to re-engage your customers & visitors without any hassle.


== Installation ==

1. Install ReachDrip from the WordPress.org plugin directory or by uploading the ReachDrip plugin folder to your "wp-content/plugins" directory. 
1. Install the plugin through the "Plugins" menu in WordPress.
1. Activate the plugin through the "Plugins" menu in WordPress.
1. Create your free ReachDrip account from the plugin itself, plugin will automatically install the required JS library.
1. Account details will be emailed post signup. Didn't Get Our Email? Check Your Spam Folder.
1. Configure the look and feel of opt-in box from your ReachDrip account panel.
1. **Purge your site Cache** In case you don't see the optin, try purging cache just once!


== Frequently Asked Questions ==

= Do I need to sign up to ReachDrip to use this plugin? =

Yes, you can create a FREE account from the plugin itself. If you are already using ReachDrip just copy your **API Key** & **Secret Key** from ReachDrip control panel and paste in WordPress dashboard once.

= I can't see any code added to my header or footer when I view my page source =

Your theme needs to have the header and footer actions in place before the '</head>' and before the '</body>'

= I can't see opt-in box on my site =

If you are using cache plugins like W3 Total Cache, Super Cache etc. Just purge the cache once. Also purge CloudFlare or CDN once to see it.

= Can ReachDrip be implemented on HTTP Websites? = 

Yes, ReachDrip can be implemented on both HTTP or HTTPS (SSL) websites. Since Push Notifications requires the websites to be running on SSL, we create a SSL sub-domain for your websites like **https://YOUR-SITE-DOMAIN.reachdrip.com**. If your site is already on SSL, please enable SSL settings from ReachDrip control panel.

= What will happen when i reach 50,000 subscribers in my FREE account?  =

Once you reach 50000 subscribers, ReachDrip will continue to work and let you collect subscribers but will restrict notifications to new subscribers. You can send unlimited notifications to your first 50,000 subscriber but to send notifications to all subscribers you need to upgrade to premium (Paid) account. Check our [pricing plans](https://reachdrip.com/pricing/).

= What will push notifications look like? =

That depends on the browser! Each browser will display your notifications somewhat differently, but in general the notifications will look appropriate for the device/OS/browser on which they are displayed

= Are there any design templates to choose for opt-in box? =

Yes, there are many templates for HTTP based setup opt-in. Configuration is possible within your ReachDrip control panel.

= Targeting Subscribers with Segments  =

You can quickly categorize subscribers into different segments. This helps you efficiently target a particular set of subscribers registered under particular segments (group). A typical use case could be one segment each for your categories i.e. Sports, Fitness, Homepage, etc. 

1. **Step 1:** Create segments from Segments tab. 

1. **Step 2:** Add the following JS code on your category pages or on any pages of your site

**Subscribing for Single Segment**

`<script>
    var _rd = [];
    _rd.push('Sports');
</script>`

**Subscribing for Multiple Segments</h3>

`<script>
    var _rd = [];
    _rd.push('Sports', 'Fitness');
</script>`

Soon, you have some subscribers under segments, you would be able to send personalized messages to specific segments. Users interested in **Sports** are more likely to click on your notifications about **Sports** than **Politics**.


== Screenshots ==

1. screenshot-1.png
2. screenshot-2.png
3. screenshot-3.png
4. screenshot-4.png


== Changelog ==

= 2.0.1 =
* Support for wordpress 5.0 and 5.2.2

== Upgrade Notice ==