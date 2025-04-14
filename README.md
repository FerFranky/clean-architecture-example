# 🏗️ Clean Architecture Example in Laravel

## Índice

1. [Comandos con Makefile](#comandos-con-makefile)
2. [Ejecutar el proyecto con docker](#ejecutar-el-proyecto-con-docker)
3. [Introducción](#introducción)
4. [Estructura esperada](#estructura-esperada)
5. [Crear la estructura de carpetas requerida](#1--crear-la-estructura-de-carpetas-requerida)
6. [Agregar entidades al Dominio](#2--agregar-entidades-al-dominio)
7. [Crear el contrato del repositorio](#3--crear-el-contrato-del-repositorio)
8. [Crear un DTO](#4--crear-un-dto)
9. [Crear un Caso de Uso](#5--crear-un-caso-de-uso)
10. [Implementar el repositorio en infraestructura](#6--implementar-el-repositorio-en-infraestructura)
11. [Crear el controlador para exponer la funcionalidad](#7--crear-el-controlador-para-exponer-la-funcionalidad)
12. [Registrar el repositorio en Laravel](#8--registrar-el-repositorio-en-laravel)

---

## Comandos con Makefile

Para facilitar el manejo del entorno de desarrollo con Docker, se ha incluido un Makefile que automatiza algunos comandos comunes. A continuación se describen los comandos disponibles:

##### Comandos disponibles

| Comando        | Descripción                                                                   |
| -------------- | ----------------------------------------------------------------------------- |
| `make init`    | Inicializa completamente el entorno (build, up, install, key, migrate, seed). |
| `make setup`   | Ejecuta build, up y composer-update. Ideal para preparar el entorno.          |
| `make install` | Instala las dependencias del proyecto con Composer.                           |
| `make build`   | Construye la imagen y levanta los contenedores en segundo plano.              |
| `make stop`    | Detiene los contenedores.                                                     |
| `make up`      | Levanta los contenedores en segundo plano.                                    |
| `make migrate` | Ejecuta las migraciones de base de datos.                                     |
| `make seed`    | Ejecuta los seeders para poblar la base de datos.                             |
| `make data`    | Ejecuta migraciones y seeders.                                                |
| `make api-key` | Genera la clave de aplicación (php artisan key:generate).                     |

##### Ejemplo de uso

```bash
# Iniciar completamente el proyecto
make init

# Levantar contenedores
make up

# Ejecutar migraciones
make migrate

# Poblar base de datos
make seed
```

---

## Ejecutar el proyecto con docker

### 1- Construir la imagen

```bash
docker-compose up -d --build
```

### 2- Instalar dependencias

```bash
docker exec -it laravel_app composer install
docker exec -it laravel_app php artisan key:generate
docker exec -it laravel_app php artisan migrate --seed
```

### 3- Acceder al contenedor (Si se desea).

```bash
docker exec -it laravel_app bash
```
### 4- Ejecutar test y generar reporte de coverage
```bash
docker exec -it laravel_app php artisan test --coverage-html report-coverage
```

---

## Introducción

Este proyecto es un ejemplo práctico de cómo implementar la Arquitectura Limpia en Laravel. La Arquitectura Limpia, también conocida como "Clean Architecture", es un enfoque que busca separar las responsabilidades de las diferentes capas de una aplicación, promoviendo un código más limpio, desacoplado y fácil de mantener.

En este ejemplo, se implementa una funcionalidad básica para gestionar órdenes, siguiendo los principios de la Arquitectura Limpia. Cada capa tiene un propósito claro:

-   **Dominio**: Contiene las reglas de negocio y las entidades puras.
-   **Aplicación**: Maneja los casos de uso y la lógica de aplicación.
-   **Infraestructura**: Implementa la persistencia de datos y otras dependencias externas.
-   **Presentación**: Expone la funcionalidad a través de controladores y validaciones.

A lo largo de este documento, se describen los pasos necesarios para construir esta arquitectura, desde la creación de la estructura de carpetas hasta la implementación de cada componente clave. Este enfoque asegura que el código sea flexible, escalable y fácil de probar.

## Estructura esperada

A continuación se describe la propuesta de directorios a utilizar para nuestro ejemplo.

```bash
app/
│── Domain/
│   ├── Entities/
│   │   ├── Order/
│   │   │   ├── Order.php
│   ├── Repositories/
│   │   ├── Order/
│   │   │   ├── OrderRepositoryInterface.php
│
│── Application/
│   ├── DTOs/
│   │   ├── Order/
│   │   │   ├── OrderDTO.php
│   ├── UseCases/
│   │   ├── Order/
│   │   │   ├── CreateOrder.php
│
│── Infrastructure/
│   ├── Persistence/
│   │   ├── Order/
│   │   │   ├── OrderRepository.php
│
│── Presentation/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Order/
│   │   │   │   ├── OrderController.php
│   ├── Requests/
│   │   │   ├── Order/
│   │   │   │   ├── CreateOrderRequest.php

```

---

## 1- Crear la estructura de carpetas requerida

📌 A partir de la raíz del proyecto, se ha propuesto la siguiente estructura de carpetas con la que implementaremos nuestra arquitectura.

```bash
mkdir -p app/Domain/Entities app/Domain/Repositories
mkdir -p app/Application/DTOs app/Application/UseCases
mkdir -p app/Infrastructure/Persistence
mkdir -p app/Presentation/Http/Controllers app/Presentation/Requests
```

---

## 2- Agregar entidades al Dominio

🔨 Para nuestro ejemplo, agregaremos la entidad `Order.php` en el directorio `app/Domain/Entities/Order`.

🔨 Dentro, definiremos una función `create()`, la cual se encargará de construir la entidad del negocio, a la vez que estará fuertemente desacoplada del framework.

### ¿Para qué sirve la entidad en la arquitectura limpia?

📌 En la arquitectura limpia, una entidad representa el modelo de dominio puro de nuestra aplicación. Es una clase que encapsula reglas de negocio y mantiene los datos sin depender de ninguna tecnología externa (como Laravel, bases de datos o frameworks).

💡 La entidad NO debe saber nada de Eloquent, bases de datos ni infraestructuras externas.

### Beneficios de usar entidades

✅ Código más limpio y desacoplado (evita el acoplamiento con Laravel y Eloquent).

✅ Pruebas unitarias más fáciles (no necesitamos Laravel para probar).

✅ Cumple con los principios SOLID (especialmente S de Single Responsibility y D de Dependency Inversion).

✅ Facilita cambios de infraestructura (por ejemplo, si cambiamos de MySQL a MongoDB, la entidad sigue funcionando).

✅ Separa la lógica de negocio de la base de datos.

✅ Permite escribir reglas de negocio en un solo lugar.

✅ Hace que el código sea más flexible y fácil de probar.

**Nota:** Cuando no se utilizan arquitecturas limpias, es común usar la instancia de algún modelo como entidad. A continuación, algunas diferencias:

| **Entidad (Dominio)**            | **Modelo de Base de Datos (Infraestructura)** |
| -------------------------------- | --------------------------------------------- |
| No depende de Eloquent           | Extiende Model de Laravel                     |
| Representa un objeto del negocio | Representa una tabla en la BD                 |
| Encapsula reglas de negocio      | Define la estructura de datos                 |
| Puede usarse sin Laravel         | Depende de Laravel y Eloquent                 |

### Enlace a la entidad Order

📄 Puedes encontrar el archivo de la entidad Order en la siguiente ruta:

[App\Domain\Entities\Order\Order](./app/Domain/Entities/Order/Order.php)

---

## 3- Crear el contrato del repositorio

🔨 En este paso, creamos una interfaz para definir qué métodos tendrá nuestro repositorio, sin implementarlos todavía.

🔨 Para nuestro ejemplo, agregaremos el archivo `OrderRepositoryInterface.php` en el directorio `app/Domain/Repositories/Order`.

🔨 Dentro de nuestra clase, definiremos una función llamada `save()` (para nuestro ejemplo). Dicha función debe recibir como parámetro una `Entidad` de tipo `Order` (la creamos en el paso anterior) y su retorno debe ser, de la misma manera, la `Entidad Order`.

### Beneficios del uso de contratos de repositorio

✅ Desacoplamiento: Permite que la aplicación no dependa de una implementación específica (por ejemplo, Eloquent, una API externa o una base de datos diferente).

✅ Facilidad de prueba: Nos permite cambiar la implementación real por una simulada en pruebas unitarias.

✅ Cumple con el Principio de Inversión de Dependencias (SOLID): La capa de aplicación y dominio dependen de una abstracción (interfaz), no de una implementación concreta.

### Enlace al contrato del repositorio

📄 Puedes encontrar el archivo del contrato del repositorio en la siguiente ruta:

[App\Domain\Repositories\Order\OrderRepositoryInterface](./app/Domain/Repositories/Order/OrderRepositoryInterface.php)

---

## 4- Crear un DTO

📌 Un DTO (Data Transfer Object) es un objeto simple que se usa para transferir datos entre capas de la aplicación.

🔨 Para nuestro ejemplo, agregaremos el archivo `OrderDTO.php` en el directorio `app/Application/DTOs/Order`.

🔨 Dentro de la clase solo definiremos un objeto simple en el constructor que reciba `$customerName` y `$totalAmount`.

### Beneficios del uso de DTOs

✅ Evita exponer modelos de Eloquent directamente en la capa de aplicación.

✅ Asegura que los datos sean inmutables y estén validados antes de usarlos.

✅ Facilita el mantenimiento y desacoplamiento entre capas.

### Enlace al DTO Order

📄 Puedes encontrar el archivo del DTO Order en la siguiente ruta:

[App\Application\DTOs\Order\OrderDTO](./app/Application/DTOs/Order/OrderDTO.php)

---

## 5- Crear un Caso de Uso.

📌 Un Caso de Uso es una clase de aplicación que contiene la lógica para ejecutar una acción específica.

🔨 Para nuestro ejemplo, agregaremos el archivo `CreateOrder.php` en el directorio `/app/Application/UseCases/Order/CreateOrder.php`.

🔨 Lo primero es que nuestra clase debe recibir una instancia de la interfaz del repositorio (Se recomienda por inyeccion de dependencias para no depender de una implementacion especifica).

Se crea un metodo `execute` que deber recibir nuestro `dto` y este debe ser utilidado para crear una instancia de la `entidad` con los datos que contenga y finalmente de debe retornar el metodo `save` contenido de la instancia que viene a partir de la `interfaz`.

### Beneficios de un caso de uso:

✅ Separa la lógica de negocio de los controladores y repositorios.
✅ Hace el código más reutilizable y fácil de probar.
✅ Permite cambiar la implementación sin afectar el resto del sistema.

### Enlace al Caso de Uso CreateOrder

📄 Puedes encontrar el archivo del Caso de Uso CreateOrder en la siguiente ruta:

[App\Application\UseCases\Order\CreateOrder](./app/Application/UseCases/Order/CreateOrder.php)

## 6- Implementar el repositorio en infraestructura.

📌 Un Repositorio es una clase que maneja la persistencia de datos y actúa como una capa intermedia entre la aplicación y la base de datos.

🔨 Crear `OrderRepository.php` en el directorio `app/Infrastructure/Persistence/Order/`

🔨 Dentro del archivo definimos el metodo `save()`

🔨 EL metodo anterior recibe como parametro la entidad `Order`, hacemos una llamada al modelo y hacemos la insersion mediante eloquent y a partir del resultante se crea una instancia de la entidad y es la que se retorna, este metodo sirve como el puente entre el ORM y nuestra arquitectura limpia.

### Ventajas de usar repositorios:

✅ Desacopla la lógica de negocio de la lógica de persistencia.

✅ Facilita cambiar la implementación (por ejemplo, de Eloquent a Redis o una API externa).

✅ Hace que el código sea más limpio y fácil de probar.

### Enlace al Repositorio OrderRepository

📄 Puedes encontrar el archivo del repositorio OrderRepository en la siguiente ruta:

[App\Infrastructure\Persistence\Order\OrderRepository](./app/Infrastructure/Persistence/Order/OrderRepository.php)

## 7- Crear el controlador para exponer la funcionalidad

📌 En Arquitectura Limpia, un controlador es una capa que recibe peticiones HTTP y las delega a los Casos de Uso.

🔨 Crear `OrderController.php` en el directorio `app/Presentation/Http/Controllers/Order/`

🔨 Dentro definimos el metodo `store()` y dentro del mismo llenamos el DTO con el request y se lo pasamos al caso de uso

### Caracteristicas.

✅ NO debe contener lógica de negocio.

✅ Solo debe validar la entrada y manejar la respuesta.

✅ Debe llamar al caso de uso correspondiente.

### Beneficios de este enfoque

✅ El controlador es simple y solo maneja la comunicación HTTP.

✅ No hay lógica de negocio en el controlador.

✅ Podemos cambiar la implementación sin modificar el controlador.

📌 Adicional puedes agregar un request validator de los que son provistos por Laravel para un mejor control.

### Enlace al Controlador OrderController

📄 Puedes encontrar el archivo del controlador OrderController en la siguiente ruta:

[App\Presentation\Http\Controllers\Order\OrderController](./app/Presentation/Http/Controllers/Order/OrderController.php)

### Enlace al Request CreateOrderRequest

📄 Puedes encontrar el archivo del Request CreateOrderRequest en la siguiente ruta:

[App\Presentation\Requests\Order\OrderRequest](./app/Presentation/Requests/Order/OrderRequest.php)

## 8- Registrar el repositorio en Laravel

🔨 Agregar en el archivo `AppServiceProvider.php` dentro del metodo `register()` el siguiente metodo:

```php
$this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
```

🔨 Esto lo que hace es que cada que se instancie la Interfaz en automatico cargara la implementacion de nuestro Repository

📌 Esto sirve para registrar dependencias y hacer uso de las mismas siempre que se necesite pero de manera desacoplada a travez de inyeccion de dependencias.

### Enlace al AppServiceProvider

📄 Puedes encontrar el archivo AppServiceProvider en la siguiente ruta:

[App\Providers\AppServiceProvider](./app/Providers/AppServiceProvider.php)
