# DEPLOYMENT

# config .htaccess
```
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>
 
    RewriteEngine On
    RewriteBase /ProjectName/ # Add This
 
    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
 
    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]
    RewriteRule ^(.*)/$ /ProjectName/$1 [L,R=301] # Add This
 
    # Handle Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

# Create a symbolic link (symlink)
> if implemented
```
php artisan storage:link
```

# Build for Production
```
npm run build
```

# Deploy
> Pass the whole project to htdocs

## Important

> route '/' will not work with storage files on deployment, use route '/home' instead.