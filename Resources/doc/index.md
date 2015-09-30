ClarityYandexOAuthBundle Emergency
==========================

Nice to see you learning our ClarityYandexOAuthBundle - Ynadex OAuth in Symfony way!

**Basics**

* [Installation](#installation)
* [Usage](#usage)

<a name="installation"></a>

## Installation

### Step 1) Get the bundle

#### Simply using composer to install bundle (symfony from 2.1 way)

    $ composer require clarity-project/yandex-oauth-bundle "dev-master"
    
    Or manually:

    "require" :  {
        // ...
        "clarity-project/yandex-oauth-bundle": "dev-master",
        // ...
    }

Yet you can try to install bundle with help of `git submodule` functionality - [Git doc](http://git-scm.com/book/en/Git-Tools-Submodules#Starting-with-Submodules).

### Step 2) Register the namespaces (not composer way)

If you install bundle via composer, use the auto generated autoload.php file and skip this step.
Else you may need to register next namespace manualy:

``` php
<?php
// app/autoload.php
$loader->registerNamespaces(array(
    // ...
    'Clarity\YandexOAuthBundle' => __DIR__ . '/../vendor/clarity-project/yandex-o-auth-bundle/Clarity/ClarityYandexOAuthBundle',
    // ...
));
```

### Step 3) Register new bundle

Place new line into AppKernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Clarity\YandexOAuthBundle\ClarityYandexOAuthBundle(),
    );
    // ...
}
```

### Step 4) Configure the bundle

Now, you need to create config section for bundle.
Here is basic configuration for your registered applications.

``` yaml
clarity_yandex_o_auth:
    default_redirect_route: homepage
    apps:
        my_first_app:
            client_id: // Here is registered application client id
            client_secret: // Here is registered application password
            redirect_route: finish // default_redirect_route will be used if this parameter not specified
        my_another_app:
            client_id: // Here is registered application client id
            client_secret: // Here is registered application password
```

Here is detailed documentation about applications by Yandex - [Registering an application](https://tech.yandex.com/oauth/doc/dg/tasks/register-client-docpage/).

<a name="usage"></a>

## Usage

### Introduction (Before usage)

To work with Yandex OAuth API you should create Yandex application first and specify scope of permissions for it.
How to create Yandex application more detailed described [here](https://tech.yandex.com/oauth/doc/dg/tasks/register-client-docpage/)

IMPORTANT: To properly work with ClarityYandexOAuthBundle you must configure specific callback url `http://your_domain.com/yandex/oauth/token/exchange` to match our route `clarity_yandex_oauth_token_exchange`
This will allow to store application token in database for future use.

After create application(s) complete your configuration with application(s) client_id and client_secret data.

### YandexOAuth service (entry point)

Service is the entry point to work with tokens.
Service registered with symfony DI as `clarity_yandex.oauth.service` and it concentrate logic to work with tokens.
More about Yandex OAuth authorization process you can read in [official documentation](https://tech.yandex.com/oauth/doc/dg/concepts/about-docpage/) provided by Yandex
Service help you to follow all authorization steps on this way!

### So, get new token for application

Bellow is example how to start flow of receiving new token for configured application:
 
Somewhere in your symfony controller...
``` php
    public function getNewTokenAction()
    {
        return $this->redirectToRoute('clarity_yandex_oauth_token_request', array(
            'appName' => 'my_first_app',
            'device_id' => 'ios_id', // Not required parameter 
            'device_name' => 'my_ios' // Not required parameter
        ));
    }
```
After redirect to route `clarity_yandex_oauth_token_request` user was redirected on Yandex oauth page to login and confirm 
access to data by specified application. When user allow or deny access Yandex will redirect user on specified in application 
callback url (remember Introduction? route `clarity_yandex_oauth_token_exchange`) and here received authorization code will 
be exchanged to authorization token. After that token will be saved and user will be redirected to specified in configuration 
`default_redirect_route` or `redirect_route` of concrete application.

Now you can use stored token where you need it.

### Get stored and not expired token

In controller action bellow we get stored token entity for configured "my_first_app" application:
``` php
    public function getCachedTokenAction()
    {
        $appToken = $this->get('clarity_yandex.oauth.service')->getCachedToken(
            'my_first_app',
            'device_id' // Not required parameter
        );
        
    }
```

Congrats! Now you can use Yandex OAuth authorization tokens in other Yandex API's.
