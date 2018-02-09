# Problèmes rencontrés
## utilisation de mariadb
il faut rajouter `Schema::defaultStringLength(191);` dans `app/Providers/AppServiceProvider.php` sinon la taille des champs par defaut est trop grande.
```php
<?php
  use Illuminate\Support\Facades\Schema;

  public function boot()
  {
      Schema::defaultStringLength(191);
  }
?>
```

## Création de foreign_keys
il faut que la clé étrangère soit de type integer et unsigned
