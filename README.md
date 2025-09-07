## Setup 

1. composer install 
2. Copy .env.example if .env does not already exist.
→ .env and set: 
  - APP_URL (public HTTPS) 
  - SHOPIFY_API_KEY, SHOPIFY_API_SECRET - SHOPIFY_SCOPES, SHOPIFY_REDIRECT_URI, SHOPIFY_API_VERSION 
3. php artisan key:generate 
4. php artisan migrate & php artisan serve
5. In your Shopify Partner dashboard, set: - App URL: ${APP_URL}/app - Allowed redirection URL: ${APP_URL}/auth/callback 
6. Install to a dev store:
