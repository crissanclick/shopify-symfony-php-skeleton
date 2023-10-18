<h1 align="center">Shopify APP Template in Symfony PHP 🐘</h1>

Authors: [crissanclick](https://github.com/crissanclick) , [Interactiv4](https://interactiv4.com)

<p align="center">
  A Shopify Symfony PHP skeleton to make your life easier and start your new APP faster.
  <br />
  <br />
  This project skeleton is using Domain Driven Design (DDD) and Hexagonal Architecture (Ports & Adapters) to make it easier to understand and maintain.
  <br />
  <br />
  It also uses the <b>shopify/shopify-api</b> package to make the Shopify API calls and it is based on the <a href="https://github.com/Shopify/shopify-app-template-php">official Shopify PHP template</a> replacing Laravel framework for a clean Symfony project.
</p>

## 👍 Benefits

Shopify apps are built on a variety of Shopify tools to create a great merchant experience.

The Symfony PHP app template comes with the following out-of-the-box functionality:

- OAuth: Installing the app and granting permissions
- Billing API: Charging merchants for using the app
- GraphQL Admin API: Querying or mutating Shopify admin data totally decoupled from the Shopify API
- Webhooks: Reacting to store events totally decoupled
- Shopify-specific tooling: (copied from the original template)
    -   AppBridge
    -   Polaris
    -   Webhooks

## 🐳 Tech Stack

This project combines a number of third party open source tools:
- Symfony: https://symfony.com/ (PHP framework for backend)
- [Vite](https://vitejs.dev/) builds the [React](https://reactjs.org/) frontend.
- [React Router](https://reactrouter.com/) is used for routing. We wrap this with file-based routing.
- [React Query](https://react-query.tanstack.com/) queries the Admin API.
- [`i18next`](https://www.i18next.com/) and related libraries are used to internationalize the frontend.
    -   [`react-i18next`](https://react.i18next.com/) is used for React-specific i18n functionality.
    -   [`i18next-resources-to-backend`](https://github.com/i18next/i18next-resources-to-backend) is used to dynamically load app translations.
    -   [`@formatjs/intl-localematcher`](https://formatjs.io/docs/polyfills/intl-localematcher/) is used to match the user locale with supported app locales.
    -   [`@formatjs/intl-locale`](https://formatjs.io/docs/polyfills/intl-locale) is used as a polyfill for [`Intl.Locale`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Intl/Locale) if necessary.
    -   [`@formatjs/intl-pluralrules`](https://formatjs.io/docs/polyfills/intl-pluralrules) is used as a polyfill for [`Intl.PluralRules`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Intl/PluralRules) if necessary.

These third party tools are complemented by Shopify specific tools to ease app development:
-   [Shopify API library](https://github.com/Shopify/shopify-api-php) adds OAuth to the Symfony backend. This lets users install the app and grant scope permissions.
-   [App Bridge React](https://shopify.dev/docs/tools/app-bridge/react-components) adds authentication to API requests in the frontend and renders components outside of the embedded App’s iFrame.
-   [Polaris React](https://polaris.shopify.com/) is a powerful design system and component library that helps developers build high quality, consistent experiences for Shopify merchants.
-   [Custom hooks](https://github.com/Shopify/shopify-frontend-template-react/tree/main/hooks) make authenticated requests to the GraphQL Admin API.
-   [File-based routing](https://github.com/Shopify/shopify-frontend-template-react/blob/main/Routes.jsx) makes creating new pages easier.
-   [`@shopify/i18next-shopify`](https://github.com/Shopify/i18next-shopify) is a plugin for [`i18next`](https://www.i18next.com/) that allows translation files to follow the same JSON schema used by Shopify [app extensions](https://shopify.dev/docs/apps/checkout/best-practices/localizing-ui-extensions#how-it-works) and [themes](https://shopify.dev/docs/themes/architecture/locales/storefront-locale-files#usage).

## 🚀 Getting Started

### Requirements
1. You must [create a Shopify partner account](https://partners.shopify.com/signup) if you don’t have one.
1. You must create a store for testing if you don't have one, either a [development store](https://help.shopify.com/en/partners/dashboard/development-stores#create-a-development-store) or a [Shopify Plus sandbox store](https://help.shopify.com/en/partners/dashboard/managing-stores/plus-sandbox-store).
1. You must have [PHP](https://www.php.net/) installed.
1. You must have [Composer](https://getcomposer.org/) installed.
1. You must have [Node.js](https://nodejs.org/) installed.

### 🏗️ Creating my first app

1. Clone this repository.
2. In root folder run `yarn install`
3. Go to `app` folder and run `composer install` to install all backend the dependencies.
4. Then take the `etc/databases/skeleton-app.sql` and import it in your MySQL server
5. Go to `apps/app/frontend` folder and run `yarn install or npm install` to install all frontend the dependencies.
6. Then, execute a `cp .env.example .env` and fill the `.env` file with your Shopify APP credentials and decide if you want to charge something to use the APP, defining the interval and the required data.
7. Once you have all defined, you can run `yarn dev or npm run dev` to start the development server. (It will automatically raise the backend server and will map a real cloudflare domain against your localhost using the 8030 port)
8. It is important before click on button `Install app` inside the Shopify panel to update your .env file with the API_KEY_CLIENT and API_KEY_SECRET.
9. Congratulations! You already should have the APP working :)

## 🤔 Contributing

There are some things missing (Cover all APIs, Uninstall APP, improve documentation...), feel free to add this if you want! If you want
some guidelines feel free to contact me :)

## 📝 Acknowledgements
- [CodelyTV](https://codely.com/) for the DDD and Hexagonal Architecture inspiration and Symfony DDD skeleton
- Shopify for the PHP template and the Shopify API package
- [Interactiv4](https://interactiv4.com) for give me the chance to work with Shopify and learn

## ⭐Extra

### How to configure a billing

1. Go to `.env` file
2. Add the following example:
```
APP_BILLING_REQUIRED=true
APP_BILLING_CHARGE_NAME="My app name"
APP_BILLING_AMOUNT=9.99
APP_BILLING_CURRENCY=EUR
APP_BILLING_INTERVAL=month or anual
APP_BILLING_TYPE=EVERY_30_DAYS or ONE_TIME
```

### How to register new webhooks

1. Create a new Handler class (Example. `Crissanclick\App\Auth\Infrastructure\Shopify\Webhook\Handler\Uninstall`)
2. Create a new Webhook class (Example. `Crissanclick\App\Auth\Infrastructure\Shopify\Webhook\Uninstall`)
3. Provide the webhook information in the Webhook class like:
```
class Uninstall implements Webhook
{
    public function __construct(private readonly UninstallHandler $handler)
    {
    }

    public function type(): string
    {
        return 'APP_UNINSTALLED';
    }

    public function handler(): WebhookHandler
    {
        return $this->handler;
    }
}
```

+info: https://shopify.dev/docs/admin-api/rest/reference/events/webhook
