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
🔨 Para nuestro ejemplo, agregaremos la entidad ```Order.php``` en el directorio ```app/Domain/Entities```.

🔨 Dentro, definiremos una función ```create()```, la cual se encargará de construir la entidad del negocio, a la vez que estará fuertemente desacoplada del framework.

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

| **Entidad (Dominio)**              | **Modelo de Base de Datos (Infraestructura)** |
|------------------------------------|-----------------------------------------------|
| No depende de Eloquent             | Extiende Model de Laravel                     |
| Representa un objeto del negocio   | Representa una tabla en la BD                 |
| Encapsula reglas de negocio        | Define la estructura de datos                 |
| Puede usarse sin Laravel           | Depende de Laravel y Eloquent                 |

### Enlace a la entidad Order

📄 Puedes encontrar el archivo de la entidad Order en la siguiente ruta:

[App\Domain\Entities\Order](./app/Domain/Entities/Order.php)

---


## 3- Crear el contrato del repositorio

🔨 En este paso, creamos una interfaz para definir qué métodos tendrá nuestro repositorio, sin implementarlos todavía.

🔨 Para nuestro ejemplo, agregaremos la entidad ```OrderRepositoryInterface.php``` en el directorio ```app/Domain/Repositories```.
 
🔨 Dentro de nuestra clase, definiremos una función llamada ```save()``` (para nuestro ejemplo). Dicha función debe recibir como parámetro una ```Entidad``` de tipo ```Order``` (la creamos en el paso anterior) y su retorno debe ser, de la misma manera, la ```Entidad Order```.

### Beneficios del uso de contratos de repositorio

✅ Desacoplamiento: Permite que la aplicación no dependa de una implementación específica (por ejemplo, Eloquent, una API externa o una base de datos diferente).

✅ Facilidad de prueba: Nos permite cambiar la implementación real por una simulada en pruebas unitarias.

✅ Cumple con el Principio de Inversión de Dependencias (SOLID): La capa de aplicación y dominio dependen de una abstracción (interfaz), no de una implementación concreta.

### Enlace al contrato del repositorio

📄 Puedes encontrar el archivo del contrato del repositorio en la siguiente ruta:

[App\Domain\Repositories\OrderRepositoryInterface](./app/Domain/Repositories/OrderRepositoryInterface.php)

---
## 4- Crear un DTO

📌 Un DTO (Data Transfer Object) es un objeto simple que se usa para transferir datos entre capas de la aplicación.

🔨 Para nuestro ejemplo, agregaremos la entidad ```OrderDTO.php``` en el directorio ```app/Application/DTOs```.

🔨 Dentro de la clase solo definiremos un objeto simple en el constructor que reciba ```$customerName``` y ```$totalAmount```

### Beneficios del uso de DTOs?
✅ Evita exponer modelos de Eloquent directamente en la capa de aplicación.

✅ Asegura que los datos sean inmutables y estén validados antes de usarlos.

✅ Facilita el mantenimiento y desacoplamiento entre capas.

### Enlace al DTO Order

📄 Puedes encontrar el archivo del DTO Order en la siguiente ruta:

[App\Application\DTOs\OrderDTO](./app/Application/DTOs/OrderDTO.php)