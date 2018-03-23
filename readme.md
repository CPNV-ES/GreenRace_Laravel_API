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

# Laravel Passport Login API
https://laravel.com/docs/5.3/passport

# Routes API
`api entry point: /api/v1/`  

| Action | Route | Params | Auth | Description |
| ------ | ----- | ------ | ---- | ----------- |
| GET | engine | - lSport='[1-10]'<br> -waypoints=''<br> -steps=''<br> - distanceType=''<br> - vConsigne=''<br> - vehicles=''<br> | NO | Get the engine for the car |
| GET | categories | | No | Get all existing categories |
| GET | category/{id} | | No | Get details about a specific category |
| POST | category | - name='{string}' | Yes | Create a new category |
| PUT / PATCH | category/{id} | - name='{string}' | Yes | Modify a category |
| DELETE | category/{id} | | Yes | Delete a category |
| GET | trips | | No | Get all trips |
| GET | trip/{id} | | No | Get a trip |
| POST | trip | - name='{string}'<br> - steps='{string}' | Yes | Create a trip |
| PUT / PATCH | trip/{id} | - name='{string}'<br> - steps='{string}' | Yes | Modify a trip |
| DELETE | trip/{id} | | Yes | Delete a trip |
| GET | vehicles | | No | Get all vehicles |
| GET | vehicle/{id} | | No | Get a vehicle |
| POST | vehicle | - id_ves='{number}'<br> - description='{string}'<br> -weight_empty_kg='{number}'<br> - electric_power_kw='{number}'<br> - max_speed='{number}'<br> - scx='{number}'<br> - cr='{number}'<br> - battery_kwh='{number}'<br> - picture='{url}'<br> - rdtBattDeCharge='{number}'<br> - rdtBattCharge='{number}'<br> - rdtMoteur='{number}'<br> - precup='{number}'<br> - note='{string}'<br> - category_id='{id}'<br> | Yes | Create a new vehicle |
| PUT / PATCH | vehicle/{id} | - id_ves='{number}'<br> - description='{string}'<br> -weight_empty_kg='{number}'<br> - electric_power_kw='{number}'<br> - max_speed='{number}'<br> - scx='{number}'<br> - cr='{number}'<br> - battery_kwh='{number}'<br> - picture='{url}'<br> - rdtBattDeCharge='{number}'<br> - rdtBattCharge='{number}'<br> - rdtMoteur='{number}'<br> - precup='{number}'<br> - note='{string}'<br> - category_id='{id}'<br> | Yes | Modify a vehicle |
| DELETE | vehicle/{id} | | Yes | Delete a vehicle |

# Routes Oauth
## clients routes
| Action | Route | Params | Description |
| ------ | ----- | ------ | ----------- |
| GET | /oauth/clients | | get all the clients for the autenticated user |
| POST | /oauth/clients | - name='{client-name}' <br> - redirect='{redirect url}' | create a new client and return the created client instance |
| PUT | /oauth/clients/{client-id} | - name='{client name}'<br>- redirect='{redirect url}' | modify the client |
| DELETE | /oauth/clients/{client-id} | | delete a client |

## API routes
| Action | Route | Params | Description |
| ------ | ----- | ------ | ----------- |
| POST | /oauth/token | - grant_type='password'<br>- client_id='{client id}'<br>- client_secret='{client secret}'<br>- username='{username}'<br>- password='{password}'<br>- scope={scope} | get an access token to the client with user credentials |
| POST | /oauth/token | - grant_type='client_credentials'<br>- client_id='{client id}'<br>- client_secret='{client secret}'<br>- scope={scope} | get an access token without credentials |

# dev test access token for fabio-manuel.marques@cpnv.ch
eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjRlMWZiNjJhYmUzMzIzOGM4M2QzNzNiNjI1NjkzNTUzNjYwZGU1ZWQ3ZTVlZmY5NGNmNjJhZWIyYWQwYmU3MzA1NzYzNmU5YjM5NGY4NjUwIn0.eyJhdWQiOiIxIiwianRpIjoiNGUxZmI2MmFiZTMzMjM4YzgzZDM3M2I2MjU2OTM1NTM2NjBkZTVlZDdlNWVmZjk0Y2Y2MmFlYjJhZDBiZTczMDU3NjM2ZTliMzk0Zjg2NTAiLCJpYXQiOjE1MTk5Nzg3MTgsIm5iZiI6MTUxOTk3ODcxOCwiZXhwIjoxODM1NTk3OTE4LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.gr6UzuteY-Er1texsJ-aslQxy1OqqWGNZJvZG3PHJeZSSJZu1-x9VGln4J2qBAsf04AJcDxbzaClCgpbjxafdqz5uf57MmG9CtNPjgatYAFyecp6BFnjuTGzjb9yeDpzgpaM6LY3sevub8t_aA3FH8LiMwmO34WQgEyQmXQmAkF9MjHvvvlpVEk7QLu8OKn36dzWopiwM7MwXEBOkDhkQ6scUFH1KwOdT0taeHDfrpPurn6I59qbl9u2MFu6fWaWXzoMzbkt1vQ-zVCFFngoelTWAis294OYSTZVceH-BeOrRHe4BEK8k4wflJ-zrTO9S7A3_-yvh5wCy_bWR_GnWl9EUeGrv4D3tIgYUZ46e-w2g2LK0RQ4ca45SA3o0qm5IFjmIqqoWWN6jemfqvRWbPSxt0Acec7V2LkA_1fcv2JrAWfoun5s1GHW6X8IyuwyzXYna-4XgEvUKyvMorGnkEixkMcxLtrv1WX-BCnrCxRuMa60a55JYLbY-oU0M6daNDT9jLPkW4bQhkl-lAXsNlZ2nhnxA-r8-_qQkDfuZB5VNbIo6EB8PiWNW5UPJqMX9mHxFzUMoyKD2ejMRPL9Y90_tolhdI2p8QfcxK-GICn9Udcin_zlZgArFqezY2wBmJ06RoeJEbKHRDUr_uaGMDY3IhHCXBn4a4sJRvoBYH8
