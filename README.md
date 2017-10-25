# Bee Rest
(an API Restful handler)

![Bee Rest](./images/bee_rest.png)

## What is this?

This is a piece of code to handle API RESTful calls.

The idea is to have a common code to migrate between systems. When you call an endpoint you are calling a method inside your mainclass in *vendor*. When you call a verb you are calling a class in *vendor/Modules*. When you refer a first parameter you are calling an method in the object created with this class.

This way you only need to add classes with its methods and you have services.

**Bee Rest** also provides you with a security class to enforce security on your apis.


This code was first based on this [article](http://coreymaynard.com/blog/creating-a-restful-api-with-php/) from [coreymaynard.com](http://coreymaynard.com).

### Atention

This code is a *work in progress* so it may have (and indeed it has) errors.

This only handles GET and POST methods by now.


## Install

### Prerequisites

Apache (or apache like) with rewrite enabled.
A DBRS and mysqli depending on what you want to do (demo class uses a DBRS, **DB_connect.php**, from *core*, uses mysqli).

### Directory structure

In root dir you have these:

  - assets - samples and other stuff
  - config - config files
  - core - the core of **Bee Rest** *(you should not modify files here)*
  - doc - the docs
  - images - the images
  - vendor - dir with all your stuff *(here you shoud put your files)*
  - api.php - main file, it is called in each call to the API


### Steps

  - Put this code in a webserver
  - Modify .htaccess
  - Modify config.php
  - Create your own service
  - Add your own Module classes
  - Set your security
  - Test your service

### Detail

#### 2. Modify .htaccess

```
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ ./api.php?request=$1 [QSA,NC,L]
</IfModule>
```

#### 3. Modify config.php

In *config.php* there is an array called **$classesDir**. This stores the dirs in which API will search for classes.

Remember that the order is important since when it find a matching class it will stop search.

Add your created dirs to this array to allow your classes to be found.

```
$classesDir = array (
    ROOT_DIR.'core/',
    ROOT_DIR.'vendor/',
);
```

In this case it will search in core/ and then in vendor/.


#### 4. Create your own service

Create your classes in vendor dir.

Here you have two options.
  - Extend the API class
  - Extend the securecall class

In the second option you are using API Key verification call and using services that only accepts a request type (i.e. POST, GET, etc).

In your vendor dir create a class that extends API or securecall, then create your own methods (endpoints) that calls get_service or post_service (if using securecall, see sample at the end of this documento on how to handle multiple methods under same endpoint) or processRequest (if using directly API). Don't forget to call your class from /api.php. (in api.php just replace vendorname with your created class)

In this class will be the endpoints (each method you can call in this class is an endpoint).

Say you have put BeeRest's files under <your_web_files_dir>/BeeRest then the URL will be something like this:

```
http://<your server>/BeeRest/endpoint/ ...
```

Say you create an endpoint (a method in your class) called flyingBee, then your URL will be like this:

```
http://<your server>/BeeRest/flyingBee/ ...
```


#### 5. Add your own modules

Under vendor/Modules you will create files with classes for your services. The class names will be the **verbs** in your URL.

Let's create a class here with name myVerb. Use the sample class in this dir.

This class can be inherited from service or from dbservice. The difference? You can guess the answer... the second one has pre set the DB access. (using parameters found in config/config.php)

```
class myVerb extends service
{
```

I will use **service** here, for **dbservice** please refer to sample.

Let's add a method to this class. The method names will be the arg0 in your URL. Let's name the method as myMethod.

First of all you must export in your class an array with all methods you want to be accessible from the API:

```
  function __construct()
  {
    parent::__construct();
    $this->add_actions(array('myMethod'));
  }
```

Now the method:

```
  public function myMethod($params,$request)
  {

```

And drop your code in its scope.

**returns** must be null or an array. This array will be converted to JSON when exposed to consumer.

Keep in mind that a good practice is the send back to the client HTTP Response Codes. ([REST API Quick Tips](http://www.restapitutorial.com/lessons/restquicktips.html))

#### 6. Set your security

If you are using securecall you must edit your vendor/APIKey.php file to set your way of handle security.

#### 7. Test your service

Let's say you have created a GET service (easy to test in your browser)... test it requesting an URL like this (in our example):

```
http://<your server>/BeeRest/flyingBee/myVerb/myMethod?apiKey=AIzaSyDrfzKxEXLCPZQapKliQLC5OFrpuWqAfz4
```


### How it works?

Using the code and database provided as example call this url:

```
http://<your server>/BeeRest/endpoint/getitemstest/activity?apiKey=AIzaSyDrfzKxEXLCPZQapKliQLC5OFrpuWqAfz4
```

*Assuming you have stored this code under /path/to/your/www/BeeRest/*

We will walk through this example following the sample site provided.

When you call the API you submit a URL like this:

```
http://<yourserver>/BeeRest/endpoint/verb/arg0
```

*api.php* in root dir is called. (Since it is set like this in *.htaccess*)

It calls *vendor/vendorname.php*. The endpoint will be matched with a method in this class.

Then the *verb* will be matched with a class which must be found in any of the paths in **$classesDir** (file *config.php*), most probably one of the classess you have put in *vendor/Modules*.

The first parameter will be matched with a method in this class, and the rest of the parameters will be sent to this method.

### Security or not?

Your *vendor/vendorname.php* class can be inherited from *securecall* or from *API*. (you have two samples: *vendorname.php*, which is actually called from *api.php*, and *vendornameAPI.php*, which is the same but inheriting and calling *API.php*)

If it inherits from *securecall* the when object is constructed security method is call on you *APIKey* class (See *How to set security?*), then it needs an apiKey to be sent to be validated. This apiKey can be matched with an origin.

Besides this, inheriting from *securecall* you can call from your methods to *get_service* or *post_service* methods, filtering to only allow GET or POST methods.


In the example *vendorname.php* inherits *securecall*.

A security class is provided in vendor/ApiKey.php where a method *verifyKey* is a sample security check.


### How to handle multiple methods under same endpoint?

One way could be this one (based on verb):

```
      public function despacho() {
		  $post_verbs = array('alta');
		  $put_verbs = array('matricular');
		  $delete_verbs = array('desmatricular');
		  if( in_array($this->verb,$post_verbs) )
		  {
			  $r = $this->post_service();
			  
		  }else if( in_array($this->verb,$put_verbs) )
		  {
			  $r = $this->put_service();
			  
		  }else
		  {
			  $r = $this->get_service();
		  }
       
       return $r;
     }
```

or this one (based on verb/method):

```
      public function despacho() {
		  $post_verbs = array('matricular/alumno_nuevo');
		  $put_verbs = array('matricular/alumno_existente');
		  $delete_verbs = array('desmatricular/alumno');
		  if( in_array($this->verb.'/'.$this->args[0],$post_verbs) )
		  {
			  $r = $this->post_service();
			  
		  }else if( in_array($this->verb.'/'.$this->args[0],$put_verbs) )
		  {
			  $r = $this->put_service();
			  
		  }else
		  {
			  $r = $this->get_service();
		  }
       
       return $r;
     }

```

