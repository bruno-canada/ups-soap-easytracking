<h3 align="center">UPS SOAP API Easy Tracking</h3>

<div align="center">

[![Status](https://img.shields.io/badge/status-active-success.svg)]()
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](/LICENSE)

</div>

---

<p align="center"> Light, simple and easy-to-use library that connects to UPS web service via SOAP (Simple Object Access Protocol) to track and show the details of a shipment.</p>

## 📝 Table of Contents

- [About](#about)
- [Getting Started](#getting_started)
- [Usage](#usage)
- [Built Using](#built_using)
- [Authors](#authors)

## 🧐 About <a name = "about"></a>

<p>This tool was created based upon some requests of an easy and very light way to add a tracking field to a website which the customers could track their shipments withing the website.</p>

<p>It offers a copy and past frontend interface to use on your website and customize as you wish. It uses Bootstrap 4 and Jquery 3.4.1.</p>

## 🏁 Getting Started <a name = "getting_started"></a>

To use it is very simple, you can either directly download the project or use composer. There are no external dependencies.

If you decide to use composer just type:

```shell
composer require bruno-canada/ups-soap-easytracking
```

### Prerequisites

<p>Tech: PHP 5.5</p>

<p>UPS Requisites:<br/>
You need to have ready to use UPS credentials including: Access Key, Username and Password. You can get more information of how to get it <a href='https://www.ups.com/upsdeveloperkit' target='_blank'>here</a>.</p>

## 🎈 Usage <a name="usage"></a>

Check the folder *frontend* for ready-to-use sample.

```shell
try {

    $ups = new UPS\UPSClient($keyaccess, $userid, $passwd, $mode);
    $resp = $ups->track($trackingNumber);

    print_r($resp);

} catch (\Exception $e) {

    echo "Error: " . $e->getMessage();
}
```

## ⛏️ Built Using <a name = "built_using"></a>

- [PHP] (https://www.php.net/) PHP
- [Bootstrap] (https://getbootstrap.com/) - Frontend
- [Jquery] (https://jquery.com/) - Frontend Javascript Library

## ✍️ Authors <a name = "authors"></a>

- [@bruno-canada](https://github.com/bruno-canada) - Idea & Initial work
